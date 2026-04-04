<?php

namespace App\Http\Controllers;

use App\Models\MainMateri;
use App\Models\Materi;
use App\Models\SubMateri;
use App\Models\StudySchedule;
use App\Models\UserFavorite;
use App\Models\UserHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    private const PAGES = [
        'dashboard',
        'history',
        'favorites',
        'schedule',
        'account',
        'materi',
        'submateri',
        'detail',
    ];

    public function spa(): View
    {
        return view('spa.user', [
            'title'       => 'Dashboard — User',
            'viteEntry'   => 'resources/js/SPA_user.js',
            'pageBaseUrl' => url('/app/page'),
            'initialPage' => 'dashboard',
        ]);
    }

    public function page(string $page, Request $request): View
    {
        if (! in_array($page, self::PAGES, true)) {
            abort(404);
        }

        // ── Dashboard ────────────────────────────────────────────────
        if ($page === 'dashboard') {
            $mainMateri = MainMateri::withCount('materis')
                ->with('materis.subMateris')
                ->get()
                ->map(function ($main) {
                    $totalSub = 0;
                    foreach ($main->materis as $m) {
                        $totalSub += $m->subMateris->count();
                    }

                    $main->total_materi     = $main->materis_count;
                    $main->total_submateri  = $totalSub;
                    $main->is_coming_soon   = false;
                    $main->is_completed     = false;
                    $main->progress_percent = 0;

                    return $main;
                });

            return view('spa.fragments.user-dashboard', [
                'data'       => ['mainMateri' => $mainMateri],
                'mainMateri' => $mainMateri,
            ]);
        }

        // ── History ──────────────────────────────────────────────────
        if ($page === 'history') {
            $userId = Auth::id();

            $histories = UserHistory::where('user_id', $userId)
                ->with('submateri.materi.mainMateri')
                ->orderByDesc('viewed_at')
                ->get();

            // Ambil daftar nama materi unik sebagai filter
            $filters = $histories
                ->filter(fn($h) => $h->submateri && $h->submateri->materi)
                ->pluck('submateri.materi.title')
                ->unique()
                ->values();

            return view('spa.fragments.user-history', [
                'histories' => $histories,
                'filters'   => $filters,
            ]);
        }

        // ── Materi (daftar materi milik satu MainMateri) ─────────────
        if ($page === 'materi') {
            $mainId     = $request->query('main_id');
            $mainMateri = MainMateri::find($mainId);

            if (! $mainMateri) {
                abort(404);
            }

            $materis = Materi::where('main_materi_id', $mainId)
                ->withCount('subMateris')
                ->get();

            $progressData = [];
            foreach ($materis as $materi) {
                $progressData[$materi->id] = [
                    'total'     => $materi->sub_materis_count,
                    'done'      => 0,
                    'completed' => false,
                ];
            }

            return view('spa.fragments.user-materisPage', [
                'materis'      => $materis,
                'firstMateri'  => $mainMateri,
                'progressData' => $progressData,
                'arsipMateri'  => UserFavorite::getIds(Auth::id(), 'materi'),
            ]);
        }

        // ── Sub Materi (daftar sub-materi milik satu Materi) ─────────
        if ($page === 'submateri') {
            $materiId = $request->query('materi_id');
            $materi   = Materi::with('mainMateri')->find($materiId);

            if (! $materi) {
                abort(404);
            }

            $subMateris = SubMateri::where('materi_id', $materiId)
                ->where('is_published', true)
                ->get();

            return view('spa.fragments.user-subMateriPage', [
                'materi'      => $materi,
                'firstMateri' => $materi,
                'subMateris'  => $subMateris,
                'arsipSub'    => UserFavorite::getIds(Auth::id(), 'sub'),
                'completed'   => [],
            ]);
        }

        // ── Detail (satu sub-materi) ──────────────────────────────────
        if ($page === 'detail') {
            $subMateriId = $request->query('submateri_id');
            $subMateri   = SubMateri::with('materi.mainMateri')->find($subMateriId);

            if (! $subMateri) {
                abort(404);
            }

            // Simpan ke history (upsert: update viewed_at jika sudah ada)
            UserHistory::updateOrCreate(
                [
                    'user_id'        => Auth::id(),
                    'sub_materi_id'  => $subMateri->id,
                ],
                [
                    'viewed_at' => now(),
                ]
            );

            $siblings = SubMateri::where('materi_id', $subMateri->materi_id)
                ->where('is_published', true)
                ->orderBy('id')
                ->get();

            $currentIndex = $siblings->search(fn($s) => $s->id === $subMateri->id);
            $prev = $currentIndex > 0 ? $siblings[$currentIndex - 1] : null;
            $next = $currentIndex < $siblings->count() - 1 ? $siblings[$currentIndex + 1] : null;

            return view('spa.fragments.user-detailSubMateriPage', [
                'subMateri' => $subMateri,
                'prev'      => $prev,
                'next'      => $next,
            ]);
        }

        // ── Schedule ──────────────────────────────────────────────────
        if ($page === 'schedule') {
            $userId    = Auth::id();
            $schedules = StudySchedule::where('user_id', $userId)
                ->orderBy('start_time')
                ->get();

            $today    = $schedules->filter(fn($s) => $s->isActiveToday());
            $upcoming = $schedules->filter(fn($s) => !$s->isActiveToday() && $s->is_active);

            return view('spa.fragments.user-schedule', [
                'schedules' => $schedules,
                'today'     => $today,
                'upcoming'  => $upcoming,
            ]);
        }

        // ── Favorites ─────────────────────────────────────────────────
        if ($page === 'favorites') {
            $userId = Auth::id();
            $favs   = UserFavorite::where('user_id', $userId)->orderByDesc('created_at')->get();

            $favMateris = $favs->where('favoritable_type', 'materi')
                ->map(fn($f) => Materi::with('mainMateri')->find($f->favoritable_id))
                ->filter();

            $favSubs = $favs->where('favoritable_type', 'sub')
                ->map(fn($f) => SubMateri::with('materi.mainMateri')->find($f->favoritable_id))
                ->filter();

            return view('spa.fragments.user-favorites', [
                'favMateris' => $favMateris,
                'favSubs'    => $favSubs,
            ]);
        }

        // ── Account ───────────────────────────────────────────────────
        if ($page === 'account') {
            return view('spa.fragments.user-account', [
                'user' => Auth::user(),
            ]);
        }

        // ── Fallback ──────────────────────────────────────────────────
        return view('spa.fragments.user', [
            'page' => $page,
            'data' => [],
        ]);
    }

    /**
     * Update profile user (AJAX POST).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];

        // Password opsional — hanya validate jika diisi
        if ($request->filled('password')) {
            $rules['password']              = ['min:8', 'confirmed'];
            $rules['password_confirmation'] = ['required'];
        }

        $validated = $request->validate($rules);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = $validated['password']; // auto-hashed by cast
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate! 🎉',
            'user'    => [
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  SCHEDULE CRUD
    // ═══════════════════════════════════════════════════════════════

    public function storeSchedule(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'schedule_type' => ['required', 'in:daily,weekly,monthly,custom'],
            'days_of_week'  => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'],
            'day_of_month'  => ['nullable', 'integer', 'between:1,31'],
            'custom_date'   => ['nullable', 'date'],
            'start_time'    => ['required', 'date_format:H:i'],
            'end_time'      => ['nullable', 'date_format:H:i'],
            'color'         => ['nullable', 'string', 'max:20'],
        ]);

        $validated['user_id'] = Auth::id();

        $schedule = StudySchedule::create($validated);

        return response()->json([
            'success'  => true,
            'message'  => 'Jadwal berhasil dibuat! 📅',
            'schedule' => $schedule,
        ]);
    }

    public function updateSchedule(Request $request, StudySchedule $schedule): JsonResponse
    {
        if ($schedule->user_id !== Auth::id()) abort(403);

        $validated = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'schedule_type' => ['required', 'in:daily,weekly,monthly,custom'],
            'days_of_week'  => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'],
            'day_of_month'  => ['nullable', 'integer', 'between:1,31'],
            'custom_date'   => ['nullable', 'date'],
            'start_time'    => ['required', 'date_format:H:i'],
            'end_time'      => ['nullable', 'date_format:H:i'],
            'color'         => ['nullable', 'string', 'max:20'],
        ]);

        $schedule->update($validated);

        return response()->json([
            'success'  => true,
            'message'  => 'Jadwal berhasil diupdate! ✏️',
            'schedule' => $schedule->fresh(),
        ]);
    }

    public function deleteSchedule(StudySchedule $schedule): JsonResponse
    {
        if ($schedule->user_id !== Auth::id()) abort(403);

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus! 🗑️',
        ]);
    }

    public function toggleSchedule(StudySchedule $schedule): JsonResponse
    {
        if ($schedule->user_id !== Auth::id()) abort(403);

        $schedule->update(['is_active' => !$schedule->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $schedule->is_active,
            'message'   => $schedule->is_active ? 'Jadwal diaktifkan' : 'Jadwal dinonaktifkan',
        ]);
    }

    /**
     * API: jadwal hari ini (untuk notifikasi client-side).
     */
    public function todaySchedules(): JsonResponse
    {
        $schedules = StudySchedule::where('user_id', Auth::id())
            ->where('is_active', true)
            ->orderBy('start_time')
            ->get();

        $today = $schedules->filter(fn($s) => $s->isActiveToday())
            ->map(fn($s) => [
                'id'         => $s->id,
                'title'      => $s->title,
                'start_time' => substr($s->start_time, 0, 5), // HH:mm
                'end_time'   => $s->end_time ? substr($s->end_time, 0, 5) : null,
                'color'      => $s->color,
            ])
            ->values();

        return response()->json($today);
    }

    // ═══════════════════════════════════════════════════════════════
    //  FAVORITES
    // ═══════════════════════════════════════════════════════════════

    public function toggleFavorite(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'in:materi,sub'],
            'id'   => ['required', 'integer'],
        ]);

        $result = UserFavorite::toggle(
            Auth::id(),
            $request->input('type'),
            $request->input('id')
        );

        return response()->json([
            'success'      => true,
            'is_favorited' => $result['is_favorited'],
            'message'      => $result['is_favorited'] ? 'Ditambahkan ke favorit ⭐' : 'Dihapus dari favorit',
        ]);
    }
}

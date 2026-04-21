<?php

namespace App\Http\Controllers;

use App\Models\MainMateri;
use App\Models\Materi;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\SubMateri;
use App\Models\StudySchedule;
use App\Models\UserFavorite;
use App\Models\UserHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        'quiz',
    ];

    public function spa(): View
    {
        return view('spa.user', [
            'title' => 'Dashboard — User',
            'viteEntry' => 'resources/js/SPA_user.js',
            'pageBaseUrl' => url('/app/page'),
            'initialPage' => 'dashboard',
        ]);
    }

    public function page(string $page, Request $request): View
    {
        if (!in_array($page, self::PAGES, true)) {
            abort(404);
        }

        // ── Dashboard ────────────────────────────────────────────────
        if ($page === 'dashboard') {
            $userId = Auth::id();

            // Ambil semua sub_materi_id yang sudah di-view user (single query, indexed lookup)
            $viewedSubIds = $userId
                ? UserHistory::where('user_id', $userId)
                    ->pluck('sub_materi_id')
                    ->flip() // flip untuk O(1) lookup via isset() instead of in_array O(n)
                    ->all()
                : [];

            // Ambil HANYA history terakhir per MainMateri (limit, bukan semua)
            $lastHistories = $userId
                ? UserHistory::where('user_id', $userId)
                    ->select(['sub_materi_id', 'viewed_at'])
                    ->with('submateri:id,title,materi_id')
                    ->orderByDesc('viewed_at')
                    ->limit(50)
                    ->get()
                : collect();

            $mainMateri = MainMateri::withCount('materis')
                ->with('materis:id,main_materi_id,title')
                ->with('materis.subMateris:id,materi_id')
                ->get()
                ->map(function ($main) use ($viewedSubIds, $lastHistories) {
                    $totalSub = 0;
                    $doneSub = 0;
                    $allSubIds = [];

                    foreach ($main->materis as $m) {
                        foreach ($m->subMateris as $sub) {
                            $totalSub++;
                            $allSubIds[] = $sub->id;
                            if (isset($viewedSubIds[$sub->id])) {
                                $doneSub++;
                            }
                        }
                    }

                    $main->total_materi = $main->materis_count;
                    $main->total_submateri = $totalSub;
                    $main->is_coming_soon = false;
                    $main->progress_percent = $totalSub > 0 ? round(($doneSub / $totalSub) * 100) : 0;
                    $main->is_completed = $totalSub > 0 && $doneSub >= $totalSub;

                    // Cari history terakhir yang sub_materi-nya milik MainMateri ini
                    $allSubFlipped = array_flip($allSubIds);
                    $lastHistory = $lastHistories->first(function ($h) use ($allSubFlipped) {
                        return isset($allSubFlipped[$h->sub_materi_id]);
                    });

                    $main->last_studied_title = $lastHistory?->submateri?->title;
                    $main->last_studied_at = $lastHistory?->viewed_at;

                    return $main;
                });

            $topUsers = \App\Models\User::where('role', 'user')
                ->orderByDesc('exp')
                ->limit(5)
                ->get();

            return view('spa.fragments.user-dashboard', [
                'data' => ['mainMateri' => $mainMateri],
                'mainMateri' => $mainMateri,
                'topUsers' => $topUsers,
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
                'filters' => $filters,
            ]);
        }

        // ── Materi (daftar materi milik satu MainMateri) ─────────────
        if ($page === 'materi') {
            $mainId = $request->query('main_id');
            $mainMateri = MainMateri::find($mainId);

            if (!$mainMateri) {
                abort(404);
            }

            $userId = Auth::id();
            $viewedSubIds = $userId
                ? UserHistory::where('user_id', $userId)->pluck('sub_materi_id')->toArray()
                : [];

            $materis = Materi::where('main_materi_id', $mainId)
                ->withCount('subMateris')
                ->with('subMateris')
                ->get();

            $progressData = [];
            foreach ($materis as $materi) {
                $total = $materi->sub_materis_count;
                $done = $materi->subMateris->whereIn('id', $viewedSubIds)->count();

                $progressData[$materi->id] = [
                    'total' => $total,
                    'done' => $done,
                    'completed' => $total > 0 && $done >= $total,
                ];
            }

            return view('spa.fragments.user-materisPage', [
                'materis' => $materis,
                'firstMateri' => $mainMateri,
                'progressData' => $progressData,
                'arsipMateri' => UserFavorite::getIds(Auth::id(), 'materi'),
            ]);
        }

        // ── Sub Materi (daftar sub-materi milik satu Materi) ─────────
        if ($page === 'submateri') {
            $materiId = $request->query('materi_id');
            $materi = Materi::with('mainMateri')->find($materiId);

            if (!$materi) {
                abort(404);
            }

            $userId = Auth::id();

            $subMateris = SubMateri::where('materi_id', $materiId)
                ->where('is_published', true)
                ->get();

            // Ambil sub_materi_id yang sudah pernah dilihat user di materi ini
            $completedSubIds = $userId
                ? UserHistory::where('user_id', $userId)
                    ->whereIn('sub_materi_id', $subMateris->pluck('id'))
                    ->pluck('sub_materi_id')
                    ->toArray()
                : [];

            return view('spa.fragments.user-subMateriPage', [
                'materi' => $materi,
                'firstMateri' => $materi,
                'subMateris' => $subMateris,
                'arsipSub' => UserFavorite::getIds(Auth::id(), 'sub'),
                'completed' => $completedSubIds,
            ]);
        }

        // ── Detail (satu sub-materi) ──────────────────────────────────
        if ($page === 'detail') {
            $subMateriId = $request->query('submateri_id');
            $subMateri = SubMateri::with('materi.mainMateri')->find($subMateriId);

            if (!$subMateri) {
                abort(404);
            }

            // Simpan ke history (upsert: update viewed_at jika sudah ada)
            UserHistory::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'sub_materi_id' => $subMateri->id,
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
                'prev' => $prev,
                'next' => $next,
            ]);
        }

        // ── Quiz (Kuis untuk satu sub-materi) ─────────────────────────
        if ($page === 'quiz') {
            $subMateriId = $request->query('submateri_id');
            $subMateri = SubMateri::with('materi.mainMateri')->find($subMateriId);

            if (!$subMateri) {
                abort(404);
            }

            $siblings = SubMateri::where('materi_id', $subMateri->materi_id)
                ->where('is_published', true)
                ->orderBy('id')
                ->get();

            $currentIndex = $siblings->search(fn($s) => $s->id === $subMateri->id);
            $prev = $currentIndex > 0 ? $siblings[$currentIndex - 1] : null;
            $next = $currentIndex < $siblings->count() - 1 ? $siblings[$currentIndex + 1] : null;

            $totalQuestions = Question::where('sub_materi_id', $subMateri->id)->count();
            // Ambil 30% dari total soal (minimal 1 soal jika ada soal)
            $takeCount = $totalQuestions > 0 ? max(1, (int) round($totalQuestions * 0.30)) : 0;

            $questions = Question::where('sub_materi_id', $subMateri->id)
                ->inRandomOrder()
                ->limit($takeCount)
                ->get();

            $quizAttempt = Auth::id()
                ? QuizAttempt::where('user_id', Auth::id())
                    ->where('sub_materi_id', $subMateri->id)
                    ->first()
                : null;

            return view('spa.fragments.user-quizPage', [
                'subMateri' => $subMateri,
                'questions' => $questions,
                'quizAttempt' => $quizAttempt,
                'prev' => $prev,
                'next' => $next,
            ]);
        }

        // ── Schedule ──────────────────────────────────────────────────
        if ($page === 'schedule') {
            $userId = Auth::id();
            $schedules = StudySchedule::where('user_id', $userId)
                ->orderBy('start_time')
                ->get();

            $today = $schedules->filter(fn($s) => $s->isActiveToday());
            $upcoming = $schedules->filter(fn($s) => !$s->isActiveToday() && $s->is_active);

            return view('spa.fragments.user-schedule', [
                'schedules' => $schedules,
                'today' => $today,
                'upcoming' => $upcoming,
            ]);
        }

        // ── Favorites ─────────────────────────────────────────────────
        if ($page === 'favorites') {
            $userId = Auth::id();
            $favs = UserFavorite::where('user_id', $userId)->orderByDesc('created_at')->get();

            // Batch load instead of N+1 individual find() calls
            $materiIds = $favs->where('favoritable_type', 'materi')->pluck('favoritable_id');
            $subIds = $favs->where('favoritable_type', 'sub')->pluck('favoritable_id');

            $favMateris = $materiIds->isNotEmpty()
                ? Materi::with('mainMateri')->whereIn('id', $materiIds)->get()
                : collect();

            $favSubs = $subIds->isNotEmpty()
                ? SubMateri::with('materi.mainMateri')->whereIn('id', $subIds)->get()
                : collect();

            return view('spa.fragments.user-favorites', [
                'favMateris' => $favMateris,
                'favSubs' => $favSubs,
            ]);
        }

        // ── Account ───────────────────────────────────────────────────
        if ($page === 'account') {
            $user = Auth::user();
            $userId = $user->id;
            $achievements = [];

            // Compute global top values
            $topScorer = QuizAttempt::selectRaw('user_id, MAX(score) as max_score')
                ->groupBy('user_id')->orderByDesc('max_score')->first();
            $mostPassed = QuizAttempt::selectRaw('user_id, COUNT(*) as pass_count')
                ->where('passed', true)->groupBy('user_id')->orderByDesc('pass_count')->first();
            $mostAttempts = QuizAttempt::selectRaw('user_id, COUNT(*) as attempt_count')
                ->groupBy('user_id')->orderByDesc('attempt_count')->first();
            $hasPerfect = QuizAttempt::where('user_id', $userId)->where('score', 100)->exists();

            if ($topScorer && $topScorer->user_id === $userId) {
                $achievements[] = ['label' => 'Top Scorer', 'icon' => 'achivement008Trans.png', 'desc' => 'Meraih skor tertinggi secara global'];
            }
            if ($mostPassed && $mostPassed->user_id === $userId) {
                $achievements[] = ['label' => 'Quiz Master', 'icon' => 'achivement009Trans.png', 'desc' => 'Menyelesaikan kuis paling banyak'];
            }
            if ($hasPerfect) {
                $achievements[] = ['label' => 'Perfect Score', 'icon' => 'achivement007Trans.png', 'desc' => 'Mendapatkan nilai sempurna (100)'];
            }
            if ($mostAttempts && $mostAttempts->user_id === $userId) {
                $achievements[] = ['label' => 'Most Active', 'icon' => 'achivement006Trans.png', 'desc' => 'Paling aktif mencoba kuis'];
            }

            // ── Additional Stats for Admin-style Dashboard ──
            $quizAttempts = QuizAttempt::where('user_id', $userId)->get();
            $totalQuizAttempts = $quizAttempts->count();
            $quizPassedCount = $quizAttempts->where('passed', true)->count();
            $quizAvgScore = $totalQuizAttempts > 0 ? round($quizAttempts->avg('score'), 1) : 0;
            $quizBestScore = $totalQuizAttempts > 0 ? $quizAttempts->max('score') : 0;

            $totalHistoryViews = UserHistory::where('user_id', $userId)->count();
            $totalFavorites = UserFavorite::where('user_id', $userId)->count();
            $daysActive = (int) $user->created_at->diffInDays(now());

            // Learning progress
            $totalSubMateris = SubMateri::where('is_published', true)->count();
            $completedSubMateris = UserHistory::where('user_id', $userId)->distinct('sub_materi_id')->count('sub_materi_id');
            $learningProgress = $totalSubMateris > 0 ? round(($completedSubMateris / $totalSubMateris) * 100) : 0;

            // Recent quiz history (latest 5)
            $recentQuizzes = QuizAttempt::where('user_id', $userId)
                ->with('subMateri.materi.mainMateri')
                ->orderByDesc('updated_at')
                ->limit(5)
                ->get();

            return view('spa.fragments.user-account', [
                'user' => $user,
                'achievements' => $achievements,
                'totalQuizAttempts' => $totalQuizAttempts,
                'quizPassedCount' => $quizPassedCount,
                'quizAvgScore' => $quizAvgScore,
                'quizBestScore' => $quizBestScore,
                'totalHistoryViews' => $totalHistoryViews,
                'totalFavorites' => $totalFavorites,
                'daysActive' => $daysActive,
                'totalSubMateris' => $totalSubMateris,
                'completedSubMateris' => $completedSubMateris,
                'learningProgress' => $learningProgress,
                'recentQuizzes' => $recentQuizzes,
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];

        // Password opsional — hanya validate jika diisi
        if ($request->filled('password')) {
            $rules['password'] = ['min:8', 'confirmed'];
            $rules['password_confirmation'] = ['required'];
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = $validated['password']; // auto-hashed by cast
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // Handle avatar removal
        if ($request->input('remove_avatar') === '1' && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate! 🎉',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null,
            ],
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  SCHEDULE CRUD
    // ═══════════════════════════════════════════════════════════════

    public function storeSchedule(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'schedule_type' => ['required', 'in:daily,weekly,monthly,custom'],
            'days_of_week' => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'],
            'day_of_month' => ['nullable', 'integer', 'between:1,31'],
            'custom_date' => ['nullable', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $validated['user_id'] = Auth::id();

        $schedule = StudySchedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dibuat! 📅',
            'schedule' => $schedule,
        ]);
    }

    public function updateSchedule(Request $request, StudySchedule $schedule): JsonResponse
    {
        if ($schedule->user_id !== Auth::id())
            abort(403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'schedule_type' => ['required', 'in:daily,weekly,monthly,custom'],
            'days_of_week' => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'],
            'day_of_month' => ['nullable', 'integer', 'between:1,31'],
            'custom_date' => ['nullable', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diupdate! ✏️',
            'schedule' => $schedule->fresh(),
        ]);
    }

    public function deleteSchedule(StudySchedule $schedule): JsonResponse
    {
        if ($schedule->user_id !== Auth::id())
            abort(403);

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus! 🗑️',
        ]);
    }

    public function toggleSchedule(StudySchedule $schedule): JsonResponse
    {
        if ($schedule->user_id !== Auth::id())
            abort(403);

        $schedule->update(['is_active' => !$schedule->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $schedule->is_active,
            'message' => $schedule->is_active ? 'Jadwal diaktifkan' : 'Jadwal dinonaktifkan',
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
                'id' => $s->id,
                'title' => $s->title,
                'start_time' => substr($s->start_time, 0, 5), // HH:mm
                'end_time' => $s->end_time ? substr($s->end_time, 0, 5) : null,
                'color' => $s->color,
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
            'id' => ['required', 'integer'],
        ]);

        $result = UserFavorite::toggle(
            Auth::id(),
            $request->input('type'),
            $request->input('id')
        );

        return response()->json([
            'success' => true,
            'is_favorited' => $result['is_favorited'],
            'message' => $result['is_favorited'] ? 'Ditambahkan ke favorit ⭐' : 'Dihapus dari favorit',
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  EXP SYSTEM
    // ═══════════════════════════════════════════════════════════════

    public function pingExp(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $cacheKey = 'exp_ping_user_' . $user->id;

        // Prevent spam - only allow +10 exp if 55 seconds have passed
        if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Too early for next EXP ping',
                'exp' => $user->exp,
            ], 429);
        }

        $user->exp += 10;
        $user->save();

        // Lock for 55 seconds (to allow minor latency on 60s intervals)
        \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addSeconds(55));

        return response()->json([
            'success' => true,
            'message' => 'EXP gained!',
            'exp' => $user->exp,
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  QUIZ SYSTEM
    // ═══════════════════════════════════════════════════════════════

    public function submitQuiz(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'sub_materi_id' => ['required', 'integer', 'exists:sub_materis,id'],
            'answers' => ['required', 'array'],
        ]);

        $userId = Auth::id();
        $subMateriId = $validated['sub_materi_id'];
        $userAnswers = $validated['answers']; // { "question_id": selected_option_index }

        $totalQuestionsInDb = Question::where('sub_materi_id', $subMateriId)->count();

        if ($totalQuestionsInDb === 0) {
            return response()->json(['success' => false, 'message' => 'Tidak ada soal'], 400);
        }

        // Ekspektasi jumlah soal adalah 30% (min 1)
        $expectedCount = max(1, (int) round($totalQuestionsInDb * 0.30));

        // Ambil maksimum N id soal dari jawaban user untuk dicegah submit berlebih
        $submittedIds = array_slice(array_keys($userAnswers), 0, $expectedCount);

        $questions = Question::where('sub_materi_id', $subMateriId)
            ->whereIn('id', $submittedIds)
            ->get();

        // Hitung skor
        $correct = 0;
        $total = $expectedCount;
        $results = [];

        foreach ($questions as $q) {
            $userAnswer = $userAnswers[$q->id] ?? -1;
            $isCorrect = (int) $userAnswer === $q->correct_option;
            if ($isCorrect)
                $correct++;

            $results[$q->id] = [
                'selected' => (int) $userAnswer,
                'correct_option' => $q->correct_option,
                'is_correct' => $isCorrect,
            ];
        }

        $score = (int) round(($correct / $total) * 100);
        $passed = $score >= 80;

        // Simpan / update attempt (keep best score)
        $existing = QuizAttempt::where('user_id', $userId)
            ->where('sub_materi_id', $subMateriId)
            ->first();

        $expAwarded = false;
        $expGained = 0;

        if ($existing) {
            // Update hanya jika skor baru lebih tinggi
            if ($score > $existing->score) {
                $existing->update([
                    'score' => $score,
                    'answers' => $results,
                    'passed' => $passed,
                ]);
            }

            // Beri EXP jika lulus dan belum pernah diberi sebelumnya
            if ($passed && !$existing->exp_awarded) {
                $user = Auth::user();
                $user->exp += 50;
                $user->save();

                $existing->update(['exp_awarded' => true]);
                $expAwarded = true;
                $expGained = 50;
            }
        } else {
            $attempt = QuizAttempt::create([
                'user_id' => $userId,
                'sub_materi_id' => $subMateriId,
                'score' => $score,
                'answers' => $results,
                'passed' => $passed,
                'exp_awarded' => $passed,
            ]);

            if ($passed) {
                $user = Auth::user();
                $user->exp += 50;
                $user->save();
                $expAwarded = true;
                $expGained = 50;
            }
        }

        return response()->json([
            'success' => true,
            'score' => $score,
            'correct' => $correct,
            'total' => $total,
            'passed' => $passed,
            'results' => $results,
            'exp_awarded' => $expAwarded,
            'exp_gained' => $expGained,
            'message' => $passed
                ? "Selamat! Kamu lulus dengan skor {$score}% 🎉"
                : "Skor kamu {$score}%. Minimal 80% untuk lulus. Coba lagi! 💪",
        ]);
    }
}

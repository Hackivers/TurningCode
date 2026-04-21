<?php

namespace App\Http\Controllers;

use App\Models\MainMateri;
use App\Models\Materi;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\SubMateri;
use App\Models\User;
use App\Models\UserFavorite;
use App\Models\UserHistory;
use Illuminate\View\View;

class AdminController extends Controller
{
    private const PAGES = [
        'dashboard',
        'addsubmateri',
        'editsubmateri',
        'main-materi',
        'materi',
        'questions',
        'database',
        'profile',
    ];

    public function spa(): View
    {
        return view('spa.admin', [
            'title' => 'Dashboard — Admin',
            'viteEntry' => 'resources/js/SPA_admin.js',
            'pageBaseUrl' => url('/admin/page'),
            'initialPage' => session()->pull('admin_open_page', 'dashboard'),
        ]);
    }

    public function page(string $page): View
    {
        if (! in_array($page, self::PAGES, true)) {
            abort(404);
        }

        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            $user->update([
                'last_seen' => now(),
                'last_page' => $page,
            ]);
        }

        if ($page === 'dashboard') {
            // Combine user counts into single query (8 queries → 4)
            $userCounts = User::selectRaw("
                SUM(CASE WHEN role = 'user' THEN 1 ELSE 0 END) as total_users,
                SUM(CASE WHEN role = 'admin' THEN 1 ELSE 0 END) as total_admins
            ")->first();

            $subMateriCounts = SubMateri::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN is_published = 1 THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN is_published = 0 THEN 1 ELSE 0 END) as draft
            ")->first();

            $quizCounts = QuizAttempt::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN passed = 1 THEN 1 ELSE 0 END) as passed,
                COALESCE(AVG(score), 0) as avg_score
            ")->first();

            $totalQuestions   = Question::count();
            $totalViews       = UserHistory::count();
            $totalFavorites   = UserFavorite::count();
            $newUsersThisWeek = User::where('role', 'user')
                ->where('created_at', '>=', now()->subDays(7))
                ->count();

            $topActiveUsers = User::where('role', 'user')
                ->where('exp', '>', 0)
                ->orderByDesc('exp')
                ->limit(5)
                ->get(['id', 'name', 'exp', 'avatar']);

            // Compute achievements per user
            $achievements = [];
            $topScorer = QuizAttempt::selectRaw('user_id, MAX(score) as max_score')
                ->groupBy('user_id')->orderByDesc('max_score')->first();
            $mostPassed = QuizAttempt::selectRaw('user_id, COUNT(*) as pass_count')
                ->where('passed', true)->groupBy('user_id')->orderByDesc('pass_count')->first();
            $perfectScorer = QuizAttempt::where('score', 100)->first();
            $mostAttempts = QuizAttempt::selectRaw('user_id, COUNT(*) as attempt_count')
                ->groupBy('user_id')->orderByDesc('attempt_count')->first();

            if ($topScorer) $achievements[$topScorer->user_id][] = ['label' => 'Top Scorer', 'icon' => 'emblemPath001.png'];
            if ($mostPassed) $achievements[$mostPassed->user_id][] = ['label' => 'Quiz Master', 'icon' => 'emblemPath001.png'];
            if ($perfectScorer) $achievements[$perfectScorer->user_id][] = ['label' => 'Perfect Score', 'icon' => 'emblemPath001.png'];
            if ($mostAttempts) $achievements[$mostAttempts->user_id][] = ['label' => 'Most Active', 'icon' => 'emblemPath001.png'];

            return view('spa.fragments.admin-dashboard', [
                'page'               => $page,
                'totalUsers'         => (int) $userCounts->total_users,
                'totalAdmins'        => (int) $userCounts->total_admins,
                'totalMainMateris'   => MainMateri::count(),
                'totalMateris'       => Materi::count(),
                'totalSubMateris'    => (int) $subMateriCounts->total,
                'publishedSubMateris'=> (int) $subMateriCounts->published,
                'draftSubMateris'    => (int) $subMateriCounts->draft,
                'recentSubMateris'   => SubMateri::with('materi.mainMateri')->latest()->limit(5)->get(),
                'topMateris'         => Materi::withCount('subMateris')->orderByDesc('sub_materis_count')->limit(5)->get(),
                // New statistics
                'totalQuestions'     => $totalQuestions,
                'totalQuizAttempts'  => (int) $quizCounts->total,
                'quizPassedCount'    => (int) $quizCounts->passed,
                'quizAvgScore'       => round((float) $quizCounts->avg_score),
                'totalViews'         => $totalViews,
                'totalFavorites'     => $totalFavorites,
                'newUsersThisWeek'   => $newUsersThisWeek,
                'topActiveUsers'     => $topActiveUsers,
                'achievements'       => $achievements,
                'totalReports'       => \App\Models\IssueReport::count(),
                'pendingReports'     => \App\Models\IssueReport::where('status', 'pending')->count(),
                'recentReports'      => \App\Models\IssueReport::with('user:id,name,avatar')->latest()->limit(5)->get(),
            ]);
        }

        if ($page === 'main-materi') {
            return view('spa.fragments.admin-main-materi', [
                'page' => $page,
                'mainMateris' => MainMateri::query()->withCount('materis')->orderBy('title')->get(),
            ]);
        }

        if ($page === 'materi') {
            return view('spa.fragments.admin-materi', [
                'page'        => $page,
                'mainMateris' => MainMateri::query()->orderBy('title')->get(),
                'materis'     => Materi::query()
                    ->with('mainMateri')
                    ->orderBy('title')
                    ->get(),
            ]);
        }

        if ($page === 'addsubmateri') {
            return view('spa.fragments.admin-addsubmateri', [
                'page' => $page,
                'mainMateris' => MainMateri::query()->orderBy('title')->get(),
                'recentSubMateris' => SubMateri::query()
                    ->with('materi.mainMateri')
                    ->latest()
                    ->limit(8)
                    ->get(),
            ]);
        }

        if ($page === 'editsubmateri') {
            $id = request('id');
            $subMateri = SubMateri::with('materi.mainMateri')->findOrFail($id);
            return view('spa.fragments.admin-editsubmateri', [
                'page' => $page,
                'sub' => $subMateri,
                'mainMateris' => MainMateri::query()->orderBy('title')->get(),
            ]);
        }

        if ($page === 'questions') {
            // Load all questions grouped by hierarchy
            $groupedQuestions = MainMateri::query()
                ->orderBy('title')
                ->with([
                    'materis' => fn($q) => $q->orderBy('title'),
                    'materis.subMateris' => fn($q) => $q->where('is_published', true)->orderBy('title'),
                    'materis.subMateris.questions' => fn($q) => $q->orderBy('order'),
                ])
                ->get()
                ->filter(function ($main) {
                    // Only include main materis that have at least one question somewhere
                    return $main->materis->contains(function ($materi) {
                        return $materi->subMateris->contains(function ($sub) {
                            return $sub->questions->isNotEmpty();
                        });
                    });
                });

            $totalQuestions = Question::count();

            return view('spa.fragments.admin-questions', [
                'page'             => $page,
                'mainMateris'      => MainMateri::query()->orderBy('title')->get(),
                'groupedQuestions' => $groupedQuestions,
                'totalQuestions'   => $totalQuestions,
            ]);
        }

        if ($page === 'database') {
            $tables = \Illuminate\Support\Facades\Schema::getTables();
            $schemaInfo = [];
            foreach ($tables as $tableItem) {
                $tableName = $tableItem['name'];
                $schemaInfo[$tableName] = [
                    'columns'      => \Illuminate\Support\Facades\Schema::getColumns($tableName),
                    'foreign_keys' => \Illuminate\Support\Facades\Schema::getForeignKeys($tableName),
                    'indexes'      => \Illuminate\Support\Facades\Schema::getIndexes($tableName),
                ];
            }
            return view('spa.fragments.admin-database', [
                'page'   => $page,
                'schema' => $schemaInfo,
            ]);
        }

        if ($page === 'profile') {
            return view('spa.fragments.admin-profile', [
                'page' => $page,
                'user' => auth()->user(),
            ]);
        }

        return view('spa.fragments.admin', ['page' => $page]);
    }

    /**
     * Web Terminal Command Runner
     */
    public function runCommand(\Illuminate\Http\Request $request)
    {
        $command = trim($request->input('command'));
        
        if (empty($command)) {
            return response()->json(['output' => 'No command provided.']);
        }

        try {
            // Securely run the command using Laravel's Process facade
            $result = \Illuminate\Support\Facades\Process::run($command);
            
            $output = trim($result->output());
            $errorOutput = trim($result->errorOutput());
            
            $fullOutput = $output;
            if ($errorOutput) {
                $fullOutput .= "\n[STDERR]\n" . $errorOutput;
            }
            
            return response()->json([
                'output' => $fullOutput ?: 'Command executed with no output.',
                'exit_code' => $result->exitCode()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'output' => 'Execution Error: ' . $e->getMessage(),
                'exit_code' => 500
            ], 500);
        }
    }

    /**
     * Store Issue Report from the widget
     */
    public function storeReport(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reports', 'public');
        }

        \App\Models\IssueReport::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image_path' => $path,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Laporan telah berhasil dikirim! Tim kami akan meninjaunya.'], 200);
    }

    /**
     * API: Mark issue report as resolved/accepted
     */
    public function resolveReport(\App\Models\IssueReport $issueReport)
    {
        $issueReport->update(['status' => 'resolved']);
        return response()->json(['message' => 'Laporan berhasil diselesaikan.']);
    }

    /**
     * Edit Profile Admin
     */
    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email_name' => ['required', 'string', 'max:150', 'regex:/^[a-zA-Z0-9_\-\.]+$/'],
            'avatar'     => ['nullable', 'file', 'image', 'max:2048', 'mimes:jpeg,png,jpg,webp,gif'],
        ]);

        // Construct email with const @turncode.com
        $newEmail = $request->input('email_name') . '@turncode.com';

        // Check if email already exists for another user
        if (\App\Models\User::where('email', $newEmail)->where('id', '!=', $user->id)->exists()) {
            return redirect()->route('admin.spa')
                ->withErrors(['email_name' => 'Email ini sudah digunakan oleh pengguna lain.'])
                ->withInput()
                ->with('admin_open_page', 'profile');
        }

        $user->name = $request->input('name');
        $user->email = $newEmail;

        if ($request->hasFile('avatar')) {
            // Delete old avatar if not default
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('admin.spa')
            ->with('success', 'Profile berhasil diperbarui!')
            ->with('admin_open_page', 'profile');
    }

    /**
     * API: Fetch recent notifications for the bell dropdown
     */
    public function notifications()
    {
        $reports = \App\Models\IssueReport::with('user:id,name,avatar')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($r) => [
                'id'    => 'report-' . $r->id,
                'type'  => 'report',
                'icon'  => '🚩',
                'color' => $r->status === 'pending' ? 'rose' : 'emerald',
                'title' => $r->name,
                'body'  => \Illuminate\Support\Str::limit($r->description, 60),
                'user'  => $r->user?->name ?? 'Unknown',
                'time'  => $r->created_at->diffForHumans(['short' => true]),
                'status'=> $r->status,
            ]);

        $recentSubs = SubMateri::with('materi:id,title')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn($s) => [
                'id'    => 'sub-' . $s->id,
                'type'  => 'submateri',
                'icon'  => '📄',
                'color' => $s->is_published ? 'indigo' : 'amber',
                'title' => $s->title,
                'body'  => ($s->is_published ? 'Published' : 'Draft') . ' — ' . ($s->materi?->title ?? ''),
                'user'  => $s->author ?? 'Admin',
                'time'  => $s->created_at->diffForHumans(['short' => true]),
                'status'=> $s->is_published ? 'published' : 'draft',
            ]);

        $items = $reports->merge($recentSubs)
            ->sortByDesc(fn($i) => $i['time'])
            ->values()
            ->take(10);

        $pendingCount = \App\Models\IssueReport::where('status', 'pending')->count();
        $latestPending = \App\Models\IssueReport::where('status', 'pending')->latest()->first();

        return response()->json([
            'items'               => $items,
            'pending_count'       => $pendingCount,
            'latest_pending_time' => $latestPending ? $latestPending->created_at->timestamp * 1000 : 0,
        ]);
    }

    public function onlineAdmins(): \Illuminate\Http\JsonResponse
    {
        // Get all admins, mark as online if last_seen is within the last 5 minutes
        $admins = \App\Models\User::where('role', 'admin')
            ->select('id', 'name', 'email', 'avatar', 'last_seen', 'last_page')
            ->orderBy('last_seen', 'desc')
            ->get()
            ->map(function ($admin) {
                $isOnline = $admin->last_seen && $admin->last_seen->diffInMinutes(now()) <= 5;
                
                // Format the page name to be more readable
                $pageMap = [
                    'dashboard' => 'Dashboard',
                    'addsubmateri' => 'Tambah Sub Materi',
                    'editsubmateri' => 'Edit Sub Materi',
                    'main-materi' => 'Main Materi',
                    'materi' => 'Materi',
                    'questions' => 'Bank Soal',
                    'database' => 'Database',
                    'profile' => 'Profile',
                ];
                
                $pageDisplay = 'Dashboard';
                if ($admin->last_page && isset($pageMap[$admin->last_page])) {
                    $pageDisplay = $pageMap[$admin->last_page];
                } elseif ($admin->last_page) {
                    $pageDisplay = ucfirst($admin->last_page);
                }

                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'avatar_url' => $admin->avatar ? asset('storage/' . $admin->avatar) : "https://ui-avatars.com/api/?name=" . urlencode($admin->name) . "&background=6366f1&color=ffffff",
                    'is_online' => $isOnline,
                    'last_page_display' => $pageDisplay,
                    'last_seen_human' => $admin->last_seen ? $admin->last_seen->diffForHumans() : 'Never'
                ];
            });

        return response()->json($admins);
    }

    /**
     * Database Table CRUD
     */
    public function tableRows(string $table): \Illuminate\Http\JsonResponse
    {
        // Validate table exists
        if (!\Illuminate\Support\Facades\Schema::hasTable($table)) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $columns = collect(\Illuminate\Support\Facades\Schema::getColumns($table))
            ->pluck('name')
            ->toArray();

        $rows = \Illuminate\Support\Facades\DB::table($table)
            ->limit(100)
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'columns' => $columns,
            'rows'    => $rows,
            'total'   => \Illuminate\Support\Facades\DB::table($table)->count(),
        ]);
    }

    public function updateRow(string $table, string $id, \Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable($table)) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $data = $request->except(['_method', '_token']);

        // Remove id and timestamp fields from update
        unset($data['id'], $data['created_at']);

        // Set updated_at if exists
        if (\Illuminate\Support\Facades\Schema::hasColumn($table, 'updated_at')) {
            $data['updated_at'] = now();
        }

        \Illuminate\Support\Facades\DB::table($table)->where('id', $id)->update($data);

        return response()->json(['message' => 'Data berhasil diperbarui.']);
    }

    public function deleteRow(string $table, string $id): \Illuminate\Http\JsonResponse
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable($table)) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        \Illuminate\Support\Facades\DB::table($table)->where('id', $id)->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}

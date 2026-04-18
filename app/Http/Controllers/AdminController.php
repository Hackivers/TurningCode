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
                ->get(['name', 'exp', 'avatar']);

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
                'totalReports'       => \App\Models\IssueReport::count(),
                'pendingReports'     => \App\Models\IssueReport::where('status', 'pending')->count(),
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
            return view('spa.fragments.admin-questions', [
                'page'            => $page,
                'mainMateris'     => MainMateri::query()->orderBy('title')->get(),
                'recentQuestions' => Question::query()
                    ->with('subMateri.materi.mainMateri')
                    ->latest()
                    ->limit(10)
                    ->get(),
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
}

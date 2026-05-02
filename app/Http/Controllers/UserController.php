<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Discussion;
use App\Models\DiscussionVote;
use App\Models\MainMateri;
use App\Models\Materi;
use App\Models\IssueReport;
use App\Models\Mission;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\SubMateri;
use App\Models\StudySchedule;
use App\Models\UserAchievement;
use App\Models\UserFavorite;
use App\Models\UserHistory;
use App\Models\UserMission;
use App\Models\UserNote;
use App\Services\AchievementService;
use App\Services\CertificateService;
use App\Services\MissionService;
use App\Services\StreakService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use App\Models\Clan;
use App\Models\ClanMember;
use App\Models\ShopItem;
use App\Models\UserPurchase;
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
        'secret-lab',
        'profile',
        'missions',
        'achievements',
        'notes',
        'analytics',
        'leaderboard',
        'clans',
        'clan-detail',
        'shop',
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

        $user = Auth::user();

        // Check feature toggles for specific pages
        $toggledPages = [
            'schedule' => 'menu_schedule',
            'favorites' => 'menu_favorites',
            'history' => 'menu_history',
            'notes' => 'menu_notes',
            'missions' => 'menu_missions',
            'achievements' => 'menu_achievements',
            'leaderboard' => 'menu_leaderboard',
            'clans' => 'menu_clans',
            'clan-detail' => 'menu_clans',
            'shop' => 'menu_shop',
            'analytics' => 'menu_analytics',
            'secret-lab' => 'menu_secret_lab',
        ];

        if (array_key_exists($page, $toggledPages)) {
            $featureKey = $toggledPages[$page];
            if (!\App\Models\FeatureToggle::isActive($featureKey) && !$user->canAccessAllFeatures()) {
                return view('spa.fragments.feature-disabled');
            }
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

            $mainMateri = MainMateri::where('status', '!=', 'draft')
                ->withCount('materis')
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
                    $main->is_coming_soon = $main->status === 'coming_soon';
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
            $topUsers = $this->processLeaderboardUsers($topUsers);

            // Fetch Schedules for Timeline
            $userSchedules = \App\Models\StudySchedule::where('user_id', Auth::id())
                ->orderBy('start_time')
                ->get();
            $todaySchedules = $userSchedules->filter(fn($s) => $s->isActiveToday())->values();
            $upcomingSchedules = $userSchedules->filter(fn($s) => !$s->isActiveToday() && $s->is_active)->values();

            // Daily Missions widget
            $missionService = new MissionService();
            $missionService->assignDailyMissions(Auth::user());
            $missionService->assignWeeklyMissions(Auth::user());

            $todayMissions = UserMission::where('user_id', Auth::id())
                ->where('assigned_date', now()->toDateString())
                ->whereHas('mission', fn($q) => $q->where('type', 'daily'))
                ->with('mission')
                ->get();

            // Friend users for leaderboard tab
            $myFriendships = \App\Models\Friendship::where('user_id', Auth::id())->orWhere('friend_id', Auth::id())->get();
            $friendIds = $myFriendships->where('status', 'accepted')->map(function ($f) {
                return $f->user_id === Auth::id() ? $f->friend_id : $f->user_id;
            })->unique()->values();
            $friendUsers = $friendIds->isNotEmpty()
                ? \App\Models\User::whereIn('id', $friendIds)->orderByDesc('exp')->get()
                : collect();

            // Smart Recommendations (based on history)
            $recommendedMateris = collect();
            $lastViewed = UserHistory::where('user_id', Auth::id())
                ->with('submateri.materi')
                ->orderByDesc('viewed_at')
                ->first();
            if ($lastViewed && $lastViewed->submateri && $lastViewed->submateri->materi) {
                $currentMateriId = $lastViewed->submateri->materi_id;
                $viewedSubIds = UserHistory::where('user_id', Auth::id())->pluck('sub_materi_id')->toArray();
                $recommendedMateris = SubMateri::where('materi_id', $currentMateriId)
                    ->where('is_published', true)
                    ->whereNotIn('id', $viewedSubIds)
                    ->with('materi')
                    ->limit(4)
                    ->get();
                if ($recommendedMateris->isEmpty()) {
                    $recommendedMateris = SubMateri::where('is_published', true)
                        ->whereNotIn('id', $viewedSubIds)
                        ->with('materi')
                        ->inRandomOrder()
                        ->limit(4)
                        ->get();
                }
            }

            // Streak logic
            $streakData = (new StreakService())->getStreakData(Auth::user());

            // Check achievements
            (new AchievementService())->checkAndAward(Auth::user());

            // Active Event
            $activeEvent = \App\Models\ExpEvent::where('is_active', true)
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->orderByDesc('multiplier')
                ->first();

            return view('spa.fragments.user-dashboard', [
                'data' => ['mainMateri' => $mainMateri],
                'mainMateri' => $mainMateri,
                'topUsers' => $topUsers,
                'myFriendships' => $myFriendships,
                'friendUsers' => $friendUsers,
                'todaySchedules' => $todaySchedules,
                'upcomingSchedules' => $upcomingSchedules,
                'todayMissions' => $todayMissions,
                'recommendedMateris' => $recommendedMateris,
                'streakData' => $streakData,
                'activeEvent' => $activeEvent,
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

            if (!$mainMateri || $mainMateri->status === 'draft') {
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

            // Ambil histories user di materi ini
            $histories = $userId
                ? UserHistory::where('user_id', $userId)
                    ->whereIn('sub_materi_id', $subMateris->pluck('id'))
                    ->get()
                    ->keyBy('sub_materi_id')
                : collect();
            $completedSubIds = $histories->pluck('sub_materi_id')->toArray();

            // Batch load question counts for the sub materis
            $subMateriIds = $subMateris->pluck('id')->toArray();
            $questionCounts = $subMateriIds
                ? Question::whereIn('sub_materi_id', $subMateriIds)
                    ->selectRaw('sub_materi_id, COUNT(*) as cnt')
                    ->groupBy('sub_materi_id')
                    ->pluck('cnt', 'sub_materi_id')
                    ->toArray()
                : [];

            return view('spa.fragments.user-subMateriPage', [
                'materi' => $materi,
                'firstMateri' => $materi,
                'subMateris' => $subMateris,
                'arsipSub' => UserFavorite::getIds(Auth::id(), 'sub'),
                'completed' => $completedSubIds,
                'histories' => $histories,
                'questionCounts' => $questionCounts,
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
            $history = UserHistory::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'sub_materi_id' => $subMateri->id,
                ],
                [
                    'viewed_at' => now(),
                    'completed_babs' => []
                ]
            );

            if (!empty($history->viewed_at) && $history->viewed_at->diffInHours(now()) > 1) {
                $history->update(['viewed_at' => now()]);
            }

            if ($request->has('complete_bab')) {
                $completed = is_array($history->completed_babs) ? $history->completed_babs : [];
                $babToComplete = $request->query('complete_bab');
                if (!in_array($babToComplete, $completed)) {
                    $completed[] = $babToComplete;
                    $history->update(['completed_babs' => $completed]);
                }
            }

            $siblings = SubMateri::where('materi_id', $subMateri->materi_id)
                ->where('is_published', true)
                ->orderBy('id')
                ->get();

            $currentIndex = $siblings->search(fn($s) => $s->id === $subMateri->id);
            $prev = $currentIndex > 0 ? $siblings[$currentIndex - 1] : null;
            $next = $currentIndex < $siblings->count() - 1 ? $siblings[$currentIndex + 1] : null;

            // Discussions for this SubMateri
            $discussions = Discussion::where('sub_materi_id', $subMateri->id)
                ->whereNull('parent_id')
                ->with(['user', 'replies.user'])
                ->orderByDesc('upvotes')
                ->orderByDesc('created_at')
                ->limit(20)
                ->get();

            $myVotes = Auth::id()
                ? DiscussionVote::where('user_id', Auth::id())
                    ->whereIn('discussion_id', $discussions->pluck('id')->merge($discussions->flatMap->replies->pluck('id')))
                    ->pluck('discussion_id')
                    ->toArray()
                : [];

            // Track read_materi mission
            (new MissionService())->trackProgress(Auth::user(), 'read_materi');
            (new AchievementService())->checkAndAward(Auth::user());

            return view('spa.fragments.user-detailSubMateriPage', [
                'subMateri'   => $subMateri,
                'prev'        => $prev,
                'next'        => $next,
                'discussions'  => $discussions,
                'myVotes'      => $myVotes,
            ]);
        }

        // ── Quiz (Kuis untuk satu sub-materi) ─────────────────────────
        if ($page === 'quiz') {
            $subMateriId = $request->query('submateri_id');
            $subMateri = SubMateri::with('materi.mainMateri')->find($subMateriId);

            if (!$subMateri) {
                abort(404);
            }

            $history = UserHistory::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'sub_materi_id' => $subMateri->id,
                ],
                [
                    'viewed_at' => now(),
                    'completed_babs' => []
                ]
            );

            if ($request->has('complete_bab')) {
                $completed = is_array($history->completed_babs) ? $history->completed_babs : [];
                $babToComplete = $request->query('complete_bab');
                if (!in_array($babToComplete, $completed)) {
                    $completed[] = $babToComplete;
                    $history->update(['completed_babs' => $completed]);
                }
            }

            // Server-side lock enforcement for Quiz
            $rawSections = is_array($subMateri->sections) ? $subMateri->sections : json_decode($subMateri->sections, true);
            if (!is_array($rawSections)) $rawSections = [];
            $babs = collect($rawSections)->where('type', 'bab')->values();
            $totalBabs = count($babs);
            
            if ($totalBabs > 0) {
                $lastBabId = $babs[$totalBabs - 1]['order'] ?? '';
                $completed = is_array($history->completed_babs) ? $history->completed_babs : [];
                if (!in_array($lastBabId, $completed)) {
                    // Redirect back if quiz is locked
                    return redirect('?page=detail&submateri_id=' . $subMateri->id);
                }
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
            $data = $this->getProfileData($user);

            // Recent quiz history (latest 5)
            $data['recentQuizzes'] = QuizAttempt::where('user_id', $user->id)
                ->with('subMateri.materi.mainMateri')
                ->orderByDesc('updated_at')
                ->limit(5)
                ->get();

            $data['friends'] = $user->friends;
            $data['friendRequests'] = $user->friendRequestsReceived()->with('sender')->get();
            $data['certificates'] = \App\Models\Certificate::where('user_id', $user->id)
                ->with('materi.mainMateri')
                ->orderByDesc('issued_at')
                ->get();

            return view('spa.fragments.user-account', $data);
        }

        // ── Profile (Public User Profile) ─────────────────────────────
        if ($page === 'profile') {
            $targetUserId = $request->query('id');
            $targetUser = \App\Models\User::find($targetUserId);

            if (!$targetUser || $targetUser->role !== 'user') {
                abort(404);
            }

            $data = $this->getProfileData($targetUser);
            
            $data['certificates'] = \App\Models\Certificate::where('user_id', $targetUser->id)
                ->with('materi.mainMateri')
                ->orderByDesc('issued_at')
                ->get();

            // Mask email
            $emailParts = explode('@', $data['user']->email);
            if (count($emailParts) === 2) {
                $namePart = $emailParts[0];
                if (strlen($namePart) > 3) {
                    $maskedName = substr($namePart, 0, 3) . str_repeat('*', strlen($namePart) - 3);
                } else {
                    $maskedName = substr($namePart, 0, 1) . str_repeat('*', strlen($namePart) - 1);
                }
                $data['user']->masked_email = $maskedName . '@' . $emailParts[1];
            } else {
                $data['user']->masked_email = $data['user']->email;
            }

            $data['myFriendships'] = \App\Models\Friendship::where('user_id', Auth::id())->orWhere('friend_id', Auth::id())->get();

            return view('spa.fragments.user-public-profile', $data);
        }

        // ── Secret Lab ────────────────────────────────────────────────
        if ($page === 'secret-lab') {
            $user = Auth::user();
            return view('spa.fragments.user-secret-lab', [
                'user' => $user,
                'isElite' => $user->isElite(),
                'eliteTier' => $user->elite_tier,
                'rankName' => $user->rank_name,
            ]);
        }

        // ── Missions ──────────────────────────────────────────────────
        if ($page === 'missions') {
            $user = Auth::user();
            $missionService = new MissionService();
            $missionService->assignDailyMissions($user);
            $missionService->assignWeeklyMissions($user);

            $today = now()->toDateString();
            $weekStart = now()->startOfWeek()->toDateString();

            $dailyMissions = UserMission::where('user_id', $user->id)
                ->where('assigned_date', $today)
                ->whereHas('mission', fn($q) => $q->where('type', 'daily'))
                ->with('mission')
                ->get();

            $weeklyMissions = UserMission::where('user_id', $user->id)
                ->where('assigned_date', $weekStart)
                ->whereHas('mission', fn($q) => $q->where('type', 'weekly'))
                ->with('mission')
                ->get();

            return view('spa.fragments.user-missions', [
                'dailyMissions'  => $dailyMissions,
                'weeklyMissions' => $weeklyMissions,
            ]);
        }

        // ── Achievements ─────────────────────────────────────────────
        if ($page === 'achievements') {
            $user = Auth::user();
            (new AchievementService())->checkAndAward($user);

            $allAchievements = Achievement::orderBy('order')->get();
            $earnedIds = UserAchievement::where('user_id', $user->id)
                ->pluck('achievement_id')
                ->toArray();

            return view('spa.fragments.user-achievements', [
                'achievements' => $allAchievements,
                'earnedIds'    => $earnedIds,
            ]);
        }

        // ── Notes ─────────────────────────────────────────────
        if ($page === 'notes') {
            return $this->notesPage($request);
        }

        // ── Analytics ─────────────────────────────────────────────
        if ($page === 'analytics') {
            $user = Auth::user();
            
            // Stats
            $totalQuizzes = QuizAttempt::where('user_id', $user->id)->count();
            $passedQuizzes = QuizAttempt::where('user_id', $user->id)->where('passed', true)->count();
            $avgScore = QuizAttempt::where('user_id', $user->id)->avg('score') ?? 0;
            
            $materisRead = UserHistory::where('user_id', $user->id)->distinct('sub_materi_id')->count();
            
            // Time spent learning (mock calculation based on history count * 5 mins)
            $timeSpentMinutes = UserHistory::where('user_id', $user->id)->count() * 5;
            $timeSpentHours = floor($timeSpentMinutes / 60);
            $timeSpentMinutes = $timeSpentMinutes % 60;
            
            // Learning activity over the last 7 days
            $weeklyActivity = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->toDateString();
                $count = UserHistory::where('user_id', $user->id)
                    ->whereDate('viewed_at', $date)
                    ->count();
                $weeklyActivity[] = [
                    'day' => now()->subDays($i)->translatedFormat('D'),
                    'count' => $count
                ];
            }

            return view('spa.fragments.user-analytics', [
                'totalQuizzes' => $totalQuizzes,
                'passedQuizzes' => $passedQuizzes,
                'avgScore' => round($avgScore),
                'materisRead' => $materisRead,
                'timeSpent' => ['hours' => $timeSpentHours, 'minutes' => $timeSpentMinutes],
                'weeklyActivity' => $weeklyActivity,
            ]);
        }

        // ── Leaderboard ───────────────────────────────────────────────
        if ($page === 'leaderboard') {
            $user = Auth::user();
            
            // Global Top 100
            $globalTop = \App\Models\User::where('role', 'user')
                ->orderByDesc('exp')
                ->limit(100)
                ->get();

            $topUsers = $this->processLeaderboardUsers($globalTop);

            // Friend users for leaderboard tab
            $myFriendships = \App\Models\Friendship::where('user_id', Auth::id())->orWhere('friend_id', Auth::id())->get();
            $friendIds = $myFriendships->where('status', 'accepted')->map(function ($f) {
                return $f->user_id === Auth::id() ? $f->friend_id : $f->user_id;
            })->unique()->values();
            
            // Include self
            $friendIds->push($user->id);
            
            $friendUsers = $friendIds->isNotEmpty()
                ? \App\Models\User::whereIn('id', $friendIds)->orderByDesc('exp')->get()
                : collect();
                
            $friendUsers = $this->processLeaderboardUsers($friendUsers);

            return view('spa.fragments.user-leaderboardPage', [
                'topUsers' => $topUsers,
                'friendUsers' => $friendUsers,
                'myFriendships' => $myFriendships,
                'currentUser' => $user,
            ]);
        }

        // ── Clans ─────────────────────────────────────────────────────
        if ($page === 'clans') {
            $user = Auth::user();
            $userClans = $user->clans;

            $clans = Clan::withCount('members')->orderByDesc('exp')->get();

            $myClans = collect();
            if ($userClans && $userClans->count() > 0) {
                $myClans = Clan::with(['members.user', 'leader'])->whereIn('id', $userClans->pluck('id'))->get();
            }

            return view('spa.fragments.user-clans', [
                'clans' => $clans,
                'myClans' => $myClans,
            ]);
        }

        // ── Clan Detail ───────────────────────────────────────────────
        if ($page === 'clan-detail') {
            $user = Auth::user();
            $clanId = $request->query('id');
            
            $clan = null;
            if ($clanId) {
                $clan = Clan::with(['members.user', 'leader'])->find($clanId);
            } else if ($user->clan) {
                $clan = Clan::with(['members.user', 'leader'])->find($user->clan->id);
            }

            if (!$clan) {
                return $this->page('clans', $request); // Fallback to list
            }

            return view('spa.fragments.user-clan-detail', [
                'clan' => $clan,
                'userMember' => $clan->members->where('user_id', $user->id)->first(),
            ]);
        }

        // ── Shop / Reward Shop ────────────────────────────────────────
        if ($page === 'shop') {
            $user = Auth::user();
            $items = ShopItem::all();
            $purchasedIds = $user->purchases()->pluck('shop_item_id')->toArray();

            return view('spa.fragments.user-shop', [
                'items' => $items,
                'purchasedIds' => $purchasedIds,
                'userCoins' => $user->coins ?? 0,
            ]);
        }

        // ── Fallback ──────────────────────────────────────────────────
        return view('spa.fragments.user', [
            'page' => $page,
            'data' => [],
        ]);
    }

    private function processLeaderboardUsers($users)
    {
        if ($users->isEmpty()) {
            return $users;
        }

        // Compute global achievements for leaderboard
        $topScorer = \App\Models\QuizAttempt::selectRaw('user_id, MAX(score) as max_score')
            ->groupBy('user_id')->orderByDesc('max_score')->first();
        $mostPassed = \App\Models\QuizAttempt::selectRaw('user_id, COUNT(*) as pass_count')
            ->where('passed', true)->groupBy('user_id')->orderByDesc('pass_count')->first();
        $mostAttempts = \App\Models\QuizAttempt::selectRaw('user_id, COUNT(*) as attempt_count')
            ->groupBy('user_id')->orderByDesc('attempt_count')->first();
        $perfectUserIds = \App\Models\QuizAttempt::where('score', 100)->distinct('user_id')->pluck('user_id')->toArray();

        $userIds = $users->pluck('id');

        $historyCounts = \App\Models\UserHistory::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COUNT(DISTINCT sub_materi_id) as c')
            ->groupBy('user_id')->pluck('c', 'user_id');
        $favCounts = \App\Models\UserFavorite::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COUNT(*) as c')
            ->groupBy('user_id')->pluck('c', 'user_id');
        $scheduleCounts = \App\Models\StudySchedule::whereIn('user_id', $userIds)
            ->selectRaw('user_id, COUNT(*) as c')
            ->groupBy('user_id')->pluck('c', 'user_id');

        foreach ($users as $u) {
            $achievements = [];
            $histCount = $historyCounts[$u->id] ?? 0;
            $fCount = $favCounts[$u->id] ?? 0;
            $schedCount = $scheduleCounts[$u->id] ?? 0;

            if ($histCount >= 1) {
                $achievements[] = ['label' => 'First Step', 'icon' => 'achivement001Trans.png', 'desc' => 'Mulai Membaca Materi'];
            }
            if ($histCount >= 50) {
                $achievements[] = ['label' => 'Kutu Buku', 'icon' => 'achivement002Trans.png', 'desc' => 'Membaca 50 Materi'];
            }
            if ($fCount >= 10) {
                $achievements[] = ['label' => 'Kolektor', 'icon' => 'achivement003Trans.png', 'desc' => 'Menyimpan 10 Favorit'];
            }
            if ($schedCount >= 1) {
                $achievements[] = ['label' => 'Terjadwal', 'icon' => 'achivement004Trans.png', 'desc' => 'Membuat Jadwal Belajar'];
            }
            if ($u->exp >= 10000) {
                $achievements[] = ['label' => 'Ahli Rank', 'icon' => 'achivement005Trans.png', 'desc' => 'Mencapai Rank Master'];
            }
            if ($mostAttempts && $mostAttempts->user_id === $u->id) {
                $achievements[] = ['label' => 'Most Active', 'icon' => 'achivement006Trans.png', 'desc' => 'Paling Aktif'];
            }
            if (in_array($u->id, $perfectUserIds)) {
                $achievements[] = ['label' => 'Perfect Score', 'icon' => 'achivement007Trans.png', 'desc' => 'Nilai Sempurna'];
            }
            if ($topScorer && $topScorer->user_id === $u->id) {
                $achievements[] = ['label' => 'Top Scorer', 'icon' => 'achivement008Trans.png', 'desc' => 'Skor Tertinggi'];
            }
            if ($mostPassed && $mostPassed->user_id === $u->id) {
                $achievements[] = ['label' => 'Quiz Master', 'icon' => 'achivement009Trans.png', 'desc' => 'Lulus Kuis Terbanyak'];
            }

            // Tampilkan maksimal 5 lencana agar UI rapi
            $u->achievements = array_slice($achievements, 0, 5);
        }

        return $users;
    }

    private function notesPage(Request $request): View
    {
        $notes = UserNote::where('user_id', Auth::id())
            ->whereNotNull('content')
            ->where('content', '!=', '')
            ->with(['subMateri.materi'])
            ->orderByDesc('updated_at')
            ->get()
            ->groupBy(function($note) {
                return $note->subMateri->materi->title ?? 'Lainnya';
            });

        return view('spa.fragments.user-notes', [
            'groupedNotes' => $notes,
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

        // Track favorite_add mission if favorited
        if ($result['is_favorited']) {
            (new MissionService())->trackProgress(Auth::user(), 'favorite_add');
        }

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

        // Track mission progress
        (new MissionService())->trackProgress($user, 'exp_gain', 10);
        
        // Check-in for streak
        (new StreakService())->checkIn($user);

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
                $expGained = (new \App\Services\ExpService())->addExp($user, 50);

                $existing->update(['exp_awarded' => true]);
                $expAwarded = true;
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
                $expGained = (new \App\Services\ExpService())->addExp($user, 50);
                $expAwarded = true;
            }
        }

        // Track quiz_pass mission if passed
        $certAwarded = false;
        if ($passed) {
            (new MissionService())->trackProgress(Auth::user(), 'quiz_pass');
            (new AchievementService())->checkAndAward(Auth::user());
            (new StreakService())->checkIn(Auth::user());
            
            // Check for certificate
            $subMateri = SubMateri::find($subMateriId);
            if ($subMateri) {
                $cert = (new CertificateService())->checkAndIssue(Auth::user(), $subMateri->materi_id);
                if ($cert && $cert->wasRecentlyCreated) {
                    $certAwarded = true;
                }
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
            'cert_awarded' => $certAwarded,
            'message' => $passed
                ? "Selamat! Kamu lulus dengan skor {$score}% 🎉"
                : "Skor kamu {$score}%. Minimal 80% untuk lulus. Coba lagi! 💪",
        ]);
    }

    // ── Friendship Methods ──
    public function searchFriend(Request $request)
    {
        $query = $request->input('q');
        if (!$query || strlen($query) < 2) return response()->json([]);

        $users = \App\Models\User::where('role', 'user')
            ->where('id', '!=', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })->limit(10)->get();

        $myFriendships = \App\Models\Friendship::where('user_id', Auth::id())
            ->orWhere('friend_id', Auth::id())->get();

        return response()->json($users->map(function($u) use ($myFriendships) {
            $f = $myFriendships->where('user_id', $u->id)->where('friend_id', Auth::id())->first()
               ?? $myFriendships->where('friend_id', $u->id)->where('user_id', Auth::id())->first();
            return [
                'id' => $u->id, 'name' => $u->name, 'email' => $u->email,
                'rank_name' => $u->rank_name,
                'avatar' => $u->avatar ? asset('storage/'.$u->avatar) : asset('assets/ico/'.($u->emblem_image ?? 'default-user.jpg')),
                'friendship_status' => $f ? $f->status : null,
            ];
        }));
    }

    public function addFriend(Request $request, $friendId)
    {
        if ($friendId == Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tidak bisa menambahkan diri sendiri.'], 422);
        }

        $existing = \App\Models\Friendship::where(function($q) use ($friendId) {
            $q->where('user_id', Auth::id())->where('friend_id', $friendId);
        })->orWhere(function($q) use ($friendId) {
            $q->where('user_id', $friendId)->where('friend_id', Auth::id());
        })->first();

        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Permintaan sudah ada atau kalian sudah berteman.'], 422);
        }

        \App\Models\Friendship::create(['user_id' => Auth::id(), 'friend_id' => $friendId, 'status' => 'pending']);
        return response()->json(['success' => true, 'message' => 'Permintaan pertemanan terkirim! 🤝']);
    }

    public function acceptFriend($friendId)
    {
        $f = \App\Models\Friendship::where('user_id', $friendId)->where('friend_id', Auth::id())->where('status', 'pending')->first();
        if ($f) {
            $f->update(['status' => 'accepted']);
            return response()->json(['success' => true, 'message' => 'Permintaan pertemanan diterima! ✅']);
        }
        return response()->json(['success' => false, 'message' => 'Permintaan tidak ditemukan.'], 404);
    }

    public function rejectFriend($friendId)
    {
        $f = \App\Models\Friendship::where('user_id', $friendId)->where('friend_id', Auth::id())->where('status', 'pending')->first();
        if ($f) {
            $f->delete();
            return response()->json(['success' => true, 'message' => 'Permintaan pertemanan ditolak.']);
        }
        return response()->json(['success' => false, 'message' => 'Permintaan tidak ditemukan.'], 404);
    }

    public function removeFriend($friendId)
    {
        $f = \App\Models\Friendship::where(function($q) use ($friendId) {
            $q->where('user_id', Auth::id())->where('friend_id', $friendId);
        })->orWhere(function($q) use ($friendId) {
            $q->where('user_id', $friendId)->where('friend_id', Auth::id());
        })->where('status', 'accepted')->first();

        if ($f) {
            $f->delete();
            return response()->json(['success' => true, 'message' => 'Teman berhasil dihapus.']);
        }
        return response()->json(['success' => false, 'message' => 'Teman tidak ditemukan.'], 404);
    }

    private function getProfileData(\App\Models\User $user): array
    {
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

        $distinctHistoryViews = \App\Models\UserHistory::where('user_id', $userId)->distinct('sub_materi_id')->count('sub_materi_id');
        $totalFavorites = \App\Models\UserFavorite::where('user_id', $userId)->count();
        $totalSchedules = \App\Models\StudySchedule::where('user_id', $userId)->count();

        if ($distinctHistoryViews >= 1) {
            $achievements[] = ['label' => 'First Step', 'icon' => 'achivement001Trans.png', 'desc' => 'Mulai Membaca Materi'];
        }
        if ($distinctHistoryViews >= 50) {
            $achievements[] = ['label' => 'Kutu Buku', 'icon' => 'achivement002Trans.png', 'desc' => 'Membaca 50 Materi'];
        }
        if ($totalFavorites >= 10) {
            $achievements[] = ['label' => 'Kolektor', 'icon' => 'achivement003Trans.png', 'desc' => 'Menyimpan 10 Favorit'];
        }
        if ($totalSchedules >= 1) {
            $achievements[] = ['label' => 'Terjadwal', 'icon' => 'achivement004Trans.png', 'desc' => 'Membuat Jadwal Belajar'];
        }
        if ($user->exp >= 10000) {
            $achievements[] = ['label' => 'Ahli Rank', 'icon' => 'achivement005Trans.png', 'desc' => 'Mencapai Rank Master'];
        }
        if ($mostAttempts && $mostAttempts->user_id === $userId) {
            $achievements[] = ['label' => 'Most Active', 'icon' => 'achivement006Trans.png', 'desc' => 'Paling aktif mencoba kuis'];
        }
        if ($hasPerfect) {
            $achievements[] = ['label' => 'Perfect Score', 'icon' => 'achivement007Trans.png', 'desc' => 'Mendapatkan nilai sempurna (100)'];
        }
        if ($topScorer && $topScorer->user_id === $userId) {
            $achievements[] = ['label' => 'Top Scorer', 'icon' => 'achivement008Trans.png', 'desc' => 'Meraih skor tertinggi secara global'];
        }
        if ($mostPassed && $mostPassed->user_id === $userId) {
            $achievements[] = ['label' => 'Quiz Master', 'icon' => 'achivement009Trans.png', 'desc' => 'Menyelesaikan kuis paling banyak'];
        }

        $quizAttempts = QuizAttempt::where('user_id', $userId)->get();
        $totalQuizAttempts = $quizAttempts->count();
        $quizPassedCount = $quizAttempts->where('passed', true)->count();
        $quizAvgScore = $totalQuizAttempts > 0 ? round($quizAttempts->avg('score'), 1) : 0;
        $quizBestScore = $totalQuizAttempts > 0 ? $quizAttempts->max('score') : 0;

        $totalHistoryViews = UserHistory::where('user_id', $userId)->count();
        $daysActive = (int) $user->created_at->diffInDays(now());

        $totalSubMateris = SubMateri::where('is_published', true)->count();
        $learningProgress = $totalSubMateris > 0 ? round(($distinctHistoryViews / $totalSubMateris) * 100) : 0;

        return [
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
            'completedSubMateris' => $distinctHistoryViews,
            'learningProgress' => $learningProgress,
        ];
    }

    // ── ISSUE REPORT ──────────────────────────────────────────────────────────
    public function storeReport(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reports', 'public');
        }

        IssueReport::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil dikirim']);
    }

    // ═══════════════════════════════════════════════════════════════
    //  MISSION SYSTEM
    // ═══════════════════════════════════════════════════════════════

    public function claimMission(UserMission $userMission): JsonResponse
    {
        $user = Auth::user();
        $result = (new MissionService())->claimReward($user, $userMission);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    // ═══════════════════════════════════════════════════════════════
    //  DISCUSSION SYSTEM
    // ═══════════════════════════════════════════════════════════════

    public function storeDiscussion(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'sub_materi_id' => ['required', 'integer', 'exists:sub_materis,id'],
            'parent_id'     => ['nullable', 'integer', 'exists:discussions,id'],
            'body'          => ['required', 'string', 'max:2000'],
        ]);

        $discussion = Discussion::create([
            'user_id'        => Auth::id(),
            'sub_materi_id'  => $validated['sub_materi_id'],
            'parent_id'      => $validated['parent_id'] ?? null,
            'body'           => $validated['body'],
        ]);

        // Track discussion_post mission
        (new MissionService())->trackProgress(Auth::user(), 'discussion_post');
        (new AchievementService())->checkAndAward(Auth::user());

        $discussion->load('user');

        return response()->json([
            'success'    => true,
            'message'    => 'Komentar berhasil dikirim! 💬',
            'discussion' => [
                'id'         => $discussion->id,
                'body'       => $discussion->body,
                'upvotes'    => 0,
                'created_at' => $discussion->created_at->diffForHumans(),
                'user'       => [
                    'id'        => $discussion->user->id,
                    'name'      => $discussion->user->name,
                    'rank_name' => $discussion->user->rank_name,
                    'avatar'    => $discussion->user->avatar
                        ? asset('storage/' . $discussion->user->avatar)
                        : asset('assets/ico/' . ($discussion->user->emblem_image ?? 'default-user.jpg')),
                ],
            ],
        ]);
    }

    public function voteDiscussion(Discussion $discussion): JsonResponse
    {
        $userId = Auth::id();

        $existing = DiscussionVote::where('user_id', $userId)
            ->where('discussion_id', $discussion->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $discussion->decrement('upvotes');
            return response()->json([
                'success'  => true,
                'voted'    => false,
                'upvotes'  => $discussion->fresh()->upvotes,
                'message'  => 'Vote dibatalkan.',
            ]);
        }

        DiscussionVote::create([
            'user_id'       => $userId,
            'discussion_id' => $discussion->id,
        ]);
        $discussion->increment('upvotes');

        return response()->json([
            'success'  => true,
            'voted'    => true,
            'upvotes'  => $discussion->fresh()->upvotes,
            'message'  => 'Upvoted! 👍',
        ]);
    }

    public function deleteDiscussion(Discussion $discussion): JsonResponse
    {
        if ($discussion->user_id !== Auth::id()) {
            abort(403);
        }

        $discussion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus.',
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  NOTES
    // ═══════════════════════════════════════════════════════════════

    public function getNote($subMateriId): JsonResponse
    {
        $note = UserNote::where('user_id', Auth::id())
            ->where('sub_materi_id', $subMateriId)
            ->first();

        return response()->json([
            'success' => true,
            'content' => $note ? $note->content : '',
        ]);
    }

    public function saveNote(Request $request): JsonResponse
    {
        $request->validate([
            'sub_materi_id' => 'required|integer',
            'content' => 'nullable|string',
        ]);

        UserNote::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'sub_materi_id' => $request->sub_materi_id,
            ],
            [
                'content' => $request->content,
            ]
        );

        return response()->json(['success' => true]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  CERTIFICATE (PUBLIC)
    // ═══════════════════════════════════════════════════════════════

    public function verifyCertificate($code)
    {
        $certificate = \App\Models\Certificate::where('certificate_code', $code)
            ->with(['user', 'materi'])
            ->firstOrFail();

        return view('certificate.verify', [
            'certificate' => $certificate
        ]);
    }

    /**
     * Create a new Clan
     */
    public function createClan(Request $request)
    {
        $user = Auth::user();

        if ($user->clans->count() >= 2) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mencapai batas maksimal 2 Guild!']);
        }

        // Need at least 5000 exp (Senior Rank) to create a Clan
        if ($user->exp < 5000) {
            return response()->json(['success' => false, 'message' => 'Anda butuh Rank Senior (5000+ EXP) untuk membuat Guild!']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:clans,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $clan = Clan::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'leader_id' => $user->id,
            'emblem' => 'emblem004Trans.png', // default emblem
        ]);

        ClanMember::create([
            'clan_id' => $clan->id,
            'user_id' => $user->id,
            'role' => 'leader',
        ]);

        return response()->json(['success' => true, 'message' => 'Guild berhasil dibuat!', 'clan_id' => $clan->id]);
    }

    /**
     * Join a Clan
     */
    public function joinClan(Request $request, $clan_id)
    {
        $user = Auth::user();

        if ($user->clans->count() >= 2) {
            return response()->json(['success' => false, 'message' => 'Anda sudah mencapai batas maksimal 2 Guild!']);
        }

        if ($user->clans->contains('id', $clan_id)) {
            return response()->json(['success' => false, 'message' => 'Anda sudah berada di dalam Guild ini!']);
        }

        $clan = Clan::findOrFail($clan_id);

        if ($clan->members()->count() >= 50) { // Max 50 members
            return response()->json(['success' => false, 'message' => 'Guild ini sudah penuh!']);
        }

        ClanMember::create([
            'clan_id' => $clan->id,
            'user_id' => $user->id,
            'role' => 'member',
        ]);

        // Add some exp to clan when someone joins
        $clan->increment('exp', 50);

        return response()->json(['success' => true, 'message' => 'Berhasil bergabung ke Guild!']);
    }

    /**
     * Leave Clan
     */
    public function leaveClan(Request $request)
    {
        $user = Auth::user();
        $clanId = $request->input('clan_id');
        $query = $user->clanMembers();
        if ($clanId) {
            $query->where('clan_id', $clanId);
        }
        $member = $query->first();

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berada di Guild tersebut!']);
        }

        $clan = Clan::withCount('members')->find($member->clan_id);

        if ($member->role === 'leader') {
            if ($clan->members_count <= 1) {
                // Solo leader — disband the guild entirely
                ClanMember::where('clan_id', $clan->id)->delete();
                $clan->delete();
                return response()->json(['success' => true, 'message' => 'Guild telah dibubarkan karena tidak ada anggota lain.']);
            }

            // Transfer leadership to the oldest remaining member
            $nextLeader = ClanMember::where('clan_id', $clan->id)
                ->where('user_id', '!=', $user->id)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($nextLeader) {
                $nextLeader->update(['role' => 'leader']);
                $clan->update(['leader_id' => $nextLeader->user_id]);
            }
        }

        $member->delete();

        return response()->json(['success' => true, 'message' => 'Berhasil keluar dari Guild.']);
    }

    /**
     * Purchase a shop item
     */
    public function purchaseItem(Request $request, $item_id)
    {
        $user = Auth::user();
        $item = ShopItem::findOrFail($item_id);

        if ($user->hasPurchased($item->id)) {
            return response()->json(['success' => false, 'message' => 'Item sudah dibeli!']);
        }

        if (($user->coins ?? 0) < $item->price) {
            return response()->json(['success' => false, 'message' => 'Koin tidak cukup! Butuh ' . $item->price . ' Koin.']);
        }

        // Deduct coins and record purchase
        $user->decrement('coins', $item->price);
        UserPurchase::create([
            'user_id' => $user->id,
            'shop_item_id' => $item->id,
            'equipped' => false,
        ]);

        return response()->json(['success' => true, 'message' => '"' . $item->name . '" berhasil dibeli!', 'coins_left' => $user->fresh()->coins]);
    }
}

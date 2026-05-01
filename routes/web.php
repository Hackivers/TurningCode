<?php

use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\Admin\AdminMateriController;
use App\Http\Controllers\Admin\AdminQuestionController;
use App\Http\Controllers\Admin\AdminSubMateriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login/otp', [AuthController::class, 'showLoginOtp'])->name('login.otp');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Public Certificate Verification
Route::get('/certificate/{code}', [UserController::class, 'verifyCertificate'])->name('certificate.verify');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');



    Route::post('/email/verification-notification', function (Request $request) {
        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue verification email', [
                'error' => $e->getMessage(),
            ]);
        }

        return back()->with('info', 'Tautan verifikasi baru sudah dikirim.');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    // Cari user berdasarkan ID
    $user = \App\Models\User::findOrFail($id);

    // Verifikasi hash email
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Tautan verifikasi tidak valid atau sudah kedaluwarsa.');
    }

    // Jika belum diverifikasi, tandai sebagai diverifikasi
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    // Loginkan user secara otomatis setelah verifikasi sukses
    \Illuminate\Support\Facades\Auth::login($user);

    // Arahkan ke dashboard yang sesuai
    return $user->role === 'admin'
        ? redirect()->route('admin.spa')->with('success', 'Email berhasil dikonfirmasi.')
        : redirect()->route('user.spa')->with('success', 'Email berhasil dikonfirmasi.');
})->middleware(['signed'])->name('verification.verify');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/app', [UserController::class, 'spa'])->name('user.spa');
    Route::get('/app/page/{page}', [UserController::class, 'page'])->name('user.page');
    Route::post('/app/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/app/api/exp/ping', [UserController::class, 'pingExp'])->name('user.exp.ping');
    // Schedule CRUD (JSON API)
    Route::post('/app/schedule', [UserController::class, 'storeSchedule'])->name('user.schedule.store');
    Route::put('/app/schedule/{schedule}', [UserController::class, 'updateSchedule'])->name('user.schedule.update');
    Route::delete('/app/schedule/{schedule}', [UserController::class, 'deleteSchedule'])->name('user.schedule.delete');
    Route::post('/app/schedule/{schedule}/toggle', [UserController::class, 'toggleSchedule'])->name('user.schedule.toggle');
    Route::get('/app/api/schedules/today', [UserController::class, 'todaySchedules'])->name('user.schedule.today');

    // Favorites
    Route::post('/app/favorite/toggle', [UserController::class, 'toggleFavorite'])->name('user.favorite.toggle');

    // Quiz
    Route::post('/app/api/quiz/submit', [UserController::class, 'submitQuiz'])->name('user.quiz.submit');

    // Friends
    Route::get('/app/friend/search', [UserController::class, 'searchFriend'])->name('user.friend.search');
    Route::post('/app/friend/add/{friend_id}', [UserController::class, 'addFriend'])->name('user.friend.add');
    Route::post('/app/friend/accept/{friend_id}', [UserController::class, 'acceptFriend'])->name('user.friend.accept');
    Route::post('/app/friend/reject/{friend_id}', [UserController::class, 'rejectFriend'])->name('user.friend.reject');
    Route::delete('/app/friend/remove/{friend_id}', [UserController::class, 'removeFriend'])->name('user.friend.remove');

    // Report
    Route::post('/app/report', [UserController::class, 'storeReport'])->name('user.report.store');

    // Missions
    Route::post('/app/api/mission/claim/{userMission}', [UserController::class, 'claimMission'])->name('user.mission.claim');

    // Discussions
    Route::post('/app/api/discussion', [UserController::class, 'storeDiscussion'])->name('user.discussion.store');
    Route::post('/app/api/discussion/{discussion}/vote', [UserController::class, 'voteDiscussion'])->name('user.discussion.vote');
    Route::delete('/app/api/discussion/{discussion}', [UserController::class, 'deleteDiscussion'])->name('user.discussion.delete');

    // Notes
    Route::get('/app/api/notes/{sub_materi_id}', [UserController::class, 'getNote'])->name('user.note.get');
    Route::post('/app/api/notes', [UserController::class, 'saveNote'])->name('user.note.save');

    // Clans
    Route::post('/app/api/clan/create', [UserController::class, 'createClan'])->name('user.clan.create');
    Route::post('/app/api/clan/join/{clan_id}', [UserController::class, 'joinClan'])->name('user.clan.join');
    Route::post('/app/api/clan/leave', [UserController::class, 'leaveClan'])->name('user.clan.leave');

    // Shop
    Route::post('/app/api/shop/purchase/{item_id}', [UserController::class, 'purchaseItem'])->name('user.shop.purchase');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'spa'])->name('admin.spa');
    Route::get('/admin/page/{page}', [AdminController::class, 'page'])->name('admin.page');

    // Main Materi
    Route::post('/admin/main-materi', [AdminMateriController::class, 'storeMainMateri'])->name('admin.main-materi.store');
    Route::put('/admin/main-materi/{mainMateri}', [AdminMateriController::class, 'updateMainMateri'])->name('admin.main-materi.update');
    Route::delete('/admin/main-materi/{mainMateri}', [AdminMateriController::class, 'deleteMainMateri'])->name('admin.main-materi.delete');

    // Materi
    Route::post('/admin/materi', [AdminMateriController::class, 'storeMateri'])->name('admin.materi.store');
    Route::put('/admin/materi/{materi}', [AdminMateriController::class, 'updateMateri'])->name('admin.materi.update');
    Route::delete('/admin/materi/{materi}', [AdminMateriController::class, 'deleteMateri'])->name('admin.materi.delete');

    // Main Materi Excel Import/Template
    Route::post('/admin/main-materi/import', [AdminMateriController::class, 'importMainMateriExcel'])->name('admin.main-materi.import');
    Route::get('/admin/main-materi/template', [AdminMateriController::class, 'downloadMainMateriTemplate'])->name('admin.main-materi.template');

    // Materi Excel Import/Template
    Route::post('/admin/materi/import', [AdminMateriController::class, 'importMateriExcel'])->name('admin.materi.import');
    Route::get('/admin/materi/template', [AdminMateriController::class, 'downloadMateriTemplate'])->name('admin.materi.template');

    // Sub Materi Excel Import/Template
    Route::post('/admin/sub-materi/import', [AdminSubMateriController::class, 'importSubMateriExcel'])->name('admin.sub-materi.import');
    Route::get('/admin/sub-materi/template', [AdminSubMateriController::class, 'downloadSubMateriTemplate'])->name('admin.sub-materi.template');

    // Sub Materi
    Route::get('/admin/api/main/{mainMateri}/materis', [AdminSubMateriController::class, 'materisByMain'])->name('admin.api.materis-by-main');
    Route::post('/admin/sub-materi', [AdminSubMateriController::class, 'store'])->name('admin.sub-materi.store');
    Route::post('/admin/sub-materi/{subMateri}/full-update', [AdminSubMateriController::class, 'updateFull'])->name('admin.sub-materi.updateFull');
    Route::put('/admin/sub-materi/{subMateri}', [AdminSubMateriController::class, 'update'])->name('admin.sub-materi.update');
    Route::delete('/admin/sub-materi/{subMateri}', [AdminSubMateriController::class, 'destroy'])->name('admin.sub-materi.delete');

    // Questions
    Route::get('/admin/api/materi/{materi}/sub-materis', [AdminQuestionController::class, 'subMaterisByMateri'])->name('admin.api.sub-materis-by-materi');
    Route::post('/admin/question', [AdminQuestionController::class, 'store'])->name('admin.question.store');
    Route::post('/admin/question/import', [AdminQuestionController::class, 'importExcel'])->name('admin.question.import');
    Route::get('/admin/question/template', [AdminQuestionController::class, 'downloadTemplate'])->name('admin.question.template');
    Route::put('/admin/question/{question}', [AdminQuestionController::class, 'update'])->name('admin.question.update');
    Route::delete('/admin/question/{question}', [AdminQuestionController::class, 'destroy'])->name('admin.question.delete');
    Route::delete('/admin/question/sub-materi/{subMateri}', [AdminQuestionController::class, 'destroyBySubMateri'])->name('admin.question.delete-by-submateri');

    // Admin global chat
    Route::get('/admin/api/chat', [AdminChatController::class, 'index'])->name('admin.chat.index');
    Route::post('/admin/api/chat', [AdminChatController::class, 'store'])->name('admin.chat.store');

    // Admin Web Terminal (CMD)
    Route::post('/admin/api/cmd', [AdminController::class, 'runCommand'])->name('admin.cmd');

    // Admin Issue Report
    Route::post('/admin/api/report', [AdminController::class, 'storeReport'])->name('admin.report.store');
    Route::put('/admin/api/report/{issueReport}/resolve', [AdminController::class, 'resolveReport'])->name('admin.report.resolve');

    // Admin Notifications
    Route::get('/admin/api/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');

    // Admin Profile
    Route::post('/admin/api/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

    // Admin Friend List
    Route::get('/admin/api/online-admins', [AdminController::class, 'onlineAdmins'])->name('admin.online-admins');

    // Database Table CRUD
    Route::get('/admin/api/table/{table}/rows', [AdminController::class, 'tableRows'])->name('admin.table.rows');
    Route::put('/admin/api/table/{table}/row/{id}', [AdminController::class, 'updateRow'])->name('admin.table.update');
    Route::delete('/admin/api/table/{table}/row/{id}', [AdminController::class, 'deleteRow'])->name('admin.table.delete');

    // Events
    Route::post('/admin/events', [AdminController::class, 'storeEvent'])->name('admin.events.store');
    Route::put('/admin/events/{event}', [AdminController::class, 'updateEvent'])->name('admin.events.update');
    Route::delete('/admin/events/{event}', [AdminController::class, 'destroyEvent'])->name('admin.events.delete');
});

<?php

use App\Http\Controllers\Admin\AdminMateriController;
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

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        $user = $request->user();

        return $user->role === 'admin'
            ? redirect()->route('admin.spa')->with('success', 'Email berhasil dikonfirmasi.')
            : redirect()->route('user.spa')->with('success', 'Email berhasil dikonfirmasi.');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('info', 'Tautan verifikasi baru sudah dikirim.');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/app', [UserController::class, 'spa'])->name('user.spa');
    Route::get('/app/page/{page}', [UserController::class, 'page'])->name('user.page');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'spa'])->name('admin.spa');
    Route::get('/admin/page/{page}', [AdminController::class, 'page'])->name('admin.page');
    Route::post('/admin/main-materi', [AdminMateriController::class, 'storeMainMateri'])->name('admin.main-materi.store');
    Route::post('/admin/materi', [AdminMateriController::class, 'storeMateri'])->name('admin.materi.store');
    Route::get('/admin/api/main/{mainMateri}/materis', [AdminSubMateriController::class, 'materisByMain'])->name('admin.api.materis-by-main');
    Route::post('/admin/sub-materi', [AdminSubMateriController::class, 'store'])->name('admin.sub-materi.store');
});

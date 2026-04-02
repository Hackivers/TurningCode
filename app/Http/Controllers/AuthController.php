<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedHome();
        }

        return view('auth.index');
    }

    public function showLogin(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedHome();
        }

        $request->session()->forget('admin_email');

        return view('auth.login');
    }

    public function showLoginOtp(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedHome();
        }

        if (! $request->session()->has('admin_email')) {
            return redirect()->route('login');
        }

        return view('auth.login-otp', [
            'email' => $request->session()->get('admin_email'),
        ]);
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedHome();
        }

        return view('auth.register');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'string'],
            'codeOTP' => ['nullable', 'string'],
        ]);

        $emailInput = $request->input('email') ?? $request->session()->get('admin_email');
        $codeInput = $request->input('codeOTP') ?? $request->input('password');

        $emailInput = $emailInput !== null && $emailInput !== '' ? trim($emailInput) : null;

        $adminEntry = $emailInput ? $this->findAdminMapEntry($emailInput) : null;

        // =====================
        // KIRIM OTP ADMIN
        // =====================
        if ($adminEntry && ($codeInput === null || $codeInput === '')) {
            $canonicalEmail = $adminEntry['login'];

            $request->session()->put('admin_email', $canonicalEmail);

            $code = (string) random_int(100000, 999999);

            DB::table('admin_codes')->updateOrInsert(
                ['email' => $canonicalEmail],
                [
                    'code' => Hash::make($code),
                    'expired_at' => now()->addMinutes(10),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            Mail::raw("Kode login admin Anda: {$code}", function ($message) use ($adminEntry) {
                $message->to($adminEntry['recipient'])
                    ->subject('Kode Login Admin TurningCode');
            });

            return redirect()->route('login.otp')->with(
                'info',
                'Kode OTP sudah dikirim ke inbox Gmail: '.$adminEntry['recipient'].' (cek juga folder spam).'
            );
        }

        // =====================
        // VERIFIKASI OTP ADMIN
        // =====================
        if ($adminEntry && $codeInput !== null && $codeInput !== '') {
            $canonicalEmail = $adminEntry['login'];

            $adminCode = DB::table('admin_codes')
                ->where('email', $canonicalEmail)
                ->where('expired_at', '>', now())
                ->first();

            if ($adminCode && Hash::check($codeInput, $adminCode->code)) {

                $user = User::firstOrCreate(
                    ['email' => $canonicalEmail],
                    [
                        'name' => 'Admin',
                        'password' => Hash::make(Str::random(32)),
                        'role' => 'admin',
                        'email_verified_at' => now(),
                    ]
                );

                $user->forceFill([
                    'role' => 'admin',
                    'email_verified_at' => $user->email_verified_at ?? now(),
                    'last_seen' => now(),
                ])->save();

                Auth::login($user);
                $request->session()->regenerate();

                DB::table('admin_codes')->where('email', $canonicalEmail)->delete();
                $request->session()->forget('admin_email');

                return redirect()->route('admin.spa')->with('success', 'Login admin berhasil');
            }

            return back()->with('error', 'Kode salah atau kadaluarsa');
        }

        // =====================
        // LOGIN USER BIASA
        // =====================
        if (! $emailInput) {
            return back()->with('error', 'Email wajib diisi')->withInput($request->only('email'));
        }

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if ($this->findAdminMapEntry($emailInput)) {
            return back()->with('error', 'Gunakan alur OTP admin (kosongkan password lalu kirim untuk OTP).')->withInput($request->only('email'));
        }

        if (Auth::attempt(['email' => $emailInput, 'password' => $request->input('password')], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (! $user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            $user->forceFill(['last_seen' => now()])->save();

            return $this->redirectForRole($user->role);
        }

        return back()->with('error', 'Email atau password salah')->withInput($request->only('email'));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * @return array{login: string, recipient: string}|null
     */
    private function findAdminMapEntry(string $email): ?array
    {
        $map = config('admin.emails', []);

        foreach ($map as $adminLogin => $recipient) {
            if (strcasecmp((string) $adminLogin, $email) === 0) {
                return ['login' => (string) $adminLogin, 'recipient' => $recipient];
            }
        }

        return null;
    }

    private function redirectAuthenticatedHome(): RedirectResponse
    {
        $user = Auth::user();
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return $this->redirectForRole($user->role);
    }

    private function redirectForRole(string $role): RedirectResponse
    {
        return match ($role) {
            'admin' => redirect()->intended(route('admin.spa')),
            default => redirect()->intended(route('user.spa')),
        };
    }
}

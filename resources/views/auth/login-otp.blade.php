<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('src/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('src/css/auth.css') }}">
    <title>Masuk — {{ config('app.name') }}</title>
</head>

<body>
    <main class="thumbnail">
        <div class="wrapper-thumb">
            <div class="title-thumb">
                <h2>yok, buruan login!!</h2>
                <h5>materi udah nugguin nih, buat dipelajari...</h5>
            </div>
            <div class="thumb-img">
                <img src="{{ asset('assets/ico/img001thumb02Trans.png') }}" alt="">
            </div>
        </div>
    </main>
    <main class="form-input">
        <div class="wrapper-input">
            <div class="title-input">
                <h2>login</h2>
            </div>
            <div class="profile">
                <div class="wrapper-profile">
                    <div class="profile-admin">
                        <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="admin image">
                        <input type="hidden" name="email" value="{{ $email }}">
                    </div>
                    <div class="profile-title">
                        <h5>admin</h5>
                        <h4>{{ $email }}</h4>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('login') }}" class="main-input admin-otp">
                @csrf
                <div class="input pass">
                    <label for="password">
                        <h5>Kode OTP</h5>
                    </label>
                    <div>
                        <i class='bx bxs-lock'></i>
                        <input type="password" name="password" id="password" placeholder="XX XX XX">
                        <i class='bx bx-show toggle-password' id="togglePassword"></i>
                    </div>
                </div>
                @if (session('info'))
                    <h5 class="text-sm info">{{ session('info') }}</h5>
                @endif
                @if (session('error'))
                    <h5 class="text-sm error">{{ session('error') }}</h5>
                @endif
                <button type="submit" class="btn-resend">
                    Kirim ulang OTP
                </button>
                <div class="btn">
                    <button type="button" onclick="window.location='{{ route('home') }}'">
                        kembali
                    </button>
                    <button type="submit">Login</button>
                </div>
                <h5 class="register">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-zinc-900 underline">Daftar</a>
                </h5>
            </form>
        </div>
    </main>
    <script>
        document.querySelectorAll('.input input').forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.input').classList.add('fokus');
            });

            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.closest('.input').classList.remove('fokus');
                }
            });
        });

        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        toggle.addEventListener('click', () => {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // ganti icon
            toggle.classList.toggle('bx-show');
            toggle.classList.toggle('bx-hide');
        });
    </script>
</body>

</html>













{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kode OTP Admin — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4">
        <h1 class="text-center text-2xl font-semibold">Kode OTP</h1>
        <p class="mt-2 text-center text-sm text-zinc-600">Masukkan 6 digit kode yang dikirim ke inbox email terdaftar.</p>
        <div class="mt-4 rounded-lg border border-zinc-200 bg-white px-4 py-3 text-center text-sm">
            <span class="text-zinc-500">Email admin</span><br>
            <span class="font-medium text-zinc-900">{{ $email }}</span>
        </div>
        <form method="post" action="{{ route('login') }}" class="mt-6 space-y-4 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div>
                <label for="codeOTP" class="block text-sm font-medium text-zinc-700">Kode OTP</label>
                <input id="codeOTP" type="text" name="codeOTP" inputmode="numeric" pattern="[0-9]*" maxlength="6" required
                    autofocus autocomplete="one-time-code"
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-center text-lg tracking-widest shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500"
                    placeholder="000000">
            </div>
            @if (session('info'))
                <p class="text-sm text-blue-700">{{ session('info') }}</p>
            @endif
            @if (session('error'))
                <p class="text-sm text-red-600">{{ session('error') }}</p>
            @endif
            <button type="submit"
                class="w-full rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                Verifikasi &amp; masuk
            </button>
        </form>
        <form method="post" action="{{ route('login') }}" class="mt-3 text-center">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="text-sm text-zinc-600 underline hover:text-zinc-900">
                Kirim ulang OTP
            </button>
        </form>
        <p class="mt-6 text-center text-sm">
            <a href="{{ route('login') }}" class="text-zinc-600 hover:text-zinc-900">← Ganti email / kembali</a>
        </p>
    </div>
</body>

</html> --}}

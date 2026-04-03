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
            <form method="post" action="{{ route('login') }}" class="main-input">
                @if (session('info'))
                    <h5 class="text-sm info">{{ session('info') }}</h5>
                @endif
                @if (session('error'))
                    <h5 class="text-sm error">{{ session('error') }}</h5>
                @endif
                @error('email')
                    <h5 class="text-sm email">{{ $message }}</h5>
                @enderror
                <div class="input">
                    <label for="email">
                        <h5>email</h5>
                    </label>
                    <div>
                        <i class='bx bxl-gmail'></i>
                        <input type="text" name="email" id="email" placeholder="Email">
                    </div>
                </div>
                <div class="input pass">
                    <label for="password">
                        <h5>password</h5>
                    </label>
                    <div>
                        <i class='bx bxs-lock'></i>
                        <input type="password" name="password" id="password" placeholder="Password">
                        <i class='bx bx-show toggle-password' id="togglePassword"></i>
                    </div>
                </div>
                <div class="remember">
                    <div class="checkbox-wrapper-30">
                        <span class="checkbox">
                            <input type="checkbox" />
                            <svg>
                                <use xlink:href="#checkbox-30" class="checkbox"></use>
                            </svg>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
                            <symbol id="checkbox-30" viewBox="0 0 22 22">
                                <path fill="none" stroke="currentColor"
                                    d="M5.5,11.3L9,14.8L20.2,3.3l0,0c-0.5-1-1.5-1.8-2.7-1.8h-13c-1.7,0-3,1.3-3,3v13c0,1.7,1.3,3,3,3h13 c1.7,0,3-1.3,3-3v-13c0-0.4-0.1-0.8-0.3-1.2" />
                            </symbol>
                        </svg>
                    </div>
                    <input style="display: none" type="checkbox" name="remember" class="rounded border-zinc-300">
                    <h5>ingat saya</h5>
                </div>
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
    <title>Masuk — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4">
        <h1 class="text-center text-2xl font-semibold">Masuk</h1>
        <p class="mt-2 text-center text-sm text-zinc-600">Admin: isi email admin, <strong>kosongkan password</strong>, lalu kirim — OTP dikirim ke email terdaftar.</p>
        <form method="post" action="{{ route('login') }}" class="mt-6 space-y-4 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-zinc-700">Password</label>
                <input id="password" type="password" name="password" autocomplete="current-password"
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
            </div>
            <label class="flex items-center gap-2 text-sm text-zinc-600">
                <input type="checkbox" name="remember" class="rounded border-zinc-300">
                Ingat saya
            </label>
            @if (session('info'))
                <p class="text-sm text-blue-700">{{ session('info') }}</p>
            @endif
            @if (session('error'))
                <p class="text-sm text-red-600">{{ session('error') }}</p>
            @endif
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
            <button type="submit"
                class="w-full rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                Masuk
            </button>
        </form>
        <p class="mt-6 text-center text-sm text-zinc-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-zinc-900 underline">Daftar</a>
        </p>
        <p class="mt-4 text-center text-sm">
            <a href="{{ route('home') }}" class="text-zinc-500 hover:text-zinc-800">← Kembali</a>
        </p>
    </div>
</body>

</html> --}}

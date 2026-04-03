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
            <form method="post" action="{{ route('register') }}" class="main-input">
                @csrf
                <div class="input">
                    <label for="name">
                        <h5>nama</h5>
                    </label>
                    <div>
                        <i class='bx bx-user'></i>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="nama" required autofocus>
                    </div>
                </div>
                <div class="input">
                    <label for="email">
                        <h5>email</h5>
                    </label>
                    <div>
                        <i class='bx bxl-gmail'></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" required>
                    </div>
                </div>
                <div class="input pass">
                    <label for="password">
                        <h5>password</h5>
                    </label>
                    <div>
                        <i class='bx bxs-lock'></i>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <i class='bx bx-show toggle-password' id="togglePassword"></i>
                    </div>
                </div>
                <div class="input pass">
                    <label for="password_confirmation">
                        <h5>ulangi password</h5>
                    </label>
                    <div>
                        <i class='bx bxs-lock'></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Ulangi Password" required>
                        <i class='bx bx-show toggle-password' id="togglePassword"></i>
                    </div>
                </div>
                <div class="list">
                    @if ($errors->any())
                        <ul class="list-info">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="btn">
                    <button type="button" onclick="window.location='{{ route('home') }}'">
                        kembali
                    </button>
                    <button type="submit">Daftar</button>
                </div>
                <h5 class="register">
                    Udah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-zinc-900 underline">Masuk</a>
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

        // FIX: support semua toggle password
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');

                const type = input.type === 'password' ? 'text' : 'password';
                input.type = type;

                // toggle icon
                this.classList.toggle('bx-show');
                this.classList.toggle('bx-hide');
            });
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
    <title>Daftar — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4 py-8">
        <h1 class="text-center text-2xl font-semibold">Daftar</h1>
        <p class="mt-2 text-center text-sm text-zinc-600">Akun baru mendapat peran <strong>user</strong>.</p>
        <form method="post" action="{{ route('register') }}" class="mt-8 space-y-4 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-zinc-700">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-zinc-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-zinc-700">Ulangi password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
            </div>
            @if ($errors->any())
                <ul class="list-inside list-disc text-sm text-red-600">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif
            <button type="submit"
                class="w-full rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                Daftar
            </button>
        </form>
        <p class="mt-6 text-center text-sm text-zinc-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-zinc-900 underline">Masuk</a>
        </p>
        <p class="mt-4 text-center text-sm">
            <a href="{{ route('home') }}" class="text-zinc-500 hover:text-zinc-800">← Kembali</a>
        </p>
    </div>
</body>

</html> --}}

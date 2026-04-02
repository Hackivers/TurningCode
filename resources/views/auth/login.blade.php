<!DOCTYPE html>
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

</html>

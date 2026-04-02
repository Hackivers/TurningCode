<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Konfirmasi email — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4">
        <h1 class="text-center text-2xl font-semibold">Konfirmasi email</h1>
        <p class="mt-3 text-center text-sm text-zinc-600">
            Terima kasih sudah mendaftar. Sebelum mengakses dashboard, silakan klik tautan verifikasi di email
            <strong>{{ auth()->user()->email }}</strong>.
        </p>
        @if (session('info'))
            <p class="mt-4 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-center text-sm text-blue-800">
                {{ session('info') }}
            </p>
        @endif
        <form method="post" action="{{ route('verification.send') }}" class="mt-6 text-center">
            @csrf
            <button type="submit"
                class="inline-flex rounded-md bg-zinc-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-zinc-800">
                Kirim ulang email verifikasi
            </button>
        </form>
        <form method="post" action="{{ route('logout') }}" class="mt-8 text-center">
            @csrf
            <button type="submit" class="text-sm text-zinc-500 underline hover:text-zinc-800">Keluar</button>
        </form>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-lg flex-col items-center justify-center px-4">
        <h1 class="text-3xl font-semibold tracking-tight">{{ config('app.name') }}</h1>
        <p class="mt-2 text-center text-sm text-zinc-600">Silakan masuk atau daftar sebagai pengguna.</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('login') }}"
                class="inline-flex rounded-md bg-zinc-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-zinc-800">
                Masuk
            </a>
            <a href="{{ route('register') }}"
                class="inline-flex rounded-md border border-zinc-300 bg-white px-5 py-2.5 text-sm font-medium text-zinc-800 hover:bg-zinc-50">
                Daftar
            </a>
        </div>
    </div>
</body>

</html>

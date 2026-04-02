<!DOCTYPE html>
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

</html>

<!DOCTYPE html>
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

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @if (Auth::User()->role == 'admin')
        @vite(['resources/css/app.css', $viteEntry])
    @else
        @vite([$viteEntry])
    @endif
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @if (Auth::User()->role == 'user')
        <link rel="stylesheet" href="{{ asset('src/css/global.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('src/css/style.css') }}">
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased" data-spa-initial="{{ $initialPage }}"
    data-spa-base="{{ $pageBaseUrl }}">
    @yield('content')
    <script src="{{ asset('src/js/OpenNavigations.js') }}"></script>
</body>

</html>

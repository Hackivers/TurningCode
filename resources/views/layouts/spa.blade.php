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
        @vite(['resources/css/global.css', 'resources/css/style.css', $viteEntry])
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>if(localStorage.getItem('tc_dark_mode')==='true')document.documentElement.classList.add('dark-mode-pending');</script>
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased" data-spa-initial="{{ $initialPage }}"
    data-spa-base="{{ $pageBaseUrl }}">
    @yield('content')
    <script src="{{ asset('src/js/OpenNavigations.js') }}"></script>
</body>

</html>

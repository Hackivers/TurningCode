<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', $viteEntry])
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('src/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('src/css/style.css') }}">
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased" data-spa-initial="{{ $initialPage }}"
    data-spa-base="{{ $pageBaseUrl }}">
    @yield('content')
</body>

</html>

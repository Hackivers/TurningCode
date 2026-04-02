<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', $viteEntry])
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased" data-spa-initial="{{ $initialPage }}"
    data-spa-base="{{ $pageBaseUrl }}">
    @yield('content')
</body>

</html>

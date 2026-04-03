<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('src/css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('src/css/global.css') }}">
    {{-- @vite(['resources/css/app.css']) --}}
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <div class="back-cover">
        <h1>Turning Code</h1>
        <h1>Turning Code</h1>
        <h1>Turning Code</h1>
        <h1>Turning Code</h1>
    </div>
    <div class="container">
        <main class="wrapper">
            <div class="title">
                <h2>welcome to</h2>
                <h1>Turning<strong>Code</strong></h1>
            </div>
            <div class="thumbnail">
                <img src="{{ asset('assets/ico/img001thumb01Trans.png') }}" alt="">
            </div>
            <div>
                <h5>silahkan login, atau bila tidak memiliki akun silahkan daftar terlebih dahulu</h5>
            </div>
            <div class="btn">
                <a href="{{ route('login') }}">
                    <button>login</button>
                </a>
                <div class="strip">
                    <span>or</span>
                    <hr>
                </div>
                <a href="{{ route('register') }}">
                    <button>register</button>
                </a>
            </div>
        </main>
    </div>
</body>
</html>

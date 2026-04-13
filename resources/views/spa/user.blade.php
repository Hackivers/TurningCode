@extends('layouts.spa')

@section('content')
    @include('spa.fragments.user-navBar')
    @include('spa.fragments.user-asideBar')

    <div id="spa-content">
        <div class="loading-page">
            <i class='bx bx-loader-alt bx-spin' style='font-size: 2.5em;'></i>
            <p>Memuat…</p>
        </div>
    </div>
    <div class="bottom-space"></div>
    @include('spa.fragments.user-navBottom')

    {{-- Toast container for schedule notifications --}}
    <div id="toast-container"></div>

    {{-- No Internet Connection Overlay --}}
    <div id="offline-overlay" class="offline-overlay active checking">
        <div class="offline-content">
            {{-- Animated signal icon --}}
            <div class="offline-icon-wrapper">
                <div class="offline-pulse-ring"></div>
                <div class="offline-pulse-ring delay-1"></div>
                <div class="offline-pulse-ring delay-2"></div>
                <div class="offline-icon">
                    <i class='bx bx-wifi-off'></i>
                </div>
            </div>

            {{-- Status indicator dot --}}
            <div class="offline-status">
                <span class="offline-dot"></span>
                <span>Offline</span>
            </div>

            {{-- Text --}}
            <h3 class="offline-title">Tidak Ada Koneksi Internet</h3>
            <p class="offline-desc">
                Periksa koneksi Wi-Fi atau data seluler kamu, lalu coba lagi.
            </p>

            {{-- Retry button --}}
            <button id="offline-retry-btn" class="offline-retry-btn" onclick="window.__retryConnection()">
                <i class='bx bx-refresh'></i>
                <span>Coba Lagi</span>
            </button>

            {{-- Connection tips --}}
            <div class="offline-tips">
                <div class="offline-tip">
                    <i class='bx bx-wifi'></i>
                    <span>Periksa Wi-Fi</span>
                </div>
                <div class="offline-tip-divider"></div>
                <div class="offline-tip">
                    <i class='bx bx-signal-5'></i>
                    <span>Data Seluler</span>
                </div>
                <div class="offline-tip-divider"></div>
                <div class="offline-tip">
                    <i class='bx bx-reset'></i>
                    <span>Restart Router</span>
                </div>
            </div>
        </div>
    </div>
@endsection
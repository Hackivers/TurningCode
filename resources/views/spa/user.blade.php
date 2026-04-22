@extends('layouts.spa')

@section('content')
    @include('spa.fragments.user-navBar')
    @include('spa.fragments.user-asideBar')

    <div id="spa-content">
        <div class="loading-page">
            <div class="loading-spinner"></div>
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

@section('styles')
    <style>
        /* ═══ ROTOOD — GLOBAL DARK BODY ═══ */
        :root {
            --bg-primary: #060606 !important;
            --text-primary: #ffffff !important;
        }

        body {
            background-color: #060606 !important;
            color: #ffffff !important;
        }

        /* Loading Page */
        .loading-page {
            color: #888 !important;
        }

        .loading-page i {
            color: #f3ebd7 !important;
        }

        .loading-spinner {
            width: 36px;
            height: 36px;
            border: 3px solid rgba(243, 235, 215, 0.15);
            border-top-color: #f3ebd7;
            border-radius: 50%;
            animation: spinRotate 0.7s linear infinite;
        }

        @keyframes spinRotate {
            to { transform: rotate(360deg); }
        }

        /* Offline overlay */
        .offline-overlay {
            background: #060606 !important;
        }

        .offline-content {
            color: #eee !important;
        }

        .offline-title {
            color: #eee !important;
        }

        .offline-desc {
            color: #888 !important;
        }

        .offline-retry-btn {
            background: #f3ebd7 !important;
            color: #000 !important;
            border: none !important;
            border-radius: 20px !important;
        }

        .offline-icon i {
            color: #f3ebd7 !important;
        }

        .offline-status span {
            color: #888 !important;
        }

        .offline-tip {
            color: #666 !important;
        }

        .offline-tip i {
            color: #555 !important;
        }

        .offline-tip-divider {
            background: #222 !important;
        }

        .offline-pulse-ring {
            border-color: rgba(243, 235, 215, 0.15) !important;
        }

        /* Toast */
        #toast-container .toast {
            background: #111 !important;
            border: 1px solid #222 !important;
            color: #eee !important;
            border-radius: 20px !important;
        }

        /* Detail sub materi page */
        .container-detail-submateri {
            background: transparent !important;
        }

        .detail-submateri-card {
            background: #111 !important;
            border: 1px solid #1a1a1a !important;
            border-radius: 28px !important;
            color: #ddd !important;
        }

        .detail-submateri-card h1,
        .detail-submateri-card h2,
        .detail-submateri-card h3,
        .detail-submateri-card h4 {
            color: #eee !important;
        }

        .detail-submateri-card pre {
            background: #0a0a0a !important;
            border: 1px solid #1a1a1a !important;
            border-radius: 16px !important;
        }

        .detail-submateri-card code {
            background: #0a0a0a !important;
            color: #f3ebd7 !important;
        }

        .btn-mark-done {
            background: #f3ebd7 !important;
            color: #000 !important;
            border: none !important;
            border-radius: 20px !important;
        }

        /* Quiz override */
        .quiz-container,
        .quiz-card {
            background: #111 !important;
            border: 1px solid #1a1a1a !important;
            border-radius: 28px !important;
            color: #eee !important;
        }
    </style>
@endsection
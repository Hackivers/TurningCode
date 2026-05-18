@extends('layouts.spa')

@section('content')
    @include('spa.fragments.user-navBar')
    @include('spa.fragments.user-asideBar')
    @include('spa.fragments.user-mascot')

    <div class="nothing-dots" style="position: fixed; z-index: -1;"></div>

    <div id="spa-content">
        <div class="loading-page">
            <div class="loading-spinner"></div>
            <p>Memuat…</p>
        </div>
    </div>

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

    {{-- Issue Report Modal (Two-Step V2) --}}
    <div id="issue-report-modal" data-report-url="{{ route('user.report.store') }}" class="neo-report-overlay"
        style="display: none;">

        {{-- Frame 2 (Confirmation) --}}
        <div id="neo-report-f2" class="neo-report-card neo-report-frame-2">
            <svg class="neo-report-star" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16M18.928 8l-13.856 8M5.072 8l13.856 8" />
            </svg>
            <h3 class="neo-report-title-f2">Kamu bisa beri masukan, ide, saran atau melaporkan <br>masalah</h3>
            <div class="neo-report-actions-f2">
                <button type="button" class="neo-report-btn neo-report-btn-secondary"
                    onclick="closeIssueReportModal()">Tidak</button>
                <button type="button" class="neo-report-btn neo-report-btn-secondary"
                    onclick="goToReportFrame3()">Laporkan</button>
            </div>
        </div>

        {{-- Frame 3 (Form) --}}
        <div id="neo-report-f3" class="neo-report-card neo-report-frame-3" style="display: none;">

            <div class="neo-report-col-left">
                <div class="neo-report-col-left-box">
                    <h3 class="neo-report-title-f3">Apa masalah yang<br>kamu alami saat ini?</h3>
                </div>
                <div class="neo-report-upload-area">
                    <input type="file" name="image" id="issue-image-input" accept="image/*" class="neo-report-file-input"
                        onchange="handleReportImagePreview(this)" form="issue-report-form">
                    <img id="neo-report-preview-img" src="" alt="Preview" class="neo-report-image-preview">
                    <i class='bx bx-image-add neo-report-upload-icon'></i>
                    <span id="issue-image-name" class="neo-report-upload-text">Upload gambar bila ada atau drop
                        disini</span>
                </div>
            </div>

            <div class="neo-report-col-right">
                <div class="neo-report-header-f3">
                    <svg class="neo-report-star" width="1em" height="1em" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16M18.928 8l-13.856 8M5.072 8l13.856 8" />
                    </svg>
                    <p class="neo-report-desc-f3">Berani lapor demi kemajuan Turning Code!!, kami siap selesaikan secepat
                        mungkin</p>
                </div>

                <form id="issue-report-form" class="neo-report-form" onsubmit="submitIssueReport(event)">
                    <div class="neo-report-group">
                        <label class="neo-report-label">Judul laporan</label>
                        <input type="text" name="title" class="neo-report-input" required
                            placeholder="isi dengan topik masalah nya">
                    </div>

                    <div class="neo-report-group">
                        <label class="neo-report-label">Deskripsi Laporan</label>
                        <textarea name="description" class="neo-report-textarea" required
                            placeholder="Isi keluhan yang kamu rasakan"></textarea>
                    </div>

                    <div id="issue-report-msg"
                        style="display: none; padding: 12px; border-radius: 12px; font-size: 13px; margin-top: 10px;"></div>

                    <div class="neo-report-actions-f3">
                        <button type="button" class="neo-report-btn neo-report-btn-secondary"
                            onclick="closeIssueReportModal()">Batalkan</button>
                        <button type="submit" id="btn-submit-report"
                            class="neo-report-btn neo-report-btn-secondary">Laporkan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="{{ asset('src/js/user-spa.js') }}"></script>
@endsection
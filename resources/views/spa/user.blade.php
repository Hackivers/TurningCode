@extends('layouts.spa')

@section('content')
    @include('spa.fragments.user-navBar')
    @include('spa.fragments.user-asideBar')
    @include('spa.fragments.user-mascot')

    <div id="spa-content">
        <div class="loading-page">
            <div class="loading-spinner"></div>
            <p>Memuat…</p>
        </div>
    </div>
    <div class="bottom-space"></div>


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

    {{-- Issue Report Modal (Neo Bento Style) --}}
    <div id="issue-report-modal" data-report-url="{{ route('user.report.store') }}" style="position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 100000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(8px); opacity: 0; transition: opacity 0.3s ease;">
        <div class="neo-card neo-card-light" style="width: 100%; max-width: 480px; padding: 32px; box-sizing: border-box; position: relative; transform: translateY(20px); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
            <button type="button" onclick="closeIssueReportModal()" style="position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.05); border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #555; transition: all 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.1)'; this.style.color='#121212'" onmouseout="this.style.background='rgba(0,0,0,0.05)'; this.style.color='#555'">
                <i class='bx bx-x' style="font-size: 20px;"></i>
            </button>
            <div class="neo-header" style="margin-bottom: 24px;">
                <h3 class="neo-title">Lapor Masalah</h3>
            </div>
            <p style="font-size: 14px; color: #555; margin-bottom: 24px; line-height: 1.5;">
                Ada masalah, bug, atau masukan terkait platform? Laporkan kepada tim admin di sini.
            </p>
            <form id="issue-report-form" onsubmit="submitIssueReport(event)">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #121212; margin-bottom: 8px;">Topik/Judul Laporan</label>
                    <input type="text" name="title" required placeholder="Contoh: Kuis tidak bisa disubmit" style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); background: #fff; font-size: 14px; font-family: inherit; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#121212'" onblur="this.style.borderColor='rgba(0,0,0,0.1)'">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #121212; margin-bottom: 8px;">Detail Masalah</label>
                    <textarea name="description" required rows="4" placeholder="Ceritakan detail masalah yang kamu alami..." style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); background: #fff; font-size: 14px; font-family: inherit; box-sizing: border-box; outline: none; resize: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#121212'" onblur="this.style.borderColor='rgba(0,0,0,0.1)'"></textarea>
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #121212; margin-bottom: 8px;">Lampiran Gambar (Opsional)</label>
                    <div style="position: relative;">
                        <input type="file" name="image" id="issue-image-input" accept="image/*" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2;" onchange="document.getElementById('issue-image-name').textContent = this.files[0] ? this.files[0].name : 'Pilih file atau tarik ke sini'">
                        <div style="width: 100%; padding: 16px; border-radius: 12px; border: 1px dashed rgba(0,0,0,0.2); background: rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 13px; color: #888; box-sizing: border-box; transition: all 0.2s;">
                            <i class='bx bx-image-add' style="font-size: 20px;"></i>
                            <span id="issue-image-name">Pilih file atau tarik ke sini</span>
                        </div>
                    </div>
                </div>
                <div id="issue-report-msg" style="display: none; padding: 10px 14px; border-radius: 12px; font-size: 13px; margin-bottom: 16px;"></div>
                <button type="submit" id="btn-submit-report" style="width: 100%; padding: 14px; border-radius: 16px; border: none; background: #121212; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-family: inherit; display: flex; justify-content: center; align-items: center; gap: 8px;">
                    <i class='bx bx-send'></i> Kirim Laporan
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('src/js/user-spa.js') }}"></script>
@endsection

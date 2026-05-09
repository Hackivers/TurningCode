<!-- ROTOOD MODERN NAVBAR -->
<div class="rtd-top-nav @if (Auth::User()->role == 'admin') admin @endif" id="navBar"
    data-friend-search-url="{{ route('user.friend.search') }}" data-csrf-token="{{ csrf_token() }}">
    <div class="rtd-nav-left">
        <button class="rtd-btn-icon btnAside">
            <i class='bx bx-menu'></i>
        </button>
        <div class="rtd-nav-title">
            <h4
                style="font-family: var(--nothing-dot-font, 'DotGothic16', monospace); font-size: 22px; text-transform: uppercase; letter-spacing: 2px; font-weight: 400; color: #000;">
                TurningCode</h4>
            <p style="text-transform: uppercase; letter-spacing: 1px; font-weight: 700; color: #888;">SYS_USER:
                {{ explode(' ', Auth::user()->name)[0] }}</p>
        </div>
    </div>

    <div class="rtd-nav-center">
        <div class="rtd-search-pill">
            <i class='bx bx-search'></i>
            <input type="search" id="global-search-input" placeholder="SEARCH SYSTEM...">
        </div>
    </div>

    <div class="rtd-nav-right">
        @if (Auth::User()->role == 'user')
            <button class="rtd-btn-icon" id="btn-general-popup" title="Menu Sistem">
                <i class='bx bx-grid-alt'></i>
                <span class="notif-badge" id="notif-badge" style="display: none;"></span>
            </button>
            <div class="rtd-nav-profile {{ Auth::user()->isPenguasaSektor() ? 'sovereign-aura' : (Auth::user()->isElite() ? 'elite-aura' : '') }}"
                id="btn-profile-popup" data-elite-tier="{{ Auth::user()->elite_tier }}">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                @else
                    <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                @endif
            </div>
        @endif
    </div>
</div>

{{-- System Panel Backdrop --}}
<div class="sys-backdrop" id="sys-backdrop"></div>

{{-- ═══════════════════════════════════════════════════════
UNIFIED SYSTEM PANEL (MATERIAL YOU + NOTHING OS)
═══════════════════════════════════════════════════════ --}}
@if (Auth::User()->role == 'user')
    <div class="sys-panel-dark" id="sys-panel">

        <div class="sys-header">
            <span class="sys-time" id="sys-time-display">00:00</span>
        </div>

        {{-- Panel Volume / Brightness Slider Mimic --}}
        <div class="sys-panel-volume" id="sys-panel-volume">
            <div class="sys-vol-track"></div>
            <div class="sys-vol-fill" id="sys-vol-fill" style="width: 100%;">
                <i class='bx bx-volume-full'></i>
            </div>
            <input type="range" id="sys-music-vol" value="100" min="0" max="100">
        </div>
        <div class="sys-pill-grid">
            {{-- Pill: Akun --}}
            <button class="sys-pill sys-pill-span2" id="sys-pill-account" data-target="sys-card-account">
                <div class="sys-pill-icon"><i class='bx bx-user'></i></div>
                <div class="sys-pill-text">
                    <strong>Akun</strong>
                    <span>Profil & data</span>
                </div>
            </button>

            {{-- Pill: Notifikasi --}}
            <button class="sys-pill" id="sys-pill-notif" data-target="sys-card-notif">
                <div class="sys-pill-icon"><i class='bx bx-bell'></i></div>
                <div class="sys-pill-text">
                    <strong>Notifikasi</strong>
                    <span id="sys-notif-subtitle">Sistem</span>
                </div>
            </button>

            {{-- Pill: Cari Teman --}}
            <button class="sys-pill" id="sys-pill-friend" data-target="sys-card-friend">
                <div class="sys-pill-icon"><i class='bx bx-user-plus'></i></div>
                <div class="sys-pill-text">
                    <strong>Cari Teman</strong>
                    <span>Global</span>
                </div>
            </button>

            {{-- Pill: Pengaturan --}}
            <button class="sys-pill" id="sys-pill-setting" data-target="sys-card-setting">
                <div class="sys-pill-icon"><i class='bx bx-slider-alt'></i></div>
                <div class="sys-pill-text">
                    <strong>Pengaturan</strong>
                    <span>Akun</span>
                </div>
            </button>

            {{-- Pill: Music Player --}}
            <button class="sys-pill" id="sys-pill-music" data-target="sys-card-music">
                <div class="sys-pill-icon"><i class='bx bx-music'></i></div>
                <div class="sys-pill-text">
                    <strong>Pemutar Musik</strong>
                    <span id="sys-music-subtitle">Berhenti</span>
                </div>
            </button>
        </div>

        {{-- DYNAMIC BOTTOM CARDS --}}
        <div class="sys-dynamic-container">

            {{-- 1. Profile Card (Default) --}}
            <div class="sys-card active" id="sys-card-profile">
                <div class="sys-profile-layout">
                    <div
                        class="sys-avatar-wrap {{ Auth::user()->isPenguasaSektor() ? 'sovereign-aura-sm' : (Auth::user()->isElite() ? 'elite-aura-sm' : '') }}">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                        @else
                            <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                        @endif
                    </div>
                    <div class="sys-info">
                        <h4
                            class="{{ Auth::user()->isPenguasaSektor() ? 'sovereign-name-sm' : (Auth::user()->isElite() ? 'elite-name-sm' : '') }}">
                            {{ Auth::user()->name }}</h4>
                        <p>{{ Auth::user()->rank_name }}</p>
                    </div>
                    <div class="sys-exp-badge">
                        <span>{{ number_format(Auth::user()->exp ?? 0) }} EXP</span>
                    </div>
                </div>
            </div>

            {{-- 2. Account Detail Card --}}
            <div class="sys-card" id="sys-card-account">
                <div class="sys-account-layout">
                    <div class="sys-account-header">
                        <div
                            class="sys-avatar-wrap {{ Auth::user()->isPenguasaSektor() ? 'sovereign-aura-sm' : (Auth::user()->isElite() ? 'elite-aura-sm' : '') }}">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                            @else
                                <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                            @endif
                        </div>
                        <div class="sys-account-info">
                            <h4
                                class="{{ Auth::user()->isPenguasaSektor() ? 'sovereign-name-sm' : (Auth::user()->isElite() ? 'elite-name-sm' : '') }}">
                                {{ Auth::user()->name }}</h4>
                            <p style="font-size: 11px; opacity: 0.6; margin-top: 2px;">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="sys-account-stats">
                        <div class="sys-account-stat">
                            <i class='bx bx-shield-quarter'></i>
                            <span>{{ Auth::user()->isPenguasaSektor() ? 'Sovereign' : (Auth::user()->isElite() ? 'Elite' : 'Basic') }}</span>
                        </div>
                        <div class="sys-account-stat">
                            <i class='bx bx-star'></i>
                            <span>{{ Auth::user()->rank_name }}</span>
                        </div>
                        <div class="sys-account-stat">
                            <i class='bx bx-trophy'></i>
                            <span>{{ number_format(Auth::user()->exp ?? 0) }} EXP</span>
                        </div>
                    </div>
                    <button class="sys-account-detail-btn" onclick="loadPage('account')">
                        <i class='bx bx-user-circle'></i>
                        <span>Detail Akun</span>
                        <i class='bx bx-chevron-right'></i>
                    </button>
                </div>
            </div>

            {{-- Notification card moved to external sys-notif-panel --}}

            {{-- 3. Friend Search Card --}}
            <div class="sys-card" id="sys-card-friend">
                <div class="fs-search-bar">
                    <i class='bx bx-search'></i>
                    <input type="text" id="input-friend-search" placeholder="Cari nama/email..." autocomplete="off">
                </div>
                <div class="sys-card-body" id="friend-search-body">
                    <div class="fs-state" id="friend-search-empty">
                        <i class='bx bx-group'></i>
                        <p>Ketik untuk mencari pengguna</p>
                    </div>
                    <div class="fs-state" id="friend-search-loading" style="display: none;">
                        <i class='bx bx-loader-alt bx-spin' style="font-size: 24px;"></i>
                    </div>
                    <div class="fs-results" id="friend-search-results"></div>
                </div>
            </div>

            {{-- 4. Settings Card --}}
            <div class="sys-card" id="sys-card-setting">
                <div class="spd-grid">
                    <label class="spd-gpill" for="toggle-notification">
                        <div class="spd-gpill-icon"><i class='bx bx-bell'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Notifikasi</strong>
                            <span>Pengingat</span>
                        </div>
                        <input type="checkbox" id="toggle-notification" class="spd-gpill-check" hidden>
                    </label>
                    <label class="spd-gpill" for="toggle-darkmode">
                        <div class="spd-gpill-icon"><i class='bx bx-moon'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Mode Gelap</strong>
                            <span>Tampilan</span>
                        </div>
                        <input type="checkbox" id="toggle-darkmode" class="spd-gpill-check" hidden>
                    </label>
                    <label class="spd-gpill" for="toggle-fullscreen">
                        <div class="spd-gpill-icon"><i class='bx bx-fullscreen'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Fullscreen</strong>
                            <span>Layar penuh</span>
                        </div>
                        <input type="checkbox" id="toggle-fullscreen" class="spd-gpill-check" hidden>
                    </label>
                    <label class="spd-gpill" for="toggle-compact">
                        <div class="spd-gpill-icon"><i class='bx bx-collapse-alt'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Kompak</strong>
                            <span>Ringkas</span>
                        </div>
                        <input type="checkbox" id="toggle-compact" class="spd-gpill-check" hidden>
                    </label>
                    <label class="spd-gpill" for="toggle-sound">
                        <div class="spd-gpill-icon"><i class='bx bx-volume-full'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Efek Suara</strong>
                            <span>UI sounds</span>
                        </div>
                        <input type="checkbox" id="toggle-sound" class="spd-gpill-check" hidden checked>
                    </label>
                    <label class="spd-gpill" for="toggle-animations">
                        <div class="spd-gpill-icon"><i class='bx bx-play-circle'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Animasi</strong>
                            <span>Transisi</span>
                        </div>
                        <input type="checkbox" id="toggle-animations" class="spd-gpill-check" hidden checked>
                    </label>
                    <label class="spd-gpill" for="toggle-autoscroll">
                        <div class="spd-gpill-icon"><i class='bx bx-up-arrow-alt'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Auto Scroll</strong>
                            <span>Navigasi</span>
                        </div>
                        <input type="checkbox" id="toggle-autoscroll" class="spd-gpill-check" hidden checked>
                    </label>
                    <div class="spd-gpill spd-gpill-action" id="btn-font-size">
                        <div class="spd-gpill-icon"><i class='bx bx-font-size'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Font</strong>
                            <span id="font-size-label">Normal</span>
                        </div>
                    </div>
                    <div class="spd-gpill spd-gpill-action" id="btn-clear-cache">
                        <div class="spd-gpill-icon"><i class='bx bx-trash'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Hapus Cache</strong>
                            <span>Reset</span>
                        </div>
                    </div>
                    <div class="spd-gpill spd-gpill-action" id="btn-report-bug">
                        <div class="spd-gpill-icon"><i class='bx bx-bug'></i></div>
                        <div class="spd-gpill-text">
                            <strong>Lapor Bug</strong>
                            <span>Kirim</span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 5. Music Player Card --}}
            <div class="sys-card" id="sys-card-music">
                <div class="sys-music-layout modern-voice-ui">
                    <div class="mv-header">
                        <span class="mv-title" id="sys-music-title">Music Player</span>
                        <input type="file" id="sys-music-file" accept="audio/mpeg, audio/wav" style="display: none;">
                        <button class="mv-btn-upload" id="btn-music-upload" title="Pilih Lagu (MP3/WAV)">
                            <i class='bx bx-plus'></i>
                        </button>
                    </div>

                    <div class="mv-visualizer" id="sys-vinyl-disk">
                        <div class="mv-bar-wrapper bw1"><div class="mv-bar-track"></div><div class="mv-bar b1"></div></div>
                        <div class="mv-bar-wrapper bw2"><div class="mv-bar-track"></div><div class="mv-bar b2"></div></div>
                        <div class="mv-bar-wrapper bw3"><div class="mv-bar-track"></div><div class="mv-bar b3"></div></div>
                        <div class="mv-bar-wrapper bw4"><div class="mv-bar-track"></div><div class="mv-bar b4"></div></div>
                        <div class="mv-bar-wrapper bw5"><div class="mv-bar-track"></div><div class="mv-bar b5"></div></div>
                        <div class="mv-bar-wrapper bw6"><div class="mv-bar-track"></div><div class="mv-bar b6"></div></div>
                        <div class="mv-bar-wrapper bw7"><div class="mv-bar-track"></div><div class="mv-bar b7"></div></div>
                    </div>

                    <div class="mv-footer">
                        <div class="sys-music-progress mv-progress">
                            <span id="sys-music-curr" style="display: none;">0:00</span>
                            <div class="mv-progress-container">
                                <div class="mv-progress-track"></div>
                                <div class="mv-progress-fill" id="sys-music-progress-fill"></div>
                                <input type="range" id="sys-music-seek" value="0" min="0" max="100">
                            </div>
                            <span id="sys-music-dur" style="display: none;">0:00</span>
                        </div>
                        
                        <div class="mv-controls">
                            <button id="btn-music-prev" style="display: none;"></button>
                            <button id="btn-music-next" style="display: none;"></button>
                            
                            <button class="mv-btn-play main-play" id="btn-music-play">
                                <div class="mv-play-icon"></div>
                            </button>
                        </div>
                    </div>

                    <p id="sys-music-artist" style="display: none;"></p>
                    <p id="sys-music-subtitle" style="display: none;"></p>
                    <audio id="sys-audio-player" style="display: none;"></audio>
                </div>
            </div>

        </div>

        <div class="panel-drag-handle"></div>
    </div>

    {{-- External Notification Panel (desktop only, left of main panel) --}}
    <div class="sys-notif-panel" id="sys-notif-panel">
        <div class="sys-card-header">
            <h4>Pemberitahuan</h4>
            <button id="btn-notif-clear"><i class='bx bx-check-double'></i></button>
        </div>
        <div class="sys-card-body" id="notif-popup-body">
            <div class="notif-empty" id="notif-empty">
                <i class='bx bx-bell-off'></i>
                <p>Belum ada notifikasi</p>
            </div>
        </div>
    </div>
@endif

<script src="{{ asset('src/js/user-navbar.js') }}"></script>

<link rel="stylesheet" href="{{ asset('assets/css/user-navbar.css') }}">
<!-- ROTOOD MODERN NAVBAR -->
<div class="rtd-top-nav @if (Auth::User()->role == 'admin') admin @endif" id="navBar" data-friend-search-url="{{ route('user.friend.search') }}" data-csrf-token="{{ csrf_token() }}">
    <div class="rtd-nav-left">
        <button class="rtd-btn-icon btnAside">
            <i class='bx bx-menu'></i>
        </button>
        <div class="rtd-nav-title">
            <h4>TurningCode</h4>
            <p>Care with {{ explode(' ', Auth::user()->name)[0] }}</p>
        </div>
    </div>

    <div class="rtd-nav-center">
        <div class="rtd-search-pill">
            <i class='bx bx-search'></i>
            <input type="search" id="global-search-input" placeholder="Search for courses, hints...">
        </div>
    </div>

    <div class="rtd-nav-right">
        @if (Auth::User()->role == 'user')
            <button class="rtd-btn-icon" id="btn-friend-search-popup" title="Cari Teman">
                <i class='bx bx-user-plus'></i>
            </button>
            <button class="rtd-btn-icon" id="btn-notification-popup">
                <i class='bx bx-bell'></i>
                <span class="notif-badge" id="notif-badge"></span>
            </button>
            <button class="rtd-btn-icon" id="btn-setting-popup">
                <i class='bx bx-slider-alt'></i>
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

{{-- Setting Popup Backdrop --}}
<div class="setting-backdrop" id="setting-backdrop"></div>

{{-- ═══════════════════════════════════════════════════════
SETTINGS POPUP OVERLAY (ADMIN STYLE)
═══════════════════════════════════════════════════════ --}}
@if (Auth::User()->role == 'user')
    <div class="setting-popup-dark" id="setting-popup">
        <div class="spd-header">
            <div class="spd-header-left">
                <div class="spd-icon-wrapper">
                    <i class='bx bx-slider-alt'></i>
                </div>
                <div>
                    <h3>Pengaturan</h3>
                    <p>Kelola preferensi akun dan tampilan</p>
                </div>
            </div>
            <button class="spd-close" id="btn-setting-close"><i class='bx bx-x'></i></button>
        </div>
        <div class="spd-body">
            <div class="spd-grid">

                {{-- Notifikasi --}}
                <label class="spd-card" for="toggle-notification">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-bell'></i></div>
                        <div class="spd-toggle">
                            <input type="checkbox" id="toggle-notification">
                            <span class="spd-slider"></span>
                        </div>
                    </div>
                    <h4>Notifikasi</h4>
                    <p>Aktifkan pengingat jadwal belajar.</p>
                </label>

                {{-- Dark Mode --}}
                <label class="spd-card" for="toggle-darkmode">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-moon'></i></div>
                        <div class="spd-toggle">
                            <input type="checkbox" id="toggle-darkmode">
                            <span class="spd-slider"></span>
                        </div>
                    </div>
                    <h4>Mode Gelap</h4>
                    <p>Tampilan yang nyaman untuk malam hari.</p>
                </label>

                {{-- Optimize Web --}}
                <label class="spd-card" for="toggle-optimize">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-rocket'></i></div>
                        <div class="spd-toggle">
                            <input type="checkbox" id="toggle-optimize">
                            <span class="spd-slider"></span>
                        </div>
                    </div>
                    <h4>Optimize Web</h4>
                    <p>Matikan animasi & efek untuk performa cepat.</p>
                </label>

                {{-- Data & Storage --}}
                <div class="spd-card" style="cursor: default; opacity: 0.7;">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-data'></i></div>
                        <span class="spd-badge">BETA</span>
                    </div>
                    <h4>Data & Penyimpanan</h4>
                    <p>Kelola riwayat cache perangkat.</p>
                </div>

                {{-- Bahasa --}}
                <div class="spd-card" style="cursor: default;">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-globe'></i></div>
                        <span class="spd-badge-green">ID</span>
                    </div>
                    <h4>Bahasa Server</h4>
                    <p>Bahasa standar sistem Indonesia.</p>
                </div>

            </div>
        </div>
    </div>
    {{-- Profile Detail Popup --}}
    <div class="profile-popup-dark" id="profile-popup">
        <div class="ppd-header">
            <div class="ppd-header-left">
                <div
                    class="ppd-avatar-wrap {{ Auth::user()->isPenguasaSektor() ? 'sovereign-aura-sm' : (Auth::user()->isElite() ? 'elite-aura-sm' : '') }}">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                    @else
                        <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                    @endif
                </div>
                <div>
                    <h3
                        class="{{ Auth::user()->isPenguasaSektor() ? 'sovereign-name-sm' : (Auth::user()->isElite() ? 'elite-name-sm' : '') }}">
                        {{ Auth::user()->name }}
                    </h3>
                    <p>{{ explode('@', Auth::user()->email)[0] }}</p>
                </div>
            </div>
            <button class="ppd-close" id="btn-profile-close"><i class='bx bx-x'></i></button>
        </div>
        <div class="ppd-body">
            <div class="ppd-stats">
                <div class="ppd-stat-item">
                    <span class="ppd-stat-val">{{ number_format(Auth::user()->exp ?? 0) }}</span>
                    <span class="ppd-stat-lbl">EXP</span>
                </div>
                <div class="ppd-stat-item">
                    <span class="ppd-stat-val">{{ Auth::user()->rank_name }}</span>
                    <span class="ppd-stat-lbl">Rank</span>
                </div>
            </div>
            <div class="ppd-actions">
                <a href="#" data-spa-page="account" class="ppd-btn-action" id="btn-profile-goto-account">
                    <i class='bx bx-user'></i>
                    <span>Buka Profil Lengkap</span>
                </a>
                <a href="{{ route('logout') }}" class="ppd-btn-action logout">
                    <i class='bx bx-log-out'></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Notification Popup --}}
    <div class="notif-popup-dark" id="notif-popup">
        <div class="npd-header">
            <div class="npd-header-left">
                <div class="npd-icon-wrapper">
                    <i class='bx bx-bell'></i>
                </div>
                <div>
                    <h3>Notifikasi</h3>
                    <p>Pemberitahuan jadwal belajar</p>
                </div>
            </div>
            <div class="npd-actions">
                <button class="npd-btn" id="btn-notif-clear" title="Hapus semua">
                    <i class='bx bx-check-double'></i>
                </button>
                <button class="npd-btn" id="btn-notif-close">
                    <i class='bx bx-x'></i>
                </button>
            </div>
        </div>
        <div class="npd-body" id="notif-popup-body">
            {{-- Notifications will be injected here by JS --}}
            <div class="notif-empty" id="notif-empty">
                <div class="notif-empty-icon">
                    <i class='bx bx-bell-off'></i>
                </div>
                <h5>Belum ada notifikasi</h5>
                <p>Notifikasi jadwal belajar akan muncul di sini</p>
            </div>
        </div>
    </div>

    {{-- Friend Search Popup --}}
    <div class="notif-popup-dark fs-popup" id="friend-search-popup">
        <div class="fs-header">
            <div class="fs-header-top">
                <div class="npd-header-left">
                    <div class="npd-icon-wrapper" style="background: rgba(16,185,129,0.1); color: #34d399;">
                        <i class='bx bx-user-plus'></i>
                    </div>
                    <div>
                        <h3>Cari Teman</h3>
                        <p>Tambahkan teman baru</p>
                    </div>
                </div>
                <button class="npd-btn" id="btn-friend-search-close">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="fs-search-bar">
                <i class='bx bx-search'></i>
                <input type="text" id="input-friend-search" placeholder="Cari nama atau email..." autocomplete="off">
            </div>
        </div>
        <div class="fs-body" id="friend-search-body">
            <div class="fs-state" id="friend-search-empty">
                <div class="fs-state-icon">
                    <i class='bx bx-group'></i>
                </div>
                <h5>Ketik untuk mencari</h5>
                <p>Cari pengguna berdasarkan nama/email</p>
            </div>
            <div class="fs-state" id="friend-search-loading" style="display: none;">
                <i class='bx bx-loader-alt bx-spin' style="font-size: 28px; color: #52525b;"></i>
                <h5>Mencari...</h5>
            </div>
            <div class="fs-results" id="friend-search-results"></div>
        </div>
    </div>
@endif

<script src="{{ asset('src/js/user-navbar.js') }}"></script>

<link rel="stylesheet" href="{{ asset('assets/css/user-navbar.css') }}">
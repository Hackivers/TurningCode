<!-- NOTHING OS MODERN NAVBAR -->
<div class="nothing-navbar-wrapper">
    <div class="nothing-navbar @if (Auth::User()->role == 'admin') admin @endif" id="navBar"
        data-friend-search-url="{{ route('user.friend.search') }}" data-csrf-token="{{ csrf_token() }}">
        <div class="nothing-nav-left">
            <button class="nothing-btn-icon btnAside">
                <i class='bx bx-menu'></i>
            </button>
            <div class="nothing-nav-title">
                <h4>TurningCode</h4>
                <p>SYS_USER: {{ explode(' ', Auth::user()->name)[0] }}</p>
            </div>
        </div>

        <div class="nothing-nav-center">
            <div class="nothing-search-pill">
                <i class='bx bx-search'></i>
                <input type="search" id="global-search-input" placeholder="SEARCH SYSTEM...">
            </div>
        </div>

        <div class="nothing-nav-right">
            @if (Auth::User()->role == 'user')
                <button class="nothing-btn-icon" id="btn-general-popup" title="Menu Sistem">
                    <i class='bx bx-grid-alt'></i>
                    <span class="notif-badge" id="notif-badge" style="display: none;"></span>
                </button>
                <div class="nothing-nav-profile {{ Auth::user()->isPenguasaSektor() ? 'sovereign-aura' : (Auth::user()->isElite() ? 'elite-aura' : '') }}"
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
</div>

{{-- System Panel Backdrop --}}
<div class="sys-backdrop" id="sys-backdrop"></div>

{{-- ═══════════════════════════════════════════════════════
UNIFIED SYSTEM PANEL (MATERIAL YOU + NOTHING OS)
═══════════════════════════════════════════════════════ --}}
@if (Auth::User()->role == 'user')
    {{-- Central Floating Notification Panel --}}
    <div class="sys-center-notif-panel" id="sys-notif-panel">
        <div class="scnp-header-pill">
            <span>Notifikasi</span>
            <i class='bx bx-check-double' id="btn-notif-clear" style="cursor: pointer;"></i>
        </div>
        <div class="scnp-body" id="notif-popup-body">
            <div id="notif-empty" style="display: none; padding: 20px; text-align: center; color: #888; font-size: 13px;">Tidak ada notifikasi baru</div>
        </div>
    </div>

    {{-- Right System Panel --}}
    <div class="sys-panel-dark" id="sys-panel">
        
        {{-- Top Control Card --}}
        <div class="sys-top-card">
            {{-- Volume Slider --}}
            <div class="sys-panel-volume" id="sys-panel-volume">
                <div class="sys-vol-track"></div>
                <div class="sys-vol-fill" id="sys-vol-fill">
                    <i class='bx bx-volume-full sys-vol-icon'></i>
                </div>
                <input type="range" id="sys-music-vol" value="100" min="0" max="100">
            </div>

            {{-- Tile Slider --}}
            <div class="sys-tile-slider" id="sys-tile-slider">
                <div class="sys-tile-track" id="sys-tile-track">
                    {{-- Page 1 --}}
                    <div class="sys-tile-page">
                        <button class="sys-tile" id="sys-pill-account" data-target="sys-card-account">
                            <i class='bx bx-user sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Account</strong>
                                <span>lihat akun mu</span>
                            </div>
                        </button>
                        <button class="sys-tile" id="sys-pill-notif" data-target="sys-card-notif">
                            <i class='bx bx-bell sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Notifikasi</strong>
                                <span id="sys-notif-subtitle">lihat notif</span>
                            </div>
                        </button>
                        <button class="sys-tile" id="sys-pill-mode" data-target="sys-card-mode">
                            <i class='bx bx-moon sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Mode</strong>
                                <span>terang</span>
                            </div>
                        </button>
                        <button class="sys-tile" id="sys-pill-friend" data-target="sys-card-friend">
                            <i class='bx bx-user-plus sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Friend</strong>
                                <span>cari teman</span>
                            </div>
                        </button>
                    </div>
                    {{-- Page 2 --}}
                    <div class="sys-tile-page">
                        <button class="sys-tile" id="sys-pill-setting" data-target="sys-card-setting">
                            <i class='bx bx-cog sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Setting</strong>
                                <span>custom web</span>
                            </div>
                        </button>
                        <button class="sys-tile" id="sys-pill-music" data-target="sys-card-music">
                            <i class='bx bx-music sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Music</strong>
                                <span id="sys-music-subtitle">dengerin music</span>
                            </div>
                        </button>
                        <button class="sys-tile" id="btn-report-bug">
                            <i class='bx bx-bug sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Lapor Bug</strong>
                                <span>laporkan masalah</span>
                            </div>
                        </button>
                        <button class="sys-tile" id="sys-pill-info" data-target="sys-card-info">
                            <i class='bx bx-info-circle sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Info</strong>
                                <span>tentang app</span>
                            </div>
                        </button>
                    </div>
                    {{-- Page 3 --}}
                    <div class="sys-tile-page">

                        <button class="sys-tile" id="sys-pill-shortcut" data-target="sys-card-shortcut">
                            <i class='bx bx-command sys-tile-icon'></i>
                            <div class="sys-tile-text">
                                <strong>Shortcut</strong>
                                <span>pintasan cepat</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Pagination Dots --}}
            <div class="sys-dots" id="sys-dots">
                <span class="sys-dot active" data-page="0"></span>
                <span class="sys-dot" data-page="1"></span>
                <span class="sys-dot" data-page="2"></span>
            </div>
        </div>

        {{-- Dynamic Bottom Panels --}}
        <div class="sys-dynamic-panels" id="sys-dynamic-panels">
            {{-- Music Player Card --}}
            <div class="sys-panel-card" id="sys-card-music">
                <div class="sys-music-player">
                    <div class="smp-header">
                        <span class="smp-title" id="sys-music-title">Music Player</span>
                        <i class='bx bx-plus smp-add' id="btn-music-upload"></i>
                    </div>
                    
                    <div class="smp-visualizer" id="sys-music-visualizer">
                        <div class="smp-bar v-1"><div class="smp-bar-fill"></div></div>
                        <div class="smp-bar v-2"><div class="smp-bar-fill"></div></div>
                        <div class="smp-bar v-3"><div class="smp-bar-fill"></div></div>
                        <div class="smp-bar v-4"><div class="smp-bar-fill"></div></div>
                        <div class="smp-bar v-5"><div class="smp-bar-fill"></div></div>
                        <div class="smp-bar v-6"><div class="smp-bar-fill"></div></div>
                        <div class="smp-bar v-7"><div class="smp-bar-fill"></div></div>
                    </div>

                    <div class="smp-footer">
                        <div class="smp-progress-bar">
                            <div class="smp-progress-fill" id="sys-music-progress-fill"></div>
                            <input type="range" id="sys-music-seek" value="0" min="0" max="100">
                        </div>
                        <div class="smp-play-btn" id="btn-music-play">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e4e4e7" stroke-width="1.5" stroke-linejoin="round">
                                <polygon points="7,4 20,12 7,20" />
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- Hidden elements for audio -->
                <input type="file" id="sys-music-file" accept="audio/*" style="display:none;">
                <audio id="sys-audio-player" style="display:none;"></audio>
            </div>

            {{-- Account Card --}}
            <div class="sys-panel-card" id="sys-card-account">
                <div class="sys-account-details">
                    <div class="sad-header">
                        <img src="{{ asset('assets/images/user-default.png') }}" alt="Profile" class="sad-avatar" onerror="this.src='https://ui-avatars.com/api/?name=User&background=random'">
                        <div class="sad-info">
                            <h4>{{ Auth::user()->name ?? 'User Name' }}</h4>
                            <p>{{ Auth::user()->email ?? 'user@example.com' }}</p>
                        </div>
                    </div>
                    <div class="sad-actions">
                        <button class="sad-btn">Edit Profile</button>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="sad-btn logout-btn">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Friend Search Card --}}
            <div class="sys-panel-card" id="sys-card-friend">
                <div class="sys-friend-panel">
                    <div class="sfp-search">
                        <i class='bx bx-search sfp-search-icon'></i>
                        <input type="text" id="sys-friend-search" placeholder="cari teman mu" autocomplete="off">
                    </div>
                    <div class="sfp-results" id="sys-friend-results">
                        <div class="sfp-empty" id="sys-friend-empty">
                            <i class='bx bx-user-plus' style="font-size: 32px; opacity: 0.3;"></i>
                            <span>Ketik nama untuk mencari teman</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Card --}}
            <div class="sys-panel-card" id="sys-card-info">
                <div class="sys-info-panel">
                    <div class="sip-slider-container">
                        <div class="sip-slider-track" id="sip-slider-track">
                            <!-- Slide 1: About & Version -->
                            <div class="sip-slide">
                                <i class='bx bx-code-alt sip-icon'></i>
                                <h3>Turning Code</h3>
                                <p class="sip-version">v1.0 - v2.0</p>
                                <p class="sip-desc">Platform pembelajaran coding interaktif dengan desain Nothing OS yang minimalis, brutalist, dan futuristik.</p>
                            </div>
                            <!-- Slide 2: Fitur Unggulan -->
                            <div class="sip-slide">
                                <i class='bx bx-star sip-icon'></i>
                                <h3>Fitur Unggulan</h3>
                                <ul class="sip-features">
                                    <li><i class='bx bx-check'></i> Desain Brutalist & Smooth UI</li>
                                    <li><i class='bx bx-check'></i> Sistem Quiz & Poin EXP</li>
                                    <li><i class='bx bx-check'></i> Mode Gelap & Hemat Daya</li>
                                    <li><i class='bx bx-check'></i> Sistem Pencarian Teman</li>
                                </ul>
                            </div>
                            <!-- Slide 3: Developer -->
                            <div class="sip-slide">
                                <i class='bx bx-code-curly sip-icon'></i>
                                <h3>Developer</h3>
                                <p class="sip-desc">Dikembangkan dengan semangat inovasi oleh tim kreator untuk memberikan pengalaman belajar terbaik.</p>
                                <div class="sip-dev-tags">
                                    <span>Laravel</span>
                                    <span>Vanilla JS</span>
                                    <span>CSS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation Dots -->
                    <div class="sip-dots" id="sip-dots">
                        <span class="sip-dot active" data-slide="0"></span>
                        <span class="sip-dot" data-slide="1"></span>
                        <span class="sip-dot" data-slide="2"></span>
                    </div>
                </div>
            </div>

            {{-- Setting Card --}}
            <div class="sys-panel-card" id="sys-card-setting">
                <div class="sys-setting-panel">
                    {{-- Dark Mode --}}
                    <div class="ssp-item">
                        <div class="ssp-item-left">
                            <i class='bx bx-moon ssp-item-icon'></i>
                            <div class="ssp-item-text">
                                <strong>Mode Gelap</strong>
                                <span>Ubah tampilan ke tema gelap</span>
                            </div>
                        </div>
                        <label class="ssp-toggle">
                            <input type="checkbox" id="toggle-darkmode">
                            <span class="ssp-toggle-slider"></span>
                        </label>
                    </div>

                    {{-- Optimize Mode --}}
                    <div class="ssp-item">
                        <div class="ssp-item-left">
                            <i class='bx bx-rocket ssp-item-icon'></i>
                            <div class="ssp-item-text">
                                <strong>Mode Hemat</strong>
                                <span>Kurangi animasi & efek visual</span>
                            </div>
                        </div>
                        <label class="ssp-toggle">
                            <input type="checkbox" id="toggle-optimize">
                            <span class="ssp-toggle-slider"></span>
                        </label>
                    </div>

                    {{-- Font Size --}}
                    <div class="ssp-item ssp-item-col">
                        <div class="ssp-item-left">
                            <i class='bx bx-font-size ssp-item-icon'></i>
                            <div class="ssp-item-text">
                                <strong>Ukuran Font</strong>
                                <span id="ssp-font-value">16px</span>
                            </div>
                        </div>
                        <div class="ssp-slider-wrap">
                            <span class="ssp-slider-label">A</span>
                            <input type="range" id="ssp-font-slider" min="12" max="22" value="16" class="ssp-slider">
                            <span class="ssp-slider-label ssp-large">A</span>
                        </div>
                    </div>

                    {{-- Clear Cache --}}
                    <div class="ssp-item">
                        <div class="ssp-item-left">
                            <i class='bx bx-trash ssp-item-icon'></i>
                            <div class="ssp-item-text">
                                <strong>Bersihkan Cache</strong>
                                <span>Hapus data sementara browser</span>
                            </div>
                        </div>
                        <button class="ssp-action-btn" id="btn-clear-cache">Bersihkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script src="{{ asset('src/js/user-navbar.js') }}"></script>

<link rel="stylesheet" href="{{ asset('assets/css/user-navbar.css') }}">
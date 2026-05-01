@php
    $user = Auth::user();
@endphp

<div class="container container-aside asidebar @if ($user->role == 'admin') admin @endif" id="asidePage">
    <aside class="neo-aside">

        <!-- Brand Logo -->
        <div class="neo-aside-brand">
            <div class="neo-brand-logo">TC</div>
            <span class="neo-brand-text">TurnCode</span>
        </div>

        <!-- Navigation -->
        <nav class="neo-nav-menu" id="spa-nav">
            <a href="#" data-spa-page="dashboard" class="neo-nav-link active" title="Dashboard">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bxs-home neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Dashboard</span>
            </a>

            <a href="#" data-spa-page="schedule" class="neo-nav-link" title="Jadwal">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-calendar neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Jadwal</span>
            </a>

            <a href="#" data-spa-page="favorites" class="neo-nav-link" title="Favorit">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-star neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Favorit</span>
            </a>

            <a href="#" data-spa-page="history" class="neo-nav-link" title="Riwayat">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-history neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Riwayat</span>
            </a>

            <a href="#" data-spa-page="notes" class="neo-nav-link" title="Catatan">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-notepad neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Catatan</span>
            </a>

            <a href="#" data-spa-page="missions" class="neo-nav-link" title="Misi">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-target-lock neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Misi</span>
            </a>

            <a href="#" data-spa-page="achievements" class="neo-nav-link" title="Pencapaian">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-trophy neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Pencapaian</span>
            </a>

            <a href="#" data-spa-page="leaderboard" class="neo-nav-link" title="Leaderboard">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-bar-chart neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Leaderboard</span>
            </a>

            <a href="#" data-spa-page="clans" class="neo-nav-link" title="Guilds & Clans">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-shield-quarter neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Guilds</span>
            </a>

            <a href="#" data-spa-page="shop" class="neo-nav-link" title="Reward Shop">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-store neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Toko</span>
            </a>

            <a href="#" data-spa-page="analytics" class="neo-nav-link" title="Analitik Belajar">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx bx-bar-chart-alt-2 neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Analitik</span>
            </a>

            <div class="neo-nav-divider"></div>

            <a href="#" data-spa-page="secret-lab"
                class="neo-nav-link neo-nav-elite {{ $user->isElite() ? 'elite-unlocked' : 'elite-locked' }}"
                title="Secret Lab">
                <div class="neo-nav-indicator"></div>
                <div class="neo-nav-icon-wrap">
                    <i class="bx {{ $user->isElite() ? 'bxs-flask' : 'bx-lock-alt' }} neo-nav-icon"></i>
                </div>
                <span class="neo-nav-label">Secret Lab</span>
                @if($user->isElite())
                    <span class="neo-elite-badge">ELITE</span>
                @else
                    <span class="neo-lock-badge"><i class='bx bx-lock-alt'></i></span>
                @endif
            </a>
        </nav>

        <!-- Footer -->
        <div class="neo-aside-footer">
            <!-- Profile Card -->
            <div class="neo-profile-module" data-spa-page="account" title="Buka Profil">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/ico/default-user.jpg') }}"
                    alt="Profile"
                    class="neo-profile-img {{ $user->isPenguasaSektor() ? 'sovereign-aura-sm' : ($user->isElite() ? 'elite-aura-sm' : '') }}">
                <div class="neo-profile-meta">
                    <span
                        class="neo-profile-name {{ $user->isPenguasaSektor() ? 'sovereign-name' : ($user->isElite() ? 'elite-name' : '') }}">{{ $user->name }}</span>
                    @if($user->isPenguasaSektor())
                        <span class="sovereign-title">Sovereign</span>
                    @else
                        <span class="neo-profile-role">{{ explode('@', $user->email)[0] }}</span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons Row -->
            <div class="neo-footer-actions">
                <button type="button" class="neo-action-btn neo-action-report" onclick="openIssueReportModal()" title="Lapor Masalah">
                    <i class="bx bx-error-circle"></i>
                    <span>Lapor</span>
                </button>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0; flex: 1;">
                    @csrf
                    <button type="submit" class="neo-action-btn neo-action-logout" title="Keluar Sesi">
                        <i class="bx bx-log-out-circle"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>

    </aside>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/user-dashboard.css') }}">
@php
    $user = Auth::user();
@endphp

<div class="container container-aside asidebar @if ($user->role == 'admin') admin @endif" id="asidePage">
    <aside class="fs-sidebar">
        <!-- Navigation -->
        <nav class="fs-nav-main" id="spa-nav">
            <a href="#" data-spa-page="dashboard" class="fs-link active" title="Dashboard">
                <i class="bx bx-grid-alt fs-icon"></i>
                <span class="fs-label">Dashboard</span>
            </a>

            @if(\App\Models\FeatureToggle::isActive('menu_schedule') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="schedule" class="fs-link" title="Jadwal">
                    <i class="bx bx-calendar fs-icon"></i>
                    <span class="fs-label">Jadwal</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_favorites') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="favorites" class="fs-link" title="Favorit">
                    <i class="bx bx-star fs-icon"></i>
                    <span class="fs-label">Favorit</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_history') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="history" class="fs-link" title="Riwayat">
                    <i class="bx bx-history fs-icon"></i>
                    <span class="fs-label">Riwayat</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_notes') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="notes" class="fs-link" title="Catatan">
                    <i class="bx bx-notepad fs-icon"></i>
                    <span class="fs-label">Catatan</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_missions') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="missions" class="fs-link" title="Misi">
                    <i class="bx bx-target-lock fs-icon"></i>
                    <span class="fs-label">Misi</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_achievements') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="achievements" class="fs-link" title="Pencapaian">
                    <i class="bx bx-trophy fs-icon"></i>
                    <span class="fs-label">Pencapaian</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_leaderboard') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="leaderboard" class="fs-link" title="Leaderboard">
                    <i class="bx bx-bar-chart fs-icon"></i>
                    <span class="fs-label">Leaderboard</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_clans') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="clans" class="fs-link" title="Guilds & Clans">
                    <i class="bx bx-shield-quarter fs-icon"></i>
                    <span class="fs-label">Guilds</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_shop') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="shop" class="fs-link" title="Reward Shop">
                    <i class="bx bx-store fs-icon"></i>
                    <span class="fs-label">Toko</span>
                </a>
            @endif

            @if(\App\Models\FeatureToggle::isActive('menu_analytics') || $user->canAccessAllFeatures())
                <a href="#" data-spa-page="analytics" class="fs-link" title="Analitik Belajar">
                    <i class="bx bx-bar-chart-alt-2 fs-icon"></i>
                    <span class="fs-label">Analitik</span>
                </a>
            @endif
        </nav>

        <!-- Promo Card -->
        @if(\App\Models\FeatureToggle::isActive('menu_secret_lab') || $user->canAccessAllFeatures())
            <div class="fs-promo">
                <div class="fs-promo-header">
                    <div class="fs-promo-icon"><i class='bx bx-sparkles'></i></div>
                    <div class="fs-promo-text">
                        <span class="fs-promo-subtitle">Current plan:</span>
                        <strong class="fs-promo-title">{{ $user->isElite() ? 'Elite Member' : 'Basic Member' }}</strong>
                    </div>
                </div>
                <p class="fs-promo-desc">
                    {{ $user->isElite() ? 'Explore the Secret Lab for exclusive features.' : 'Upgrade to Elite to get the latest and exclusive features' }}
                </p>
                <a href="#" data-spa-page="secret-lab" class="fs-promo-btn">
                    <i class='bx bxs-zap'></i> {{ $user->isElite() ? 'Enter Secret Lab' : 'Upgrade to Elite' }}
                </a>
            </div>
        @endif

        <div class="fs-divider"></div>

        <!-- Bottom Actions -->
        <div class="fs-bottom-links">


            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="fs-link fs-logout-btn"
                    style="width: 100%; border: none; background: transparent; text-align: left;">
                    <i class="bx bx-log-out fs-icon"></i>
                    <span class="fs-label">Keluar</span>
                </button>
            </form>
        </div>

        <!-- Footer Profile -->
        <div class="fs-footer">
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/ico/default-user.jpg') }}"
                alt="Profile" class="fs-avatar">
            <div class="fs-meta">
                <span class="fs-name">{{ $user->name }}</span>
                <span
                    class="fs-role">{{ $user->isPenguasaSektor() ? 'Sovereign' : ($user->isElite() ? 'Elite' : 'Basic Plan') }}</span>
            </div>
            <i class='bx bx-chevron-up fs-chevron'></i>
        </div>

    </aside>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/user-dashboard.css') }}">
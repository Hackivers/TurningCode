@php
    $user = Auth::user();
@endphp

<div class="container container-aside asidebar @if ($user->role == 'admin') admin @endif" id="asidePage">
    <aside class="neo-aside">

        <!-- Ultra Minimalist Header / Brand -->
        <div class="neo-aside-brand">
            <div class="neo-brand-dot"></div>
            <h2 class="neo-brand-mark">RTD</h2>
        </div>

        <!-- Super Clean Navigation -->
        <nav class="neo-nav-menu" id="spa-nav">
            <a href="#" data-spa-page="dashboard" class="neo-nav-link active">
                <i class="bx bxs-home neo-nav-icon"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" data-spa-page="schedule" class="neo-nav-link">
                <i class="bx bx-calendar neo-nav-icon"></i>
                <span>Jadwal</span>
            </a>

            <a href="#" data-spa-page="favorites" class="neo-nav-link">
                <i class="bx bx-star neo-nav-icon"></i>
                <span>Favorit</span>
            </a>

            <a href="#" data-spa-page="history" class="neo-nav-link">
                <i class="bx bx-history neo-nav-icon"></i>
                <span>Riwayat</span>
            </a>

            <div class="neo-nav-divider"></div>

            <a href="#" data-spa-page="secret-lab"
                class="neo-nav-link neo-nav-elite {{ $user->isElite() ? 'elite-unlocked' : 'elite-locked' }}">
                <i class="bx {{ $user->isElite() ? 'bxs-flask' : 'bx-lock-alt' }} neo-nav-icon"></i>
                <span>Secret Lab</span>
                @if($user->isElite())
                    <span class="neo-elite-badge">ELITE</span>
                @else
                    <span class="neo-lock-badge"><i class='bx bx-lock-alt'></i></span>
                @endif
            </a>
        </nav>

        <!-- Minimal footer actions -->
        <div class="neo-aside-footer">
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
                <i class='bx bx-chevron-right' style="color: #aaa; margin-left: auto;"></i>
            </div>

            <button type="button" class="neo-report-btn" onclick="openIssueReportModal()">
                <i class="bx bx-error-circle"></i>
                <span>Lapor Masalah</span>
            </button>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0; width: 100%;">
                @csrf
                <button type="submit" class="neo-logout-btn">
                    <i class="bx bx-log-out-circle"></i>
                    <span>Keluar Sesi</span>
                </button>
            </form>
        </div>

    </aside>
</div>

<style>
    /* ═══ NEO-MINIMALIST SIDEBAR ═══ */
    .container-aside.asidebar {
        /* Backdrop for the sidebar */
        background: rgba(0, 0, 0, 0.2) !important;
        border-right: none !important;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .neo-aside {
        background: #fdfdfd;
        display: flex;
        flex-direction: column;
        height: 100vh;
        width: 100%;
        max-width: 280px;
        /* Constrain width so page behind is visible */
        padding: 32px 20px;
        box-sizing: border-box;
        border-right: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
    }

    /* Brand */
    .neo-aside-brand {
        margin-bottom: 48px;
        padding-left: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .neo-brand-dot {
        width: 12px;
        height: 12px;
        background: #121212;
        border-radius: 50%;
    }

    .neo-brand-mark {
        font-family: 'Inter', sans-serif;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.05em;
        color: #121212;
        margin: 0;
        line-height: 1;
    }

    /* Navigation Menu */
    .neo-nav-menu {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
    }

    .neo-nav-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 10px 14px;
        text-decoration: none;
        color: #888;
        border-radius: 12px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 500;
        position: relative;
    }

    .neo-nav-icon {
        font-size: 20px;
        color: inherit;
        transition: transform 0.2s;
    }

    .neo-nav-link:hover {
        color: #121212;
        background: rgba(0, 0, 0, 0.02);
    }

    .neo-nav-link:hover .neo-nav-icon {
        transform: scale(1.1);
    }

    /* Active State (Like Linear / Vercel style) */
    .neo-nav-link.active {
        color: #121212;
        font-weight: 600;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .neo-nav-link.active::before {
        content: '';
        position: absolute;
        left: -1px;
        top: 25%;
        bottom: 25%;
        width: 3px;
        background: #121212;
        border-radius: 4px;
    }

    /* Footer Section */
    .neo-aside-footer {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding-top: 24px;
    }

    /* Ultra Minimalist Profile */
    .neo-profile-module {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid transparent;
        background: transparent;
    }

    .neo-profile-module:hover {
        background: #fff;
        border-color: rgba(0, 0, 0, 0.04);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    .neo-profile-img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .neo-profile-meta {
        display: flex;
        flex-direction: column;
        flex: 1;
        overflow: hidden;
    }

    .neo-profile-name {
        font-size: 13px;
        font-weight: 600;
        color: #121212;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .neo-profile-role {
        font-size: 11px;
        font-weight: 400;
        color: #888;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Minimalist Logout */
    .neo-logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        background: transparent;
        border: 1px dashed rgba(0, 0, 0, 0.1);
        color: #888;
        font-size: 13px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
    }

    .neo-logout-btn:hover {
        color: #ef4444;
        background: rgba(239, 68, 68, 0.05);
        border-color: rgba(239, 68, 68, 0.3);
        border-style: solid;
    }

    .neo-logout-btn i {
        font-size: 18px;
    }

    /* Minimalist Report */
    .neo-report-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        background: transparent;
        border: 1px dashed rgba(0, 0, 0, 0.1);
        color: #888;
        font-size: 13px;
        font-weight: 500;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
    }

    .neo-report-btn:hover {
        color: #f59e0b;
        background: rgba(245, 158, 11, 0.05);
        border-color: rgba(245, 158, 11, 0.3);
        border-style: solid;
    }

    .neo-report-btn i {
        font-size: 18px;
    }

    /* ═══ SECRET LAB SIDEBAR ═══ */
    .neo-nav-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.06), transparent);
        margin: 8px 14px;
    }

    .neo-nav-elite {
        position: relative;
    }

    .neo-nav-elite.elite-unlocked {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.06), rgba(236, 72, 153, 0.06));
        border: 1px solid rgba(139, 92, 246, 0.08);
    }

    .neo-nav-elite.elite-unlocked:hover {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.12), rgba(236, 72, 153, 0.12));
        border-color: rgba(139, 92, 246, 0.2);
    }

    .neo-nav-elite.elite-unlocked .neo-nav-icon {
        color: #8b5cf6;
    }

    .neo-nav-elite.elite-unlocked span:first-of-type {
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .neo-elite-badge {
        font-size: 8px !important;
        font-weight: 800 !important;
        letter-spacing: 1.5px;
        padding: 3px 8px;
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        color: #fff !important;
        -webkit-text-fill-color: #fff !important;
        border-radius: 6px;
        margin-left: auto;
        animation: elitePulse 2s ease-in-out infinite;
    }

    @keyframes elitePulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }
    }

    .neo-nav-elite.elite-locked {
        opacity: 0.45;
    }

    .neo-nav-elite.elite-locked:hover {
        opacity: 0.6;
    }

    .neo-lock-badge {
        margin-left: auto;
        font-size: 14px;
        color: #94a3b8;
    }

    /* ═══ SIDEBAR ELITE AURA ═══ */
    .neo-profile-img.elite-aura-sm {
        border: 2px solid transparent;
        background-image: linear-gradient(#fdfdfd, #fdfdfd), linear-gradient(135deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        box-shadow: 0 0 10px rgba(139, 92, 246, 0.25), 0 0 20px rgba(236, 72, 153, 0.12);
    }

    .neo-profile-name.elite-name {
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800 !important;
    }

    /* ═══ SIDEBAR SOVEREIGN AURA ═══ */
    .neo-profile-img.sovereign-aura-sm {
        border: 2px solid transparent;
        background-image: linear-gradient(#fdfdfd, #fdfdfd), linear-gradient(135deg, #d946ef, #fbbf24, #f59e0b, #d946ef);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        box-shadow: 0 0 12px rgba(217, 70, 239, 0.3), 0 0 24px rgba(251, 191, 36, 0.15);
    }

    .neo-profile-name.sovereign-name {
        background: linear-gradient(135deg, #fbbf24, #d946ef);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 900;
        letter-spacing: -0.2px;
    }

    .sovereign-title {
        font-size: 11px;
        color: #f59e0b;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
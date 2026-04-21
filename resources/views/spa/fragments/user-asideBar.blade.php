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
                <span>Tinjauan</span>
            </a>
            
            <a href="#" data-spa-page="schedule" class="neo-nav-link">
                <i class="bx bx-calendar neo-nav-icon"></i>
                <span>Jadwal</span>
            </a>
            
            <a href="#" data-spa-page="favorites" class="neo-nav-link">
                <i class="bx bx-star neo-nav-icon"></i>
                <span>Markah</span>
            </a>
            
            <a href="#" data-spa-page="history" class="neo-nav-link">
                <i class="bx bx-history neo-nav-icon"></i>
                <span>Riwayat</span>
            </a>
        </nav>

        <!-- Minimal footer actions -->
        <div class="neo-aside-footer">
            <div class="neo-profile-module" data-spa-page="account" title="Buka Profil">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/ico/default-user.jpg') }}" alt="Profile" class="neo-profile-img">
                <div class="neo-profile-meta">
                    <span class="neo-profile-name">{{ $user->name }}</span>
                    <span class="neo-profile-role">{{ explode('@', $user->email)[0] }}</span>
                </div>
                <i class='bx bx-chevron-right' style="color: #aaa; margin-left: auto;"></i>
            </div>

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
        max-width: 280px; /* Constrain width so page behind is visible */
        padding: 32px 20px;
        box-sizing: border-box;
        border-right: 1px solid rgba(0,0,0,0.06);
        box-shadow: 4px 0 24px rgba(0,0,0,0.05);
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
        background: rgba(0,0,0,0.02);
    }
    
    .neo-nav-link:hover .neo-nav-icon {
        transform: scale(1.1);
    }

    /* Active State (Like Linear / Vercel style) */
    .neo-nav-link.active {
        color: #121212;
        font-weight: 600;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.04);
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
        border-color: rgba(0,0,0,0.04);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .neo-profile-img {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
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
        border: 1px dashed rgba(0,0,0,0.1);
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
</style>
{{-- ═══════════════════════════════════════════════════════════════
SECRET LAB — Elite-Only Zone (Universe+ Tier)
═══════════════════════════════════════════════════════════════ --}}

@if(!$isElite)
    {{-- ══ LOCKED STATE ══ --}}
    <div class="neo-dashboard rtd-dashboard" style="min-height:80vh;display:flex;align-items:center;justify-content:center;">
        <div class="sl-locked-card">
            <div class="sl-locked-visual">
                <div class="sl-lock-rings">
                    <div class="sl-ring sl-ring-1"></div>
                    <div class="sl-ring sl-ring-2"></div>
                    <div class="sl-ring sl-ring-3"></div>
                    <div class="sl-lock-icon">
                        <i class='bx bx-lock-alt'></i>
                    </div>
                </div>
            </div>
            <div class="sl-locked-body">
                <h2>Akses Ditolak</h2>
                <p class="sl-locked-sub">Gerbang ini hanya terbuka untuk pejuang sejati</p>

                <div class="sl-req-list">
                    <div class="sl-req-row">
                        <div class="sl-req-ico purple"><i class='bx bx-shield-quarter'></i></div>
                        <div class="sl-req-text">
                            <strong>Tier Dibutuhkan: Universe</strong>
                            <span>Capai 80.000 EXP untuk membuka Secret Lab</span>
                        </div>
                    </div>
                    <div class="sl-req-row">
                        <div class="sl-req-ico amber"><i class='bx bx-trophy'></i></div>
                        <div class="sl-req-text">
                            <strong>Tier Kamu: {{ $rankName }}</strong>
                            <span>{{ number_format($user->exp ?? 0) }} / 80.000 EXP</span>
                        </div>
                    </div>
                </div>

                @php $pct = min(100, round(($user->exp ?? 0) / 80000 * 100)); @endphp
                <div class="sl-bar-wrap">
                    <div class="sl-bar">
                        <div class="sl-bar-fill" style="width:{{ $pct }}%"></div>
                    </div>
                    <span>{{ $pct }}% menuju Universe</span>
                </div>

                <a href="?page=dashboard" data-page="dashboard" class="link-spa sl-back-btn" style="text-decoration:none;">
                    <i class='bx bx-arrow-back'></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

@else
    {{-- ══ UNLOCKED STATE ══ --}}
    <div class="neo-dashboard rtd-dashboard">
        <div class="neo-bento-container">

            {{-- ── BACK TO DASHBOARD ────────────────────────────────────────── --}}
            <a href="?page=dashboard" class="link-spa" data-page="dashboard"
                style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:700;color:var(--neo-text-dark, #888);text-decoration:none;margin-bottom:32px;transition:color 0.2s; background: rgba(0,0,0,0.03); padding: 8px 16px; border-radius: 20px;"
                onmouseover="this.style.background='rgba(0,0,0,0.05)';" 
                onmouseout="this.style.background='rgba(0,0,0,0.03)';">
                <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
            </a>

            {{-- Header --}}
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
                        <h2 class="neo-title" style="font-size: 32px; margin: 0; color: var(--neo-text-dark, #121212);">Secret Lab</h2>
                        @if($user->isPenguasaSektor())
                            <span class="sl-badge" style="background: rgba(251,191,36,0.15); color: #f59e0b; border: 1px solid rgba(251,191,36,0.3);"><i class='bx bxs-crown'></i> SOVEREIGN</span>
                        @else
                            <span class="sl-badge"><i class='bx bxs-crown'></i> ELITE</span>
                        @endif
                    </div>
                    <p style="font-size: 15px; color: #888; margin: 0;">Selamat datang, <span class="sl-gradient-txt">{{ $user->name }}</span> — {{ $rankName }}</p>
                </div>
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                    <i class='bx bxs-flask' style="font-size: 28px; color: #8b5cf6;"></i>
                </div>
            </div>

            {{-- Bento Stats --}}
            <div class="sl-bento-stats">
                <div class="sl-bento-card sl-bc-dark">
                    <span class="sl-bc-label">Total EXP</span>
                    <span class="sl-bc-value">{{ number_format($user->exp ?? 0) }}</span>
                    <div class="sl-bc-ico"><i class='bx bx-trending-up'></i></div>
                </div>
                <div class="sl-bento-card">
                    <span class="sl-bc-label">Rank Saat Ini</span>
                    <span class="sl-bc-value">{{ $rankName }}</span>
                    <div class="sl-bc-ico"><i class='bx bx-star'></i></div>
                </div>
                <div class="sl-bento-card">
                    <span class="sl-bc-label">Elite Tier</span>
                    <span class="sl-bc-value">Tier {{ $eliteTier }}</span>
                    <div class="sl-bc-ico"><i class='bx bx-layer'></i></div>
                </div>
            </div>

            @if($user->isPenguasaSektor())
                {{-- Sovereign Zone --}}
                <div class="sl-section-head" style="margin-top: 40px;">
                    <h3><i class='bx bxs-crown' style="color:#f59e0b;"></i> Sovereign Zone</h3>
                    <p>Akses absolut khusus Penguasa Sektor</p>
                </div>

                <div class="sl-feature-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
                    <div class="sl-feature-card" style="background: #1a1a1a; border: 1px solid rgba(251, 191, 36, 0.3);">
                        <div class="sl-fc-top" style="background: rgba(251, 191, 36, 0.1); color: #fbbf24;">
                            <div class="sl-fc-icon"><i class='bx bx-id-card'></i></div>
                            <span class="sl-fc-tag" style="background: rgba(251,191,36,0.2); color: #fbbf24;">SOVEREIGN</span>
                        </div>
                        <div class="sl-fc-body">
                            <h4 style="color: var(--neo-text-light, #ffffff);">Golden Identity</h4>
                            <p style="color:#aaa;">Identitas visual eksklusif di leaderboard, profil, dan navbar. Aura dan
                                emblem emas-ungu.</p>
                            <div class="sl-fc-action">
                                <span class="sl-fc-status active" style="color:#fbbf24;"><i class='bx bx-check-circle'></i>
                                    Aktif</span>
                            </div>
                        </div>
                    </div>

                    <div class="sl-feature-card" style="background: #1a1a1a; border: 1px solid rgba(251, 191, 36, 0.3);">
                        <div class="sl-fc-top" style="background: rgba(251, 191, 36, 0.1); color: #fbbf24;">
                            <div class="sl-fc-icon"><i class='bx bx-crown'></i></div>
                            <span class="sl-fc-tag" style="background: rgba(251,191,36,0.2); color: #fbbf24;">PRIVILEGE</span>
                        </div>
                        <div class="sl-fc-body">
                            <h4 style="color: var(--neo-text-light, #ffffff);">Absolute Authority</h4>
                            <p style="color:#aaa;">Fitur tambahan rahasia dan prioritas akses ke sistem baru di masa mendatang.
                            </p>
                            <div class="sl-fc-action">
                                <span class="sl-fc-status" style="color:#888;"><i class='bx bx-time'></i> Segera Hadir</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Exclusive Features --}}
            <div class="sl-section-head" style="margin-top: 40px;">
                <h3><i class='bx bxs-diamond'></i> Konten Eksklusif</h3>
                <p>Hanya untuk pengguna di atas tier Legend</p>
            </div>

            <div class="sl-feature-grid">
                <div class="sl-feature-card">
                    <div class="sl-fc-top purple">
                        <div class="sl-fc-icon"><i class='bx bx-target-lock'></i></div>
                        <span class="sl-fc-tag">CHALLENGE</span>
                    </div>
                    <div class="sl-fc-body">
                        <h4>Elite Challenge</h4>
                        <p>Tantangan eksklusif dengan EXP berlipat. Hanya para elit yang bisa bertahan!</p>
                        <div class="sl-fc-pills">
                            <span><i class='bx bx-bolt-circle'></i> 2x EXP</span>
                            <span><i class='bx bx-timer'></i> Terbatas</span>
                        </div>
                    </div>
                    <div class="sl-fc-foot"><i class='bx bx-time-five'></i> Coming Soon</div>
                </div>

                <div class="sl-feature-card">
                    <div class="sl-fc-top pink">
                        <div class="sl-fc-icon"><i class='bx bx-book-content'></i></div>
                        <span class="sl-fc-tag">MATERI</span>
                    </div>
                    <div class="sl-fc-body">
                        <h4>Advanced Materials</h4>
                        <p>Materi mendalam: arsitektur sistem, design patterns, dan optimasi performa.</p>
                        <div class="sl-fc-pills">
                            <span><i class='bx bx-code-curly'></i> Deep Dive</span>
                            <span><i class='bx bx-shield-quarter'></i> Elite Only</span>
                        </div>
                    </div>
                    <div class="sl-fc-foot"><i class='bx bx-time-five'></i> Coming Soon</div>
                </div>

                <div class="sl-feature-card">
                    <div class="sl-fc-top amber">
                        <div class="sl-fc-icon"><i class='bx bx-crown'></i></div>
                        <span class="sl-fc-tag">LEADERBOARD</span>
                    </div>
                    <div class="sl-fc-body">
                        <h4>Hall of Legends</h4>
                        <p>Papan peringkat eksklusif para elit. Buktikan siapa yang paling unggul!</p>
                        <div class="sl-fc-pills">
                            <span><i class='bx bx-trophy'></i> Top Elite</span>
                            <span><i class='bx bx-medal'></i> Reward</span>
                        </div>
                    </div>
                    <div class="sl-fc-foot"><i class='bx bx-time-five'></i> Coming Soon</div>
                </div>
            </div>

            {{-- Privileges --}}
            <div class="sl-priv-card">
                <h3><i class='bx bxs-gift'></i> Hak Istimewa Elite</h3>
                <div class="sl-priv-grid">
                    <div class="sl-priv-item">
                        <div class="sl-priv-ico" style="--c:#8b5cf6;"><i class='bx bxs-magic-wand'></i></div>
                        <strong>Cosmic Aura</strong>
                        <span>Efek visual eksklusif di foto profil</span>
                    </div>
                    <div class="sl-priv-item">
                        <div class="sl-priv-ico" style="--c:#ec4899;"><i class='bx bxs-flask'></i></div>
                        <strong>Secret Lab</strong>
                        <span>Akses ke zona rahasia elit</span>
                    </div>
                    <div class="sl-priv-item">
                        <div class="sl-priv-ico" style="--c:#f59e0b;"><i class='bx bxs-badge-check'></i></div>
                        <strong>Elite Badge</strong>
                        <span>Lencana khusus di sidebar</span>
                    </div>
                    <div class="sl-priv-item">
                        <div class="sl-priv-ico" style="--c:#10b981;"><i class='bx bxs-crown'></i></div>
                        <strong>Nama Berkilau</strong>
                        <span>Nama bergradien eksklusif</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endif

<style>
    /* ═══════════════════════════════════════
   SECRET LAB — Neo-Bento Consistent
   ═══════════════════════════════════════ */
    .neo-bento-container {
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }


    /* ── LOCKED ── */
    .sl-locked-card {
        background: var(--neo-card-light, #e5e5e5);
        border-radius: var(--neo-radius, 32px);
        max-width: 460px;
        width: 100%;
        overflow: hidden;
        animation: slPop .5s cubic-bezier(.16, 1, .3, 1);
    }

    @keyframes slPop {
        0% {
            transform: scale(.96) translateY(16px);
            opacity: 0;
        }

        100% {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }

    .sl-locked-visual {
        background: #121212;
        padding: 52px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .sl-locked-visual::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(139, 92, 246, .12) 0%, transparent 70%);
    }

    .sl-lock-rings {
        position: relative;
        width: 110px;
        height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sl-ring {
        position: absolute;
        border-radius: 50%;
        border: 1.5px solid;
        animation: slPulse 3s ease-in-out infinite;
    }

    .sl-ring-1 {
        inset: 0;
        border-color: rgba(139, 92, 246, .35);
    }

    .sl-ring-2 {
        inset: -12px;
        border-color: rgba(236, 72, 153, .2);
        animation-delay: .5s;
    }

    .sl-ring-3 {
        inset: -24px;
        border-color: rgba(245, 158, 11, .12);
        animation-delay: 1s;
    }

    @keyframes slPulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.06);
            opacity: .5;
        }
    }

    .sl-lock-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(6px);
    }

    .sl-lock-icon i {
        font-size: 32px;
        color: var(--neo-text-light, #ffffff);
        opacity: 0.5;
    }

    .sl-locked-body {
        padding: 28px 28px 32px;
        text-align: center;
    }

    .sl-locked-body h2 {
        font-family: 'Inter', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: var(--neo-text-dark, #121212);
        margin: 0 0 6px;
        letter-spacing: -.3px;
    }

    .sl-locked-sub {
        font-size: 13px;
        color: #888;
        margin: 0 0 24px;
        font-weight: 500;
    }

    .sl-req-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    .sl-req-row {
        display: flex;
        gap: 12px;
        align-items: center;
        background: var(--neo-text-light, #ffffff);
        padding: 12px 14px;
        border-radius: 16px;
        text-align: left;
    }

    .sl-req-ico {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .sl-req-ico.purple {
        background: rgba(139, 92, 246, .1);
        color: #8b5cf6;
    }

    .sl-req-ico.amber {
        background: rgba(245, 158, 11, .1);
        color: #f59e0b;
    }

    .sl-req-text strong {
        display: block;
        font-size: 13px;
        color: var(--neo-text-dark, #121212);
    }

    .sl-req-text span {
        font-size: 11px;
        color: #888;
    }

    .sl-bar-wrap {
        margin-bottom: 24px;
    }

    .sl-bar {
        background: rgba(0, 0, 0, .06);
        border-radius: 10px;
        height: 6px;
        overflow: hidden;
    }

    .sl-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #8b5cf6, #ec4899);
        border-radius: 10px;
        transition: width 1s cubic-bezier(.16, 1, .3, 1);
    }

    .sl-bar-wrap span {
        font-size: 11px;
        color: #888;
        font-weight: 600;
        display: block;
        margin-top: 6px;
    }

    .sl-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--neo-text-dark, #121212);
        color: var(--neo-text-light, #ffffff);
        border-radius: 14px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all .3s cubic-bezier(.16, 1, .3, 1);
    }

    .sl-back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12);
    }



    .sl-gradient-txt {
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }

    .sl-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        background: var(--neo-text-dark, #121212);
        color: var(--neo-text-light, #ffffff);
        border-radius: 10px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.2px;
    }

    /* Bento Stats */
    .sl-bento-stats {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr;
        gap: 16px;
        margin-bottom: 32px;
    }

    .sl-bento-card {
        background: var(--neo-card-light, #e5e5e5);
        border-radius: var(--neo-radius, 32px);
        padding: 32px;
        position: relative;
        overflow: hidden;
        min-height: 100px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s;
    }

    .sl-bento-card:hover {
        transform: translateY(-4px);
    }

    .sl-bento-card.sl-bc-dark {
        background: var(--neo-card-black, #000000);
        color: var(--neo-text-light, #ffffff);
    }

    .sl-bento-card.sl-bc-dark .sl-bc-label {
        color: rgba(255, 255, 255, .5);
    }

    .sl-bento-card.sl-bc-dark .sl-bc-value {
        color: #fff;
    }

    .sl-bc-label {
        font-size: 11px;
        font-weight: 600;
        color: #888;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 4px;
    }

    .sl-bc-value {
        font-size: 22px;
        font-weight: 800;
        color: var(--neo-text-dark, #121212);
        letter-spacing: -.3px;
    }

    .sl-bc-ico {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 28px;
        opacity: .15;
    }

    .sl-bento-card.sl-bc-dark .sl-bc-ico {
        opacity: .2;
    }

    /* Section Heading */
    .sl-section-head {
        margin-bottom: 16px;
    }

    .sl-section-head h3 {
        font-size: 16px;
        font-weight: 800;
        color: var(--neo-text-dark, #121212);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .sl-section-head h3 i {
        color: #8b5cf6;
        font-size: 18px;
    }

    .sl-section-head p {
        font-size: 12px;
        color: #888;
        margin: 4px 0 0;
        font-weight: 500;
    }

    /* Feature Cards */
    .sl-feature-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }

    .sl-feature-card {
        background: var(--neo-card-light, #e5e5e5);
        border-radius: var(--neo-radius, 32px);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform .3s cubic-bezier(.16, 1, .3, 1), box-shadow .3s;
    }

    .sl-feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px rgba(0, 0, 0, .06);
    }

    .sl-fc-top {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sl-fc-top.purple {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .sl-fc-top.pink {
        background: linear-gradient(135deg, #ec4899, #db2777);
    }

    .sl-fc-top.amber {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .sl-fc-icon {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, .2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: var(--neo-text-light, #ffffff);
    }

    .sl-fc-tag {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, .8);
        background: rgba(255, 255, 255, .15);
        padding: 4px 10px;
        border-radius: 8px;
    }

    .sl-fc-body {
        padding: 20px;
        flex: 1;
    }

    .sl-fc-body h4 {
        font-size: 16px;
        font-weight: 800;
        color: var(--neo-text-dark, #121212);
        margin: 0 0 6px;
        letter-spacing: -.2px;
    }

    .sl-fc-body p {
        font-size: 12px;
        color: #888;
        margin: 0 0 14px;
        line-height: 1.6;
    }

    .sl-fc-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .sl-fc-pills span {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 10px;
        font-weight: 700;
        color: #888;
        background: rgba(0, 0, 0, .04);
        padding: 5px 10px;
        border-radius: 8px;
    }

    .sl-fc-foot {
        padding: 14px 20px;
        border-top: 1px solid rgba(0, 0, 0, .04);
        font-size: 11px;
        font-weight: 700;
        color: #aaa;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Privileges */
    .sl-priv-card {
        background: var(--neo-card-light, #e5e5e5);
        border-radius: var(--neo-radius, 32px);
        padding: 32px;
        margin-bottom: 32px;
    }

    .sl-priv-card h3 {
        font-size: 16px;
        font-weight: 800;
        color: var(--neo-text-dark, #121212);
        margin: 0 0 20px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .sl-priv-card h3 i {
        color: #8b5cf6;
    }

    .sl-priv-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .sl-priv-item {
        text-align: center;
        padding: 20px 12px;
        background: rgba(255, 255, 255, .5);
        border-radius: 18px;
        transition: all .3s;
    }

    .sl-priv-item:hover {
        background: var(--neo-text-light, #ffffff);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .04);
    }

    .sl-priv-ico {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: color-mix(in srgb, var(--c) 12%, transparent);
        color: var(--c);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 10px;
    }

    .sl-priv-item strong {
        display: block;
        font-size: 13px;
        color: var(--neo-text-dark, #121212);
        margin-bottom: 2px;
    }

    .sl-priv-item span {
        font-size: 11px;
        color: #888;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .neo-dashboard { 
            padding: 16px 0; 
            overflow-x: hidden; 
        }
        
        .neo-bento-container,
        .neo-bento-container * {
            box-sizing: border-box;
        }

        .neo-bento-container {
            padding: 0 16px;
            max-width: 100vw;
        }

        .sl-bento-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .sl-feature-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .sl-priv-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }



        .sl-bento-card {
            padding: 20px;
            min-height: auto;
        }

        .sl-bc-value {
            font-size: 18px;
        }

        .sl-fc-top, .sl-fc-body, .sl-priv-card {
            padding: 16px;
        }

        .sl-fc-body h4 {
            font-size: 14px;
        }

        .sl-priv-card h3 {
            font-size: 14px;
        }

        .sl-priv-item {
            padding: 12px 8px;
        }
    }
</style>
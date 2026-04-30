<div style="margin-top: 48px; margin-bottom: 24px;">
    <h3 class="neo-title" style="font-size: 28px; margin: 0 0 8px 0; color: #121212;">Daftar Tier</h3>
    <p style="font-size: 16px; color: #555; margin: 0;">Jelajahi seluruh tier dari terendah hingga tertinggi.</p>
</div>

@php
$tiers = [
    ['name' => 'Pemula', 'exp' => 0, 'icon' => 'emblem001Trans.png'],
    ['name' => 'Junior', 'exp' => 1000, 'icon' => 'emblem002Trans.png'],
    ['name' => 'Senior', 'exp' => 5000, 'icon' => 'emblem003Trans.png'],
    ['name' => 'Master', 'exp' => 10000, 'icon' => 'emblem004Trans.png'],
    ['name' => 'Grandmaster', 'exp' => 20000, 'icon' => 'emblem005Trans.png'],
    ['name' => 'Legend', 'exp' => 40000, 'icon' => 'emblem006Trans.png'],
    ['name' => 'Universe', 'exp' => 80000, 'icon' => 'emblem007Trans.png'],
    ['name' => 'Domain', 'exp' => 100000, 'icon' => 'emblem008Trans.png'],
    ['name' => 'Immortal', 'exp' => 250000, 'icon' => 'emblem009Trans.png'],
    ['name' => 'Venerable', 'exp' => 500000, 'icon' => 'emblem010Trans.png'],
    ['name' => 'Penguasa Sektor', 'exp' => 1000000, 'icon' => 'emblem011Trans.png'],
];
@endphp

<div class="tier-list-container">
    <div class="tier-list-scroll">
        @foreach($tiers as $index => $tier)
            @php
                // Check if user is currently at this tier
                $isCurrentTier = auth()->user() && auth()->user()->rank_name === $tier['name'];
                $isSovereign = $tier['name'] === 'Penguasa Sektor';
            @endphp
            <div class="tier-card {{ $isCurrentTier ? 'current-tier' : '' }} {{ $isSovereign ? 'tier-card-sovereign' : '' }}">
                <div class="tier-number">#{{ $index + 1 }}</div>
                @if($isCurrentTier)
                    <div class="current-badge">Kamu di sini</div>
                @endif
                <div class="tier-icon-wrap">
                    <img src="{{ asset('assets/ico/' . $tier['icon']) }}" alt="{{ $tier['name'] }}" class="tier-icon">
                </div>
                <h4 class="tier-name">{{ $tier['name'] }}</h4>
                <div class="tier-exp">{{ number_format($tier['exp']) }} EXP</div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .tier-list-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }
    .tier-list-scroll {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        padding-bottom: 16px; /* Space for scrollbar */
        padding-top: 16px; /* Space for hover effects */
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,0.2) transparent;
        -webkit-overflow-scrolling: touch;
    }
    .tier-list-scroll::-webkit-scrollbar {
        height: 8px;
    }
    .tier-list-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .tier-list-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.2);
        border-radius: 20px;
    }
    .tier-card {
        flex: 0 0 auto;
        width: 160px;
        background: var(--neo-card-light, #e5e5e5);
        border-radius: 24px;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s, background-color 0.3s;
        border: 2px solid transparent;
    }
    .tier-card:hover {
        transform: translateY(-8px);
        background: #fff;
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }
    .tier-card.current-tier {
        background: #fff;
        border-color: #121212;
        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
    }
    .tier-number {
        position: absolute;
        top: 12px;
        left: 16px;
        font-size: 14px;
        font-weight: 800;
        color: #888;
    }
    .current-badge {
        position: absolute;
        top: -12px;
        background: #121212;
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        letter-spacing: 0.5px;
        z-index: 2;
    }
    .tier-icon-wrap {
        width: 80px;
        height: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 12px;
        margin-top: 16px;
    }
    .tier-icon {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        transition: transform 0.3s;
    }
    .tier-card:hover .tier-icon {
        transform: scale(1.1);
    }
    .tier-name {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #121212;
    }
    .tier-exp {
        font-size: 13px;
        color: #555;
        font-weight: 600;
        margin-top: 4px;
    }
    
    /* Sovereign Card Special Styling */
    .tier-card-sovereign {
        background: linear-gradient(135deg, #1f1f1f, #121212);
        position: relative;
    }
    
    .tier-card-sovereign::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 22px;
        padding: 2px;
        background: linear-gradient(135deg, #fbbf24, #d946ef, #fbbf24);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        animation: sovereignBorderRotate 4s linear infinite;
    }
    
    .tier-card-sovereign .tier-name {
        background: linear-gradient(135deg, #fbbf24, #d946ef);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 900;
    }
    
    .tier-card-sovereign .tier-exp {
        color: #a1a1aa;
    }
    
    .tier-card-sovereign .tier-number {
        color: #fbbf24;
    }
    
    .tier-card-sovereign .tier-icon {
        filter: drop-shadow(0 0 15px rgba(251, 191, 36, 0.6));
        animation: sovereignIconPulse 2s ease-in-out infinite alternate;
    }
    
    .tier-card-sovereign:hover {
        background: linear-gradient(135deg, #262626, #1a1a1a);
        box-shadow: 0 16px 32px rgba(251, 191, 36, 0.2);
    }
    
    .tier-card-sovereign.current-tier {
        background: linear-gradient(135deg, #262626, #1a1a1a);
        box-shadow: 0 8px 16px rgba(251, 191, 36, 0.15);
    }
    
    @keyframes sovereignBorderRotate {
        0% { filter: hue-rotate(0deg); }
        100% { filter: hue-rotate(360deg); }
    }
    
    @keyframes sovereignIconPulse {
        0% { transform: scale(1); filter: drop-shadow(0 0 10px rgba(251, 191, 36, 0.4)); }
        100% { transform: scale(1.1); filter: drop-shadow(0 0 20px rgba(251, 191, 36, 0.8)); }
    }

    /* ═══ MOBILE RESPONSIVENESS ═══ */
    @media (max-width: 768px) {
        .tier-list-container {
            margin: 0;
            width: 100%;
        }
        .tier-list-scroll {
            gap: 12px;
            padding: 12px 10px;
        }
        .tier-card {
            width: 120px;
            padding: 16px 10px;
            border-radius: 16px;
        }
        .tier-icon-wrap {
            width: 60px;
            height: 60px;
            margin-bottom: 8px;
            margin-top: 12px;
        }
        .tier-name {
            font-size: 14px;
        }
        .tier-exp {
            font-size: 11px;
            margin-top: 2px;
        }
        .tier-number {
            top: 10px;
            left: 12px;
            font-size: 13px;
        }
        .current-badge {
            top: -10px;
            font-size: 9px;
            padding: 4px 8px;
        }
    }
</style>

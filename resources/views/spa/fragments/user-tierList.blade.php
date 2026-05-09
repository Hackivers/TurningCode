<div style="margin-top: 48px; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
        <div style="width: 6px; height: 6px; background: #d71921; border-radius: 50%;"></div>
        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--text-muted);">SYSTEM TIERS</div>
    </div>
    <h3 style="font-size: 22px; font-weight: 800; margin: 0 0 4px 0; color: var(--text-primary); font-family: 'Space Mono', monospace; text-transform: uppercase; letter-spacing: -0.5px;">Daftar Tier</h3>
    <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Terendah hingga tertinggi.</p>
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

<div class="nothing-tier-container">
    <div class="nothing-tier-scroll">
        @php
            $myIndex = 0;
            if(auth()->user()) {
                $myRank = auth()->user()->rank_name;
                foreach($tiers as $idx => $t) {
                    if($t['name'] === $myRank) {
                        $myIndex = $idx;
                        break;
                    }
                }
            }
            
            $displayTiers = [];
            // Paling kiri tier saya
            $myTierData = $tiers[$myIndex];
            $myTierData['original_index'] = $myIndex;
            $myTierData['is_me'] = true;
            $displayTiers[] = $myTierData;

            // 6 tier sebelum saya (yang lebih rendah)
            // Urut dari yang paling dekat dengan saya hingga yang terendah
            for($i = $myIndex - 1; $i >= max(0, $myIndex - 6); $i--) {
                $t = $tiers[$i];
                $t['original_index'] = $i;
                $t['is_me'] = false;
                $displayTiers[] = $t;
            }
        @endphp

        @foreach($displayTiers as $tier)
            @php
                $isCurrentTier = $tier['is_me'];
                $isSovereign = $tier['name'] === 'Penguasa Sektor';
                $index = $tier['original_index'];
            @endphp
            <div class="nothing-tier-card {{ $isCurrentTier ? 'nothing-tier-active' : '' }} {{ $isSovereign ? 'nothing-tier-sovereign' : '' }}">
                <!-- Index -->
                <div class="nothing-tier-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                @if($isCurrentTier)
                    <div class="nothing-tier-badge">
                        <div style="width: 6px; height: 6px; background: #d71921; border-radius: 50%; margin-right: 4px;"></div>
                        YOU
                    </div>
                @endif

                @if($isCurrentTier)
                    <!-- WIDE LAYOUT FOR MY TIER -->
                    <div style="display: flex; align-items: center; width: 100%; height: 100%; gap: 24px; padding: 0 16px;">
                        <!-- Icon -->
                        <div class="nothing-tier-icon-wrap" style="margin: 0; width: 80px; height: 80px; flex-shrink: 0;">
                            <img src="{{ asset('assets/ico/' . $tier['icon']) }}" alt="{{ $tier['name'] }}" class="nothing-tier-icon">
                        </div>
                        
                        <!-- Info -->
                        <div style="flex: 1; text-align: left; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 4px;">CURRENT RANK</div>
                            <h4 class="nothing-tier-name" style="font-size: 24px; margin: 0 0 8px 0; letter-spacing: -0.5px;">{{ $tier['name'] }}</h4>
                            <div class="nothing-tier-exp" style="font-size: 16px; color: var(--text-secondary); margin: 0;">
                                {{ number_format(auth()->user()->exp) }} <span style="font-size: 10px; color: var(--text-muted);">/ {{ number_format($tier['exp']) }} EXP</span>
                            </div>
                            
                            <!-- Progress Bar -->
                            @php
                                $nextExp = $tier['exp']; // Target for next tier, actually my tier exp is the requirement for this tier.
                                // Let's find next tier requirement
                                $nextTierExp = isset($tiers[$index+1]) ? $tiers[$index+1]['exp'] : $tier['exp'];
                                $progress = 100;
                                if($nextTierExp > $tier['exp']) {
                                    $progress = ((auth()->user()->exp - $tier['exp']) / ($nextTierExp - $tier['exp'])) * 100;
                                    $progress = min(100, max(0, $progress));
                                }
                            @endphp
                            <div style="width: 100%; height: 4px; background: var(--border-color); border-radius: 2px; margin-top: 12px; overflow: hidden;">
                                <div style="width: {{ $progress }}%; height: 100%; background: var(--bg-secondary); border-radius: 2px;"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- NORMAL LAYOUT -->
                    <!-- Icon -->
                    <div class="nothing-tier-icon-wrap">
                        <img src="{{ asset('assets/ico/' . $tier['icon']) }}" alt="{{ $tier['name'] }}" class="nothing-tier-icon">
                    </div>

                    <!-- Name -->
                    <h4 class="nothing-tier-name">{{ $tier['name'] }}</h4>

                    <!-- EXP -->
                    <div class="nothing-tier-exp">{{ number_format($tier['exp']) }}</div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<style>
    .nothing-tier-container {
        width: 100%;
        overflow: hidden;
    }

    .nothing-tier-scroll {
        display: flex;
        gap: 10px;
        justify-content: space-between;
        width: 100%;
        overflow-x: auto;
        padding-bottom: 12px;
        padding-top: 16px;
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,0.15) transparent;
        -webkit-overflow-scrolling: touch;
    }

    .nothing-tier-scroll::-webkit-scrollbar {
        height: 4px;
    }

    .nothing-tier-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .nothing-tier-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.15);
        border-radius: 0;
    }

    .nothing-tier-card {
        flex: 0 0 auto;
        width: 140px;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        transition: border-color 0.15s, background-color 0.15s, transform 0.2s;
        cursor: default;
        box-shadow: none;
    }

    .nothing-tier-card:hover {
        border-color: var(--text-primary); font-family: 'Space Mono', monospace; text-transform: uppercase;
    }

    /* Active tier — inverted */
    .nothing-tier-active {
        width: 440px !important;
        background: var(--bg-tertiary) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary);
        transform: translateY(-4px);
        box-shadow: none;
        padding: 24px;
    }

    .nothing-tier-active .nothing-tier-name {
        color: var(--text-primary) !important;
    }

    .nothing-tier-active .nothing-tier-exp {
        color: var(--text-muted) !important;
    }

    .nothing-tier-active .nothing-tier-index {
        color: var(--text-muted) !important;
    }

    .nothing-tier-active .nothing-tier-icon {
        filter: brightness(1.3) !important;
    }

    /* Sovereign — inverted + red accent */
    .nothing-tier-sovereign {
        background: var(--bg-tertiary) !important;
        border: 2px solid #d71921 !important;
    }

    .nothing-tier-sovereign .nothing-tier-name {
        color: #d71921 !important;
        font-weight: 900 !important;
    }

    .nothing-tier-sovereign .nothing-tier-exp {
        color: var(--text-muted) !important;
    }

    .nothing-tier-sovereign .nothing-tier-index {
        color: #d71921 !important;
    }

    .nothing-tier-sovereign .nothing-tier-icon {
        filter: drop-shadow(0 0 8px rgba(215,25,33,0.4)) brightness(1.2) !important;
    }

    .nothing-tier-index {
        position: absolute;
        top: 16px;
        left: 16px;
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        font-size: 14px;
        color: var(--text-muted);
    }

    .nothing-tier-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: #ea1515;
        color: var(--text-primary);
        font-size: 9px;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: var(--neo-btn-radius);
        letter-spacing: 1.5px;
        text-transform: uppercase;
        z-index: 2;
        display: flex;
        align-items: center;
        border: var(--nothing-border);
    }

    .nothing-tier-icon-wrap {
        width: 72px;
        height: 72px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
        margin-top: 16px;
    }

    .nothing-tier-icon {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: contrast(1.1);
        transition: transform 0.2s;
    }

    .nothing-tier-card:hover .nothing-tier-icon {
        transform: scale(1.05);
    }

    .nothing-tier-name {
        margin: 0;
        font-size: 14px;
        font-weight: 800;
        color: var(--text-primary); font-family: 'Space Mono', monospace; text-transform: uppercase;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .nothing-tier-exp {
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* ═══ MOBILE ═══ */
    @media (max-width: 768px) {
        .nothing-tier-scroll {
            gap: 8px;
            padding: 12px 4px;
        }

        .nothing-tier-card {
            width: 110px;
            padding: 14px 10px;
        }

        .nothing-tier-icon-wrap {
            width: 52px;
            height: 52px;
            margin-bottom: 8px;
            margin-top: 12px;
        }

        .nothing-tier-name {
            font-size: 11px;
        }

        .nothing-tier-exp {
            font-size: 10px;
        }

        .nothing-tier-index {
            font-size: 11px;
            top: 12px;
            left: 12px;
        }

        .nothing-tier-badge {
            font-size: 7px;
            padding: 4px 10px;
            top: -10px;
        }
    }
</style>

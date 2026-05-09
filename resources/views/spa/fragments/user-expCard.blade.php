@php
    $rank = auth()->user()->rank_name;
    $userExp = auth()->user()->exp ?? 0;
@endphp

<div style="padding: 24px; height: 100%; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
    
    <!-- Background Emblem (watermark style) -->
    <img src="{{ asset('assets/ico/' . auth()->user()->emblem_image) }}" alt="Emblem" style="position: absolute; right: -40px; bottom: -40px; width: 240px; height: 240px; opacity: 0.1; filter: grayscale(1); pointer-events: none; z-index: 0;">

    <div style="position: relative; z-index: 1;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
            <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #888;">
                <i class='bx bx-hive' style="margin-right: 4px;"></i> SYSTEM ID
            </div>
            <div style="font-family: 'Space Mono', monospace; font-size: 12px; color: #fff; text-transform: uppercase; padding: 4px 8px; border: 1px solid rgba(255,255,255,0.2); border-radius: 4px;">
                {{ $rank }}
            </div>
        </div>

        <div style="margin-top: auto;">
            <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #ea1515; margin-bottom: 4px;">EXPERIENCE</div>
            <div style="font-family: 'Space Mono', monospace; font-size: clamp(32px, 4vw, 48px); font-weight: 700; color: #fff; line-height: 1; letter-spacing: -1px;">
                <span id="current-exp-amount">{{ number_format($userExp) }}</span>
            </div>
        </div>
    </div>

    <div style="position: relative; z-index: 1; margin-top: 24px;">
        @if(auth()->user()->next_rank_exp)
            <div style="display: flex; justify-content: space-between; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 8px;">
                <span>NEXT: {{ auth()->user()->next_rank_name }}</span>
                <span style="color: #fff;"><span id="exp-needed">{{ number_format(auth()->user()->next_rank_exp - $userExp) }}</span> EXP</span>
            </div>
            <div style="height: 2px; background: rgba(255,255,255,0.1); width: 100%;">
                @php
                    $prevRankExp = auth()->user()->rank_exp_requirement ?? 0;
                    $nextRankExp = auth()->user()->next_rank_exp;
                    $progress = 0;
                    if ($nextRankExp > $prevRankExp) {
                        $progress = (($userExp - $prevRankExp) / ($nextRankExp - $prevRankExp)) * 100;
                        $progress = min(100, max(0, $progress));
                    }
                @endphp
                <div style="height: 100%; width: {{ $progress }}%; background: #fff;"></div>
            </div>
        @else
            <div style="display: flex; justify-content: space-between; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #ea1515; margin-bottom: 8px;">
                <span>STATUS: MAX RANK</span>
                <span>MAXED OUT</span>
            </div>
            <div style="height: 2px; background: rgba(234,21,21,0.2); width: 100%;">
                <div style="height: 100%; width: 100%; background: #ea1515;"></div>
            </div>
        @endif
    </div>
</div>
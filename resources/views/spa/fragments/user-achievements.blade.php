<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: #121212;">Pencapaian</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Kumpulkan lencana dengan menyelesaikan berbagai tantangan.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(-5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-trophy' style="font-size: 28px; color: #f59e0b;"></i>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="neo-card neo-card-light" style="padding: 32px; margin-bottom: 32px; border-radius: 20px; display: flex; justify-content: space-around; gap: 24px; flex-wrap: wrap; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="text-align: center; flex: 1; min-width: 120px;">
                <div style="font-size: 40px; font-weight: 900; color: #121212; line-height: 1;">{{ count($earnedIds) }}</div>
                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #888; margin-top: 8px;">Diraih</div>
            </div>
            
            <div style="width: 2px; background: rgba(0,0,0,0.05); border-radius: 2px;"></div>

            <div style="text-align: center; flex: 1; min-width: 120px;">
                <div style="font-size: 40px; font-weight: 900; color: #aaa; line-height: 1;">{{ $achievements->count() - count($earnedIds) }}</div>
                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #888; margin-top: 8px;">Terkunci</div>
            </div>
            
            <div style="width: 2px; background: rgba(0,0,0,0.05); border-radius: 2px;"></div>

            <div style="text-align: center; flex: 1; min-width: 120px;">
                <div style="font-size: 40px; font-weight: 900; background: linear-gradient(135deg, #f59e0b, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1;">{{ round((count($earnedIds) / max(1, $achievements->count())) * 100) }}%</div>
                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #888; margin-top: 8px;">Progres</div>
            </div>
        </div>

        <!-- Achievement Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
            @foreach($achievements as $ach)
                @php
                    $isEarned = in_array($ach->id, $earnedIds);
                @endphp
                <div class="neo-card neo-card-light ach-grid-card" style="padding: 24px; border-radius: 20px; display: flex; align-items: center; gap: 20px; position: relative; overflow: hidden; {{ !$isEarned ? 'opacity: 0.7; background: rgba(0,0,0,0.02);' : 'box-shadow: 0 8px 24px rgba(0,0,0,0.06);' }}">
                    <!-- Earned Glow -->
                    @if($isEarned)
                        <div style="position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%); pointer-events: none;"></div>
                    @endif

                    <!-- Badge Icon -->
                    <div style="width: 64px; height: 64px; flex-shrink: 0; position: relative;">
                        <img src="{{ asset('assets/ico/' . $ach->icon) }}" alt="{{ $ach->title }}"
                            style="width: 64px; height: 64px; object-fit: contain; {{ !$isEarned ? 'filter: grayscale(1) opacity(0.4);' : 'filter: drop-shadow(0 8px 16px rgba(0,0,0,0.15));' }} transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                        @if(!$isEarned)
                            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                                <div style="background: rgba(0,0,0,0.5); width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                                    <i class='bx bx-lock-alt' style="font-size: 16px; color: #fff;"></i>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                            <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: {{ $isEarned ? '#121212' : '#777' }}; letter-spacing: -0.3px;">{{ $ach->title }}</h4>
                            @if($isEarned)
                                <i class='bx bxs-check-circle' style="color: #10b981; font-size: 18px; filter: drop-shadow(0 2px 4px rgba(16,185,129,0.3));"></i>
                            @endif
                        </div>
                        <p style="margin: 0 0 10px 0; font-size: 13px; color: #666; line-height: 1.5;">{{ $ach->description }}</p>
                        @if($ach->exp_reward > 0)
                            <div style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; color: {{ $isEarned ? '#10b981' : '#aaa' }}; background: {{ $isEarned ? 'rgba(16, 185, 129, 0.1)' : 'rgba(0,0,0,0.04)' }}; padding: 4px 10px; border-radius: 8px;">
                                @if($isEarned) <i class='bx bx-check'></i> @else <i class='bx bx-star'></i> @endif
                                +{{ $ach->exp_reward }} EXP
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<style>
    .ach-grid-card { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); border: 1px solid rgba(0,0,0,0.02); }
    .ach-grid-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.08) !important; border-color: rgba(0,0,0,0.05); }
    .ach-grid-card:hover img { transform: scale(1.15) rotate(5deg); }

    @media (max-width: 768px) {
        .ach-grid-card { padding: 16px !important; gap: 16px !important; }
        .ach-grid-card img { width: 48px !important; height: 48px !important; }
    }
</style>

<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: var(--text-primary)fff;">Pencapaian</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Kumpulkan lencana dengan menyelesaikan berbagai tantangan.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(-5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-trophy' style="font-size: 28px; color: #f59e0b;"></i>
            </div>
        </div>

        <!-- Stats Summary -->
        <div class="neo-card neo-card-light" style="padding: 32px; margin-bottom: 32px; border-radius: 20px; display: flex; justify-content: space-around; gap: 24px; flex-wrap: wrap; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="text-align: center; flex: 1; min-width: 120px;">
                <div style="font-size: 40px; font-weight: 900; color: var(--text-primary)fff; line-height: 1;">{{ count($earnedIds) }}</div>
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
                    
                    // Rarity based on EXP
                    $rarityColor = '#f59e0b'; // Default Gold/Common
                    $rarityBg = 'rgba(245, 158, 11, 0.1)';
                    $rarityName = 'Common';
                    
                    if ($ach->exp_reward >= 150) {
                        $rarityColor = '#ef4444'; // Red/Legendary
                        $rarityBg = 'rgba(239, 68, 68, 0.15)';
                        $rarityName = 'Legendary';
                    } elseif ($ach->exp_reward >= 75) {
                        $rarityColor = '#a855f7'; // Purple/Epic
                        $rarityBg = 'rgba(168, 85, 247, 0.15)';
                        $rarityName = 'Epic';
                    } elseif ($ach->exp_reward >= 50) {
                        $rarityColor = '#3b82f6'; // Blue/Rare
                        $rarityBg = 'rgba(59, 130, 246, 0.15)';
                        $rarityName = 'Rare';
                    }
                @endphp
                <div class="neo-card neo-card-light ach-grid-card" style="padding: 24px; border-radius: 20px; display: flex; align-items: center; gap: 20px; position: relative; overflow: hidden; {{ !$isEarned ? 'opacity: 0.7; background: rgba(0,0,0,0.02); filter: grayscale(0.8);' : 'box-shadow: 0 8px 24px rgba(0,0,0,0.06); border: 1px solid ' . $rarityBg . ';' }}">
                    <!-- Earned Glow -->
                    @if($isEarned)
                        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: radial-gradient(circle, {{ $rarityBg }} 0%, transparent 70%); pointer-events: none;"></div>
                        <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, transparent, {{ $rarityColor }}, transparent); opacity: 0.5;"></div>
                    @endif

                    <!-- Badge Icon -->
                    <div style="width: 64px; height: 64px; flex-shrink: 0; position: relative;">
                        <img src="{{ asset('assets/ico/' . $ach->icon) }}" alt="{{ $ach->title }}"
                            style="width: 64px; height: 64px; object-fit: contain; {{ !$isEarned ? 'filter: grayscale(1) opacity(0.4);' : 'filter: drop-shadow(0 8px 16px ' . $rarityBg . ');' }} transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
                        @if(!$isEarned)
                            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                                <div style="background: rgba(0,0,0,0.5); width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                                    <i class='bx bx-lock-alt' style="font-size: 16px; color: var(--text-primary);"></i>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div style="flex: 1; min-width: 0; position: relative; z-index: 1;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <h4 style="margin: 0; font-size: 16px; font-weight: 800; color: {{ $isEarned ? '#121212' : '#777' }}; letter-spacing: -0.3px;">{{ $ach->title }}</h4>
                                @if($isEarned)
                                    <i class='bx bxs-check-circle' style="color: {{ $rarityColor }}; font-size: 18px; filter: drop-shadow(0 2px 4px {{ $rarityBg }});"></i>
                                @endif
                            </div>
                        </div>
                        <p style="margin: 0 0 10px 0; font-size: 13px; color: #666; line-height: 1.5;">{{ $ach->description }}</p>
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            @if($ach->exp_reward > 0)
                                <div style="display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; color: {{ $isEarned ? $rarityColor : '#aaa' }}; background: {{ $isEarned ? $rarityBg : 'rgba(0,0,0,0.04)' }}; padding: 4px 10px; border-radius: 8px;">
                                    @if($isEarned) <i class='bx bx-check'></i> @else <i class='bx bx-star'></i> @endif
                                    +{{ $ach->exp_reward }} EXP
                                </div>
                            @endif
                            @if($isEarned)
                                <div style="font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: {{ $rarityColor }}; border: 1px solid {{ $rarityColor }}; padding: 2px 6px; border-radius: 4px; opacity: 0.8;">
                                    {{ $rarityName }}
                                </div>
                            @endif
                        </div>
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

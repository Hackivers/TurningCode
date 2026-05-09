<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: var(--text-primary)fff;">Analitik Belajar</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Pantau perkembangan dan kebiasaan belajarmu.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-bar-chart-alt-2' style="font-size: 28px; color: var(--text-primary);"></i>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-top: 32px;">
            {{-- Stat Card 1 --}}
            <div class="neo-card neo-card-light" style="padding: 24px; display: flex; align-items: center; gap: 16px; border-radius: 20px;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #3b82f6, #60a5fa); display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 8px 16px rgba(59,130,246,0.25);">
                    <i class='bx bx-book-open' style="font-size: 28px;"></i>
                </div>
                <div>
                    <div style="font-size: 11px; color: #888; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Materi Dibaca</div>
                    <div style="font-size: 28px; font-weight: 900; color: var(--text-primary)fff; line-height: 1;">{{ $materisRead }}</div>
                </div>
            </div>

            {{-- Stat Card 2 --}}
            <div class="neo-card neo-card-light" style="padding: 24px; display: flex; align-items: center; gap: 16px; border-radius: 20px;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #10b981, #34d399); display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 8px 16px rgba(16,185,129,0.25);">
                    <i class='bx bx-check-shield' style="font-size: 28px;"></i>
                </div>
                <div>
                    <div style="font-size: 11px; color: #888; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Kuis Lulus</div>
                    <div style="font-size: 28px; font-weight: 900; color: var(--text-primary)fff; line-height: 1;">{{ $passedQuizzes }} <span style="font-size: 16px; color: #888; font-weight: 600;">/ {{ $totalQuizzes }}</span></div>
                </div>
            </div>

            {{-- Stat Card 3 --}}
            <div class="neo-card neo-card-light" style="padding: 24px; display: flex; align-items: center; gap: 16px; border-radius: 20px;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #f59e0b, #fbbf24); display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 8px 16px rgba(245,158,11,0.25);">
                    <i class='bx bx-target-lock' style="font-size: 28px;"></i>
                </div>
                <div>
                    <div style="font-size: 11px; color: #888; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Akurasi Rata-rata</div>
                    <div style="font-size: 28px; font-weight: 900; color: var(--text-primary)fff; line-height: 1;">{{ $avgScore }}%</div>
                </div>
            </div>

            {{-- Stat Card 4 --}}
            <div class="neo-card neo-card-light" style="padding: 24px; display: flex; align-items: center; gap: 16px; border-radius: 20px;">
                <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #8b5cf6, #a78bfa); display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 8px 16px rgba(139,92,246,0.25);">
                    <i class='bx bx-time-five' style="font-size: 28px;"></i>
                </div>
                <div>
                    <div style="font-size: 11px; color: #888; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Waktu Belajar</div>
                    <div style="font-size: 28px; font-weight: 900; color: var(--text-primary)fff; line-height: 1;">
                        @if($timeSpent['hours'] > 0)
                            {{ $timeSpent['hours'] }}<span style="font-size: 14px; margin-right: 4px;">j</span>
                        @endif
                        {{ $timeSpent['minutes'] }}<span style="font-size: 14px;">m</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity Chart --}}
        <div class="neo-card neo-card-light" style="margin-top: 32px; padding: 32px; border-radius: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                <h3 class="neo-title" style="font-size: 20px; margin: 0; color: var(--text-primary)fff;">Aktivitas 7 Hari Terakhir</h3>
                <div style="font-size: 12px; font-weight: 600; color: #888; background: rgba(0,0,0,0.05); padding: 4px 12px; border-radius: 20px;">Intensitas Belajar</div>
            </div>
            
            <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 220px; gap: 16px; padding-top: 20px; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 12px;">
                @php $maxCount = collect($weeklyActivity)->max('count') ?: 1; @endphp
                @foreach($weeklyActivity as $day)
                    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 12px; height: 100%;">
                        <div style="position: relative; width: 100%; height: 100%; display: flex; align-items: flex-end; justify-content: center; background: rgba(0,0,0,0.02); border-radius: 12px; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.background='rgba(0,0,0,0.05)';" onmouseout="this.style.background='rgba(0,0,0,0.02)';">
                            @php $heightPct = ($day['count'] / $maxCount) * 100; @endphp
                            <div style="width: 100%; max-width: 48px; height: {{ $heightPct }}%; background: linear-gradient(to top, #121212, #3a3a3a); border-radius: 12px; transition: height 1s ease-out; position: relative;" title="{{ $day['count'] }} Aktivitas">
                                @if($day['count'] > 0)
                                    <div style="position: absolute; top: -28px; left: 50%; transform: translateX(-50%); font-size: 12px; font-weight: 800; color: var(--text-primary)fff; background: var(--text-primary); padding: 2px 8px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                        {{ $day['count'] }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div style="font-size: 13px; font-weight: 700; color: #555; text-transform: uppercase;">{{ $day['day'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@php
    $completedDaily = $dailyMissions->where('completed', true)->count();
    $totalDaily = $dailyMissions->count();
    $completedWeekly = $weeklyMissions->where('completed', true)->count();
    $totalWeekly = $weeklyMissions->count();
@endphp

<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: #121212;">Misi & Tantangan</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Selesaikan misi untuk mendapatkan bonus EXP tambahan.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-target-lock' style="font-size: 28px; color: #ef4444;"></i>
            </div>
        </div>

        <!-- Daily Missions -->
        <div style="margin-bottom: 40px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b, #f97316); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(245,158,11,0.25);">
                    <i class='bx bx-sun' style="color: #fff; font-size: 20px;"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #121212; letter-spacing: -0.2px;">Misi Harian</h3>
                    <p style="margin: 0; font-size: 12px; font-weight: 600; color: #888;">{{ now()->translatedFormat('l, d M Y') }} &bull; <span style="color: #f59e0b;">{{ $completedDaily }}/{{ $totalDaily }} selesai</span></p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
                @forelse($dailyMissions as $um)
                    @php
                        $m = $um->mission;
                        $pct = $m->target > 0 ? min(100, round(($um->progress / $m->target) * 100)) : 0;
                        $isDone = $um->completed;
                        $isClaimed = $um->claimed;
                    @endphp
                    <div class="neo-card neo-card-light mission-card" style="padding: 24px; border-radius: 20px; display: flex; align-items: center; gap: 16px; {{ $isClaimed ? 'opacity: 0.6; background: rgba(0,0,0,0.02);' : 'box-shadow: 0 8px 24px rgba(0,0,0,0.04);' }}">
                        <!-- Icon -->
                        <div style="width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                            {{ $isDone ? 'background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 6px 12px rgba(16,185,129,0.2);' : 'background: rgba(0,0,0,0.05);' }}">
                            <i class='bx {{ $isDone ? 'bx-check' : $m->icon }}' style="font-size: 24px; {{ $isDone ? 'color: #fff;' : 'color: #555;' }}"></i>
                        </div>

                        <!-- Info -->
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #121212;">{{ $m->title }}</h4>
                                <span style="font-size: 10px; font-weight: 700; color: #f59e0b; background: rgba(245, 158, 11, 0.1); padding: 2px 8px; border-radius: 6px; white-space: nowrap;">+{{ $m->exp_reward }} EXP</span>
                            </div>
                            <p style="margin: 0 0 12px 0; font-size: 13px; color: #666; line-height: 1.4;">{{ $m->description }}</p>

                            <!-- Progress Bar -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; height: 6px; background: rgba(0,0,0,0.06); border-radius: 3px; overflow: hidden;">
                                    <div style="height: 100%; width: {{ $pct }}%; background: {{ $isDone ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #f59e0b, #f97316)' }}; border-radius: 3px; transition: width 0.5s cubic-bezier(0.16, 1, 0.3, 1);"></div>
                                </div>
                                <span style="font-size: 11px; font-weight: 800; color: {{ $isDone ? '#10b981' : '#888' }}; white-space: nowrap;">{{ $um->progress }}/{{ $m->target }}</span>
                            </div>
                        </div>

                        <!-- Claim Button -->
                        <div style="flex-shrink: 0; align-self: flex-start;">
                            @if($isClaimed)
                                <button disabled style="padding: 8px 16px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); background: transparent; color: #aaa; font-size: 12px; font-weight: 700; cursor: not-allowed; display: flex; align-items: center; gap: 4px;">
                                    <i class='bx bx-check'></i> Diklaim
                                </button>
                            @elseif($isDone)
                                <button class="mission-claim-btn" data-url="{{ route('user.mission.claim', $um->id) }}" style="padding: 10px 20px; border-radius: 12px; border: none; background: linear-gradient(135deg, #10b981, #059669); color: #fff; font-size: 12px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); transition: all 0.2s;">
                                    <i class='bx bx-gift' style="font-size: 16px;"></i> Klaim
                                </button>
                            @else
                                <div style="padding: 8px 16px; border-radius: 12px; background: rgba(0,0,0,0.03); color: #888; font-size: 12px; font-weight: 700;">
                                    {{ $pct }}%
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="neo-card neo-card-light" style="text-align: center; padding: 40px 20px; border-radius: 20px; grid-column: 1 / -1;">
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <i class='bx bx-target-lock' style="font-size: 32px; color: #ccc;"></i>
                        </div>
                        <p style="color: #888; font-weight: 600; margin: 0; font-size: 14px;">Belum ada misi harian tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Weekly Missions -->
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(139,92,246,0.25);">
                    <i class='bx bx-calendar-star' style="color: #fff; font-size: 20px;"></i>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #121212; letter-spacing: -0.2px;">Misi Mingguan</h3>
                    <p style="margin: 0; font-size: 12px; font-weight: 600; color: #888;"><span style="color: #8b5cf6;">{{ $completedWeekly }}/{{ $totalWeekly }} selesai</span></p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
                @forelse($weeklyMissions as $um)
                    @php
                        $m = $um->mission;
                        $pct = $m->target > 0 ? min(100, round(($um->progress / $m->target) * 100)) : 0;
                        $isDone = $um->completed;
                        $isClaimed = $um->claimed;
                    @endphp
                    <div class="neo-card neo-card-light mission-card" style="padding: 24px; border-radius: 20px; display: flex; align-items: center; gap: 16px; {{ $isClaimed ? 'opacity: 0.6; background: rgba(0,0,0,0.02);' : 'box-shadow: 0 8px 24px rgba(0,0,0,0.04);' }}">
                        <div style="width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
                            {{ $isDone ? 'background: linear-gradient(135deg, #8b5cf6, #7c3aed); box-shadow: 0 6px 12px rgba(139,92,246,0.2);' : 'background: rgba(0,0,0,0.05);' }}">
                            <i class='bx {{ $isDone ? 'bx-check' : $m->icon }}' style="font-size: 24px; {{ $isDone ? 'color: #fff;' : 'color: #555;' }}"></i>
                        </div>

                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #121212;">{{ $m->title }}</h4>
                                <span style="font-size: 10px; font-weight: 700; color: #8b5cf6; background: rgba(139, 92, 246, 0.1); padding: 2px 8px; border-radius: 6px; white-space: nowrap;">+{{ $m->exp_reward }} EXP</span>
                            </div>
                            <p style="margin: 0 0 12px 0; font-size: 13px; color: #666; line-height: 1.4;">{{ $m->description }}</p>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; height: 6px; background: rgba(0,0,0,0.06); border-radius: 3px; overflow: hidden;">
                                    <div style="height: 100%; width: {{ $pct }}%; background: {{ $isDone ? 'linear-gradient(135deg, #8b5cf6, #7c3aed)' : 'linear-gradient(135deg, #8b5cf6, #a78bfa)' }}; border-radius: 3px; transition: width 0.5s cubic-bezier(0.16, 1, 0.3, 1);"></div>
                                </div>
                                <span style="font-size: 11px; font-weight: 800; color: {{ $isDone ? '#8b5cf6' : '#888' }}; white-space: nowrap;">{{ $um->progress }}/{{ $m->target }}</span>
                            </div>
                        </div>

                        <div style="flex-shrink: 0; align-self: flex-start;">
                            @if($isClaimed)
                                <button disabled style="padding: 8px 16px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); background: transparent; color: #aaa; font-size: 12px; font-weight: 700; cursor: not-allowed; display: flex; align-items: center; gap: 4px;">
                                    <i class='bx bx-check'></i> Diklaim
                                </button>
                            @elseif($isDone)
                                <button class="mission-claim-btn" data-url="{{ route('user.mission.claim', $um->id) }}" style="padding: 10px 20px; border-radius: 12px; border: none; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: #fff; font-size: 12px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); transition: all 0.2s;">
                                    <i class='bx bx-gift' style="font-size: 16px;"></i> Klaim
                                </button>
                            @else
                                <div style="padding: 8px 16px; border-radius: 12px; background: rgba(0,0,0,0.03); color: #888; font-size: 12px; font-weight: 700;">
                                    {{ $pct }}%
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="neo-card neo-card-light" style="text-align: center; padding: 40px 20px; border-radius: 20px; grid-column: 1 / -1;">
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(0,0,0,0.03); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <i class='bx bx-calendar-star' style="font-size: 32px; color: #ccc;"></i>
                        </div>
                        <p style="color: #888; font-weight: 600; margin: 0; font-size: 14px;">Belum ada misi mingguan tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
    .mission-card { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); border: 1px solid rgba(0,0,0,0.02); }
    .mission-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.08) !important; border-color: rgba(0,0,0,0.05); }
    .mission-claim-btn:hover { transform: scale(1.05) translateY(-2px); filter: brightness(1.1); box-shadow: 0 6px 16px rgba(0,0,0,0.15) !important; }

    @media (max-width: 768px) {
        .mission-card { padding: 16px !important; gap: 12px !important; align-items: flex-start !important; flex-direction: column; }
        .mission-card > div:last-child { align-self: flex-end; width: 100%; display: flex; justify-content: flex-end; }
    }
</style>

<script>
(function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('.mission-claim-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const url = this.dataset.url;
            this.disabled = true;
            this.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i> Mengklaim...`;

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                });
                const data = await res.json();

                if (res.ok && data.success) {
                    this.innerHTML = `<i class='bx bx-check'></i> Diklaim`;
                    this.style.background = 'transparent';
                    this.style.color = '#aaa';
                    this.style.border = '1px solid rgba(0,0,0,0.05)';
                    this.style.boxShadow = 'none';
                    this.style.cursor = 'not-allowed';

                    const card = this.closest('.mission-card');
                    if (card) {
                        card.style.opacity = '0.6';
                        card.style.background = 'rgba(0,0,0,0.02)';
                    }

                    if (window.showFriendToast) window.showFriendToast(data.message, 'success');
                } else {
                    this.innerHTML = `<i class='bx bx-gift'></i> Klaim`;
                    this.disabled = false;
                    if (window.showFriendToast) window.showFriendToast(data.message || 'Gagal mengklaim.', 'error');
                }
            } catch (err) {
                this.innerHTML = `<i class='bx bx-gift'></i> Klaim`;
                this.disabled = false;
                if (window.showFriendToast) window.showFriendToast('Terjadi kesalahan koneksi.', 'error');
            }
        });
    });
})();
</script>

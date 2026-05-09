<div class="nothing-widget-board" style="position: relative; z-index: 2;">
    <!-- Top Grid: Time, EXP, Streak -->
    <div class="nw-grid">
        <div class="nw-cell nw-span-2-col nw-span-2-row" style="display:flex;">
            @include('spa.fragments.user-timeCard')
        </div>
        <div class="nw-cell nw-span-1-col nw-span-2-row">
            @include('spa.fragments.user-expCard')
        </div>
        
        @if(isset($streakData))
        <div class="nw-cell nw-span-1-col nw-span-2-row nw-widget-streak" style="padding: 24px; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; border: 2px dashed var(--border-color); display: flex; align-items: center; justify-content: center;">
                        <i class='bx bxs-hot' style="font-size: 24px; color: {{ $streakData['is_active_today'] ? '#ea1515' : 'var(--text-muted)' }};"></i>
                    </div>
                    @if($streakData['streak_shields'] > 0)
                        <div style="background: var(--text-primary); color: var(--bg-primary); padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 800;" title="Streak Shield Active">
                            SHIELD: {{ $streakData['streak_shields'] }}
                        </div>
                    @endif
                </div>
                <div style="margin-top: 24px;">
                    <div style="font-family: 'Space Mono', monospace; font-size: 48px; font-weight: 700; color: var(--text-primary); line-height: 1;">
                        {{ $streakData['current_streak'] }}
                    </div>
                    <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-top: 4px;">HARI BERUNTUN</div>
                </div>
            </div>
            <div style="padding-top: 16px; border-top: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; color: var(--text-muted);">
                    <span>BEST: {{ $streakData['longest_streak'] }}</span>
                    <span>{{ $streakData['is_active_today'] ? 'ACTIVE' : 'ACTION REQ' }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Middle Grid: Progress, Missions -->
    <div class="nw-grid" style="margin-top: 16px;">
        <div class="nw-cell nw-span-2-col">
            @include('spa.fragments.user-progres', ['materis' => $materis, 'selectedMainMateri' => $selectedMainMateri])
        </div>

        @if(isset($todayMissions) && $todayMissions->count() > 0)
        <div class="nw-cell nw-span-2-col nw-widget-missions" style="padding: 24px; display: flex; flex-direction: column;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--text-muted);">DAILY MISSIONS</div>
                <a href="#" data-spa-page="missions" class="link-spa" style="font-size: 10px; font-family: 'Space Mono', monospace; text-transform: uppercase; color: var(--text-primary); text-decoration: none; border: 1px solid var(--border-color); padding: 4px 8px; border-radius: 4px;">ALL <i class='bx bx-right-arrow-alt'></i></a>
            </div>
            <div style="display: flex; flex-direction: column; gap: 12px; flex: 1; justify-content: center;">
                @foreach($todayMissions->take(3) as $um)
                    @php
                        $m = $um->mission;
                        $pct = $m->target > 0 ? min(100, round(($um->progress / $m->target) * 100)) : 0;
                    @endphp
                    <div style="display: flex; align-items: center; gap: 12px; {{ $um->completed ? 'opacity: 0.5;' : '' }}">
                        <div style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid {{ $um->completed ? 'var(--text-primary)' : 'var(--border-color)' }}; background: {{ $um->completed ? 'var(--text-primary)' : 'transparent' }}; display: flex; align-items: center; justify-content: center;">
                            @if($um->completed) <i class='bx bx-check' style="color: var(--bg-primary); font-size: 14px;"></i> @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="font-family: 'Space Mono', monospace; font-size: 12px; text-transform: uppercase; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; {{ $um->completed ? 'text-decoration: line-through;' : '' }}">{{ $m->title }}</div>
                            <div style="height: 2px; background: var(--border-color); margin-top: 6px; width: 100%;">
                                <div style="height: 100%; width: {{ $pct }}%; background: #ea1515;"></div>
                            </div>
                        </div>
                        <div style="font-size: 10px; font-weight: 700; color: #ea1515;">+{{ $m->exp_reward }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @if(isset($activeEvent))
    <!-- Active Event Box (Nothing OS 2.0 style) -->
    <div class="nw-cell" style="margin-top: 16px; padding: 24px; background: rgba(234, 21, 21, 0.05); border-color: rgba(234, 21, 21, 0.2); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <i class='bx bxs-zap' style="font-size: 32px; color: #ea1515;"></i>
            <div>
                <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #ea1515; margin-bottom: 4px;">ACTIVE EVENT</div>
                <h3 style="margin: 0; font-size: 20px; font-weight: 800; color: var(--text-primary);">{{ $activeEvent->title }}</h3>
                <p style="margin: 4px 0 0; font-size: 12px; color: var(--text-muted);">{{ $activeEvent->description }}</p>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 16px; text-align: right;">
            <div>
                <div style="font-family: 'Space Mono', monospace; font-size: 24px; color: #ea1515;">x{{ $activeEvent->multiplier }}</div>
                <div style="font-size: 8px; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);">MULTIPLIER</div>
            </div>
            <div style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; writing-mode: vertical-rl; transform: scale(-1);">ENDS {{ \Carbon\Carbon::parse($activeEvent->end_time)->translatedFormat('d M H:i') }}</div>
        </div>
    </div>
    @endif

    <!-- Materi Section -->
    <div class="nw-materi-section" style="margin-top: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h3 style="font-family: 'Space Mono', monospace; font-size: 24px; color: var(--text-primary); margin: 0; text-transform: uppercase;">MATERI BELAJAR</h3>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px; text-transform: uppercase; letter-spacing: 1px;">JALUR: {{ $selectedMainMateri->title ?? 'BELUM DIPILIH' }} // PROGRESS: {{ $overallProgress }}%</div>
            </div>
            <a href="?page=select-main-materi" class="link-spa" data-spa-page="select-main-materi" style="font-size: 10px; font-family: 'Space Mono', monospace; color: var(--text-primary); border: 1px solid var(--border-color); padding: 8px 16px; border-radius: 8px; text-decoration: none; text-transform: uppercase;">
                GANTI JALUR
            </a>
        </div>

        <div style="height: 2px; background: var(--border-color); width: 100%; margin-bottom: 24px;">
            <div style="height: 100%; width: {{ $overallProgress }}%; background: var(--text-primary);"></div>
        </div>

        @if(isset($materis) && $materis->count())
        <div class="nw-grid">
            @foreach($materis as $materi)
            <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa nw-cell" data-page="submateri&materi_id={{ $materi->id }}" style="padding: 24px; text-decoration: none; display: flex; flex-direction: column; justify-content: space-between; min-height: 180px;">
                <div>
                    <h4 style="font-family: 'Space Mono', monospace; font-size: 16px; color: var(--text-primary); margin: 0 0 12px 0; text-transform: uppercase;">{{ $materi->title }}</h4>
                    <div style="font-size: 12px; color: var(--text-muted);">{{ $materi->progress_done }}/{{ $materi->progress_total }} SUB SELESAI</div>
                </div>
                <div style="margin-top: 24px;">
                    <div style="display: flex; justify-content: space-between; font-size: 10px; color: var(--text-primary); margin-bottom: 8px; font-family: 'Space Mono', monospace;">
                        <span>PROGRESS</span>
                        <span style="color: {{ $materi->is_completed ? '#10b981' : 'var(--text-primary)' }}">{{ $materi->is_completed ? 'DONE' : $materi->progress_percent.'%' }}</span>
                    </div>
                    <div style="height: 2px; background: var(--border-color); width: 100%;">
                        <div style="height: 100%; width: {{ $materi->progress_percent }}%; background: {{ $materi->is_completed ? '#10b981' : 'var(--text-primary)' }};"></div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Recommendations -->
    @if(isset($recommendedMateris) && $recommendedMateris->count() > 0)
    <div style="margin-top: 32px;">
        <h3 style="font-family: 'Space Mono', monospace; font-size: 16px; color: var(--text-primary); margin: 0 0 16px 0; text-transform: uppercase;">RECOMMENDATIONS</h3>
        <div class="nw-grid">
            @foreach($recommendedMateris as $rec)
            <a href="?page=detail&submateri_id={{ $rec->id }}" class="link-spa nw-cell" data-page="detail&submateri_id={{ $rec->id }}" style="padding: 16px; text-decoration: none; min-height: 120px; display: flex; flex-direction: column; justify-content: center;">
                <div style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">{{ $rec->materi->title ?? 'MATERI' }}</div>
                <h4 style="font-family: 'Space Mono', monospace; font-size: 14px; color: var(--text-primary); margin: 0 0 4px 0; text-transform: uppercase;">{{ $rec->title }}</h4>
                <div style="font-size: 10px; color: #555; text-transform: uppercase;">{{ $rec->subtitle ?? 'BELUM DIBACA' }}</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- The rest of the sections -->
    <div style="margin-top: 48px;">@include('spa.fragments.user-journeyTimeline')</div>
    <div style="margin-top: 48px;">@include('spa.fragments.user-tierList')</div>
    <div style="margin-top: 48px;">@include('spa.fragments.user-seasonTimer')</div>
    <div style="margin-top: 48px;">@include('spa.fragments.user-leaderboard')</div>

</div>

<style>
/* Nothing OS Widget Grid CSS */
.nothing-widget-board { padding: 32px 16px; max-width: 1400px; margin: 0 auto; }
.nw-grid { display: grid; grid-template-columns: repeat(4, 1fr); grid-auto-rows: minmax(180px, auto); gap: 16px; }
.nw-cell { background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 16px; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); position: relative; overflow: hidden; transition: transform 0.2s; }
.nw-cell:hover { transform: translateY(-4px); border-color: var(--border-color); }
.nw-span-2-col { grid-column: span 2; }
.nw-span-3-col { grid-column: span 3; }
.nw-span-4-col { grid-column: span 4; }
.nw-span-2-row { grid-row: span 2; }

@media (max-width: 992px) {
    .nw-grid { grid-template-columns: repeat(2, 1fr); }
    .nw-span-2-col, .nw-span-3-col, .nw-span-4-col { grid-column: span 2; }
}
@media (max-width: 576px) {
    .nw-grid { grid-template-columns: 1fr; }
    .nw-span-2-col, .nw-span-3-col, .nw-span-4-col { grid-column: span 1; }
    .nw-span-2-row { grid-row: span 1; min-height: auto; }
}
</style>

<script>
    (function () {
        if (window._expPingInterval) clearInterval(window._expPingInterval);
        window._expPingInterval = setInterval(() => {
            if (typeof axios !== 'undefined') {
                axios.post('/app/api/exp/ping').then(res => {
                    if (res.data.success) {
                        const expSpan = document.getElementById('current-exp-amount');
                        if (expSpan) {
                            expSpan.textContent = Number(res.data.exp).toLocaleString();
                            const expNeededSpan = document.getElementById('exp-needed');
                            if (expNeededSpan) {
                                let needed = parseInt(expNeededSpan.textContent.replace(/,/g, '')) - 10;
                                if (needed <= 0) window.location.reload();
                                else expNeededSpan.textContent = Number(needed).toLocaleString();
                            }
                        }
                    }
                }).catch(err => {});
            }
        }, 60000);
    })();
</script>
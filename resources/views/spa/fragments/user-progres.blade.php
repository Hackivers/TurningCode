@php
    $hasProgress = $materis->contains(fn($m) => $m->progress_percent > 0);
    $activeMateris = $materis->filter(fn($m) => $m->progress_percent > 0)->take(2);
@endphp

<div style="padding: 24px; height: 100%; display: flex; flex-direction: column;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div style="font-size: 18px; font-weight: 600; color: var(--text-primary);">
            Progres Terakhir
        </div>
        <div class="md-icon-container" style="width: 32px; height: 32px; background: var(--bg-tertiary); color: var(--accent-primary); border-radius: 50%;">
            <i class='bx bx-history' style="font-size: 18px;"></i>
        </div>
    </div>

    @if ($hasProgress && $activeMateris->count())
        <div style="display: flex; flex-direction: column; gap: 16px; flex: 1;">
            @foreach ($activeMateris as $mat)
                <a href="?page=submateri&materi_id={{ $mat->id }}" class="link-spa md-card-interactive"
                    style="display: flex; flex-direction: column; justify-content: space-between; background: var(--bg-tertiary); border-radius: 20px; padding: 20px; text-decoration: none; position: relative; overflow: hidden;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                        <h4 style="font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 600; color: var(--text-primary); margin: 0; max-width: 85%; line-height: 1.3;">
                            {{ $mat->title }}
                        </h4>
                        <i class='bx bx-play-circle' style="color: var(--accent-primary); font-size: 24px;"></i>
                    </div>

                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="width: 56px; height: 56px; border-radius: 16px; background: var(--bg-primary); display: flex; align-items: center; justify-content: center; position: relative; flex-shrink: 0; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                            <span style="font-family: 'Outfit', sans-serif; font-size: 16px; font-weight: 700; color: {{ $mat->is_completed ? '#10b981' : 'var(--accent-primary)' }};">
                                {{ $mat->progress_percent }}%
                            </span>
                        </div>

                        <div style="flex: 1;">
                            <div style="font-size: 12px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px;">
                                {{ $mat->progress_done }} dari {{ $mat->progress_total }} Sub-materi
                            </div>
                            <div class="md-progress-bar-bg" style="height: 6px;">
                                <div class="md-progress-bar-fill" style="width: {{ $mat->progress_percent }}%; background: {{ $mat->is_completed ? '#10b981' : 'var(--accent-primary)' }};"></div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <a href="?page=materi&main_id={{ $selectedMainMateri->id ?? '' }}" class="link-spa md-card-interactive"
            style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; background: var(--bg-tertiary); border-radius: 20px; text-decoration: none; padding: 32px; text-align: center;">
            <div class="md-icon-container" style="background: var(--bg-primary); color: var(--accent-primary); width: 64px; height: 64px; margin-bottom: 16px; border-radius: 24px;">
                <i class='bx bx-rocket' style="font-size: 32px;"></i>
            </div>
            <div style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">
                Mulai Perjalananmu
            </div>
            <div style="font-size: 13px; font-weight: 500; color: var(--text-muted); max-width: 80%;">
                Pilih materi pertamamu dan tingkatkan keahlian coding-mu.
            </div>
        </a>
    @endif
</div>
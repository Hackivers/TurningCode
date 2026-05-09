@php
    $hasProgress = $materis->contains(fn($m) => $m->progress_percent > 0);
    $activeMateris = $materis->filter(fn($m) => $m->progress_percent > 0)->take(2);
@endphp

<div style="padding: 24px; height: 100%; display: flex; flex-direction: column;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--text-muted);">RECENT PROGRESS</div>
        <div style="width: 8px; height: 8px; border-radius: 50%; background: #ea1515;"></div>
    </div>

    @if ($hasProgress && $activeMateris->count())
        <div style="display: flex; flex-direction: column; gap: 16px; flex: 1;">
            @foreach ($activeMateris as $mat)
                <a href="?page=submateri&materi_id={{ $mat->id }}" class="link-spa" style="display: flex; flex-direction: column; justify-content: space-between; border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; text-decoration: none; background: var(--bg-secondary); transition: all 0.2s;" onmouseover="this.style.background='var(--bg-tertiary)'; this.style.borderColor='var(--border-color)';" onmouseout="this.style.background='var(--bg-secondary)'; this.style.borderColor='var(--border-color)';">
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
                        <h4 style="font-family: 'Space Mono', monospace; font-size: 14px; color: var(--text-primary); margin: 0; text-transform: uppercase; max-width: 80%;">{{ $mat->title }}</h4>
                        <i class='bx bx-right-top-arrow-circle' style="color: var(--text-muted); font-size: 20px;"></i>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <!-- Circular Progress -->
                        <div style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid {{ $mat->is_completed ? '#10b981' : 'var(--border-color)' }}; display: flex; align-items: center; justify-content: center; position: relative; flex-shrink: 0;">
                            <span style="font-family: 'Space Mono', monospace; font-size: 14px; font-weight: 700; color: {{ $mat->is_completed ? '#10b981' : '#fff' }};">{{ $mat->progress_percent }}%</span>
                        </div>
                        
                        <div style="flex: 1;">
                            <div style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 6px;">{{ $mat->progress_done }}/{{ $mat->progress_total }} SUB MATERI</div>
                            <div style="height: 2px; background: var(--border-color); width: 100%;">
                                <div style="height: 100%; width: {{ $mat->progress_percent }}%; background: {{ $mat->is_completed ? '#10b981' : '#fff' }};"></div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <a href="?page=materi&main_id={{ $selectedMainMateri->id ?? '' }}" class="link-spa" style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 1px dashed var(--border-color); border-radius: 12px; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='var(--bg-secondary)';" onmouseout="this.style.background='transparent';">
            <i class='bx bx-rocket' style="font-size: 32px; color: var(--text-muted); margin-bottom: 12px;"></i>
            <div style="font-family: 'Space Mono', monospace; font-size: 14px; color: var(--text-primary); text-transform: uppercase;">MULAI PERJALANANMU</div>
            <div style="font-size: 10px; color: var(--text-muted); text-transform: uppercase; margin-top: 4px;">Pilih materi pertamamu</div>
        </a>
    @endif
</div>
<div style="margin-bottom: 32px;">
    <h3 class="neo-title" style="font-size: 28px; margin: 0 0 8px 0; color: var(--text-primary)fff;">Ruang Belajar</h3>
    <p style="font-size: 16px; color: #555; margin: 0;">Pilih jalur keahlian yang ingin kamu kuasai.</p>
</div>

@if (isset($data['mainMateri']) && $data['mainMateri']->count())
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
        @foreach ($data['mainMateri'] as $materi)
            <a href="{{ $materi->is_coming_soon ? '#' : '?page=materi&main_id='.$materi->id }}" 
               class="link-spa" 
               data-page="materi" 
               data-id="{{ $materi->id }}" 
               style="text-decoration: none; display: block; {{ $materi->is_coming_soon ? 'opacity: 0.6; cursor: not-allowed; filter: grayscale(100%);' : '' }}">
                
                <div class="materi-premium-card" style="background-image: url('{{ asset('assets/img/img00' . (($loop->iteration % 3) + 1) . 'non.jpg') }}');">
                    <div class="materi-overlay">
                        <div class="materi-content">
                            <div class="materi-header-row">
                                <h3 class="materi-title">{{ $materi->title }}</h3>
                                <div class="materi-badge-price">
                                    {{ $materi->progress_percent ?? 0 }}%
                                </div>
                            </div>
                            
                            <p class="materi-desc">
                                {{ \Illuminate\Support\Str::limit($materi->description ?? 'Modul pembelajaran interaktif terstruktur untuk membangun pondasi kuat di bidang pemrograman.', 80) }}
                            </p>
                            
                            <div class="materi-pills-row">
                                @if ($materi->is_coming_soon)
                                    <span class="materi-pill">Segera Hadir</span>
                                @endif
                                <span class="materi-pill">{{ $materi->total_materi ?? 0 }} Materi</span>
                                <span class="materi-pill">{{ $materi->total_submateri ?? 0 }} Bab</span>
                            </div>

                            <div class="materi-action-btn">
                                {{ $materi->is_coming_soon ? 'Segera Hadir' : ($materi->progress_percent > 0 ? 'Lanjutkan Belajar' : 'Mulai Sekarang') }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

<style>
/* Modern Premium Image Card Styling (Guest House Style) */
.materi-premium-card {
    position: relative;
    width: 100%;
    height: 460px;
    border-radius: 28px;
    background-size: cover;
    background-position: center;
    background-color: #2a2a2a;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.06); 
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s;
    isolation: isolate;
}

.materi-premium-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 45px rgba(0,0,0,0.12);
}

.materi-overlay {
    position: absolute;
    inset: 0;
    /* Soft gradient matching the picture */
    background: linear-gradient(to bottom, 
        rgba(20,20,20,0) 0%, 
        rgba(20,20,20,0.2) 35%, 
        rgba(20,20,20,0.85) 75%, 
        rgba(20,20,20,0.98) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 32px 24px 24px 24px;
}

.materi-content {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.materi-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center; 
    gap: 12px;
}

.materi-title {
    margin: 0;
    color: var(--text-primary)fff;
    font-size: 24px;
    font-weight: 700;
    font-family: 'Outfit', sans-serif;
    line-height: 1.25;
    flex: 1;
}

.materi-badge-price {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary)fff;
    /* subtle translucent background */
    background: var(--border-color);
    padding: 6px 12px;
    border-radius: 20px;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.materi-desc {
    margin: 0;
    color: #a1a1aa; 
    font-size: 14px;
    line-height: 1.5;
    font-family: 'Outfit', sans-serif;
}

.materi-pills-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 6px;
}

.materi-pill {
    background: rgba(255, 255, 255, 0.12);
    color: #e4e4e7;
    font-size: 12px;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 20px;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
}

.materi-action-btn {
    width: 100%;
    background: var(--text-primary)fff;
    color: var(--text-primary)fff;
    font-size: 15px;
    font-weight: 600;
    text-align: center;
    padding: 16px 0;
    border-radius: 22px; /* Very rounded button */
    margin-top: 4px;
    transition: background 0.3s, transform 0.2s;
    font-family: 'Outfit', sans-serif;
}

.link-spa:hover .materi-action-btn {
    background: #f4f4f5;
    transform: scale(0.98);
}

/* ═══ MOBILE RESPONSIVENESS ═══ */
@media (max-width: 768px) {
    /* Give grid wrapper margin left and right */
    div[style*="grid-template-columns: repeat"] {
        margin: 0 10px !important;
        gap: 16px !important;
    }
    
    .materi-premium-card {
        height: 240px; /* Compressed height */
        border-radius: 20px;
    }
    
    .materi-overlay {
        padding: 20px 16px 16px 16px;
    }
    
    .materi-content {
        gap: 8px;
    }
    
    .materi-title {
        font-size: 18px;
    }
    
    .materi-badge-price {
        padding: 4px 10px;
        font-size: 12px;
    }
    
    .materi-desc {
        font-size: 12px;
        line-height: 1.4;
    }
    
    .materi-pill {
        padding: 4px 10px;
        font-size: 10px;
    }
    
    .materi-action-btn {
        padding: 12px 0;
        font-size: 13px;
        border-radius: 16px;
    }
}
</style>
@else
    <div class="neo-card neo-card-light" style="text-align:center; padding: 80px 20px;">
        <i class='bx bx-folder-open' style="font-size: 56px; color: #888; margin-bottom: 16px;"></i>
        <h5 style="color: #444; font-size: 16px; font-weight: 500; margin: 0;">Belum ada materi ruang belajar yang tersedia.</h5>
    </div>
@endif
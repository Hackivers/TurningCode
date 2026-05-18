{{-- ═══════════════════════════════════════════════════════════════
SUB MATERI PAGE — Auth Index Nothing OS Design
═══════════════════════════════════════════════════════════════ --}}
@php $subMateris = $subMateris ?? []; @endphp

<div class="wlc-sub-page">
    {{-- Background elements --}}
    <div class="wlc-sub-bg"></div>
    <div class="wlc-sub-watermark">S(M)</div>
    <div class="wlc-lines" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>

    <div class="wlc-sub-container">
        
        {{-- Back Button --}}
        <a href="?page=materi&main_id={{ $firstMateri->main_materi_id ?? '' }}" class="link-spa wlc-back-btn" data-page="materi&main_id={{ $firstMateri->main_materi_id ?? '' }}">
            <i class='bx bx-chevron-left'></i> KEMBALI KE {{ strtoupper($firstMateri->mainMateri->title ?? 'MATERI') }}
        </a>

        {{-- Hero Section (Split Layout) --}}
        <div class="wlc-sub-hero">
            <div class="wlc-sub-hero-left">
                <div class="wlc-sparkle">✦</div>
                <div class="wlc-hero-badges">
                    <span class="wlc-hero-badge">{{ $firstMateri->mainMateri->title ?? 'MAIN' }}</span>
                    <span class="wlc-hero-badge red">{{ $firstMateri->title ?? 'BAB' }}</span>
                </div>
                <h1 class="wlc-hero-title">
                    <span class="serif">Materi</span><br>
                    Pembelajaran
                </h1>
                <p class="wlc-hero-desc">
                    Terdapat <strong>{{ count($subMateris) }} Sub Materi</strong> dalam bab ini. Kuasai setiap bagian secara berurutan untuk naik level.
                </p>
            </div>
            <div class="wlc-sub-hero-right">
                <div class="wlc-sub-mockup">
                    <div class="wlc-mockup-inner">
                        <div class="wlc-mockup-bar">
                            <div class="wlc-mockup-dots"><span></span><span></span><span></span></div>
                            <div class="wlc-mockup-url"><i class='bx bx-book-open'></i> module.viewer</div>
                        </div>
                        <div class="wlc-mockup-body">
                            <div class="wlc-mock-card-line w80"></div>
                            <div class="wlc-mock-card-line w50"></div>
                            <div class="wlc-mock-card-line w70" style="margin-top:20px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Divider --}}
        <div class="wlc-sub-divider">
            <i class='bx bx-code-alt'></i> TOPIK MATERI
        </div>

        {{-- Grid List --}}
        <div class="wlc-sub-grid">
            @foreach ($subMateris as $i => $subMateri)
                @php 
                    $isDone = in_array($subMateri->id, $completed ?? []); 
                    $qCount = $questionCounts[$subMateri->id] ?? 0;
                    
                    $sections = is_string($subMateri->sections_json) 
                                    ? json_decode($subMateri->sections_json, true) 
                                    : (is_array($subMateri->sections) ? $subMateri->sections : []);
                    if (!is_array($sections)) $sections = [];
                    
                    $babs = collect($sections)->where('type', 'bab')->values();
                    $totalBabs = count($babs);
                    $hasAccordion = $totalBabs > 0 || $qCount > 0;
                    
                    $statusIcon = $isDone ? 'bx-check-double' : 'bx-list-ul';
                @endphp
                
                <div class="wlc-card sub-card-item {{ $isDone ? 'done' : '' }}">
                    <div class="wlc-card-header">
                        <div class="wlc-card-num">
                            <i class='bx {{ $statusIcon }}'></i> {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="wlc-card-actions">
                            <i class="bx {{ in_array($subMateri->id, $arsipSub ?? []) ? 'bxs-star star-active' : 'bx-star' }} archive-btn wlc-fav-btn"
                                data-id="{{ $subMateri->id }}" data-type="sub"
                                title="{{ in_array($subMateri->id, $arsipSub ?? []) ? 'Hapus' : 'Favorit' }}"
                                onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorite(this);"></i>
                        </div>
                    </div>

                    <a href="?page=detail&submateri_id={{ $subMateri->id }}" class="link-spa wlc-card-title">
                        <h3>{{ $subMateri->title }}</h3>
                        <p>{{ $subMateri->subtitle ?? Str::limit(strip_tags($subMateri->content), 80) }}</p>
                    </a>

                    <div class="wlc-card-footer">
                        @if($hasAccordion)
                            <button class="wlc-btn-timeline" onclick="toggleBabList('sub-{{ $subMateri->id }}')">
                                URUTAN <i class='bx bx-chevron-down' id="icon-sub-{{ $subMateri->id }}"></i>
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($qCount > 0)
                            <span class="wlc-badge-quiz"><i class='bx bx-trophy'></i> {{ $qCount }}</span>
                        @endif
                    </div>

                    @if($hasAccordion)
                        <div id="bab-list-sub-{{ $subMateri->id }}" class="wlc-timeline" style="display:none;">
                            <div class="wlc-timeline-line"></div>
                            @php
                                $history = $histories->get($subMateri->id);
                                $completedBabs = $history && is_array($history->completed_babs) ? $history->completed_babs : [];
                            @endphp
                            
                            @foreach($babs as $bIndex => $bab)
                                @php
                                    $isBabUnlocked = $bIndex === 0;
                                    if ($bIndex > 0) {
                                        $prevBabId = $babs[$bIndex - 1]['order'] ?? '';
                                        $isBabUnlocked = in_array($prevBabId, $completedBabs);
                                    }
                                    if (in_array($bab['order'] ?? '', $completedBabs)) {
                                        $isBabUnlocked = true;
                                    }
                                    $babDone = in_array($bab['order'] ?? '', $completedBabs);
                                @endphp
                                
                                @if($isBabUnlocked)
                                    <a href="?page=detail&submateri_id={{ $subMateri->id }}&bab_id={{ $bab['order'] ?? '' }}" class="link-spa wlc-tl-item {{ $babDone ? 'done' : '' }}">
                                        <div class="wlc-tl-dot"></div>
                                        <div class="wlc-tl-content">
                                            <h4>{{ $bab['content'] ?? 'Bab ' . ($bIndex + 1) }}</h4>
                                        </div>
                                        <i class='bx bx-right-arrow-alt wlc-tl-arrow'></i>
                                    </a>
                                @else
                                    <div class="wlc-tl-item locked">
                                        <div class="wlc-tl-dot"></div>
                                        <div class="wlc-tl-content">
                                            <h4>{{ $bab['content'] ?? 'Bab ' . ($bIndex + 1) }} <span>LOCKED</span></h4>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if($qCount > 0)
                                @php
                                    $isQuizUnlocked = true;
                                    if ($totalBabs > 0) {
                                        $lastBabId = $babs[$totalBabs - 1]['order'] ?? '';
                                        $isQuizUnlocked = in_array($lastBabId, $completedBabs);
                                    }
                                @endphp
                                @if($isQuizUnlocked)
                                    <a href="?page=detail&submateri_id={{ $subMateri->id }}&auto_quiz=1" class="link-spa wlc-tl-item quiz">
                                        <div class="wlc-tl-dot"></div>
                                        <div class="wlc-tl-content">
                                            <h4>Quiz <span>{{ $qCount }} SOAL</span></h4>
                                        </div>
                                        <i class='bx bx-right-arrow-alt wlc-tl-arrow'></i>
                                    </a>
                                @else
                                    <div class="wlc-tl-item locked">
                                        <div class="wlc-tl-dot"></div>
                                        <div class="wlc-tl-content">
                                            <h4>Quiz <span>LOCKED</span></h4>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <br><br>

    </div>
</div>

<script>
    function toggleBabList(babId) {
        const list = document.getElementById('bab-list-' + babId);
        const icon = document.getElementById('icon-' + babId);
        
        if (list.style.display === 'none' || !list.style.display) {
            list.style.display = 'block';
            list.animate([
                { opacity: 0, transform: 'translateY(-10px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ], { duration: 300, easing: 'ease-out' });
            icon.style.transform = 'rotate(180deg)';
        } else {
            const animation = list.animate([
                { opacity: 1, transform: 'translateY(0)' },
                { opacity: 0, transform: 'translateY(-10px)' }
            ], { duration: 200, easing: 'ease-in' });
            
            animation.onfinish = () => { list.style.display = 'none'; };
            icon.style.transform = 'rotate(0deg)';
        }
    }

    window.__currentSearchHandler = function (query) {
        document.querySelectorAll('.sub-card-item').forEach(card => {
            const title = card.querySelector('.wlc-card-title h3')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.wlc-card-title p')?.textContent.toLowerCase() || '';
            if (title.includes(query) || desc.includes(query)) { card.style.display = 'flex'; }
            else { card.style.display = 'none'; }
        });
    };
</script>

<style>
    /* AUTH INDEX NOTHING OS STYLING FOR SUB MATERI */
    @import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap');

    .wlc-sub-page {
        position: relative;
        width: 100%;
        min-height: 100vh;
        background: var(--bg-secondary); /* Pure black */
        color: #ffffff;
        font-family: 'Inter', sans-serif;
        overflow: hidden;
        margin: -20px; /* Offset the container padding from dashboard */
        padding: 40px;
        z-index: 1;
    }

    /* Backgrounds */
    .wlc-sub-bg {
        position: absolute;
        inset: -20%;
        width: 140%;
        height: 140%;
        background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 30px 30px;
        z-index: 0;
        pointer-events: none;
    }
    .wlc-sub-watermark {
        position: absolute;
        top: 5%;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-size: 25vw;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.02);
        letter-spacing: -0.05em;
        pointer-events: none;
        user-select: none;
        z-index: 0;
    }
    .wlc-lines {
        position: absolute;
        inset: 0;
        display: flex;
        justify-content: space-between;
        padding: 0 10%;
        pointer-events: none;
        z-index: 0;
    }
    .wlc-lines span {
        width: 1px;
        height: 100%;
        background: linear-gradient(180deg, transparent 0%, rgba(255, 255, 255, 0.04) 20%, rgba(255, 255, 255, 0.04) 80%, transparent 100%);
    }

    .wlc-sub-container {
        position: relative;
        z-index: 2;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Back Button */
    .wlc-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #a1a1aa;
        text-decoration: none;
        padding: 8px 16px;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 9999px;
        margin-bottom: 32px;
        transition: all 0.2s;
        background: rgba(255,255,255,0.02);
    }
    .wlc-back-btn:hover {
        background: rgba(255,255,255,0.06);
        color: #ffffff;
        border-color: rgba(255,255,255,0.2);
    }

    /* Hero Section */
    .wlc-sub-hero {
        display: flex;
        align-items: center;
        gap: 48px;
        margin-bottom: 60px;
    }
    .wlc-sub-hero-left {
        flex: 1;
    }
    .wlc-sparkle {
        font-size: 18px;
        color: #ffffff;
        margin-bottom: 24px;
        animation: wlcSparkle 3s ease-in-out infinite;
    }
    @keyframes wlcSparkle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .wlc-hero-badges {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;
    }
    .wlc-hero-badge {
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 10px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 6px;
        color: #a1a1aa;
    }
    .wlc-hero-badge.red {
        background: rgba(234,21,21,0.1);
        border-color: rgba(234,21,21,0.3);
        color: var(--accent-primary);
    }
    .wlc-hero-title {
        font-family: 'Inter', sans-serif;
        font-size: clamp(32px, 5vw, 52px);
        font-weight: 700;
        line-height: 1.1;
        letter-spacing: -2px;
        margin: 0 0 16px;
        text-transform: uppercase;
    }
    .wlc-hero-title .serif {
        font-family: 'Instrument Serif', serif;
        font-style: italic;
        font-weight: 400;
        color: var(--accent-primary);
        text-transform: none;
    }
    .wlc-hero-desc {
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        color: #a1a1aa;
        line-height: 1.6;
        max-width: 440px;
    }
    .wlc-hero-desc strong { color: #ffffff; font-weight: 700; }
    
    .wlc-sub-hero-right {
        flex: 0 0 320px;
        perspective: 1000px;
    }
    .wlc-mockup-inner {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        overflow: hidden;
        transform: rotateY(-5deg) rotateX(2deg);
        transition: transform 0.5s;
    }
    .wlc-mockup-inner:hover { transform: rotateY(0) rotateX(0); }
    .wlc-mockup-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: rgba(255,255,255,0.03);
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .wlc-mockup-dots { display: flex; gap: 6px; }
    .wlc-mockup-dots span { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.2); }
    .wlc-mockup-dots span:nth-child(1) { background: var(--accent-primary); }
    .wlc-mockup-url {
        flex: 1;
        background: rgba(255,255,255,0.04);
        padding: 4px 10px;
        border-radius: 6px;
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        color: #a1a1aa;
        display: flex; align-items: center; gap: 6px;
        justify-content: center;
    }
    .wlc-mockup-body { padding: 24px; min-height: 120px; }
    .wlc-mock-card-line {
        height: 6px; border-radius: 3px; background: rgba(255,255,255,0.1); margin-bottom: 10px;
    }
    .wlc-mock-card-line.w80 { width: 80%; }
    .wlc-mock-card-line.w50 { width: 50%; }
    .wlc-mock-card-line.w70 { width: 70%; }

    /* Divider */
    .wlc-sub-divider {
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #a1a1aa;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .wlc-sub-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255,255,255,0.1);
    }

    /* List Layout */
    .wlc-sub-grid {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Card */
    .wlc-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    .wlc-card:hover {
        background: rgba(255,255,255,0.04);
        border-color: rgba(255,255,255,0.15);
        transform: translateY(-4px);
    }
    .wlc-card.done {
        border-color: rgba(166, 227, 161, 0.2);
    }
    
    .wlc-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    .wlc-card-num {
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #a1a1aa;
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.05);
        padding: 4px 10px;
        border-radius: 6px;
    }
    .wlc-card.done .wlc-card-num {
        color: #a6e3a1;
        background: rgba(166, 227, 161, 0.1);
    }
    .wlc-fav-btn {
        font-size: 18px;
        color: #a1a1aa;
        cursor: pointer;
        transition: 0.2s;
    }
    .wlc-fav-btn:hover { color: #ffffff; transform: scale(1.1); }
    .wlc-fav-btn.star-active { color: #f59e0b; }

    .wlc-card-title {
        text-decoration: none;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 24px;
    }
    .wlc-card-title h3 {
        font-family: 'Inter', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
        line-height: 1.3;
        letter-spacing: -0.5px;
    }
    .wlc-card-title p {
        font-family: 'Outfit', sans-serif;
        font-size: 12px;
        color: #a1a1aa;
        margin: 0;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .wlc-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    .wlc-btn-timeline {
        background: transparent;
        border: 1px solid rgba(255,255,255,0.1);
        color: #a1a1aa;
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: 0.2s;
    }
    .wlc-btn-timeline:hover {
        background: rgba(255,255,255,0.1);
        color: #ffffff;
    }
    .wlc-badge-quiz {
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        font-weight: 700;
        color: #f59e0b;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Timeline */
    .wlc-timeline {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px dashed rgba(255,255,255,0.1);
        position: relative;
        padding-left: 8px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .wlc-timeline-line {
        position: absolute;
        left: 17px;
        top: 28px;
        bottom: 28px;
        width: 2px;
        background: rgba(255,255,255,0.1);
        z-index: 1;
    }
    .wlc-tl-item {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 2;
        text-decoration: none;
        padding: 4px;
        transition: 0.2s;
        border-radius: 6px;
    }
    .wlc-tl-item:hover:not(.locked) {
        background: rgba(255,255,255,0.05);
        transform: translateX(4px);
    }
    .wlc-tl-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--bg-secondary);
        border: 2px solid rgba(255,255,255,0.2);
        box-shadow: 0 0 0 4px var(--bg-secondary);
        z-index: 2;
    }
    .wlc-tl-item.done .wlc-tl-dot { border-color: #a6e3a1; background: #a6e3a1; }
    .wlc-tl-item.quiz .wlc-tl-dot { border-color: #f59e0b; }
    .wlc-tl-item.locked .wlc-tl-dot { border-color: rgba(255,255,255,0.1); }
    
    .wlc-tl-content { flex: 1; }
    .wlc-tl-content h4 {
        margin: 0;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 500;
        color: #eeeeee;
    }
    .wlc-tl-content span { font-family: 'Outfit', sans-serif; font-size: 11px; color: #a1a1aa; font-weight: 700; margin-left: 6px; }
    .wlc-tl-item.locked .wlc-tl-content h4 { color: #a1a1aa; }
    
    .wlc-tl-arrow { font-size: 16px; color: #a1a1aa; transition: 0.2s; opacity: 0; }
    .wlc-tl-item:hover:not(.locked) .wlc-tl-arrow { opacity: 1; transform: translateX(2px); color: #ffffff; }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .wlc-sub-hero { flex-direction: column; gap: 32px; text-align: center; }
        .wlc-hero-badges { justify-content: center; }
        .wlc-hero-desc { margin: 0 auto; }
        .wlc-sub-hero-right { display: none; }
        .wlc-sub-page { padding: 20px; }
    }
</style>
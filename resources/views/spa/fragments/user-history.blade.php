{{-- ═══════════════════════════════════════════════════════════════
 HISTORY PAGE — Neo Bento Design (synced with Dashboard)
═══════════════════════════════════════════════════════════════ --}}
<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        {{-- Back --}}
        <a href="?page=dashboard" class="link-spa" data-page="dashboard"
            style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#888;text-decoration:none;margin-bottom:24px;transition:color 0.2s;"
            onmouseover="this.style.color='#121212'" onmouseout="this.style.color='#888'">
            <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
        </a>

        {{-- Header --}}
        <div style="margin-bottom:32px;">
            <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Riwayat Belajar</h3>
            <p style="font-size:16px;color:#555;margin:0;">Lanjutkan progres materi yang terakhir kamu pelajari.</p>
        </div>

        {{-- Filters --}}
        <div style="display:flex;overflow-x:auto;gap:8px;margin-bottom:24px;padding-bottom:4px;" class="nhp-filter-row">
            <button class="nhp-neo-filter active" data-filter="all">Semua</button>
            @foreach ($filters as $f)
                <button class="nhp-neo-filter" data-filter="{{ strtolower($f) }}">{{ $f }}</button>
            @endforeach
        </div>

        {{-- History List --}}
        <div class="neo-card neo-card-light" style="padding:8px;">
            @if ($histories && count($histories))
                @foreach ($histories as $history)
                    @if ($history->submateri && $history->submateri->materi)
                        @php
                            $mainThemeColor = '#121212';
                            $mainTitle = $history->submateri->materi->mainMateri->title ?? '-';
                            if(str_contains(strtolower($mainTitle), 'javascript')) $mainThemeColor = '#f59e0b';
                            elseif(str_contains(strtolower($mainTitle), 'php')) $mainThemeColor = '#6366f1';
                            elseif(str_contains(strtolower($mainTitle), 'html')) $mainThemeColor = '#ec4899';
                            elseif(str_contains(strtolower($mainTitle), 'css')) $mainThemeColor = '#3b82f6';
                        @endphp
                        <a href="?page=detail&submateri_id={{ $history->submateri->id }}"
                           class="link-spa history-item"
                           data-filter="{{ strtolower($history->submateri->materi->title) }}"
                           style="text-decoration:none;display:block;border-radius:20px;transition:background 0.2s;">

                            <div style="display:flex;align-items:center;padding:16px;gap:16px;border-bottom:1px solid rgba(0,0,0,0.04);">
                                {{-- Icon --}}
                                <div style="width:44px;height:44px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;color:{{ $mainThemeColor }};background:{{ $mainThemeColor }}15;">
                                    <i class='bx bx-book-reader'></i>
                                </div>
                                {{-- Body --}}
                                <div style="flex:1;min-width:0;">
                                    <h4 style="margin:0 0 4px;font-size:15px;font-weight:700;color:#121212;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $history->submateri->title }}</h4>
                                    <p style="margin:0;font-size:13px;font-weight:500;color:#888;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $mainTitle }} <span style="margin:0 4px;color:#ccc;">/</span> {{ $history->submateri->materi->title }}</p>
                                </div>
                                {{-- Time --}}
                                <div style="color:#aaa;font-size:12px;font-weight:600;white-space:nowrap;">
                                    {{ $history->viewed_at->diffForHumans() }}
                                </div>
                                {{-- Arrow --}}
                                <div class="nhp-neo-arrow" style="display:flex;align-items:center;color:#ccc;font-size:22px;transition:all 0.2s;">
                                    <i class='bx bx-right-arrow-alt'></i>
                                </div>
                            </div>

                        </a>
                    @endif
                @endforeach
            @else
                <div style="padding:60px 20px;text-align:center;">
                    <i class='bx bx-ghost' style="font-size:48px;color:#ccc;margin-bottom:16px;display:block;"></i>
                    <h4 style="font-size:16px;font-weight:700;color:#121212;margin:0 0 8px;">Belum ada riwayat</h4>
                    <p style="font-size:14px;color:#888;margin:0;">Mulai eksplorasi materi untuk mencatat riwayat belajarmu.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
(function() {
    const filterBtns = document.querySelectorAll('.nhp-neo-filter');
    const items = document.querySelectorAll('.history-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            items.forEach(item => {
                item.style.display = (filter === 'all' || item.dataset.filter === filter) ? '' : 'none';
            });
        });
    });
})();

window.__currentSearchHandler = function(query) {
    const allBtn = document.querySelector('.nhp-neo-filter[data-filter="all"]');
    if (allBtn && query !== '') allBtn.click();
    document.querySelectorAll('.history-item').forEach(card => {
        const title = card.querySelector('h4')?.textContent.toLowerCase() || '';
        const path = card.querySelector('p')?.textContent.toLowerCase() || '';
        card.style.display = (title.includes(query) || path.includes(query)) ? '' : 'none';
    });
    if (query !== '') {
        const first = Array.from(document.querySelectorAll('.history-item')).find(c => c.style.display !== 'none');
        if (first) setTimeout(() => first.scrollIntoView({ behavior: 'smooth', block: 'center' }), 50);
    }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --neo-bg: #ececec;
    --neo-card-light: #e5e5e5;
    --neo-radius: 32px;
    --neo-text-dark: #121212;
}

body { background-color: var(--neo-bg) !important; }

.neo-dashboard {
    background-color: var(--neo-bg);
    color: var(--neo-text-dark);
    font-family: 'Inter', sans-serif;
    padding: 32px 0;
    min-height: 100vh;
    width: 100%;
}
.neo-bento-container { max-width: 1400px; margin: 0 auto; width: 100%; }
.neo-title { font-size: 24px; font-weight: 600; margin: 0; line-height: 1.25; letter-spacing: -0.03em; }
.neo-card {
    border-radius: var(--neo-radius);
    padding: 32px;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
}
.neo-card-light { background: var(--neo-card-light); color: var(--neo-text-dark); }

/* Filters */
.nhp-filter-row::-webkit-scrollbar { display: none; }
.nhp-neo-filter {
    background: transparent;
    border: 1px solid rgba(0,0,0,0.15);
    color: #666;
    padding: 8px 18px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
    font-family: inherit;
}
.nhp-neo-filter:hover {
    background: rgba(0,0,0,0.03);
    color: #121212;
}
.nhp-neo-filter.active {
    background: #121212;
    color: #fff;
    border-color: #121212;
}

/* History Items */
.history-item:hover {
    background: rgba(0,0,0,0.03);
}
.history-item:last-child > div {
    border-bottom: none !important;
}
.history-item:hover .nhp-neo-arrow {
    color: #121212;
    transform: translateX(3px);
}

@media (max-width: 768px) {
    .neo-dashboard { 
        padding: 16px 0; 
        overflow-x: hidden; 
    }
    
    .neo-bento-container,
    .neo-bento-container * {
        box-sizing: border-box;
    }

    .neo-bento-container {
        padding: 0 16px;
        max-width: 100vw;
    }

    .neo-title { font-size: 20px !important; }
    
    .neo-card {
        padding: 16px !important;
        border-radius: 20px !important;
    }

    .history-item > div {
        padding: 12px 8px !important;
        gap: 12px !important;
    }

    .history-item h4 {
        font-size: 14px !important;
    }

    .history-item p {
        font-size: 12px !important;
    }

    .history-item > div > div:first-child {
        width: 36px !important;
        height: 36px !important;
        font-size: 18px !important;
        border-radius: 12px !important;
    }

    .nhp-neo-arrow { display: none !important; }
}
</style>

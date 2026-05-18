<div class="neo-dashboard rtd-dashboard">
<div class="neo-bento-container">

    <a href="?page=dashboard" class="link-spa ns-back" data-page="dashboard">
        <i class='bx bx-arrow-back'></i> Kembali
    </a>

    {{-- ═══ COMPACT HEADER ═══ --}}
    <div class="ns-header">
        <div class="ns-header-left">
            <h1 class="ns-date"><i class='bx bx-history'></i></h1>
            <div class="ns-date-meta">
                <span class="ns-month">Riwayat Belajar</span>
                <span class="ns-day-name">Lanjutkan progres materimu</span>
            </div>
        </div>
        <div class="ns-fab-inline" style="background: transparent; box-shadow: none; border: 1px solid #27272a; color: #a1a1aa; cursor: default;">
            <i class='bx bx-time-five'></i>
        </div>
    </div>

    {{-- ═══ HORIZONTAL FILTER STRIP ═══ --}}
    <div class="ns-day-strip nhp-filter-row" style="margin-bottom: 24px;">
        <div class="ns-day-item ns-day-active nhp-neo-filter" data-filter="all">
            <span class="ns-day-label">Filter</span>
            <span class="ns-day-num" style="font-size: 14px;">Semua</span>
            <span class="ns-day-dot"></span>
        </div>
        @foreach ($filters as $f)
            <div class="ns-day-item nhp-neo-filter" data-filter="{{ strtolower($f) }}">
                <span class="ns-day-label">Kategori</span>
                <span class="ns-day-num" style="font-size: 14px;">{{ $f }}</span>
            </div>
        @endforeach
    </div>

    {{-- ═══ TIMELINE: RIWAYAT ═══ --}}
    <div class="ns-section">
        <div class="ns-section-head">
            <i class='bx bx-book-reader ns-section-icon'></i>
            <span>Daftar Riwayat</span>
            <span class="ns-count">{{ count($histories) }}</span>
        </div>
        
        <div class="ns-timeline history-list">
            @if ($histories && count($histories))
                @foreach ($histories as $history)
                    @if ($history->submateri && $history->submateri->materi)
                        @php
                            $mainThemeColor = '#8b5cf6'; // Default color (purple)
                            $mainTitle = $history->submateri->materi->mainMateri->title ?? '-';
                            if(str_contains(strtolower($mainTitle), 'javascript')) $mainThemeColor = '#f59e0b';
                            elseif(str_contains(strtolower($mainTitle), 'php')) $mainThemeColor = '#6366f1';
                            elseif(str_contains(strtolower($mainTitle), 'html')) $mainThemeColor = '#ec4899';
                            elseif(str_contains(strtolower($mainTitle), 'css')) $mainThemeColor = '#3b82f6';
                            elseif(str_contains(strtolower($mainTitle), 'sql') || str_contains(strtolower($mainTitle), 'database')) $mainThemeColor = '#10b981';
                        @endphp
                        
                        <div class="ntl-item history-item" data-filter="{{ strtolower($history->submateri->materi->title) }}">
                            {{-- Timeline gutter --}}
                            <div class="ntl-gutter">
                                <span class="ntl-time">{{ $history->viewed_at->diffForHumans(null, true, true) }}</span>
                                <div class="ntl-dot" style="background: {{ $mainThemeColor }}; box-shadow: 0 0 0 4px {{ $mainThemeColor }}22;"></div>
                            </div>
                            
                            {{-- Card --}}
                            <a href="?page=detail&submateri_id={{ $history->submateri->id }}" class="link-spa ntl-card" style="border-left: 3px solid {{ $mainThemeColor }}; text-decoration: none;">
                                <div class="ntl-card-head">
                                    <div class="ntl-badge" style="color: {{ $mainThemeColor }}; background: {{ $mainThemeColor }}12;">
                                        <i class='bx bx-folder'></i>
                                        {{ $mainTitle }}
                                    </div>
                                    <div class="ntl-actions">
                                        <span class="ntl-btn" style="color: {{ $mainThemeColor }};">
                                            <i class='bx bx-right-arrow-alt'></i>
                                        </span>
                                    </div>
                                </div>
                                <h4 class="ntl-title">{{ $history->submateri->title }}</h4>
                                <div class="ntl-label">
                                    <i class='bx bx-book-open'></i>
                                    {{ $history->submateri->materi->title }}
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="ns-empty">
                    <i class='bx bx-ghost'></i>
                    <p>Belum ada riwayat. Yuk mulai belajar!</p>
                </div>
            @endif
        </div>
    </div>

</div>
</div>

<script>
(function() {
    const filterBtns = document.querySelectorAll('.nhp-neo-filter');
    const items = document.querySelectorAll('.history-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active state and dot
            filterBtns.forEach(b => {
                b.classList.remove('ns-day-active');
                const dot = b.querySelector('.ns-day-dot');
                if (dot) dot.remove();
            });

            // Add active state and dot
            btn.classList.add('ns-day-active');
            if (!btn.querySelector('.ns-day-dot')) {
                btn.insertAdjacentHTML('beforeend', '<span class="ns-day-dot"></span>');
            }

            const filter = btn.dataset.filter;
            items.forEach(item => {
                if (filter === 'all' || item.dataset.filter === filter) {
                    item.style.display = '';
                    item.classList.remove('ntl-inactive');
                } else {
                    item.style.display = 'none';
                    item.classList.add('ntl-inactive');
                }
            });
        });
    });
})();

window.__currentSearchHandler = function(query) {
    const allBtn = document.querySelector('.nhp-neo-filter[data-filter="all"]');
    if (allBtn && query !== '') allBtn.click();
    
    document.querySelectorAll('.history-item').forEach(card => {
        const title = card.querySelector('.ntl-title')?.textContent.toLowerCase() || '';
        const badge = card.querySelector('.ntl-badge')?.textContent.toLowerCase() || '';
        const label = card.querySelector('.ntl-label')?.textContent.toLowerCase() || '';
        
        if (title.includes(query) || badge.includes(query) || label.includes(query)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });

    if (query !== '') {
        const first = Array.from(document.querySelectorAll('.history-item')).find(c => c.style.display !== 'none');
        if (first) setTimeout(() => first.scrollIntoView({ behavior: 'smooth', block: 'center' }), 50);
    }
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&display=swap');

/* ═══ NOTHING HISTORY V2 ═══ */

/* Back */
.ns-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; color: #71717a;
    text-decoration: none; margin-bottom: 24px;
    padding: 6px 14px; border-radius: 9999px;
    border: 1px solid #27272a; background: transparent;
    transition: all 0.2s; text-transform: uppercase; letter-spacing: 0.5px;
}
.ns-back:hover { color: #fff; border-color: #52525b; }
.ns-back i { font-size: 15px; }

/* ═══ COMPACT HEADER ═══ */
.ns-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px; padding: 0;
}
.ns-header-left { display: flex; align-items: center; gap: 16px; }
.ns-date {
    font-size: 48px; color: #fff; margin: 0;
    line-height: 1; letter-spacing: -2px;
}
.ns-date-meta { display: flex; flex-direction: column; gap: 2px; }
.ns-month { font-size: 16px; font-weight: 700; color: #e4e4e7; font-family: 'Outfit', sans-serif; letter-spacing: -0.5px; }
.ns-day-name { font-size: 12px; color: #71717a; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
.ns-fab-inline {
    width: 48px; height: 48px; border-radius: 14px;
    background: #111113; color: #fff; border: 1px solid #27272a;
    font-size: 22px; display: flex; align-items: center; justify-content: center;
}

/* ═══ FILTER STRIP ═══ */
.ns-day-strip {
    display: flex; gap: 8px; margin-bottom: 32px;
    overflow-x: auto; scrollbar-width: none;
    padding: 4px 0;
}
.ns-day-strip::-webkit-scrollbar { display: none; }
.ns-day-item {
    min-width: 80px; padding: 12px 16px; display: flex; flex-direction: column;
    align-items: center; gap: 6px; border-radius: 16px; 
    border: 1px solid #27272a; background: #111113; 
    cursor: pointer; transition: all 0.25s; position: relative;
    flex-shrink: 0;
}
.ns-day-item:hover { border-color: #52525b; background: #18181b; }
.ns-day-active {
    background: #b91c1c !important; border-color: #b91c1c !important;
}
.ns-day-active .ns-day-label,
.ns-day-active .ns-day-num { color: #fff !important; }
.ns-day-label { font-size: 11px; color: #71717a; font-weight: 600; text-transform: uppercase; }
.ns-day-num { font-size: 16px; font-weight: 800; color: #e4e4e7; }
.ns-day-dot {
    width: 4px; height: 4px; border-radius: 50%; background: #fff;
    position: absolute; bottom: 6px;
}

/* ═══ SECTIONS ═══ */
.ns-section { margin-bottom: 32px; }
.ns-section-head {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 16px; padding-bottom: 12px;
    border-bottom: 1px solid #1a1a1e;
}
.ns-section-icon { font-size: 18px; color: #b91c1c; }
.ns-section-head > span {
    font-size: 13px; font-weight: 700; color: #a1a1aa;
    text-transform: uppercase; letter-spacing: 1.5px;
}
.ns-count {
    margin-left: auto; font-size: 11px; font-weight: 700;
    color: #71717a; background: #18181b; border: 1px solid #27272a;
    padding: 2px 10px; border-radius: 9999px;
    font-family: 'Outfit', sans-serif;
}

/* ═══ TIMELINE ═══ */
.ns-timeline {
    display: flex; flex-direction: column; gap: 0;
    position: relative;
}
.ns-timeline::before {
    content: ''; position: absolute; left: 46px; top: 0; bottom: 0;
    width: 1px; background: #27272a;
}

/* ═══ TIMELINE ITEM ═══ */
.ntl-item {
    display: flex; gap: 16px; padding: 8px 0;
    position: relative; transition: opacity 0.3s;
}
.ntl-inactive { opacity: 0.35; filter: grayscale(0.6); }
.ntl-gutter {
    width: 56px; flex-shrink: 0; display: flex;
    flex-direction: column; align-items: center; gap: 4px;
    padding-top: 16px; position: relative; z-index: 1;
}
.ntl-time {
    font-size: 10px; font-weight: 700; color: #71717a;
    font-family: 'Outfit', sans-serif; text-align: center;
    line-height: 1.2;
}
.ntl-dot {
    width: 10px; height: 10px; border-radius: 50%;
    flex-shrink: 0; z-index: 2; margin-top: 4px;
}
.ntl-card {
    flex: 1; background: #111113; border: 1px solid #27272a;
    border-radius: 16px; padding: 16px 18px;
    display: flex; flex-direction: column; gap: 10px;
    transition: all 0.25s cubic-bezier(0.16,1,0.3,1);
    min-width: 0;
}
.ntl-card:hover {
    border-color: #3f3f46; transform: translateX(4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
}
.ntl-card-head {
    display: flex; justify-content: space-between;
    align-items: center; gap: 8px;
}
.ntl-badge {
    font-size: 10px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.5px; padding: 3px 10px; border-radius: 6px;
    display: inline-flex; align-items: center; gap: 4px;
}
.ntl-badge i { font-size: 12px; }
.ntl-actions { display: flex; gap: 4px; }
.ntl-btn {
    width: 28px; height: 28px; border-radius: 8px;
    background: transparent; cursor: pointer; font-size: 18px;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.ntl-card:hover .ntl-btn { transform: translateX(4px); }
.ntl-title {
    font-size: 15px; font-weight: 700; color: #e4e4e7;
    margin: 0; line-height: 1.4;
}
.ntl-label {
    font-size: 11px; color: #52525b; display: flex;
    align-items: center; gap: 4px; margin-top: 4px;
}
.ntl-label i { font-size: 13px; }

/* ═══ EMPTY STATE ═══ */
.ns-empty {
    text-align: center; padding: 48px 24px;
    background: #111113; border: 1px dashed #27272a;
    border-radius: 16px; margin-left: 72px;
}
.ns-empty i { font-size: 32px; color: #27272a; margin-bottom: 8px; }
.ns-empty p { color: #52525b; font-size: 13px; margin: 0; }

@media (max-width: 768px) {
    .ns-date { font-size: 36px !important; }
    .ns-timeline::before { left: 30px; }
    .ntl-gutter { width: 40px; }
    .ns-empty { margin-left: 56px; }
}
</style>

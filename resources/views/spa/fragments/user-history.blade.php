<div class="neo-history-page">
    {{-- Header --}}
    <div class="nhp-header">
        <div class="nhp-header-text">
            <h2>Riwayat Belajar</h2>
            <p>Lanjutkan progres materi yang terakhir kamu pelajari.</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="nhp-filter">
        <button class="nhp-filter-btn active" data-filter="all">Semua</button>
        @foreach ($filters as $f)
            <button class="nhp-filter-btn" data-filter="{{ strtolower($f) }}">{{ $f }}</button>
        @endforeach
    </div>

    {{-- History List --}}
    <div class="nhp-list">
        @if ($histories && count($histories))
            @foreach ($histories as $history)
                @if ($history->submateri && $history->submateri->materi)
                    @php
                        $mainThemeColor = '#121212'; // Default
                        $mainTitle = $history->submateri->materi->mainMateri->title ?? '-';
                        if(str_contains(strtolower($mainTitle), 'javascript')) $mainThemeColor = '#f59e0b';
                        elseif(str_contains(strtolower($mainTitle), 'php')) $mainThemeColor = '#6366f1';
                        elseif(str_contains(strtolower($mainTitle), 'html')) $mainThemeColor = '#ec4899';
                        elseif(str_contains(strtolower($mainTitle), 'css')) $mainThemeColor = '#3b82f6';
                    @endphp
                    <a href="?page=detail&submateri_id={{ $history->submateri->id }}" 
                       class="link-spa history-item"
                       data-filter="{{ strtolower($history->submateri->materi->title) }}">
                        
                        <div class="nhp-row">
                            <div class="nhp-icon" style="color: {{ $mainThemeColor }}; background: {{ $mainThemeColor }}15;">
                                <i class='bx bx-book-reader'></i>
                            </div>
                            <div class="nhp-body">
                                <h4>{{ $history->submateri->title }}</h4>
                                <h5>{{ $mainTitle }} <span style="margin: 0 4px; color: #ccc;">/</span> {{ $history->submateri->materi->title }}</h5>
                            </div>
                            <div class="nhp-time">
                                <span>{{ $history->viewed_at->diffForHumans() }}</span>
                            </div>
                            <div class="nhp-arrow">
                                <i class='bx bx-right-arrow-alt'></i>
                            </div>
                        </div>

                    </a>
                @endif
            @endforeach
        @else
            <div class="nhp-empty">
                <i class='bx bx-ghost'></i>
                <h4>Belum ada riwayat</h4>
                <p>Mulai eksplorasi materi untuk mencatat riwayat belajarmu.</p>
            </div>
        @endif
    </div>
</div>

<script>
    (function() {
        // Filter Activity
        const filterBtns = document.querySelectorAll('.nhp-filter-btn');
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

    // Search Handler
    window.__currentSearchHandler = function(query) {
        const allBtn = document.querySelector('.nhp-filter-btn[data-filter="all"]');
        if(allBtn && query !== '') allBtn.click();

        document.querySelectorAll('.history-item').forEach(card => {
            const title = card.querySelector('.nhp-body h4')?.textContent.toLowerCase() || '';
            const path = card.querySelector('.nhp-body h5')?.textContent.toLowerCase() || '';
            if (title.includes(query) || path.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        if (query !== '') {
            const firstVisible = Array.from(document.querySelectorAll('.history-item')).find(c => c.style.display !== 'none');
            if (firstVisible) {
                setTimeout(() => {
                    firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 50);
            }
        }
    };
</script>

<style>
/* ═══ ULTRA MINIMALIST HISTORY ═══ */
.neo-history-page {
    max-width: 79em;
    margin: 40px auto 100px;
    padding: 0 24px;
    font-family: 'Inter', sans-serif;
}

/* Header */
.nhp-header {
    margin-bottom: 32px;
}
.nhp-header h2 {
    font-size: 28px;
    font-weight: 800;
    color: #121212;
    margin: 0 0 8px 0;
    letter-spacing: -0.5px;
}
.nhp-header p {
    font-size: 15px;
    color: #666;
    margin: 0;
}

/* Filters */
.nhp-filter {
    display: flex;
    overflow-x: auto;
    gap: 8px;
    margin-bottom: 24px;
    padding-bottom: 4px;
}
.nhp-filter::-webkit-scrollbar {
    display: none;
}
.nhp-filter-btn {
    background: transparent;
    border: 1px solid rgba(0,0,0,0.08);
    color: #666;
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.nhp-filter-btn:hover {
    background: rgba(0,0,0,0.02);
    color: #121212;
}
.nhp-filter-btn.active {
    background: #121212;
    color: #fff;
    border-color: #121212;
}

/* List Framework */
.nhp-list {
    background: #fff;
    border-radius: 24px;
    border: 1px solid rgba(0,0,0,0.04);
    box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    padding: 8px;
    display: flex;
    flex-direction: column;
}

.history-item {
    text-decoration: none;
    display: block;
    border-radius: 16px;
    transition: background 0.2s;
}
.history-item:hover {
    background: #f9f9f9;
}

.nhp-row {
    display: flex;
    align-items: center;
    padding: 16px;
    gap: 16px;
    border-bottom: 1px solid rgba(0,0,0,0.03);
}
.history-item:last-child .nhp-row {
    border-bottom: none;
}

/* Row Contents */
.nhp-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.nhp-body {
    flex: 1;
    min-width: 0;
}
.nhp-body h4 {
    margin: 0 0 4px 0;
    font-size: 15px;
    font-weight: 700;
    color: #121212;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nhp-body h5 {
    margin: 0;
    font-size: 13px;
    font-weight: 500;
    color: #888;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.nhp-time {
    color: #aaa;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.nhp-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ccc;
    font-size: 22px;
    transition: all 0.2s;
}
.history-item:hover .nhp-arrow {
    color: #121212;
    transform: translateX(3px);
}

/* Empty State */
.nhp-empty {
    padding: 60px 20px;
    text-align: center;
}
.nhp-empty i {
    font-size: 48px;
    color: #e5e5e5;
    margin-bottom: 16px;
}
.nhp-empty h4 {
    font-size: 16px;
    font-weight: 700;
    color: #121212;
    margin: 0 0 8px 0;
}
.nhp-empty p {
    font-size: 14px;
    color: #888;
    margin: 0;
}

@media (max-width: 768px) {
    .nhp-row {
        flex-wrap: wrap;
    }
    .nhp-time {
        width: 100%;
        padding-left: 60px;
        margin-top: -8px;
    }
    .nhp-arrow {
        display: none;
    }
}
</style>

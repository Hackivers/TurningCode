<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        {{-- Back --}}
        <a href="?page=dashboard" class="link-spa" data-page="dashboard"
            style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:700;color:#888;text-decoration:none;margin-bottom:32px;transition:color 0.2s; background: rgba(0,0,0,0.03); padding: 8px 16px; border-radius: 20px;"
            onmouseover="this.style.color='#121212'; this.style.background='rgba(0,0,0,0.05)';" 
            onmouseout="this.style.color='#888'; this.style.background='rgba(0,0,0,0.03)';">
            <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
        </a>

        {{-- Header --}}
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: var(--text-primary)fff;">Riwayat Belajar</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Lanjutkan progres materi yang terakhir kamu pelajari.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-history' style="font-size: 28px; color: #10b981;"></i>
            </div>
        </div>

        {{-- Filters --}}
        <div style="display:flex;overflow-x:auto;gap:12px;margin-bottom:32px;padding-bottom:8px;" class="nhp-filter-row">
            <button class="nhp-neo-filter active" data-filter="all">Semua</button>
            @foreach ($filters as $f)
                <button class="nhp-neo-filter" data-filter="{{ strtolower($f) }}">{{ $f }}</button>
            @endforeach
        </div>

        {{-- History List --}}
        <div class="neo-card neo-card-light" style="padding: 24px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            @if ($histories && count($histories))
                <div style="display: flex; flex-direction: column; gap: 12px;">
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
                            <a href="?page=detail&submateri_id={{ $history->submateri->id }}"
                               class="link-spa history-item"
                               data-filter="{{ strtolower($history->submateri->materi->title) }}"
                               style="text-decoration:none;display:block;border-radius:20px;transition:all 0.3s;border: 1px solid rgba(0,0,0,0.02);background: var(--neo-bg, #fff);overflow: hidden;">
    
                                <div style="display:flex;align-items:center;padding:20px;gap:20px;position: relative;">
                                    <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: {{ $mainThemeColor }}; opacity: 0.8;"></div>
                                    
                                    {{-- Icon --}}
                                    <div style="width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;color:{{ $mainThemeColor }};background:{{ $mainThemeColor }}15;">
                                        <i class='bx bx-book-reader'></i>
                                    </div>
                                    
                                    {{-- Body --}}
                                    <div style="flex:1;min-width:0;">
                                        <h4 style="margin:0 0 6px;font-size:16px;font-weight:800;color: var(--text-primary)fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;letter-spacing:-0.2px;">{{ $history->submateri->title }}</h4>
                                        <p style="margin:0;font-size:13px;font-weight:600;color:#888;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            <span style="color: {{ $mainThemeColor }}; opacity: 0.8;">{{ $mainTitle }}</span>
                                            <span style="margin:0 4px;color:#ccc;">/</span> 
                                            {{ $history->submateri->materi->title }}
                                        </p>
                                    </div>
                                    
                                    {{-- Time --}}
                                    <div style="color:#aaa;font-size:11px;font-weight:700;white-space:nowrap;background:rgba(0,0,0,0.03);padding:4px 10px;border-radius:8px;">
                                        {{ $history->viewed_at->diffForHumans() }}
                                    </div>
                                    
                                    {{-- Arrow --}}
                                    <div class="nhp-neo-arrow" style="display:flex;align-items:center;color:#ccc;font-size:24px;transition:all 0.3s;">
                                        <i class='bx bx-right-arrow-circle'></i>
                                    </div>
                                </div>
    
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <div style="padding:80px 20px;text-align:center;">
                    <div style="width: 80px; height: 80px; background: rgba(0,0,0,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class='bx bx-ghost' style="font-size:40px;color:#ccc;"></i>
                    </div>
                    <h4 style="font-size:18px;font-weight:800;color: var(--text-primary)fff;margin:0 0 8px;letter-spacing:-0.2px;">Belum ada riwayat</h4>
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
/* Filters */
.nhp-filter-row::-webkit-scrollbar { display: none; }
.nhp-neo-filter {
    background: transparent;
    border: 1px solid rgba(0,0,0,0.1);
    color: #888;
    padding: 10px 20px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
    font-family: inherit;
}
.nhp-neo-filter:hover {
    background: rgba(0,0,0,0.03);
    color: var(--text-primary)fff;
    border-color: rgba(0,0,0,0.2);
}
.nhp-neo-filter.active {
    background: linear-gradient(135deg, #121212, #2a2a2a);
    color: var(--text-primary);
    border-color: var(--text-primary)fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* History Items */
.history-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.06);
    border-color: rgba(0,0,0,0.05) !important;
}
.history-item:hover .nhp-neo-arrow {
    color: var(--text-primary)fff;
    transform: translateX(4px) scale(1.1);
}

@media (max-width: 768px) {
    .history-item > div {
        padding: 16px !important;
        gap: 12px !important;
    }

    .history-item h4 {
        font-size: 14px !important;
    }

    .history-item p {
        font-size: 12px !important;
    }

    .history-item > div > div:nth-child(2) {
        width: 40px !important;
        height: 40px !important;
        font-size: 20px !important;
        border-radius: 10px !important;
    }

    .nhp-neo-arrow { display: none !important; }
}
</style>

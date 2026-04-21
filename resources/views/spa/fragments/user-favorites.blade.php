<div class="fv-page">
    <div class="fv-container">

        {{-- Header --}}
        <div class="fv-header">
            <h2 class="fv-title">Favorit</h2>
            <p class="fv-subtitle">Koleksi materi yang kamu simpan</p>
        </div>

        {{-- Tabs --}}
        <div class="fv-tabs">
            <button class="fv-tab active" data-target="fv-materi-list">
                <i class='bx bx-book'></i>
                <span>Materi</span>
                <span class="fv-count">{{ $favMateris->count() }}</span>
            </button>
            <button class="fv-tab" data-target="fv-sub-list">
                <i class='bx bx-file'></i>
                <span>Sub Materi</span>
                <span class="fv-count">{{ $favSubs->count() }}</span>
            </button>
        </div>

        {{-- Materi List --}}
        <div class="fv-list" id="fv-materi-list">
            @forelse ($favMateris as $materi)
                <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa fv-item favorites-item">
                    <div class="fv-item__left">
                        <div class="fv-item__dot" style="background:#6366f1;"></div>
                        <div class="fv-item__info">
                            <h4 class="fv-item__title">{{ $materi->title }}</h4>
                            <p class="fv-item__meta">{{ $materi->mainMateri->title ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="fv-item__right">
                        <i class="bx bxs-star archive-btn" data-id="{{ $materi->id }}" data-type="materi"
                           style="color:#f59e0b;font-size:18px;cursor:pointer;"></i>
                        <i class='bx bx-chevron-right fv-item__arrow'></i>
                    </div>
                </a>
            @empty
                <div class="fv-empty">
                    <div class="fv-empty__icon">
                        <i class='bx bx-bookmark'></i>
                    </div>
                    <p class="fv-empty__text">Belum ada materi favorit</p>
                    <p class="fv-empty__hint">Tekan ikon ⭐ di halaman materi untuk menyimpan</p>
                </div>
            @endforelse
        </div>

        {{-- Sub Materi List --}}
        <div class="fv-list" id="fv-sub-list" style="display:none;">
            @forelse ($favSubs as $sub)
                <a href="?page=detail&submateri_id={{ $sub->id }}" class="link-spa fv-item favorites-item">
                    <div class="fv-item__left">
                        <div class="fv-item__dot" style="background:#8b5cf6;"></div>
                        <div class="fv-item__info">
                            <h4 class="fv-item__title">{{ $sub->title }}</h4>
                            <p class="fv-item__meta">{{ $sub->materi->mainMateri->title ?? '-' }} → {{ $sub->materi->title ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="fv-item__right">
                        <i class="bx bxs-star archive-btn" data-id="{{ $sub->id }}" data-type="sub"
                           style="color:#f59e0b;font-size:18px;cursor:pointer;"></i>
                        <i class='bx bx-chevron-right fv-item__arrow'></i>
                    </div>
                </a>
            @empty
                <div class="fv-empty">
                    <div class="fv-empty__icon">
                        <i class='bx bx-bookmark'></i>
                    </div>
                    <p class="fv-empty__text">Belum ada sub materi favorit</p>
                    <p class="fv-empty__hint">Tekan ikon ⭐ di halaman sub materi untuk menyimpan</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

<script>
    (function() {
        document.querySelectorAll('.fv-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.fv-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                document.querySelectorAll('.fv-list').forEach(l => l.style.display = 'none');
                const target = document.getElementById(tab.dataset.target);
                if (target) target.style.display = '';
            });
        });
    })();

    // ── Search Handler ────────────────────────────────────────────
    window.__currentSearchHandler = function(query) {
        document.querySelectorAll('.favorites-item').forEach(card => {
            const title = card.querySelector('.fv-item__title')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.fv-item__meta')?.textContent.toLowerCase() || '';
            if (title.includes(query) || desc.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        if (query !== '') {
            const firstVisible = Array.from(document.querySelectorAll('.favorites-item')).find(c => c.style.display !== 'none');
            if (firstVisible) {
                setTimeout(() => {
                    firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 50);
            }
        }
    };
</script>

<style>
    /* ═══ NEO BENTO LIGHT — FAVORITES ═══ */
    .fv-page {
        display: flex;
        justify-content: center;
        padding: 2rem 24px 6rem;
        font-family: 'Inter', sans-serif;
    }
    .fv-container {
        width: 100%;
        max-width: 79em;
    }
    .fv-header { margin-bottom: 2rem; }
    .fv-title {
        font-size: 28px;
        font-weight: 800;
        color: #121212;
        margin: 0;
        letter-spacing: -0.5px;
    }
    .fv-subtitle {
        font-size: 15px;
        color: #666;
        margin: 4px 0 0;
    }

    /* Tabs */
    .fv-tabs {
        display: flex;
        gap: 16px;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 0;
    }
    .fv-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 0;
        border: none;
        background: none;
        color: #888;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        transition: color 0.2s, border-color 0.2s;
    }
    .fv-tab:hover { color: #121212; }
    .fv-tab.active {
        color: #121212;
        border-bottom-color: #121212;
    }
    .fv-tab i { font-size: 18px; }
    .fv-count {
        font-size: 11px;
        font-weight: 700;
        background: rgba(0,0,0,0.05);
        color: #666;
        padding: 2px 8px;
        border-radius: 12px;
    }
    .fv-tab.active .fv-count {
        background: #121212;
        color: #fff;
    }

    /* List */
    .fv-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    @media (max-width: 768px) {
        .fv-list {
            grid-template-columns: 1fr;
        }
    }

    /* Item Card */
    .fv-item {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 16px;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 20px;
        text-decoration: none;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: all 0.2s ease;
    }
    .fv-item:hover {
        transform: translateY(-2px);
        border-color: rgba(0,0,0,0.08);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }

    .fv-item__left {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
        flex: 1;
        padding: 4px;
    }
    .fv-item__dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 5px;
    }
    .fv-item__title {
        font-size: 15px;
        font-weight: 700;
        color: #121212;
        margin: 0;
        text-transform: capitalize;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fv-item__meta {
        font-size: 13px;
        color: #888;
        font-weight: 500;
        margin: 4px 0 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fv-item__right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .fv-item__arrow {
        font-size: 20px;
        color: #d4d4d8;
        transition: all 0.2s;
    }
    .fv-item:hover .fv-item__arrow {
        transform: translateX(2px);
        color: #121212;
    }

    /* Empty */
    .fv-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 1rem;
        text-align: center;
        grid-column: 1 / -1;
    }
    .fv-empty__icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .fv-empty__icon i {
        font-size: 28px;
        color: #d4d4d8;
    }
    .fv-empty__text {
        font-size: 16px;
        font-weight: 700;
        color: #121212;
        margin: 0 0 4px;
    }
    .fv-empty__hint {
        font-size: 14px;
        color: #888;
        font-weight: 500;
        margin: 0;
    }
</style>

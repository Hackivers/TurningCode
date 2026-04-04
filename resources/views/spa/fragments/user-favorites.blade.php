<div class="container-favorites">
    <main class="main-favorites">
        <div class="wrapper-favorites">

            <div class="fav-header">
                <div>
                    <h4>materi favorit mu</h4>
                    <h5>akses cepat materi yang sudah kamu simpan</h5>
                </div>
            </div>

            {{-- Tab filter --}}
            <div class="fav-tabs">
                <button class="fav-tab active" data-target="fav-materi-list">
                    <i class='bx bx-book'></i> Materi
                    <span class="fav-badge">{{ $favMateris->count() }}</span>
                </button>
                <button class="fav-tab" data-target="fav-sub-list">
                    <i class='bx bx-file'></i> Sub Materi
                    <span class="fav-badge">{{ $favSubs->count() }}</span>
                </button>
            </div>

            {{-- Materi list --}}
            <div class="fav-list" id="fav-materi-list">
                @forelse ($favMateris as $materi)
                    <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa fav-card">
                        <div class="fav-color" style="background: #6366f1"></div>
                        <div class="fav-info">
                            <h4>{{ $materi->title }}</h4>
                            <h6>{{ $materi->mainMateri->title ?? '-' }}</h6>
                        </div>
                        <div class="fav-action">
                            <i class="bx bxs-star active archive-btn"
                               data-id="{{ $materi->id }}" data-type="materi"
                               style="color:#f59e0b; font-size:20px; cursor:pointer; transition: transform 0.2s;"></i>
                        </div>
                    </a>
                @empty
                    <div class="fav-empty">
                        <i class='bx bx-star'></i>
                        <p>Belum ada materi favorit</p>
                        <h6>Tekan ikon ⭐ di halaman materi untuk menyimpan</h6>
                    </div>
                @endforelse
            </div>

            {{-- Sub Materi list --}}
            <div class="fav-list" id="fav-sub-list" style="display:none;">
                @forelse ($favSubs as $sub)
                    <a href="?page=detail&submateri_id={{ $sub->id }}" class="link-spa fav-card">
                        <div class="fav-color" style="background: #8b5cf6"></div>
                        <div class="fav-info">
                            <h4>{{ $sub->title }}</h4>
                            <h6>{{ $sub->materi->mainMateri->title ?? '-' }} → {{ $sub->materi->title ?? '-' }}</h6>
                        </div>
                        <div class="fav-action">
                            <i class="bx bxs-star active archive-btn"
                               data-id="{{ $sub->id }}" data-type="sub"
                               style="color:#f59e0b; font-size:20px; cursor:pointer; transition: transform 0.2s;"></i>
                        </div>
                    </a>
                @empty
                    <div class="fav-empty">
                        <i class='bx bx-star'></i>
                        <p>Belum ada sub materi favorit</p>
                        <h6>Tekan ikon ⭐ di halaman sub materi untuk menyimpan</h6>
                    </div>
                @endforelse
            </div>

        </div>
    </main>
</div>

<script>
(function() {
    document.querySelectorAll('.fav-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.fav-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            document.querySelectorAll('.fav-list').forEach(l => l.style.display = 'none');
            const target = document.getElementById(tab.dataset.target);
            if (target) target.style.display = '';
        });
    });
})();
</script>

<style>
    .container-favorites {
        display: flex;
        justify-content: center;
        margin-top: 1.5em;
        padding-bottom: 6em;
    }
    .main-favorites {
        width: 100%;
        max-width: 79em;
        margin: 0 10px;
    }
    .wrapper-favorites {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Header */
    .fav-header h4 {
        font-weight: 550;
        font-size: 16px;
        color: #E6E0E9;
        text-transform: capitalize;
    }
    .fav-header h5 {
        margin-top: 6px;
        font-size: 12px;
        color: #8a898a;
    }

    /* Tabs */
    .fav-tabs {
        display: flex;
        gap: 8px;
    }
    .fav-tab {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 20px;
        border: 1px solid #2a2c3a;
        background: transparent;
        color: #8a898a;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .fav-tab.active {
        background: #6366f1;
        border-color: #6366f1;
        color: #fff;
    }
    .fav-badge {
        background: rgba(255,255,255,0.2);
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 11px;
    }
    .fav-tab:not(.active) .fav-badge {
        background: #222430;
        color: #75bbed;
    }

    /* Cards */
    .fav-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .fav-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #191825;
        border-radius: 16px;
        border: 1px solid #1f1e2e;
        text-decoration: none;
        transition: all 0.2s;
    }
    .fav-card:hover {
        border-color: #2a2c3a;
        background: #1d1c2c;
    }
    .fav-color {
        width: 4px;
        height: 36px;
        border-radius: 4px;
        flex-shrink: 0;
    }
    .fav-info {
        flex: 1;
        min-width: 0;
    }
    .fav-info h4 {
        color: #E6E0E9;
        font-size: 14px;
        font-weight: 500;
        text-transform: capitalize;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .fav-info h6 {
        color: #8a898a;
        font-size: 11px;
        margin-top: 3px;
    }
    .fav-action {
        flex-shrink: 0;
    }

    /* Empty */
    .fav-empty {
        text-align: center;
        padding: 3em 1em;
        color: #555;
    }
    .fav-empty i {
        font-size: 36px;
        margin-bottom: 10px;
        display: block;
        color: #8a898a;
    }
    .fav-empty p {
        font-size: 14px;
        color: #8a898a;
    }
    .fav-empty h6 {
        font-size: 12px;
        color: #555;
        margin-top: 6px;
    }
</style>

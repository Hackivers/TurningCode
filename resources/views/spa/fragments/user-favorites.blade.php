{{-- FAVORITES — Neo Bento Design (synced with Dashboard) --}}
<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        <a href="?page=dashboard" class="link-spa" data-page="dashboard" style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#888;text-decoration:none;margin-bottom:24px;transition:color 0.2s;" onmouseover="this.style.color='#121212'" onmouseout="this.style.color='#888'">
            <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
        </a>

        <div style="margin-bottom:32px;">
            <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Favorit</h3>
            <p style="font-size:16px;color:#555;margin:0;">Koleksi materi yang kamu simpan.</p>
        </div>

        {{-- Tabs --}}
        <div style="display:flex;gap:16px;margin-bottom:24px;border-bottom:1px solid rgba(0,0,0,0.06);padding-bottom:0;">
            <button class="fv-neo-tab active" data-target="fv-materi-list" style="display:flex;align-items:center;gap:8px;padding:12px 0;border:none;background:none;color:#121212;font-size:14px;font-weight:600;cursor:pointer;border-bottom:2px solid #121212;margin-bottom:-1px;font-family:inherit;">
                <i class='bx bx-book' style="font-size:18px;"></i> Materi
                <span style="font-size:11px;font-weight:700;background:#121212;color:#fff;padding:2px 8px;border-radius:12px;">{{ $favMateris->count() }}</span>
            </button>
            <button class="fv-neo-tab" data-target="fv-sub-list" style="display:flex;align-items:center;gap:8px;padding:12px 0;border:none;background:none;color:#888;font-size:14px;font-weight:600;cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;font-family:inherit;">
                <i class='bx bx-file' style="font-size:18px;"></i> Sub Materi
                <span style="font-size:11px;font-weight:700;background:rgba(0,0,0,0.05);color:#666;padding:2px 8px;border-radius:12px;">{{ $favSubs->count() }}</span>
            </button>
        </div>

        {{-- Materi List --}}
        <div class="fv-neo-list" id="fv-materi-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;">
            @forelse ($favMateris as $materi)
                <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa favorites-item" style="text-decoration:none;">
                    <div class="neo-card neo-card-light" style="padding:20px 24px;flex-direction:row;align-items:center;gap:16px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:#6366f1;flex-shrink:0;"></div>
                        <div style="flex:1;min-width:0;">
                            <h4 style="margin:0;font-size:15px;font-weight:700;color:#121212;text-transform:capitalize;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $materi->title }}</h4>
                            <p style="margin:4px 0 0;font-size:13px;color:#888;font-weight:500;">{{ $materi->mainMateri->title ?? '-' }}</p>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
                            <i class="bx bxs-star archive-btn" data-id="{{ $materi->id }}" data-type="materi" style="color:#f59e0b;font-size:18px;cursor:pointer;" onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorite(this);"></i>
                            <span class="neo-arrow" style="font-size:20px;">&#x2197;</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="neo-card neo-card-light" style="grid-column:1/-1;text-align:center;padding:48px 24px;">
                    <i class='bx bx-bookmark' style="font-size:48px;color:#ccc;margin-bottom:12px;"></i>
                    <p style="font-size:16px;font-weight:700;color:#121212;margin:0 0 4px;">Belum ada materi favorit</p>
                    <p style="font-size:14px;color:#888;margin:0;">Tekan ikon ⭐ di halaman materi untuk menyimpan</p>
                </div>
            @endforelse
        </div>

        {{-- Sub Materi List --}}
        <div class="fv-neo-list" id="fv-sub-list" style="display:none;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;">
            @forelse ($favSubs as $sub)
                <a href="?page=detail&submateri_id={{ $sub->id }}" class="link-spa favorites-item" style="text-decoration:none;">
                    <div class="neo-card neo-card-light" style="padding:20px 24px;flex-direction:row;align-items:center;gap:16px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:#8b5cf6;flex-shrink:0;"></div>
                        <div style="flex:1;min-width:0;">
                            <h4 style="margin:0;font-size:15px;font-weight:700;color:#121212;text-transform:capitalize;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $sub->title }}</h4>
                            <p style="margin:4px 0 0;font-size:13px;color:#888;font-weight:500;">{{ $sub->materi->mainMateri->title ?? '-' }} → {{ $sub->materi->title ?? '-' }}</p>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
                            <i class="bx bxs-star archive-btn" data-id="{{ $sub->id }}" data-type="sub" style="color:#f59e0b;font-size:18px;cursor:pointer;" onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorite(this);"></i>
                            <span class="neo-arrow" style="font-size:20px;">&#x2197;</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="neo-card neo-card-light" style="grid-column:1/-1;text-align:center;padding:48px 24px;">
                    <i class='bx bx-bookmark' style="font-size:48px;color:#ccc;margin-bottom:12px;"></i>
                    <p style="font-size:16px;font-weight:700;color:#121212;margin:0 0 4px;">Belum ada sub materi favorit</p>
                    <p style="font-size:14px;color:#888;margin:0;">Tekan ikon ⭐ di halaman sub materi untuk menyimpan</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

<script>
(function() {
    document.querySelectorAll('.fv-neo-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.fv-neo-tab').forEach(t => {
                t.style.color = '#888'; t.style.borderBottomColor = 'transparent';
                t.querySelector('span').style.background = 'rgba(0,0,0,0.05)'; t.querySelector('span').style.color = '#666';
            });
            tab.style.color = '#121212'; tab.style.borderBottomColor = '#121212';
            tab.querySelector('span').style.background = '#121212'; tab.querySelector('span').style.color = '#fff';
            document.querySelectorAll('.fv-neo-list').forEach(l => l.style.display = 'none');
            const target = document.getElementById(tab.dataset.target);
            if (target) target.style.display = 'grid';
        });
    });
})();
window.__currentSearchHandler = function(query) {
    document.querySelectorAll('.favorites-item').forEach(card => {
        const t = card.querySelector('h4')?.textContent.toLowerCase() || '';
        const m = card.querySelector('p')?.textContent.toLowerCase() || '';
        card.style.display = (t.includes(query) || m.includes(query)) ? '' : 'none';
    });
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
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s;
    box-sizing: border-box;
}
.neo-card:hover { transform: translateY(-4px); }
.neo-card-light { background: var(--neo-card-light); color: var(--neo-text-dark); }
.neo-arrow {
    font-size: 32px; font-weight: 400; line-height: 1;
    transition: transform 0.2s; margin-top: -4px;
}
.neo-card:hover .neo-arrow { transform: translate(2px, -2px); }

@media (max-width: 768px) {
    .neo-dashboard { padding: 24px 16px; }
    .fv-neo-list { grid-template-columns: 1fr !important; }
}
</style>

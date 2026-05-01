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
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: #121212;">Favorit Saya</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Koleksi materi dan bacaan yang kamu simpan.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(-5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-star' style="font-size: 28px; color: #fef08a;"></i>
            </div>
        </div>

        {{-- Tabs --}}
        <div style="display:flex;gap:24px;margin-bottom:32px;border-bottom:2px solid rgba(0,0,0,0.04);padding-bottom:0;">
            <button class="fv-neo-tab active" data-target="fv-materi-list" style="display:flex;align-items:center;gap:10px;padding:12px 4px;border:none;background:none;color:#121212;font-size:15px;font-weight:700;cursor:pointer;border-bottom:3px solid #121212;margin-bottom:-2px;font-family:inherit;transition:all 0.3s;">
                <i class='bx bx-book-open' style="font-size:20px;"></i> Materi
                <span class="fv-tab-badge" style="font-size:11px;font-weight:800;background:linear-gradient(135deg, #121212, #2a2a2a);color:#fff;padding:2px 10px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">{{ $favMateris->count() }}</span>
            </button>
            <button class="fv-neo-tab" data-target="fv-sub-list" style="display:flex;align-items:center;gap:10px;padding:12px 4px;border:none;background:none;color:#888;font-size:15px;font-weight:700;cursor:pointer;border-bottom:3px solid transparent;margin-bottom:-2px;font-family:inherit;transition:all 0.3s;">
                <i class='bx bx-file' style="font-size:20px;"></i> Sub Materi
                <span class="fv-tab-badge" style="font-size:11px;font-weight:800;background:rgba(0,0,0,0.05);color:#888;padding:2px 10px;border-radius:12px;">{{ $favSubs->count() }}</span>
            </button>
        </div>

        {{-- Materi List --}}
        <div class="fv-neo-list" id="fv-materi-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:24px;">
            @forelse ($favMateris as $materi)
                <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa favorites-item" style="text-decoration:none;display:block;border-radius:20px;transition:all 0.3s;border: 1px solid rgba(0,0,0,0.02);background: var(--neo-bg, #fff);overflow: hidden;box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="padding:24px;display:flex;align-items:center;gap:20px;position:relative;">
                        <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(to bottom, #6366f1, #a5b4fc);"></div>
                        
                        <div style="width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;color:#6366f1;background:rgba(99,102,241,0.1);">
                            <i class='bx bx-book'></i>
                        </div>
                        
                        <div style="flex:1;min-width:0;">
                            <h4 style="margin:0 0 6px;font-size:16px;font-weight:800;color:#121212;text-transform:capitalize;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;letter-spacing:-0.2px;">{{ $materi->title }}</h4>
                            <p style="margin:0;font-size:13px;color:#888;font-weight:600;"><span style="color:#6366f1;opacity:0.8;">{{ $materi->mainMateri->title ?? '-' }}</span></p>
                        </div>
                        
                        <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
                            <div class="fv-star-btn" style="width:36px;height:36px;border-radius:50%;background:rgba(245,158,11,0.1);display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorite(this);">
                                <i class="bx bxs-star archive-btn" data-id="{{ $materi->id }}" data-type="materi" style="color:#f59e0b;font-size:20px;cursor:pointer;filter:drop-shadow(0 2px 4px rgba(245,158,11,0.3));"></i>
                            </div>
                            <span class="neo-arrow" style="font-size:24px;color:#ccc;transition:all 0.3s;"><i class='bx bx-right-arrow-circle'></i></span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="neo-card neo-card-light" style="grid-column:1/-1;text-align:center;padding:80px 24px;border-radius:24px;box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    <div style="width: 80px; height: 80px; background: rgba(0,0,0,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class='bx bx-star' style="font-size:40px;color:#ccc;"></i>
                    </div>
                    <p style="font-size:18px;font-weight:800;color:#121212;margin:0 0 8px;letter-spacing:-0.2px;">Belum ada materi favorit</p>
                    <p style="font-size:14px;color:#888;margin:0;">Tekan ikon <i class='bx bxs-star' style="color:#f59e0b;"></i> di halaman materi untuk menyimpannya di sini.</p>
                </div>
            @endforelse
        </div>

        {{-- Sub Materi List --}}
        <div class="fv-neo-list" id="fv-sub-list" style="display:none;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:24px;">
            @forelse ($favSubs as $sub)
                <a href="?page=detail&submateri_id={{ $sub->id }}" class="link-spa favorites-item" style="text-decoration:none;display:block;border-radius:20px;transition:all 0.3s;border: 1px solid rgba(0,0,0,0.02);background: var(--neo-bg, #fff);overflow: hidden;box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="padding:24px;display:flex;align-items:center;gap:20px;position:relative;">
                        <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: linear-gradient(to bottom, #8b5cf6, #c4b5fd);"></div>
                        
                        <div style="width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;color:#8b5cf6;background:rgba(139,92,246,0.1);">
                            <i class='bx bx-file'></i>
                        </div>
                        
                        <div style="flex:1;min-width:0;">
                            <h4 style="margin:0 0 6px;font-size:16px;font-weight:800;color:#121212;text-transform:capitalize;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;letter-spacing:-0.2px;">{{ $sub->title }}</h4>
                            <p style="margin:0;font-size:12px;color:#888;font-weight:600;"><span style="color:#8b5cf6;opacity:0.8;">{{ $sub->materi->mainMateri->title ?? '-' }}</span> <span style="margin:0 4px;color:#ccc;">/</span> {{ $sub->materi->title ?? '-' }}</p>
                        </div>
                        
                        <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
                            <div class="fv-star-btn" style="width:36px;height:36px;border-radius:50%;background:rgba(245,158,11,0.1);display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorite(this);">
                                <i class="bx bxs-star archive-btn" data-id="{{ $sub->id }}" data-type="sub" style="color:#f59e0b;font-size:20px;cursor:pointer;filter:drop-shadow(0 2px 4px rgba(245,158,11,0.3));"></i>
                            </div>
                            <span class="neo-arrow" style="font-size:24px;color:#ccc;transition:all 0.3s;"><i class='bx bx-right-arrow-circle'></i></span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="neo-card neo-card-light" style="grid-column:1/-1;text-align:center;padding:80px 24px;border-radius:24px;box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                    <div style="width: 80px; height: 80px; background: rgba(0,0,0,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                        <i class='bx bx-file' style="font-size:40px;color:#ccc;"></i>
                    </div>
                    <p style="font-size:18px;font-weight:800;color:#121212;margin:0 0 8px;letter-spacing:-0.2px;">Belum ada sub materi favorit</p>
                    <p style="font-size:14px;color:#888;margin:0;">Tekan ikon <i class='bx bxs-star' style="color:#f59e0b;"></i> di halaman bacaan materi untuk menyimpannya di sini.</p>
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
                t.style.color = '#888'; 
                t.style.borderBottomColor = 'transparent';
                t.querySelector('.fv-tab-badge').style.background = 'rgba(0,0,0,0.05)'; 
                t.querySelector('.fv-tab-badge').style.color = '#888';
                t.querySelector('.fv-tab-badge').style.boxShadow = 'none';
            });
            tab.style.color = '#121212'; 
            tab.style.borderBottomColor = '#121212';
            tab.querySelector('.fv-tab-badge').style.background = 'linear-gradient(135deg, #121212, #2a2a2a)'; 
            tab.querySelector('.fv-tab-badge').style.color = '#fff';
            tab.querySelector('.fv-tab-badge').style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            
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
/* Favorites Items */
.favorites-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.06) !important;
    border-color: rgba(0,0,0,0.05) !important;
}
.favorites-item:hover .neo-arrow {
    color: #121212 !important;
    transform: translateX(4px) scale(1.1);
}
.fv-star-btn:hover {
    transform: scale(1.1);
    background: rgba(245,158,11,0.2) !important;
}

@media (max-width: 768px) {
    .fv-neo-list { 
        grid-template-columns: 1fr !important; 
        gap: 16px !important;
    }

    .favorites-item > div {
        padding: 16px !important;
        gap: 12px !important;
    }

    .favorites-item h4 {
        font-size: 14px !important;
    }

    .favorites-item p {
        font-size: 11px !important;
    }

    .favorites-item > div > div:nth-child(2) {
        width: 40px !important;
        height: 40px !important;
        font-size: 20px !important;
        border-radius: 10px !important;
    }

    .neo-arrow { display: none !important; }
}
</style>

<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: var(--neo-text-dark, #121212);">Catatan Saya</h2>
                <p style="font-size: 15px; color: var(--neo-text-dark, #888); margin: 4px 0 0;">Kumpulan catatan personal dari seluruh materi belajar.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(-5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-notepad' style="font-size: 28px; color: #8b5cf6;"></i>
            </div>
        </div>

        @if($groupedNotes->isEmpty())
            <div class="neo-card neo-card-light" style="padding: 60px 20px; text-align: center; border-radius: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.04);">
                <div style="width: 80px; height: 80px; background: rgba(0,0,0,0.03); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class='bx bx-notepad' style="font-size: 40px; color: var(--neo-text-dark, #ccc);"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--neo-text-dark, #121212); margin: 0 0 8px; letter-spacing: -0.2px;">Belum ada catatan</h3>
                <p style="font-size: 14px; color: var(--neo-text-dark, #888); margin: 0; max-width: 400px; margin: 0 auto; line-height: 1.5;">Kamu belum membuat catatan apapun. Buka materi dan gunakan panel catatan di sebelah kanan untuk mulai mencatat.</p>
                <a href="?page=dashboard" class="link-spa" data-page="dashboard" style="display: inline-flex; margin-top: 24px; padding: 12px 24px; text-decoration: none; background: linear-gradient(135deg, #121212, #2a2a2a); color: var(--text-primary); font-weight: 700; font-size: 14px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0,0,0,0.15); transition: transform 0.2s; border: 1px solid var(--border-color);" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                    Mulai Belajar
                </a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 32px;">
                @foreach($groupedNotes as $materiTitle => $notes)
                    <div style="background: rgba(0,0,0,0.01); border: 1px solid rgba(0,0,0,0.03); border-radius: 24px; padding: 24px;">
                        <h3 style="font-size: 18px; font-weight: 800; color: var(--neo-text-dark, #121212); margin: 0 0 20px; padding-bottom: 12px; border-bottom: 2px solid rgba(0,0,0,0.04); display: flex; align-items: center; gap: 10px; letter-spacing: -0.2px;">
                            <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(139,92,246,0.3);">
                                <i class='bx bx-folder' style="color: var(--text-primary); font-size: 16px;"></i>
                            </div>
                            {{ $materiTitle }}
                        </h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
                            @foreach($notes as $note)
                                <a href="?page=detail&submateri_id={{ $note->sub_materi_id }}" class="link-spa neo-card neo-card-light note-grid-card" data-page="detail&submateri_id={{ $note->sub_materi_id }}" style="padding: 24px; text-decoration: none; color: inherit; display: block; position: relative; overflow: hidden; border-radius: 20px; background: var(--neo-bg, #fff); border: 1px solid rgba(0,0,0,0.02);">
                                    <div style="position: absolute; top: 0; left: 0; width: 6px; height: 100%; background: linear-gradient(to bottom, #8b5cf6, #a78bfa);"></div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                                        <h4 class="note-title" style="font-size: 16px; font-weight: 800; color: var(--neo-text-dark, #121212); margin: 0; line-height: 1.3;">{{ $note->subMateri->title ?? 'Sub Materi' }}</h4>
                                        <span style="font-size: 10px; font-weight: 700; color: var(--neo-text-dark, #888); background: rgba(0,0,0,0.04); padding: 4px 10px; border-radius: 8px; white-space: nowrap;">{{ $note->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="note-content" style="font-size: 13px; color: var(--neo-text-dark, #666); line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; background: rgba(0,0,0,0.02); padding: 12px 16px; border-radius: 12px; font-family: 'Outfit', sans-serif;">
                                        {!! nl2br(e(Str::limit($note->content, 200))) !!}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

<style>
    .note-grid-card { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .note-grid-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.08) !important; border-color: rgba(0,0,0,0.05) !important; }
    
    @media (max-width: 768px) {
        .note-grid-card { padding: 20px !important; }
    }
</style>

<script>
window.__currentSearchHandler = function(query) {
    document.querySelectorAll('.note-grid-card').forEach(card => {
        const title = card.querySelector('.note-title')?.textContent.toLowerCase() || '';
        const content = card.querySelector('.note-content')?.textContent.toLowerCase() || '';
        if (title.includes(query) || content.includes(query)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
};
</script>

{{-- ═══════════════════════════════════════════════════════════════
SUB MATERI PAGE — Neo Bento Design (synced with Dashboard)
═══════════════════════════════════════════════════════════════ --}}
@php $subMateris = $subMateris ?? []; @endphp

<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        {{-- Back --}}
        <a href="?page=materi&main_id={{ $firstMateri->main_materi_id ?? '' }}" class="link-spa"
            style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#888;text-decoration:none;margin-bottom:24px;transition:color 0.2s;"
            onmouseover="this.style.color='#121212'" onmouseout="this.style.color='#888'">
            <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke
            {{ $firstMateri->mainMateri->title ?? 'Materi' }}
        </a>

        {{-- Hero Header --}}
        <div class="neo-card"
            style="min-height:180px;background:#121212;color:#fff;padding:40px;display:flex;align-items:center;margin-bottom:32px;position:relative;overflow:hidden;">
            <div style="position:absolute;right:0;top:0;width:40%;height:100%;pointer-events:none;z-index:1;">
                <img src="{{ asset('assets/ico/img001thumb03.jpg') }}" alt=""
                    style="width:100%;height:100%;object-fit:contain;opacity:0.15;filter:grayscale(100%);">
            </div>
            <div style="position:relative;z-index:2;width:100%;">
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                    <span class="neo-pill"
                        style="color:#fff;border-color:rgba(255,255,255,0.3);">{{ $firstMateri->mainMateri->title ?? 'Main' }}</span>
                    <span class="neo-pill"
                        style="color:#fff;border-color:rgba(255,255,255,0.3);">{{ $firstMateri->title ?? 'Bab' }}</span>
                    <span class="neo-pill"
                        style="color:#fff;border-color:rgba(255,255,255,0.3);">{{ count($subMateris) }} Sub
                        Materi</span>
                </div>
                <h3
                    style="font-size:clamp(28px,3.5vw,40px);font-weight:800;line-height:1.15;letter-spacing:-0.02em;color:#fff;margin:0 0 8px;">
                    {{ $firstMateri->title ?? 'Sub Materi' }}
                </h3>
                <p style="font-size:15px;color:#888;margin:0;">Gass pelajari semuanya! Kayaknya seru nih 🚀</p>
            </div>
        </div>

        {{-- Sub Materi List --}}
        <div style="margin-bottom:32px;">
            <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Daftar Sub Materi</h3>
            <p style="font-size:16px;color:#555;margin:0 0 24px;">Pelajari setiap topik secara mendalam.</p>

            <div style="display:flex;flex-direction:column;gap:16px;">
                @foreach ($subMateris as $i => $subMateri)
                    @php $isDone = in_array($subMateri->id, $completed ?? []); @endphp
                    <a href="?page=detail&submateri_id={{ $subMateri->id }}" class="link-spa"
                        style="text-decoration:none;display:block;">
                        <div class="neo-card neo-card-light sub-card-item"
                            style="padding:24px 32px;flex-direction:row;align-items:center;gap:20px;{{ $isDone ? 'border:2px solid rgba(16,185,129,0.4);' : '' }}">
                            {{-- Number --}}
                            <div
                                style="width:40px;height:40px;border-radius:12px;background:{{ $isDone ? '#ecfdf5' : 'rgba(0,0,0,0.06)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                @if($isDone)
                                    <i class='bx bx-check' style="font-size:20px;color:#10b981;"></i>
                                @else
                                    <span style="font-size:16px;font-weight:800;color:#888;">{{ $i + 1 }}</span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div style="flex:1;min-width:0;">
                                <h4
                                    style="margin:0 0 4px;font-size:16px;font-weight:700;color:#121212;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;">
                                    {{ $subMateri->title }}</h4>
                                <p
                                    style="margin:0;font-size:13px;color:#888;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ Str::limit(strip_tags($subMateri->content), 100) }}
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
                                <i class="bx {{ in_array($subMateri->id, $arsipSub ?? []) ? 'bxs-star' : 'bx-star' }} archive-btn"
                                    data-id="{{ $subMateri->id }}" data-type="sub"
                                    style="font-size:20px;color:{{ in_array($subMateri->id, $arsipSub ?? []) ? '#f59e0b' : '#ccc' }};cursor:pointer;z-index:5;"
                                    onclick="event.preventDefault();event.stopPropagation();"></i>
                                <span class="neo-arrow" style="font-size:24px;">&#x2197;</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
    window.__currentSearchHandler = function (query) {
        document.querySelectorAll('.sub-card-item').forEach(card => {
            const a = card.closest('a');
            const title = card.querySelector('h4')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('p')?.textContent.toLowerCase() || '';
            if (title.includes(query) || desc.includes(query)) { if (a) a.style.display = ''; }
            else { if (a) a.style.display = 'none'; }
        });
        if (query !== '') {
            const first = Array.from(document.querySelectorAll('.sub-card-item')).find(c => {
                const a = c.closest('a'); return a ? a.style.display !== 'none' : true;
            });
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

    body {
        background-color: var(--neo-bg) !important;
    }

    .neo-dashboard {
        background-color: var(--neo-bg);
        color: var(--neo-text-dark);
        font-family: 'Inter', sans-serif;
        padding: 32px 0;
        min-height: 100vh;
        width: 100%;
    }

    .neo-bento-container {
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    .neo-card {
        border-radius: var(--neo-radius);
        padding: 32px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s;
        max-width: 100%;
        box-sizing: border-box;
    }

    .neo-card:hover {
        transform: translateY(-4px);
    }

    .neo-card-light {
        background: var(--neo-card-light);
        color: var(--neo-text-dark);
    }

    .neo-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }

    .neo-title {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
        line-height: 1.25;
        letter-spacing: -0.03em;
    }

    .neo-arrow {
        font-size: 32px;
        font-weight: 400;
        line-height: 1;
        transition: transform 0.2s;
        margin-top: -4px;
    }

    .neo-card:hover .neo-arrow {
        transform: translate(2px, -2px);
    }

    .neo-pill {
        background: transparent;
        color: var(--neo-text-dark);
        border: 1px solid rgba(0, 0, 0, 0.3);
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
    }

    .neo-desc {
        font-size: 15px;
        color: #555;
        margin: 0;
        line-height: 1.5;
    }

    .sub-card-item {
        cursor: pointer;
    }

    @media (max-width:768px) {
        .neo-dashboard {
            padding: 24px 16px;
        }

        .neo-card {
            padding: 24px;
        }

        .sub-card-item {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
    }
</style>
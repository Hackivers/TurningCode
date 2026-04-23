{{-- ═══════════════════════════════════════════════════════════════
MATERI PAGE — Neo Bento Design (synced with Dashboard)
═══════════════════════════════════════════════════════════════ --}}
@php $progressData = $progressData ?? []; @endphp

<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        {{-- Back --}}
        <a href="?page=dashboard" class="link-spa" data-page="dashboard"
            style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#888;text-decoration:none;margin-bottom:24px;transition:color 0.2s;"
            onmouseover="this.style.color='#121212'" onmouseout="this.style.color='#888'">
            <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
        </a>

        {{-- Hero Header --}}
        <div class="neo-card"
            style="min-height:200px;background:#121212;color:#fff;padding:40px;display:flex;align-items:center;margin-bottom:32px;position:relative;overflow:hidden;">
            <div style="position:absolute;right:0;top:0;width:40%;height:100%;pointer-events:none;z-index:1;">
                <img src="{{ asset('assets/ico/img001thumb03.jpg') }}" alt=""
                    style="width:100%;height:100%;object-fit:contain;opacity:0.15;filter:grayscale(100%);">
            </div>
            <div style="position:relative;z-index:2;width:100%;">
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                    <span class="neo-pill"
                        style="color:#fff;border-color:rgba(255,255,255,0.3);">{{ $firstMateri->mainMateri->title ?? 'Materi' }}</span>
                    <span class="neo-pill"
                        style="color:#fff;border-color:rgba(255,255,255,0.3);">{{ $materis->count() }} Bab</span>
                </div>
                <h3
                    style="font-size:clamp(28px,3.5vw,40px);font-weight:800;line-height:1.15;letter-spacing:-0.02em;color:#fff;margin:0 0 8px;">
                    {{ $firstMateri->title ?? 'Materi' }}
                </h3>
                <p style="font-size:15px;color:#888;margin:0;">Yuk mulai dari fundamental dulu! Pelajari satu per satu
                    dari yang paling dasar.</p>
            </div>
        </div>

        {{-- Materi Grid --}}
        <div style="margin-bottom:32px;">
            <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Daftar Bab</h3>
            <p style="font-size:16px;color:#555;margin:0 0 24px;">Pilih bab yang ingin kamu pelajari.</p>

            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px;">
                @foreach ($materis as $materi)
                    @php
                        $done = $progressData[$materi->id]['done'] ?? 0;
                        $total = $progressData[$materi->id]['total'] ?? 0;
                        $isCompleted = $progressData[$materi->id]['completed'] ?? false;
                        $pct = $total > 0 ? round(($done / $total) * 100) : 0;
                    @endphp
                    <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa"
                        style="text-decoration:none;display:block;">
                        <div class="neo-card neo-card-light materi-card-item"
                            style="height:100%;justify-content:space-between;{{ $isCompleted ? 'border:2px solid rgba(16,185,129,0.4);' : '' }}">
                            <div>
                                <div class="neo-header">
                                    <h3 class="neo-title" style="max-width:80%;">{{ $materi->title }}</h3>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <i class="bx {{ in_array($materi->id, $arsipMateri ?? []) ? 'bxs-star' : 'bx-star' }} archive-btn"
                                            data-id="{{ $materi->id }}" data-type="materi"
                                            style="font-size:20px;color:{{ in_array($materi->id, $arsipMateri ?? []) ? '#f59e0b' : '#aaa' }};cursor:pointer;z-index:5;"
                                            onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorite(this);"></i>
                                        <span class="neo-arrow">&#x2197;</span>
                                    </div>
                                </div>
                                <p class="neo-desc" style="margin-bottom:20px;font-weight:500;">
                                    Gass belajar {{ $materi->title }}
                                </p>
                            </div>

                            {{-- Progress bar --}}
                            <div>
                                <div
                                    style="width:100%;height:4px;background:rgba(0,0,0,0.08);border-radius:4px;margin-bottom:12px;overflow:hidden;">
                                    <div
                                        style="width:{{ $pct }}%;height:100%;background:{{ $isCompleted ? '#10b981' : '#121212' }};border-radius:4px;transition:width 0.5s;">
                                    </div>
                                </div>
                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    <span class="neo-pill"
                                        style="{{ $isCompleted ? 'color:#10b981;border-color:#10b981;' : '' }}">
                                        {{ $isCompleted ? '✓ Selesai' : 'On Progress' }}
                                    </span>
                                    <span class="neo-pill">{{ $done }}/{{ $total }} Sub Materi</span>
                                </div>
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
        document.querySelectorAll('.materi-card-item').forEach(card => {
            const a = card.closest('a');
            const title = card.querySelector('.neo-title')?.textContent.toLowerCase() || '';
            if (title.includes(query)) { if (a) a.style.display = ''; else card.style.display = ''; }
            else { if (a) a.style.display = 'none'; else card.style.display = 'none'; }
        });
        if (query !== '') {
            const first = Array.from(document.querySelectorAll('.materi-card-item')).find(c => {
                const a = c.closest('a'); return a ? a.style.display !== 'none' : c.style.display !== 'none';
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

    @media (max-width:768px) {
        .neo-dashboard {
            padding: 24px 16px;
        }

        .neo-card {
            padding: 24px;
        }
    }
</style>
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

        {{-- Premium Hero Header --}}
        <div class="neo-card"
            style="min-height:240px;background:#0f0f13;color:#fff;padding:48px;display:flex;align-items:center;margin-bottom:40px;position:relative;overflow:hidden;border:1px solid var(--bg-tertiary);box-shadow:0 24px 48px rgba(0,0,0,0.2);">
            {{-- Background Gradient Orbs --}}
            <div
                style="position:absolute;top:-50%;left:-10%;width:350px;height:350px;background:radial-gradient(circle, rgba(139,92,246,0.25) 0%, rgba(0,0,0,0) 70%);border-radius:50%;filter:blur(40px);pointer-events:none;z-index:1;">
            </div>
            <div
                style="position:absolute;bottom:-50%;right:10%;width:450px;height:450px;background:radial-gradient(circle, rgba(236,72,153,0.15) 0%, rgba(0,0,0,0) 70%);border-radius:50%;filter:blur(60px);pointer-events:none;z-index:1;">
            </div>

            {{-- Grid Pattern Overlay --}}
            <div
                style="position:absolute;inset:0;background-image:radial-gradient(var(--border-color) 1px, transparent 1px);background-size:24px 24px;opacity:0.4;z-index:1;pointer-events:none;">
            </div>

            <div style="position:relative;z-index:2;width:100%;max-width:700px;">
                <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
                    <span class="neo-pill"
                        style="color:#fff;background:var(--bg-tertiary);border-color:var(--border-color);backdrop-filter:blur(10px);font-weight:700;letter-spacing:1px;text-transform:uppercase;font-size:11px;padding:8px 16px;">
                        <i class='bx bx-category' style="margin-right:4px;"></i>
                        {{ $firstMateri->mainMateri->title ?? 'Materi Utama' }}
                    </span>
                    <span class="neo-pill"
                        style="color:#fff;background:var(--bg-tertiary);border-color:var(--border-color);backdrop-filter:blur(10px);font-weight:700;letter-spacing:1px;text-transform:uppercase;font-size:11px;padding:8px 16px;">
                        <i class='bx bx-book-content' style="margin-right:4px;"></i> {{ $materis->count() }} Bab
                        Pembelajaran
                    </span>
                </div>
                <h3
                    style="font-size:clamp(32px,4vw,48px);font-weight:900;line-height:1.15;letter-spacing:-0.03em;margin:0 0 16px;background:linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                    {{ $firstMateri->title ?? 'Eksplorasi Materi' }}
                </h3>
                <p style="font-size:16px;color:var(--text-secondary);margin:0;line-height:1.6;font-weight:500;">
                    Perluas wawasanmu dan kuasai konsep fundamental dari topik ini. Siapkan dirimu untuk melangkah ke
                    tingkat pemahaman berikutnya!
                </p>
            </div>

            {{-- Abstract Decorative Icon --}}
            <div
                style="position:absolute;right:8%;top:50%;transform:translateY(-50%) rotate(-10deg);z-index:2;pointer-events:none;opacity:0.5;">
                <i class='bx bxs-compass'
                    style="font-size:180px;color:rgba(255,255,255,0.03);filter:drop-shadow(0 20px 40px rgba(0,0,0,0.5));"></i>
            </div>
        </div>

        {{-- Materi Grid --}}
        <div style="margin-bottom:32px;">
            <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color: var(--text-primary)fff;">Daftar Bab</h3>
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
        --neo-bg: transparent;
        --neo-card-light: rgba(255, 255, 255, 0.03);
        --neo-radius: 16px;
        --neo-text-dark: #ffffff;
    }

    body { background-color: var(--bg-secondary) !important; }

    .neo-dashboard {
        background-color: var(--neo-bg);
        color: var(--neo-text-dark);
        font-family: 'Outfit', sans-serif;
        padding: 32px 0;
        min-height: 100vh;
        width: 100%;
    }

    .neo-bento-container {
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        box-sizing: border-box;
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
            padding: 16px 0;
            overflow-x: hidden;
        }

        .neo-bento-container {
            padding: 0 16px;
            box-sizing: border-box;
            max-width: 100vw;
        }

        .neo-card {
            padding: 20px !important;
            border-radius: 20px !important;
        }

        /* Hero header compression */
        .neo-card[style*="min-height:240px"] {
            min-height: 160px !important;
            padding: 24px 20px !important;
            margin-bottom: 24px !important;
        }

        .neo-card[style*="min-height:240px"] h3 {
            font-size: 24px !important;
        }

        .neo-card[style*="min-height:240px"] p {
            font-size: 13px !important;
        }

        .neo-card[style*="min-height:240px"] .neo-pill {
            font-size: 9px !important;
            padding: 6px 10px !important;
        }

        /* Decorative icon hide on mobile */
        .neo-card[style*="min-height:240px"]>div[style*="right:8%"] {
            display: none !important;
        }

        /* Section title */
        .neo-title[style*="font-size:28px"] {
            font-size: 20px !important;
        }

        /* Grid */
        div[style*="grid-template-columns:repeat(auto-fill,minmax(320px"] {
            grid-template-columns: 1fr !important;
            gap: 12px !important;
        }

        .materi-card-item {
            padding: 16px !important;
            border-radius: 16px !important;
        }

        .materi-card-item .neo-header {
            margin-bottom: 12px;
        }

        .materi-card-item .neo-title {
            font-size: 16px !important;
        }

        .materi-card-item .neo-desc {
            font-size: 13px !important;
            margin-bottom: 12px !important;
        }

        .materi-card-item .neo-pill {
            font-size: 11px !important;
            padding: 4px 12px !important;
        }

        .materi-card-item .neo-arrow {
            font-size: 24px !important;
        }

        /* Back link */
        a[style*="margin-bottom:24px"][style*="font-size:14px"] {
            font-size: 12px !important;
            margin-bottom: 16px !important;
        }
    }
</style>
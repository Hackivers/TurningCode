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

        {{-- Premium Hero Header --}}
        <div class="neo-card" style="min-height:240px;background:#0f0f13;color:#fff;padding:48px;display:flex;align-items:center;margin-bottom:40px;position:relative;overflow:hidden;border:1px solid rgba(255,255,255,0.05);box-shadow:0 24px 48px rgba(0,0,0,0.2);">
            {{-- Background Gradient Orbs --}}
            <div style="position:absolute;top:-50%;left:-10%;width:350px;height:350px;background:radial-gradient(circle, rgba(139,92,246,0.25) 0%, rgba(0,0,0,0) 70%);border-radius:50%;filter:blur(40px);pointer-events:none;z-index:1;"></div>
            <div style="position:absolute;bottom:-50%;right:10%;width:450px;height:450px;background:radial-gradient(circle, rgba(236,72,153,0.15) 0%, rgba(0,0,0,0) 70%);border-radius:50%;filter:blur(60px);pointer-events:none;z-index:1;"></div>
            
            {{-- Grid Pattern Overlay --}}
            <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);background-size:24px 24px;opacity:0.4;z-index:1;pointer-events:none;"></div>
            
            <div style="position:relative;z-index:2;width:100%;max-width:700px;">
                <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
                    <span class="neo-pill" style="color:#fff;background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.1);backdrop-filter:blur(10px);font-weight:700;letter-spacing:1px;text-transform:uppercase;font-size:11px;padding:8px 16px;">
                        <i class='bx bx-category' style="margin-right:4px;"></i> {{ $firstMateri->mainMateri->title ?? 'Main' }}
                    </span>
                    <span class="neo-pill" style="color:#fff;background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.1);backdrop-filter:blur(10px);font-weight:700;letter-spacing:1px;text-transform:uppercase;font-size:11px;padding:8px 16px;">
                        <i class='bx bx-book-content' style="margin-right:4px;"></i> {{ $firstMateri->title ?? 'Bab' }}
                    </span>
                    <span class="neo-pill" style="color:#fff;background:rgba(255,255,255,0.05);border-color:rgba(255,255,255,0.1);backdrop-filter:blur(10px);font-weight:700;letter-spacing:1px;text-transform:uppercase;font-size:11px;padding:8px 16px;">
                        <i class='bx bx-list-ul' style="margin-right:4px;"></i> {{ count($subMateris) }} Sub Materi
                    </span>
                </div>
                <h3 style="font-size:clamp(32px,4vw,48px);font-weight:900;line-height:1.15;letter-spacing:-0.03em;margin:0 0 16px;background:linear-gradient(135deg, #ffffff 0%, #a5b4fc 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                    {{ $firstMateri->title ?? 'Daftar Sub Materi' }}
                </h3>
                <p style="font-size:16px;color:rgba(255,255,255,0.6);margin:0;line-height:1.6;font-weight:500;">
                    Gass pelajari semuanya! Jelajahi setiap topik secara mendalam dan tingkatkan pemahamanmu. 🚀
                </p>
            </div>
            
            {{-- Abstract Decorative Icon --}}
            <div style="position:absolute;right:8%;top:50%;transform:translateY(-50%) rotate(10deg);z-index:2;pointer-events:none;opacity:0.5;">
                <i class='bx bxs-bulb' style="font-size:180px;color:rgba(255,255,255,0.03);filter:drop-shadow(0 20px 40px rgba(0,0,0,0.5));"></i>
            </div>
        </div>

        {{-- Sub Materi List --}}
        <div style="margin-bottom:32px;">
            <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Daftar Sub Materi</h3>
            <p style="font-size:16px;color:#555;margin:0 0 24px;">Pelajari setiap topik secara mendalam.</p>

            <div style="display:flex;flex-direction:column;gap:16px;">
                @foreach ($subMateris as $i => $subMateri)
                    @php 
                        $isDone = in_array($subMateri->id, $completed ?? []); 
                        $qCount = $questionCounts[$subMateri->id] ?? 0;
                        
                        // Parse JSON sections to get "bab" blocks
                        $sections = is_string($subMateri->sections_json) 
                                        ? json_decode($subMateri->sections_json, true) 
                                        : (is_array($subMateri->sections) ? $subMateri->sections : []);
                        if (!is_array($sections)) $sections = [];
                        
                        $babs = collect($sections)->where('type', 'bab')->values();
                        $totalBabs = count($babs);
                        $hasAccordion = $totalBabs > 0 || $qCount > 0;
                    @endphp
                    
                    <div class="neo-card neo-card-light sub-card-item" style="padding:24px 32px;{{ $isDone ? 'border:2px solid rgba(16,185,129,0.4);' : '' }}">
                        <div style="display:flex;flex-direction:row;align-items:flex-start;gap:20px;">
                            {{-- Number --}}
                            <div style="width:40px;height:40px;border-radius:12px;background:{{ $isDone ? '#ecfdf5' : 'rgba(0,0,0,0.06)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                @if($isDone)
                                    <i class='bx bx-check' style="font-size:20px;color:#10b981;"></i>
                                @else
                                    <span style="font-size:16px;font-weight:800;color:#888;">{{ $i + 1 }}</span>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div style="flex:1;min-width:0;">
                                <a href="?page=detail&submateri_id={{ $subMateri->id }}" class="link-spa" style="text-decoration:none;">
                                    <h4 style="margin:0 0 4px;font-size:18px;font-weight:700;color:#121212;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;">{{ $subMateri->title }}</h4>
                                    <p style="margin:0 0 16px;font-size:14px;color:#666;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $subMateri->subtitle ?? Str::limit(strip_tags($subMateri->content), 100) }}</p>
                                </a>
                                
                                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                                    @if($hasAccordion)
                                        <button class="btn-primary" onclick="toggleBabList('sub-{{ $subMateri->id }}')" style="display:inline-flex;align-items:center;gap:6px;background:#121212;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                            Urutan Belajar <i class='bx bx-chevron-down' id="icon-sub-{{ $subMateri->id }}" style="transition:transform 0.3s;"></i>
                                        </button>
                                    @endif
                                    
                                    @if($qCount > 0)
                                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:12px;font-weight:600;color:#f59e0b;background:rgba(245,158,11,0.1);padding:8px 12px;border-radius:8px;">
                                            <i class='bx bx-trophy'></i> Ada Quiz
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
                                <i class="bx {{ in_array($subMateri->id, $arsipSub ?? []) ? 'bxs-star' : 'bx-star' }} archive-btn"
                                    data-id="{{ $subMateri->id }}" data-type="sub"
                                    style="font-size:20px;color:{{ in_array($subMateri->id, $arsipSub ?? []) ? '#f59e0b' : '#ccc' }};cursor:pointer;z-index:5;"
                                    onclick="event.preventDefault(); event.stopPropagation(); window.toggleFavorite(this);"></i>
                            </div>
                        </div>
                        
                        {{-- Timeline Accordion for Babs --}}
                        @if($hasAccordion)
                            <div id="bab-list-sub-{{ $subMateri->id }}" class="bab-timeline-container" style="display:none;margin-top:20px;padding-top:20px;border-top:1px solid rgba(0,0,0,0.06);">
                                <div style="position:relative;padding-left:16px;">
                                    <div style="position:absolute;left:23px;top:20px;bottom:20px;width:2px;background:rgba(0,0,0,0.1);z-index:1;"></div>
                                    
                                    <div style="display:flex;flex-direction:column;gap:0;">
                                        {{-- Render Babs --}}
                                        @php
                                            $history = $histories->get($subMateri->id);
                                            $completedBabs = $history && is_array($history->completed_babs) ? $history->completed_babs : [];
                                        @endphp
                                        
                                        @foreach($babs as $bIndex => $bab)
                                            @php
                                                $isBabUnlocked = $bIndex === 0;
                                                if ($bIndex > 0) {
                                                    $prevBabId = $babs[$bIndex - 1]['order'] ?? '';
                                                    $isBabUnlocked = in_array($prevBabId, $completedBabs);
                                                }
                                                if (in_array($bab['order'] ?? '', $completedBabs)) {
                                                    $isBabUnlocked = true;
                                                }
                                            @endphp
                                            
                                            @if($isBabUnlocked)
                                                <a href="?page=detail&submateri_id={{ $subMateri->id }}&bab_id={{ $bab['order'] ?? '' }}" class="link-spa" style="text-decoration:none;display:block;position:relative;z-index:2;padding:12px 0;transition:transform 0.2s;" onmouseover="this.style.transform='translateX(6px)'" onmouseout="this.style.transform='translateX(0)'">
                                                    <div style="display:flex;align-items:center;gap:16px;">
                                                        <div style="width:16px;height:16px;border-radius:50%;background:#fff;border:2px solid #8b5cf6;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 0 4px var(--neo-card-light);"></div>
                                                        <div style="flex:1;">
                                                            <h4 style="margin:0;font-size:14px;font-weight:600;color:#444;">{{ $bab['content'] ?? 'Bab ' . ($bIndex + 1) }}</h4>
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <div style="display:block;position:relative;z-index:2;padding:12px 0;opacity:0.6;cursor:not-allowed;">
                                                    <div style="display:flex;align-items:center;gap:16px;">
                                                        <div style="width:16px;height:16px;border-radius:50%;background:#f3f4f6;border:2px solid #d1d5db;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 0 4px var(--neo-card-light);">
                                                            <i class='bx bx-lock-alt' style="font-size:10px;color:#9ca3af;"></i>
                                                        </div>
                                                        <div style="flex:1;">
                                                            <h4 style="margin:0;font-size:14px;font-weight:600;color:#9ca3af;">{{ $bab['content'] ?? 'Bab ' . ($bIndex + 1) }} <span style="font-size:11px;font-weight:500;">(Terkunci)</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        {{-- Render Quiz if any --}}
                                        @if($qCount > 0)
                                            @php
                                                $isQuizUnlocked = true;
                                                if ($totalBabs > 0) {
                                                    $lastBabId = $babs[$totalBabs - 1]['order'] ?? '';
                                                    $isQuizUnlocked = in_array($lastBabId, $completedBabs);
                                                }
                                            @endphp
                                            @if($isQuizUnlocked)
                                                <a href="?page=detail&submateri_id={{ $subMateri->id }}&auto_quiz=1" class="link-spa" style="text-decoration:none;display:block;position:relative;z-index:2;padding:12px 0;transition:transform 0.2s;" onmouseover="this.style.transform='translateX(6px)'" onmouseout="this.style.transform='translateX(0)'">
                                                    <div style="display:flex;align-items:center;gap:16px;">
                                                        <div style="width:16px;height:16px;border-radius:50%;background:#f59e0b;border:2px solid #f59e0b;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 0 4px var(--neo-card-light);"></div>
                                                        <div style="flex:1;">
                                                            <h4 style="margin:0;font-size:14px;font-weight:700;color:#d97706;">Quiz ({{ $qCount }} Soal)</h4>
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <div style="display:block;position:relative;z-index:2;padding:12px 0;opacity:0.6;cursor:not-allowed;">
                                                    <div style="display:flex;align-items:center;gap:16px;">
                                                        <div style="width:16px;height:16px;border-radius:50%;background:#f3f4f6;border:2px solid #d1d5db;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 0 4px var(--neo-card-light);">
                                                            <i class='bx bx-lock-alt' style="font-size:10px;color:#9ca3af;"></i>
                                                        </div>
                                                        <div style="flex:1;">
                                                            <h4 style="margin:0;font-size:14px;font-weight:700;color:#9ca3af;">Quiz ({{ $qCount }} Soal) <span style="font-size:11px;font-weight:500;">(Terkunci)</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
    function toggleBabList(babId) {
        const list = document.getElementById('bab-list-' + babId);
        const icon = document.getElementById('icon-' + babId);
        
        if (list.style.display === 'none' || !list.style.display) {
            list.style.display = 'block';
            list.animate([
                { opacity: 0, transform: 'translateY(-10px)' },
                { opacity: 1, transform: 'translateY(0)' }
            ], { duration: 300, easing: 'ease-out' });
            icon.style.transform = 'rotate(180deg)';
        } else {
            const animation = list.animate([
                { opacity: 1, transform: 'translateY(0)' },
                { opacity: 0, transform: 'translateY(-10px)' }
            ], { duration: 200, easing: 'ease-in' });
            
            animation.onfinish = () => {
                list.style.display = 'none';
            };
            icon.style.transform = 'rotate(0deg)';
        }
    }

    window.__currentSearchHandler = function (query) {
        document.querySelectorAll('.sub-card-item').forEach(card => {
            const a = card; // it is an <a> tag now
            const title = card.querySelector('h4')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('p')?.textContent.toLowerCase() || '';
            if (title.includes(query) || desc.includes(query)) { a.style.display = 'block'; }
            else { a.style.display = 'none'; }
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

    .sub-card-item {
        cursor: pointer;
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
        .neo-card[style*="min-height:240px"] > div[style*="right:8%"] {
            display: none !important;
        }
        /* Section title */
        .neo-title[style*="font-size:28px"] {
            font-size: 20px !important;
        }
        /* Sub-materi list */
        div[style*="flex-direction:column;gap:16px"] {
            gap: 10px !important;
        }
        .sub-card-item {
            flex-direction: column !important;
            align-items: flex-start !important;
            padding: 16px !important;
            border-radius: 16px !important;
            gap: 12px !important;
        }
        .sub-card-item h4 {
            font-size: 14px !important;
        }
        .sub-card-item p {
            font-size: 12px !important;
        }
        .sub-card-item div[style*="width:40px"] {
            width: 32px !important;
            height: 32px !important;
            border-radius: 10px !important;
        }
        .sub-card-item div[style*="width:40px"] span {
            font-size: 14px !important;
        }
        .sub-card-item .neo-arrow {
            font-size: 20px !important;
        }
        /* Back link */
        a[style*="margin-bottom:24px"][style*="font-size:14px"] {
            font-size: 12px !important;
            margin-bottom: 16px !important;
        }
    }
</style>
{{-- ═══════════════════════════════════════════════════════════════
SELECT MAIN MATERI — Onboarding Page
═══════════════════════════════════════════════════════════════ --}}

<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        {{-- Hero Section --}}
        <div class="smm-hero">
            <div class="smm-hero-orb smm-hero-orb-1"></div>
            <div class="smm-hero-orb smm-hero-orb-2"></div>
            <div class="smm-hero-grid-pattern"></div>

            <div class="smm-hero-content">
                <div class="smm-hero-badge">
                    <i class='bx bxs-rocket'></i>
                    <span>Langkah Pertama</span>
                </div>
                <h1 class="smm-hero-title">Pilih Jalur Belajarmu</h1>
                <p class="smm-hero-desc">
                    Selamat datang di TurnCode! Pilih satu jalur keahlian yang ingin kamu kuasai terlebih dahulu.
                    Kamu bisa mengganti pilihan ini kapan saja nanti.
                </p>
            </div>
        </div>

        {{-- Main Materi Grid --}}
        <div class="smm-grid-section">
            <div class="smm-grid">
                @foreach($mainMateris as $main)
                    <div class="smm-card {{ $main->status === 'coming_soon' ? 'smm-card-disabled' : '' }}"
                         data-main-id="{{ $main->id }}"
                         onclick="{{ $main->status !== 'coming_soon' ? 'selectMainMateri(' . $main->id . ', this)' : '' }}">
                        
                        {{-- Background Image --}}
                        <div class="smm-card-bg" style="background-image: url('{{ asset('assets/img/img00' . (($loop->iteration % 3) + 1) . 'non.jpg') }}');"></div>
                        
                        {{-- Overlay --}}
                        <div class="smm-card-overlay">
                            <div class="smm-card-content">
                                {{-- Status badge --}}
                                @if($main->status === 'coming_soon')
                                    <span class="smm-badge smm-badge-soon">
                                        <i class='bx bx-time'></i> Segera Hadir
                                    </span>
                                @else
                                    <span class="smm-badge smm-badge-ready">
                                        <i class='bx bx-check-circle'></i> Tersedia
                                    </span>
                                @endif

                                {{-- Title --}}
                                <h3 class="smm-card-title">{{ $main->title }}</h3>
                                <p class="smm-card-desc">
                                    {{ \Illuminate\Support\Str::limit($main->description ?? 'Modul pembelajaran interaktif terstruktur.', 100) }}
                                </p>

                                {{-- Stats --}}
                                <div class="smm-card-stats">
                                    <span><i class='bx bx-book-content'></i> {{ $main->materis_count }} Materi</span>
                                    <span><i class='bx bx-layer'></i> {{ $main->total_sub ?? 0 }} Bab</span>
                                </div>

                                {{-- CTA --}}
                                <div class="smm-card-cta">
                                    {{ $main->status === 'coming_soon' ? 'Segera Hadir' : 'Pilih Jalur Ini' }}
                                    @if($main->status !== 'coming_soon')
                                        <i class='bx bx-right-arrow-alt'></i>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Loading overlay --}}
                        <div class="smm-card-loading" id="smm-loading-{{ $main->id }}">
                            <div class="smm-spinner"></div>
                            <span>Menyiapkan jalur belajar...</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
    async function selectMainMateri(mainId, cardEl) {
        // Disable all cards
        document.querySelectorAll('.smm-card').forEach(c => c.style.pointerEvents = 'none');
        
        // Show loading on clicked card
        const loadingEl = document.getElementById('smm-loading-' + mainId);
        if (loadingEl) loadingEl.classList.add('active');
        cardEl.classList.add('smm-card-selected');

        try {
            const res = await fetch('/app/api/select-main-materi', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ main_materi_id: mainId })
            });

            const data = await res.json();

            if (data.success) {
                // Navigate to dashboard
                if (typeof loadPage === 'function') {
                    loadPage('dashboard', true);
                } else {
                    window.location.href = '/app?page=dashboard';
                }
            } else {
                throw new Error(data.message || 'Gagal menyimpan pilihan');
            }
        } catch (error) {
            alert(error.message);
            // Re-enable cards
            document.querySelectorAll('.smm-card').forEach(c => c.style.pointerEvents = '');
            if (loadingEl) loadingEl.classList.remove('active');
            cardEl.classList.remove('smm-card-selected');
        }
    }
</script>

<style>
    /* ═══ HERO SECTION ═══ */
    .smm-hero {
        position: relative;
        background: #0f0f13;
        border-radius: 32px;
        padding: 64px 48px;
        margin-bottom: 48px;
        overflow: hidden;
        border: 1px solid var(--bg-tertiary);
    }

    .smm-hero-orb-1 {
        position: absolute;
        top: -40%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139,92,246,0.3) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(60px);
        pointer-events: none;
    }

    .smm-hero-orb-2 {
        position: absolute;
        bottom: -40%;
        right: 5%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(236,72,153,0.2) 0%, transparent 70%);
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
    }

    .smm-hero-grid-pattern {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
        background-size: 24px 24px;
        opacity: 0.5;
        pointer-events: none;
    }

    .smm-hero-content {
        position: relative;
        z-index: 2;
        max-width: 640px;
    }

    .smm-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.08);
        border: 1px solid var(--border-color);
        backdrop-filter: blur(10px);
        padding: 10px 20px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 24px;
    }

    .smm-hero-badge i {
        font-size: 16px;
        color: #a78bfa;
    }

    .smm-hero-title {
        font-size: clamp(36px, 5vw, 56px);
        font-weight: 900;
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin: 0 0 20px;
        background: linear-gradient(135deg, #ffffff 0%, #a5b4fc 50%, #c084fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .smm-hero-desc {
        font-size: 16px;
        color: rgba(255,255,255,0.55);
        margin: 0;
        line-height: 1.7;
        font-weight: 500;
    }

    /* ═══ GRID SECTION ═══ */
    .smm-grid-section {
        margin-bottom: 48px;
    }

    .smm-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 28px;
    }

    /* ═══ CARD ═══ */
    .smm-card {
        position: relative;
        width: 100%;
        height: 480px;
        border-radius: 28px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    }

    .smm-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    }

    .smm-card-disabled {
        opacity: 0.5;
        cursor: not-allowed;
        filter: grayscale(100%);
    }

    .smm-card-disabled:hover {
        transform: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
    }

    .smm-card-selected {
        transform: scale(0.97) !important;
        box-shadow: 0 0 0 4px rgba(139,92,246,0.5), 0 20px 40px rgba(0,0,0,0.2) !important;
    }

    .smm-card-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        background-color: #2a2a2a;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .smm-card:hover .smm-card-bg {
        transform: scale(1.06);
    }

    .smm-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom,
            rgba(15,15,19,0) 0%,
            rgba(15,15,19,0.15) 30%,
            rgba(15,15,19,0.8) 65%,
            rgba(15,15,19,0.97) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 36px 28px 28px;
    }

    .smm-card-content {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .smm-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        width: fit-content;
        backdrop-filter: blur(8px);
    }

    .smm-badge-ready {
        background: rgba(16,185,129,0.2);
        color: #6ee7b7;
        border: 1px solid rgba(16,185,129,0.3);
    }

    .smm-badge-soon {
        background: rgba(245,158,11,0.2);
        color: #fcd34d;
        border: 1px solid rgba(245,158,11,0.3);
    }

    .smm-card-title {
        margin: 0;
        color: var(--text-primary);
        font-size: 26px;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .smm-card-desc {
        margin: 0;
        color: var(--text-muted);
        font-size: 14px;
        line-height: 1.6;
        font-weight: 500;
    }

    .smm-card-stats {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .smm-card-stats span {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .smm-card-stats i {
        font-size: 15px;
        color: var(--text-muted);
    }

    .smm-card-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--text-primary)fff;
        color: #0f0f13;
        font-size: 15px;
        font-weight: 700;
        padding: 16px 0;
        border-radius: 22px;
        margin-top: 6px;
        transition: background 0.3s, transform 0.2s;
    }

    .smm-card:hover .smm-card-cta {
        background: #f0f0f0;
    }

    .smm-card-cta i {
        font-size: 20px;
        transition: transform 0.3s;
    }

    .smm-card:hover .smm-card-cta i {
        transform: translateX(4px);
    }

    /* ═══ LOADING OVERLAY ═══ */
    .smm-card-loading {
        position: absolute;
        inset: 0;
        background: rgba(15,15,19,0.85);
        backdrop-filter: blur(8px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        z-index: 10;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s;
    }

    .smm-card-loading.active {
        opacity: 1;
        pointer-events: auto;
    }

    .smm-card-loading span {
        color: rgba(255,255,255,0.7);
        font-size: 14px;
        font-weight: 600;
    }

    .smm-spinner {
        width: 36px;
        height: 36px;
        border: 3px solid rgba(255,255,255,0.15);
        border-top-color: #a78bfa;
        border-radius: 50%;
        animation: smm-spin 0.8s linear infinite;
    }

    @keyframes smm-spin {
        to { transform: rotate(360deg); }
    }

    /* ═══ MOBILE ═══ */
    @media (max-width: 768px) {
        .smm-hero {
            padding: 40px 24px;
            border-radius: 24px;
            margin-bottom: 32px;
        }

        .smm-hero-title {
            font-size: 28px !important;
        }

        .smm-hero-desc {
            font-size: 14px;
        }

        .smm-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .smm-card {
            height: 360px;
            border-radius: 22px;
        }

        .smm-card-title {
            font-size: 20px;
        }

        .smm-card-overlay {
            padding: 24px 20px 20px;
        }

        .smm-card-cta {
            padding: 14px 0;
            font-size: 14px;
            border-radius: 16px;
        }
    }
</style>

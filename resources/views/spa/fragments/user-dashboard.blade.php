<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">
        <!-- Top Bento Grid -->
        <div class="neo-bento-grid">
            <!-- Left Tall Column -->
            <div class="neo-bento-col">
                @include('spa.fragments.user-expCard')
            </div>
            
            <!-- Right Column -->
            <div class="neo-bento-right">
                <div class="neo-bento-top-row">
                    @include('spa.fragments.user-progres', ['mainMateri' => $mainMateri])
                </div>
                <!-- Bottom Black Card -->
                <div style="flex: 1; display:flex;">
                    @include('spa.fragments.user-timeCard')
                </div>
            </div>
        </div>

        <!-- Section separating bottom -->
        <div class="neo-materi-section" style="margin-top: 48px;">
            @include('spa.fragments.user-materiCard', ['data' => $data, 'mainMateri' => $mainMateri])
        </div>

        <!-- Leaderboard Section -->
        <div class="neo-leaderboard-section">
            @include('spa.fragments.user-leaderboard')
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    :root {
        --neo-bg: #ececec;
        --neo-card-light: #e5e5e5;
        --neo-card-black: #000000;
        --neo-text-dark: #121212;
        --neo-text-light: #ffffff;
        --neo-radius: 32px;
    }

    body {
        background-color: var(--neo-bg) !important;
        overflow-x: hidden;
    }

    .neo-dashboard *, .neo-dashboard *::before, .neo-dashboard *::after {
        box-sizing: border-box;
    }

    .neo-dashboard {
        background-color: var(--neo-bg);
        color: var(--neo-text-dark);
        font-family: 'Inter', sans-serif;
        padding: 32px 0; /* Let rtd container handle left/right spacing so it perfectly lines up with the sidebar & header */
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
    }

    .neo-bento-container {
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    .neo-bento-grid {
        display: grid;
        grid-template-columns: 1fr 2fr; /* Mathematically perfect 1:2 layout ratio */
        gap: 24px;
        margin-bottom: 24px;
        width: 100%;
    }

    @media (max-width: 1024px) {
        .neo-bento-grid {
            grid-template-columns: 1fr;
        }
    }

    .neo-card {
        border-radius: var(--neo-radius);
        padding: 32px;
        position: relative;
        overflow: hidden;
        text-decoration: none;
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

    .neo-card-black {
        background: var(--neo-card-black);
        color: var(--neo-text-light);
    }

    .neo-bento-right {
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-width: 0;
    }

    .neo-bento-top-row {
        display: grid;
        grid-template-columns: 1fr 1fr; /* Strictly force 2 square cells for perfect balance */
        gap: 24px;
        width: 100%;
    }

    @media (max-width: 768px) {
        .neo-bento-top-row {
            grid-template-columns: 1fr;
        }
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
        border: 1px solid rgba(0,0,0,0.3);
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
    }
    
    .neo-card-black .neo-pill {
        background: transparent;
        color: var(--neo-text-light);
        border-color: rgba(255,255,255,0.4);
    }

    .neo-desc {
        font-size: 15px;
        color: #555;
        margin: 0;
        line-height: 1.5;
    }
    
    .neo-card-black .neo-desc {
        color: #aaa;
    }

    @media (max-width: 768px) {
        .neo-dashboard {
            padding: 24px 16px;
        }
        .neo-card {
            padding: 24px;
        }
    }
</style>

<script>
    (function () {
        // ── Cleanup previous interval (SPA re-navigation) ─────────────
        if (window._dashboardClockInterval) {
            clearInterval(window._dashboardClockInterval);
            window._dashboardClockInterval = null;
        }

        // ── Asset base URL ─────────────────────────────────────────────
        const assetBase = "{{ asset('assets/img') }}";

        // ── All cloud images in order (pagi → tengah malam) ────────────
        const cloudImages = [
            'img001cloud',   // 0 — pagi         (05–10)
            'img002cloud',   // 1 — siang        (11–14)
            'img003cloud',   // 2 — sore         (15–17)
            'img004cloud',   // 3 — malam        (18–22)
            'img005cloud',   // 4 — tengah malam (23–04)
        ];

        function getTimeIndex(h) {
            if (h >= 5 && h < 11) return 0;
            if (h >= 11 && h < 15) return 1;
            if (h >= 15 && h < 18) return 2;
            if (h >= 18 && h < 23) return 3;
            return 4;
        }

        // ── Indonesian locale ──────────────────────────────────────────
        const hariNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // ── Clock update ───────────────────────────────────────────────
        let currentTimeIndex = -1;
        let introFinished = false;

        function updateClock() {
            const now = new Date();
            const h = now.getHours();
            const hour = document.getElementById('hour');
            const minute = document.getElementById('minute');
            const dayLabel = document.getElementById('day-label');
            const dateLabel = document.getElementById('date-label');

            if (hour) hour.textContent = String(h).padStart(2, '0');
            if (minute) minute.textContent = String(now.getMinutes()).padStart(2, '0');
            if (dayLabel) dayLabel.textContent = hariNames[now.getDay()] + ' ' + now.getDate();
            if (dateLabel) dateLabel.textContent = now.getDate() + ', ' + bulanNames[now.getMonth()] + ', ' + now.getFullYear();

            // After intro is done, handle real-time changes
            if (introFinished) {
                const idx = getTimeIndex(h);
                if (idx !== currentTimeIndex) {
                    currentTimeIndex = idx;
                    crossFade(cloudImages[idx]);
                }
            }
        }

        // ── Cross-fade between img1 and img2 ───────────────────────────
        function crossFade(key) {
            const img1 = document.getElementById('img1');
            const img2 = document.getElementById('img2');
            if (!img1 || !img2) return;

            const newSrc = assetBase + '/' + key + '.png';
            const isImg1Active = img1.classList.contains('active');
            const incoming = isImg1Active ? img2 : img1;
            const outgoing = isImg1Active ? img1 : img2;

            incoming.src = newSrc;
            incoming.onload = () => {
                incoming.classList.add('active');
                outgoing.classList.remove('active');
            };
        }

        // ── Intro transition sequence ──────────────────────────────────
        function playIntroSequence() {
            const img1 = document.getElementById('img1');
            const img2 = document.getElementById('img2');
            if (!img1 || !img2) return;

            const h = new Date().getHours();
            const targetIdx = getTimeIndex(h);
            const startIdx = 4; // tengah malam
            const delay = 900;

            const dayOrder = [4, 0, 1, 2, 3];

            const startPos = dayOrder.indexOf(startIdx);
            const targetPos = dayOrder.indexOf(targetIdx);
            const sequence = [];

            for (let i = startPos; i <= targetPos; i++) {
                sequence.push(dayOrder[i]);
            }

            img1.classList.add('active');
            img2.classList.remove('active');
            currentTimeIndex = startIdx;

            if (sequence.length <= 1) {
                introFinished = true;
                return;
            }

            for (let i = 1; i < sequence.length; i++) {
                const pre = new Image();
                pre.src = assetBase + '/' + cloudImages[sequence[i]] + '.png';
            }

            let step = 1;

            function nextStep() {
                if (step >= sequence.length) {
                    introFinished = true;
                    currentTimeIndex = targetIdx;
                    return;
                }

                const idx = sequence[step];
                const isImg1Active = img1.classList.contains('active');
                const incoming = isImg1Active ? img2 : img1;
                const outgoing = isImg1Active ? img1 : img2;

                incoming.src = assetBase + '/' + cloudImages[idx] + '.png';

                const doFade = () => {
                    incoming.classList.add('active');
                    outgoing.classList.remove('active');
                    currentTimeIndex = idx;
                    step++;
                    setTimeout(nextStep, delay);
                };

                if (incoming.complete && incoming.naturalWidth > 0) {
                    doFade();
                } else {
                    incoming.onload = doFade;
                }
            }

            setTimeout(nextStep, delay);
        }

        // ── Init ───────────────────────────────────────────────────────
        updateClock();
        playIntroSequence();
        window._dashboardClockInterval = setInterval(updateClock, 1000);

        // ── Time-based greeting ────────────────────────────────────────
        const timeText = document.getElementById('time-text');
        if (timeText) {
            const h = new Date().getHours();
            if (h >= 5 && h < 11) timeText.textContent = 'selamat pagi! yok mulai belajar';
            else if (h >= 11 && h < 15) timeText.textContent = 'siang-siang gini, waktunya ngoding!';
            else if (h >= 15 && h < 18) timeText.textContent = 'sore menjelang malam, ayo lanjut belajar!';
            else if (h >= 18 && h < 23) timeText.textContent = 'udah malam nih, istirahat atau lanjut ngoding?';
            else timeText.textContent = 'masih begadang ngoding ya? semangat!';
        }

        // ── EXP System Interval (1 menit = +10 EXP) ────────────────────
        if (window._expPingInterval) {
            clearInterval(window._expPingInterval);
        }
        window._expPingInterval = setInterval(() => {
            if (typeof axios !== 'undefined') {
                axios.post('/app/api/exp/ping')
                    .then(res => {
                        if (res.data.success) {
                            const expSpan = document.getElementById('current-exp-amount');
                            if (expSpan) {
                                expSpan.textContent = res.data.exp;

                                const expNeededSpan = document.getElementById('exp-needed');
                                if (expNeededSpan) {
                                    let needed = parseInt(expNeededSpan.textContent) - 10;
                                    if (needed <= 0) {
                                        // Rank Up! Reload untuk update badge dan target berikutnya
                                        window.location.reload();
                                    } else {
                                        expNeededSpan.textContent = needed;
                                    }
                                }

                                // Optional: Tambah efek animasi kecil saat EXP bertambah
                                expSpan.style.transition = 'transform 0.3s, -webkit-text-fill-color 0.3s, color 0.3s';
                                expSpan.style.transform = 'scale(1.3)';
                                expSpan.style.color = '#ffeb3b';
                                expSpan.style.webkitTextFillColor = '#ffeb3b';

                                setTimeout(() => {
                                    expSpan.style.transform = '';
                                    expSpan.style.color = '';
                                    expSpan.style.webkitTextFillColor = '';
                                    expSpan.style.transition = '';
                                }, 500);
                            }
                        }
                    })
                    .catch(err => console.error('Gagal claim EXP:', err));
            }
        }, 60000); // 60,000 ms = 1 menit

        // ── Search Handler ────────────────────────────────────────────
        window.__currentSearchHandler = function (query) {
            document.querySelectorAll('.link-spa.neo-card').forEach(card => {
                const title = card.querySelector('.neo-title')?.textContent.toLowerCase() || '';
                const desc = card.querySelector('.materi-desc')?.textContent.toLowerCase() || '';
                if (title.includes(query) || desc.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });

            if (query !== '') {
                // Scroll layar utama ke area materi agar kotak grid terlihat
                const materiContainer = document.querySelector('.neo-materi-section');
                if (materiContainer) {
                    materiContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        };

    })();
</script>
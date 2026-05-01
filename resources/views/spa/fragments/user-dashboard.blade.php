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

        <!-- Active Event Banner -->
        @if(isset($activeEvent))
            <div
                style="margin-top: 32px; background: linear-gradient(135deg, #4f46e5, #ec4899); border-radius: 20px; padding: 20px 24px; color: #fff; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(79,70,229,0.2);">
                <div
                    style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%); border-radius: 50%; pointer-events: none;">
                </div>

                <div style="display: flex; align-items: center; gap: 16px; position: relative; z-index: 1;">
                    <div
                        style="width: 56px; height: 56px; border-radius: 16px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
                        <i class='bx bxs-zap' style="font-size: 32px; color: #fef08a;"></i>
                    </div>
                    <div>
                        <div
                            style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; color: rgba(255,255,255,0.8); margin-bottom: 4px;">
                            Event Sedang Berlangsung</div>
                        <h3 style="margin: 0 0 4px; font-size: 20px; font-weight: 800; line-height: 1.2;">
                            {{ $activeEvent->title }}</h3>
                        <p style="margin: 0; font-size: 13px; color: rgba(255,255,255,0.9); font-weight: 500;">
                            {{ $activeEvent->description }}
                        </p>
                    </div>
                </div>

                <div
                    style="position: relative; z-index: 1; text-align: right; background: rgba(0,0,0,0.2); padding: 12px 20px; border-radius: 12px; backdrop-filter: blur(8px);">
                    <div
                        style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; color: rgba(255,255,255,0.8);">
                        Multiplier EXP</div>
                    <div style="font-size: 28px; font-weight: 900; color: #fef08a;">x{{ $activeEvent->multiplier }}</div>
                    <div style="font-size: 10px; color: rgba(255,255,255,0.6); margin-top: 2px;">Sampai
                        {{ \Carbon\Carbon::parse($activeEvent->end_time)->translatedFormat('d M H:i') }}</div>
                </div>
            </div>
        @endif

        <!-- Learning Journey Timeline Section -->
        <div class="neo-timeline-section" style="margin-top: 48px;">
            @include('spa.fragments.user-journeyTimeline')
        </div>

        <!-- Streak Widget -->
        @if(isset($streakData))
            <div
                style="margin-top: 48px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 20px; padding: 24px; color: #fff; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div
                        style="width: 56px; height: 56px; border-radius: 16px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; position: relative;">
                        <i class='bx bxs-hot'
                            style="font-size: 32px; color: {{ $streakData['is_active_today'] ? '#ef4444' : '#888' }}; {{ $streakData['is_active_today'] ? 'filter: drop-shadow(0 0 10px rgba(239,68,68,0.5));' : '' }}"></i>
                        @if($streakData['streak_shields'] > 0)
                            <div style="position: absolute; top: -5px; right: -5px; background: #3b82f6; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; border: 2px solid #121212;"
                                title="Streak Shield Active">
                                <i class='bx bx-shield'></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 style="margin: 0 0 4px; font-size: 20px; font-weight: 800;">{{ $streakData['current_streak'] }}
                            Hari Beruntun!</h3>
                        <p style="margin: 0; font-size: 13px; color: #aaa; font-weight: 500;">
                            {{ $streakData['is_active_today'] ? 'Streak hari ini aman! Pertahankan terus 🔥' : 'Selesaikan materi atau kuis hari ini untuk menjaga streak!' }}
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; align-items: center;">
                    <div style="text-align: right;">
                        <div
                            style="font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">
                            Rekor Terbaik</div>
                        <div style="font-size: 16px; font-weight: 800;">{{ $streakData['longest_streak'] }} Hari</div>
                    </div>
                    <div style="width: 1px; height: 30px; background: rgba(255,255,255,0.1);"></div>
                    @php
                        $nextMilestone = 3;
                        if ($streakData['current_streak'] >= 3)
                            $nextMilestone = 7;
                        if ($streakData['current_streak'] >= 7)
                            $nextMilestone = 14;
                        if ($streakData['current_streak'] >= 14)
                            $nextMilestone = 30;
                        if ($streakData['current_streak'] >= 30)
                            $nextMilestone = 100;
                        $streakProgress = ($streakData['current_streak'] / $nextMilestone) * 100;
                        $streakProgress = min(100, max(0, $streakProgress));
                    @endphp
                    <div style="min-width: 120px;">
                        <div
                            style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; margin-bottom: 4px; color: #aaa;">
                            <span>Next: {{ $nextMilestone }} Hari</span>
                            <span>{{ $streakData['current_streak'] }}/{{ $nextMilestone }}</span>
                        </div>
                        <div style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                            <div
                                style="height: 100%; width: {{ $streakProgress }}%; background: linear-gradient(90deg, #ef4444, #f59e0b); border-radius: 3px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Daily Missions Widget -->
        @if(isset($todayMissions) && $todayMissions->count() > 0)
            <div style="margin-top: 48px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div
                            style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #f59e0b, #f97316); display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-target-lock' style="color: #fff; font-size: 18px;"></i>
                        </div>
                        <h3 class="neo-title" style="font-size: 20px; margin: 0; color: #121212;">Misi Hari Ini</h3>
                    </div>
                    <a href="#" data-spa-page="missions" class="link-spa"
                        style="font-size: 13px; font-weight: 600; color: #888; text-decoration: none; display: flex; align-items: center; gap: 4px;"
                        onmouseover="this.style.color='#121212'" onmouseout="this.style.color='#888'">
                        Lihat semua <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 12px;">
                    @foreach($todayMissions as $um)
                        @php
                            $m = $um->mission;
                            $pct = $m->target > 0 ? min(100, round(($um->progress / $m->target) * 100)) : 0;
                        @endphp
                        <div class="neo-card neo-card-light"
                            style="padding: 16px 20px; border-radius: 14px; {{ $um->claimed ? 'opacity: 0.5;' : '' }}">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                                <div
                                    style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;
                                        {{ $um->completed ? 'background: linear-gradient(135deg, #10b981, #059669);' : 'background: rgba(0,0,0,0.05);' }}">
                                    <i class='bx {{ $um->completed ? 'bx-check' : $m->icon }}'
                                        style="font-size: 16px; {{ $um->completed ? 'color: #fff;' : 'color: #555;' }}"></i>
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h4
                                        style="margin: 0; font-size: 13px; font-weight: 700; color: #121212; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $m->title }}</h4>
                                    <span style="font-size: 11px; color: #f59e0b; font-weight: 600;">+{{ $m->exp_reward }}
                                        EXP</span>
                                </div>
                            </div>
                            <div style="height: 5px; background: rgba(0,0,0,0.06); border-radius: 3px; overflow: hidden;">
                                <div
                                    style="height: 100%; width: {{ $pct }}%; background: {{ $um->completed ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #f59e0b, #f97316)' }}; border-radius: 3px; transition: width 0.5s;">
                                </div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 6px;">
                                <span style="font-size: 11px; color: #999;">{{ $um->progress }}/{{ $m->target }}</span>
                                <span
                                    style="font-size: 11px; font-weight: 600; color: {{ $um->completed ? '#10b981' : '#888' }};">{{ $um->completed ? ($um->claimed ? 'Diklaim ✓' : 'Selesai!') : $pct . '%' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Section separating bottom -->
        <div class="neo-materi-section" style="margin-top: 48px;">
            @include('spa.fragments.user-materiCard', ['data' => $data, 'mainMateri' => $mainMateri])
        </div>

        <!-- Smart Recommendations -->
        @if(isset($recommendedMateris) && $recommendedMateris->count() > 0)
            <div style="margin-top: 48px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                    <div
                        style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #06b6d4, #0891b2); display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-bulb' style="color: #fff; font-size: 18px;"></i>
                    </div>
                    <div>
                        <h3 class="neo-title" style="font-size: 20px; margin: 0; color: #121212;">Rekomendasi Untukmu</h3>
                        <p style="font-size: 12px; color: #888; margin: 0;">Berdasarkan riwayat belajarmu.</p>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 12px;">
                    @foreach($recommendedMateris as $rec)
                        <a href="?page=detail&submateri_id={{ $rec->id }}" class="link-spa neo-card neo-card-light"
                            data-page="detail&submateri_id={{ $rec->id }}"
                            style="padding: 18px 20px; border-radius: 14px; text-decoration: none; color: inherit; transition: transform 0.2s, box-shadow 0.2s; display: block;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)'"
                            onmouseout="this.style.transform=''; this.style.boxShadow=''">
                            <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                                <span
                                    style="font-size: 11px; font-weight: 600; color: #06b6d4; background: rgba(6, 182, 212, 0.1); padding: 2px 8px; border-radius: 6px;">{{ $rec->materi->title ?? 'Materi' }}</span>
                            </div>
                            <h4
                                style="margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #121212; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $rec->title }}</h4>
                            <p
                                style="margin: 0; font-size: 12px; color: #888; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $rec->subtitle ?? 'Belum dibaca' }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tier List Section -->
        <div class="neo-tier-list-section">
            @include('spa.fragments.user-tierList')
        </div>

        <!-- Season Timer Section -->
        <div class="neo-season-timer-section">
            @include('spa.fragments.user-seasonTimer')
        </div>

        <!-- Leaderboard Section -->
        <div class="neo-leaderboard-section">
            @include('spa.fragments.user-leaderboard')
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/user-dashboard.css') }}">

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
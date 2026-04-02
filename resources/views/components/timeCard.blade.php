<div class="container container-time">
    <main class="main-time">
        <div class="wrapper-time">
            <div class="cover-time">
                <div class="date-time">
                    <div>
                        @php
                            $day = \Carbon\Carbon::parse(auth()->user()->created_at)->diffInDays(now()) + 1;
                            $now = now();
                        @endphp
                        <h3>day {{ (int) $day }}</h3>
                    </div>
                    <div>
                        <h3 id="hour"></h3>
                        <h3 id="minute"></h3>
                        <h6>{{ $now->format('d, M, y') }}</h6>
                    </div>
                </div>
                @if ($lastStudy)
                    <div class="desc-time">
                        <section>
                            <div>
                                <h5 id="time-text">Loading...</h5>
                            </div>
                            <div>
                                <a href="/belajar/{{ $lastStudy->submateri->id }}">
                                    <h6>apa mau lanjutin {{ $lastStudy->submateri->materi->title }}</h6>
                                </a>
                            </div>
                        </section>
                    </div>
                @else
                    <div class="desc-time">
                        <section>
                            <div>
                                <h5 id="time-text">kamu belum belajar apa apa nih</h5>
                            </div>
                            <div>
                                <h6>yopk mulai belajar coding</h6>
                            </div>
                        </section>
                    </div>
                @endif
            </div>
            <div class="thumb-time img-wrapper">
                <img id="img1" src="{{ asset('assets/img/img005cloud.png') }}" class="active">
                <img id="img2">
            </div>
        </div>
    </main>
</div>
<script>
    /* ===============================
   🛡️ GLOBAL GUARD (ANTI DOUBLE LOAD)
================================ */
    if (!window.__TIME_COMPONENT__) {

        window.__TIME_COMPONENT__ = true;

        /* ===============================
           🧹 GLOBAL STATE (SAFE)
        ================================ */
        window.__TIME_INTERVALS__ = window.__TIME_INTERVALS__ || [];
        window.currentImg = window.currentImg || 1;
        window.isAnimating = false;

        /* ===============================
           🎯 DATA
        ================================ */
        window.timeStates = [{
                name: "morning",
                text: "pagi ini mau belajar? 🌤️",
                img: "img001cloud.jpg"
            },
            {
                name: "afternoon",
                text: "siang gini enaknya belajar 😎",
                img: "img002cloud.jpg"
            },
            {
                name: "evening",
                text: "udah sore nih, lanjut belajar yuk 🔥",
                img: "img003cloud.jpg"
            },
            {
                name: "night",
                text: "malam waktunya fokus 💡",
                img: "img004cloud.jpg"
            },
            {
                name: "midnight",
                text: "masih bangun nih? 😴",
                img: "img005cloud.jpg"
            }
        ];

        /* ===============================
           ⏱️ HELPER
        ================================ */
        function sleep(ms) {
            return new Promise(res => setTimeout(res, ms));
        }

        /* ===============================
           🧠 TIME DETECT
        ================================ */
        function getCurrentIndex() {
            const h = new Date().getHours();
            if (h < 5) return 4;
            if (h < 11) return 0;
            if (h < 15) return 1;
            if (h < 18) return 2;
            return 3;
        }

        /* ===============================
           🎬 CROSSFADE ENGINE
        ================================ */
        async function applyTimeState(state, withText = true) {

            if (window.isAnimating) return;
            window.isAnimating = true;

            const textEl = document.getElementById("time-text");
            const img1 = document.getElementById("img1");
            const img2 = document.getElementById("img2");

            if (!textEl || !img1 || !img2) {
                window.isAnimating = false;
                return;
            }

            const nextImg = window.currentImg === 1 ? img2 : img1;
            const activeImg = window.currentImg === 1 ? img1 : img2;

            nextImg.src = "/assets/img/" + state.img;

            nextImg.classList.add("active");
            activeImg.classList.remove("active");

            window.currentImg = window.currentImg === 1 ? 2 : 1;

            // TEXT ANIMATION
            if (withText) {
                textEl.classList.remove("show");
                textEl.classList.add("fade");

                await sleep(300);

                textEl.innerText = state.text;

                textEl.classList.remove("fade");
                textEl.classList.add("show");
            }

            document.body.className = state.name;

            await sleep(800);

            window.isAnimating = false;
        }

        /* ===============================
           🚀 INTRO (REFRESH)
        ================================ */
        async function runIntro() {

            const textEl = document.getElementById("time-text");

            if (textEl) {
                textEl.innerText = "Loading...";
                textEl.className = "show";
            }

            const target = getCurrentIndex();

            for (let i = 0; i <= target; i++) {
                await applyTimeState(window.timeStates[i], false);
                await sleep(200);
            }

            await sleep(300);

            await applyTimeState(window.timeStates[target], true);
        }

        /* ===============================
           ⏰ CLOCK
        ================================ */
        function updateClock() {
            const now = new Date();
            const h = now.getHours().toString().padStart(2, '0');
            const m = now.getMinutes().toString().padStart(2, '0');

            const hourEl = document.getElementById("hour");
            const minuteEl = document.getElementById("minute");

            if (!hourEl || !minuteEl) return;

            hourEl.innerText = h;
            minuteEl.innerText = m;
        }

        /* ===============================
           🚀 INIT (SPA + REFRESH)
        ================================ */
        window.initTimeComponent = async function() {

            // 🔥 clear interval lama
            window.__TIME_INTERVALS__.forEach(i => clearInterval(i));
            window.__TIME_INTERVALS__ = [];

            const index = getCurrentIndex();

            // 🧠 tunggu render selesai
            await new Promise(requestAnimationFrame);
            await sleep(200);

            // 🔥 DETEKSI NAVIGASI
            const nav = performance.getEntriesByType("navigation")[0];
            const isReload = nav && nav.type === "reload";
            const isFirstVisit = !sessionStorage.getItem("visited_dashboard");

            // 🎬 REFRESH
            if (isReload || isFirstVisit) {

                await sleep(800);
                await runIntro();

                sessionStorage.setItem("visited_dashboard", "true");
            }

            // ⚡ SPA
            else {
                await applyTimeState(window.timeStates[index], true);
            }

            // ⏰ CLOCK
            updateClock();

            const clock = setInterval(updateClock, 1000);
            window.__TIME_INTERVALS__.push(clock);
        };

    } // END GUARD
</script>
{{-- ============================================= --}}

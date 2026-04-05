@include('spa.fragments.user-headerCard')
@include('spa.fragments.user-timeCard')
@include('spa.fragments.user-materiCard', ['data' => $data, 'mainMateri' => $mainMateri])
@include('spa.fragments.user-progres', ['mainMateri' => $mainMateri])

<script>
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
        if (h >= 5  && h < 11) return 0;
        if (h >= 11 && h < 15) return 1;
        if (h >= 15 && h < 18) return 2;
        if (h >= 18 && h < 23) return 3;
        return 4;
    }

    // ── Indonesian locale ──────────────────────────────────────────
    const hariNames  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const bulanNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    // ── Clock update ───────────────────────────────────────────────
    let currentTimeIndex = -1;
    let introFinished = false;

    function updateClock() {
        const now = new Date();
        const h   = now.getHours();
        const hour     = document.getElementById('hour');
        const minute   = document.getElementById('minute');
        const dayLabel  = document.getElementById('day-label');
        const dateLabel = document.getElementById('date-label');

        if (hour)   hour.textContent   = String(h).padStart(2, '0');
        if (minute) minute.textContent = ':' + String(now.getMinutes()).padStart(2, '0');
        if (dayLabel)  dayLabel.textContent  = hariNames[now.getDay()] + ' ' + now.getDate();
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

        const newSrc     = assetBase + '/' + key + '.png';
        const isImg1Active = img1.classList.contains('active');
        const incoming   = isImg1Active ? img2 : img1;
        const outgoing   = isImg1Active ? img1 : img2;

        incoming.src = newSrc;
        incoming.onload = () => {
            incoming.classList.add('active');
            outgoing.classList.remove('active');
        };
    }

    // ── Intro transition sequence ──────────────────────────────────
    // Always starts from img005cloud (tengah malam) and cycles
    // through the day: tengah malam → pagi → siang → sore → malam
    function playIntroSequence() {
        const img1 = document.getElementById('img1');
        const img2 = document.getElementById('img2');
        if (!img1 || !img2) return;

        const h         = new Date().getHours();
        const targetIdx = getTimeIndex(h);
        const startIdx  = 4; // tengah malam
        const delay     = 900;

        // Day cycle order: 4(tengah malam) → 0(pagi) → 1(siang) → 2(sore) → 3(malam)
        const dayOrder = [4, 0, 1, 2, 3];

        // Build the sequence of steps from startIdx to targetIdx
        const startPos  = dayOrder.indexOf(startIdx);
        const targetPos = dayOrder.indexOf(targetIdx);
        const sequence  = [];

        for (let i = startPos; i <= targetPos; i++) {
            sequence.push(dayOrder[i]);
        }

        // img1 already shows img005cloud from blade, mark it
        img1.classList.add('active');
        img2.classList.remove('active');
        currentTimeIndex = startIdx;

        // If already tengah malam, done
        if (sequence.length <= 1) {
            introFinished = true;
            return;
        }

        // Preload all images in the sequence
        for (let i = 1; i < sequence.length; i++) {
            const pre = new Image();
            pre.src = assetBase + '/' + cloudImages[sequence[i]] + '.png';
        }

        // Chain transitions: step through each image
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
    setInterval(updateClock, 1000);

    // ── Time-based greeting ────────────────────────────────────────
    const timeText = document.getElementById('time-text');
    if (timeText) {
        const h = new Date().getHours();
        if (h >= 5  && h < 11) timeText.textContent = 'selamat pagi! yok mulai belajar';
        else if (h >= 11 && h < 15) timeText.textContent = 'siang-siang gini, waktunya ngoding!';
        else if (h >= 15 && h < 18) timeText.textContent = 'sore menjelang malam, ayo lanjut belajar!';
        else if (h >= 18 && h < 23) timeText.textContent = 'udah malam nih, istirahat atau lanjut ngoding?';
        else timeText.textContent = 'masih begadang ngoding ya? semangat!';
    }
</script>

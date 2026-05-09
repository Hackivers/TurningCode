@php
    $nextSeason = now()->addMonthNoOverflow()->startOfMonth();
@endphp

<div class="nothing-season-timer" style="margin-top: 48px; margin-bottom: 24px; background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 16px; padding: 28px 32px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px; position: relative; overflow: hidden; z-index: 1;">

    <!-- Dot grid background -->
    <div style="position: absolute; inset: 0; background-image: radial-gradient(var(--bg-tertiary) 1px, transparent 1px); background-size: 16px 16px; pointer-events: none;"></div>

    <!-- Left: Info -->
    <div style="position: relative; z-index: 1;">
        <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--text-muted); margin-bottom: 8px;">SYSTEM ALERT</div>
        <h4 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 10px; letter-spacing: -0.3px;">
            <div style="width: 8px; height: 8px; background: #d71921; border-radius: 50%; animation: nothingSeasonPulse 1.5s infinite;"></div>
            Season Reset
        </h4>
        <p style="margin: 0; font-size: 13px; color: var(--text-muted); line-height: 1.5; max-width: 320px;">Peringkat direset & EXP dikurangi 80%.</p>
    </div>

    <!-- Right: Countdown Grid -->
    <div id="season-countdown" style="display: flex; gap: 8px; text-align: center; position: relative; z-index: 1;" data-target="{{ $nextSeason->toIso8601String() }}">
        <div class="nothing-cd-box">
            <span id="cd-days" class="nothing-cd-val">00</span>
            <span class="nothing-cd-lbl">HARI</span>
        </div>
        <div class="nothing-cd-sep">:</div>
        <div class="nothing-cd-box">
            <span id="cd-hours" class="nothing-cd-val">00</span>
            <span class="nothing-cd-lbl">JAM</span>
        </div>
        <div class="nothing-cd-sep">:</div>
        <div class="nothing-cd-box">
            <span id="cd-mins" class="nothing-cd-val">00</span>
            <span class="nothing-cd-lbl">MENIT</span>
        </div>
        <div class="nothing-cd-sep">:</div>
        <div class="nothing-cd-box">
            <span id="cd-secs" class="nothing-cd-val">00</span>
            <span class="nothing-cd-lbl">DETIK</span>
        </div>
    </div>
</div>

<style>
    @keyframes nothingSeasonPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.2; }
    }

    .nothing-cd-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 52px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 10px 8px 8px;
    }

    .nothing-cd-val {
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        font-size: 28px;
        font-weight: 400;
        color: var(--text-primary);
        line-height: 1;
        letter-spacing: 2px;
        font-variant-numeric: tabular-nums;
    }

    .nothing-cd-lbl {
        font-size: 8px;
        font-weight: 700;
        color: var(--text-muted);
        margin-top: 6px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .nothing-cd-sep {
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        font-size: 24px;
        color: var(--border-color);
        line-height: 1.1;
        align-self: flex-start;
        padding-top: 10px;
    }

    /* ═══ MOBILE ═══ */
    @media (max-width: 768px) {
        .nothing-season-timer {
            flex-direction: row !important;
            padding: 16px 14px !important;
            gap: 8px !important;
            border-radius: 24px !important;
            margin-top: 24px !important;
            margin-bottom: 16px !important;
        }

        .nothing-season-timer > div:first-child {
            flex: 1;
            min-width: 0;
        }

        .nothing-season-timer h4 {
            font-size: 13px !important;
        }

        .nothing-season-timer p {
            display: none !important;
        }

        .nothing-season-timer .nothing-cd-box {
            min-width: 28px !important;
            padding: 6px 4px 4px !important;
        }

        .nothing-cd-val {
            font-size: 14px !important;
        }

        .nothing-cd-lbl {
            font-size: 6px !important;
            letter-spacing: 1px !important;
            margin-top: 3px !important;
        }

        .nothing-cd-sep {
            font-size: 14px !important;
            padding-top: 6px !important;
        }

        #season-countdown {
            gap: 4px !important;
            flex-shrink: 0;
        }
    }
</style>

<script>
    (function () {
        const cdContainer = document.getElementById('season-countdown');
        if (!cdContainer) return;

        const targetDate = new Date(cdContainer.getAttribute('data-target')).getTime();

        const daysEl = document.getElementById('cd-days');
        const hoursEl = document.getElementById('cd-hours');
        const minsEl = document.getElementById('cd-mins');
        const secsEl = document.getElementById('cd-secs');

        function updateTimer() {
            if (!document.body.contains(cdContainer)) return;

            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                if (daysEl) daysEl.innerText = "00";
                if (hoursEl) hoursEl.innerText = "00";
                if (minsEl) minsEl.innerText = "00";
                if (secsEl) secsEl.innerText = "00";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (daysEl) daysEl.innerText = String(days).padStart(2, '0');
            if (hoursEl) hoursEl.innerText = String(hours).padStart(2, '0');
            if (minsEl) minsEl.innerText = String(minutes).padStart(2, '0');
            if (secsEl) secsEl.innerText = String(seconds).padStart(2, '0');
        }

        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);

        const observer = new MutationObserver(() => {
            if (!document.body.contains(cdContainer)) {
                clearInterval(timerInterval);
                observer.disconnect();
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    })();
</script>
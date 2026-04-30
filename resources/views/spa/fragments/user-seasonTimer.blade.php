@php
    $nextSeason = now()->addMonthNoOverflow()->startOfMonth();
@endphp

<div class="neo-card neo-card-light"
    style="margin-top: 32px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px; padding: 24px 32px;">
    <div>
        <h4
            style="margin: 0 0 4px 0; font-size: 20px; font-weight: 700; color: #121212; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-timer' style="font-size: 24px; color: #888;"></i> Season Akan Berakhir
        </h4>
        <p style="margin: 0; font-size: 14px; color: #666;">Persiapkan dirimu. Peringkat dan EXP akan direset untuk
            musim baru.</p>
    </div>

    <div id="season-countdown" style="display: flex; gap: 16px; text-align: center;"
        data-target="{{ $nextSeason->toIso8601String() }}">
        <div class="cd-minimal-box">
            <span id="cd-days" class="cd-minimal-val">00</span>
            <span class="cd-minimal-lbl">Hari</span>
        </div>
        <div class="cd-minimal-separator">:</div>
        <div class="cd-minimal-box">
            <span id="cd-hours" class="cd-minimal-val">00</span>
            <span class="cd-minimal-lbl">Jam</span>
        </div>
        <div class="cd-minimal-separator">:</div>
        <div class="cd-minimal-box">
            <span id="cd-mins" class="cd-minimal-val">00</span>
            <span class="cd-minimal-lbl">Menit</span>
        </div>
        <div class="cd-minimal-separator">:</div>
        <div class="cd-minimal-box">
            <span id="cd-secs" class="cd-minimal-val">00</span>
            <span class="cd-minimal-lbl">Detik</span>
        </div>
    </div>
</div>

<style>
    .cd-minimal-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 48px;
    }

    .cd-minimal-val {
        font-size: 28px;
        font-weight: 800;
        color: #121212;
        line-height: 1;
        font-variant-numeric: tabular-nums;
        letter-spacing: -1px;
    }

    .cd-minimal-lbl {
        font-size: 12px;
        font-weight: 600;
        color: #888;
        margin-top: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cd-minimal-separator {
        font-size: 24px;
        font-weight: 700;
        color: #aaa;
        line-height: 1.1;
        margin-top: -2px;
    }

    @media (max-width: 768px) {
        .neo-season-timer-section .neo-card {
            flex-direction: row !important;
            /* Keep horizontal */
            align-items: center !important;
            justify-content: space-between !important;
            padding: 19px 14px !important;
            gap: 8px !important;
            border-radius: 12px !important;
            margin-top: 24px !important;
            margin-bottom: 16px !important;
        }

        .neo-season-timer-section .neo-card>div:first-child {
            flex: 1;
            min-width: 0;
        }

        .neo-season-timer-section .neo-card h4 {
            font-size: 13px !important;
            margin-bottom: 0 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .neo-season-timer-section .neo-card h4 i {
            font-size: 16px !important;
        }

        .neo-season-timer-section .neo-card p {
            display: none !important;
            /* Hide description for minimal look */
        }

        #season-countdown {
            gap: 4px !important;
            width: auto !important;
            justify-content: flex-end !important;
            align-items: flex-start !important; /* Align to top with the numbers */
            flex-shrink: 0;
            margin-top: 2px !important;
        }

        .cd-minimal-box {
            min-width: 24px !important;
        }

        .cd-minimal-val {
            font-size: 14px !important;
            line-height: 14px !important;
        }

        .cd-minimal-lbl {
            font-size: 8px !important;
            margin-top: 2px !important;
        }

        .cd-minimal-separator {
            font-size: 14px !important;
            line-height: 14px !important;
            margin-top: -1px !important; /* Micro-adjustment for colon vertical centering */
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
            if (!document.body.contains(cdContainer)) {
                return; // Let the observer clear the interval
            }

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

        const observer = new MutationObserver((mutations) => {
            if (!document.body.contains(cdContainer)) {
                clearInterval(timerInterval);
                observer.disconnect();
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    })();
</script>
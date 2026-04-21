<div class="neo-card"
    style="flex: 1; min-height: 280px; position: relative; overflow: hidden; padding: 48px 40px; display: flex; align-items: center; background: #121212; border: 1px solid rgba(255,255,255,0.05); grid-column: 1 / -1;">

    <!-- Background Image fading layer -->
    <div style="position: absolute; right: 0; top: 0; width: 60%; height: 100%; pointer-events: none; z-index: 1;">
        <!-- Dynamic images controlled by JS -->
        <img id="img1" src="{{ asset('assets/img/img002cloud.png') }}" class="active"
            style="width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 0.5s;">
        <img id="img2" class="" src=""
            style="display:none; width: 100%; height: 100%; object-fit: cover; opacity: 1; transition: opacity 0.5s;">
        <!-- Gradient overlay to melt the image cleanly into the dark background -->
        <div
            style="position: absolute; inset: 0; background: linear-gradient(90deg, #121212 0%, #121212 15%, rgba(18,18,18,0.6) 50%, transparent 100%);">
        </div>
    </div>

    <!-- Content wrapper -->
    <div
        style="position: relative; z-index: 10; width: 85%; display: flex; flex-direction: column; justify-content: center; height: 100%;">

        <!-- Top Date/Time -->
        <div
            style="font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 24px; display: flex; align-items: center;">
            <span id="day-label">Terjadwal</span>
            <span style="margin: 0 10px; opacity: 0.5;">&bull;</span>
            <span id="hour">00</span><span style="opacity: 0.5; margin: 0 2px;">:</span><span id="minute">00</span>
        </div>

        <!-- Giant Phrase -->
        <h3 id="time-text"
            style="font-size: clamp(32px, 4vw, 46px); font-weight: 800; line-height: 1.15; letter-spacing: -0.02em; color: #fff; margin: 0 0 40px 0;">
            Waktunya ngoding ya? semangat!
        </h3>

        <!-- Bottom Link -->
        <div>
            <a href="?page=materi"
                style="display: inline-flex; align-items: center; gap: 6px; font-size: 15px; font-weight: 700; color: #fff; text-decoration: none;">
                Learn more <i class='bx bx-right-arrow-alt' style="font-size: 18px;"></i>
            </a>
        </div>
    </div>
</div>
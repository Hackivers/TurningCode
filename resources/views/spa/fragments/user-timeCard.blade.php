<div id="timecard-container" style="position: relative; width: 100%; height: 100%; overflow: hidden; border-radius: 16px; perspective: 1000px;">
    <!-- 3D Background Layer -->
    <div id="timecard-bg-layer" style="position: absolute; inset: -20px; background: #000; z-index: 0; transition: transform 0.1s ease-out;">
        <!-- Cross-fade images -->
        <img id="img1" src="" alt="bg" class="time-bg-img active" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1.5s ease-in-out; filter: grayscale(1) contrast(1.2);">
        <img id="img2" src="" alt="bg" class="time-bg-img" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 1.5s ease-in-out; filter: grayscale(1) contrast(1.2);">
        <!-- Dot Grid overlay -->
        <div style="position: absolute; inset: 0; background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 16px 16px;"></div>
        <!-- Gradient Overlay -->
        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 100%);"></div>
    </div>

    <!-- 3D Content Layer -->
    <div id="timecard-content-layer" style="position: relative; z-index: 1; height: 100%; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.1s ease-out; box-sizing: border-box;">
        
        <!-- Normal Clock View -->
        <div id="normal-clock-view" style="display: flex; flex-direction: column; height: 100%; justify-content: space-between;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div id="day-label" style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #ea1515; font-weight: 700;"></div>
                    <div id="date-label" style="font-size: 12px; color: rgba(255,255,255,0.7); text-transform: uppercase; margin-top: 4px;"></div>
                </div>
                <button id="btn-start-focus" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; backdrop-filter: blur(4px);" onmouseover="this.style.background='#fff'; this.style.color='#000';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.color='#fff';">
                    <i class='bx bx-timer' style="font-size: 18px;"></i>
                </button>
            </div>

            <div style="text-align: left;">
                <div style="font-family: 'Space Mono', monospace; font-size: clamp(40px, 5vw, 72px); font-weight: 700; color: #fff; line-height: 0.9; letter-spacing: -2px; display: flex; align-items: baseline; white-space: nowrap;">
                    <span id="hour">00</span>
                    <span style="font-size: clamp(30px, 4vw, 50px); color: rgba(255,255,255,0.3); margin: 0 4px; animation: blink 1s infinite;">:</span>
                    <span id="minute">00</span>
                </div>
                <div id="time-text" style="font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 8px; cursor: pointer; text-transform: uppercase; max-width: 100%; line-height: 1.3; transition: all 0.2s; white-space: normal; overflow-wrap: break-word; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"></div>
            </div>
        </div>

        <!-- Pomodoro View -->
        <div id="pomodoro-view" style="display: none; flex-direction: column; height: 100%; justify-content: center; align-items: center;">
            <div style="position: relative; width: 140px; height: 140px; margin-bottom: 24px;">
                <svg width="140" height="140" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"></circle>
                    <circle id="pomo-progress-ring" cx="50" cy="50" r="45" fill="none" stroke="#ea1515" stroke-width="4" stroke-dasharray="283" stroke-dashoffset="0" style="transition: stroke-dashoffset 1s linear; transform: rotate(-90deg); transform-origin: 50% 50%;"></circle>
                </svg>
                <div id="pomo-timer-display" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-family: 'Space Mono', monospace; font-size: 28px; font-weight: 700; color: #fff; letter-spacing: -1px;">
                    25:00
                </div>
            </div>
            
            <div id="pomo-status-text" style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.7); margin-bottom: 16px;">SESI FOKUS SEDANG BERJALAN</div>
            
            <div style="display: flex; gap: 12px;">
                <button id="btn-pause-focus" style="background: transparent; border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 8px 16px; border-radius: 4px; font-size: 10px; text-transform: uppercase; font-family: 'Space Mono', monospace; cursor: pointer; display: flex; align-items: center; gap: 4px;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">
                    <i class='bx bx-pause'></i> PAUSE
                </button>
                <button id="btn-stop-focus" style="background: #fff; border: 1px solid #fff; color: #000; padding: 8px 16px; border-radius: 4px; font-size: 10px; text-transform: uppercase; font-family: 'Space Mono', monospace; cursor: pointer; display: flex; align-items: center; gap: 4px;" onmouseover="this.style.background='#ea1515'; this.style.color='#fff'; this.style.borderColor='#ea1515';" onmouseout="this.style.background='#fff'; this.style.color='#000'; this.style.borderColor='#fff';">
                    <i class='bx bx-stop'></i> STOP
                </button>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.2; }
    }
    .time-bg-img.active {
        opacity: 0.6 !important;
    }
</style>

<script>
(function() {
    // 3D Parallax Effect
    const container = document.getElementById('timecard-container');
    const bgLayer = document.getElementById('timecard-bg-layer');
    const contentLayer = document.getElementById('timecard-content-layer');
    
    if (container) {
        container.addEventListener('mousemove', (e) => {
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const percentX = (x - centerX) / centerX;
            const percentY = (y - centerY) / centerY;
            
            const maxTilt = 10;
            if(bgLayer) bgLayer.style.transform = `scale(1.05) translate(${percentX * -10}px, ${percentY * -10}px)`;
            if(contentLayer) contentLayer.style.transform = `rotateX(${percentY * -maxTilt}deg) rotateY(${percentX * maxTilt}deg)`;
        });
        
        container.addEventListener('mouseleave', () => {
            if(bgLayer) bgLayer.style.transform = 'scale(1) translate(0px, 0px)';
            if(contentLayer) contentLayer.style.transform = 'rotateX(0deg) rotateY(0deg)';
        });
    }

    // Time & Greeting
    const hourEl = document.getElementById('hour');
    const minEl = document.getElementById('minute');
    const dayEl = document.getElementById('day-label');
    const dateEl = document.getElementById('date-label');
    const timeTextEl = document.getElementById('time-text');
    const img1 = document.getElementById('img1');
    
    const days = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
    const months = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
    
    @php
        $firstName = 'User';
        if(auth()->user() && auth()->user()->name) {
            $firstName = explode(' ', auth()->user()->name)[0];
        }
    @endphp
    const bladeUserName = "{{ $firstName }}";

    function updateTime() {
        const now = new Date();
        if (hourEl) hourEl.textContent = String(now.getHours()).padStart(2, '0');
        if (minEl) minEl.textContent = String(now.getMinutes()).padStart(2, '0');
        if (dayEl) dayEl.textContent = days[now.getDay()];
        if (dateEl) dateEl.textContent = `${String(now.getDate()).padStart(2, '0')} ${months[now.getMonth()]} ${now.getFullYear()}`;
        
        const hour = now.getHours();
        let greeting = '';
        let bgImg = '';
        
        // Minimalist B/W wallpapers from unsplash to match Nothing OS dark mode
        if (hour >= 5 && hour < 11) {
            greeting = `PAGI YANG PRODUKTIF, ${bladeUserName.toUpperCase()}. MARI MULAI FOKUS.`;
            bgImg = 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=800&auto=format&fit=crop';
        } else if (hour >= 11 && hour < 15) {
            greeting = `TETAP KONSENTRASI SIANG INI, ${bladeUserName.toUpperCase()}.`;
            bgImg = 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=800&auto=format&fit=crop';
        } else if (hour >= 15 && hour < 18) {
            greeting = `SORE YANG TENANG, ${bladeUserName.toUpperCase()}. WAKTU UNTUK BELAJAR.`;
            bgImg = 'https://images.unsplash.com/photo-1606162386869-703c39f21fbc?q=80&w=800&auto=format&fit=crop';
        } else {
            greeting = `MALAM YANG SUNYI, ${bladeUserName.toUpperCase()}. FOKUS TANPA GANGGUAN.`;
            bgImg = 'https://images.unsplash.com/photo-1550684376-efcbd6e3f031?q=80&w=800&auto=format&fit=crop';
        }
        
        if (timeTextEl && timeTextEl.textContent !== greeting) {
            timeTextEl.textContent = greeting;
        }
        
        if (img1 && img1.src !== bgImg) {
            img1.src = bgImg;
        }
    }
    
    updateTime();
    if(window._clockInterval) clearInterval(window._clockInterval);
    window._clockInterval = setInterval(updateTime, 1000);

    // Pomodoro Logic
    let pomoInterval;
    let pomoTimeLeft = 25 * 60; 
    let pomoTotal = 25 * 60;
    let isPomoRunning = false;

    const btnStart = document.getElementById('btn-start-focus');
    const btnPause = document.getElementById('btn-pause-focus');
    const btnStop = document.getElementById('btn-stop-focus');
    const normalView = document.getElementById('normal-clock-view');
    const pomoView = document.getElementById('pomodoro-view');
    const pomoDisplay = document.getElementById('pomo-timer-display');
    const pomoRing = document.getElementById('pomo-progress-ring');
    const pomoStatus = document.getElementById('pomo-status-text');

    function updatePomoDisplay() {
        if(!pomoDisplay) return;
        const m = Math.floor(pomoTimeLeft / 60);
        const s = pomoTimeLeft % 60;
        pomoDisplay.textContent = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        
        if(pomoRing) {
            const offset = 283 - ((pomoTimeLeft / pomoTotal) * 283);
            pomoRing.style.strokeDashoffset = offset;
        }
    }

    if(btnStart) {
        btnStart.addEventListener('click', () => {
            if(normalView) normalView.style.display = 'none';
            if(pomoView) pomoView.style.display = 'flex';
            pomoTimeLeft = 25 * 60;
            pomoTotal = 25 * 60;
            isPomoRunning = true;
            updatePomoDisplay();
            pomoStatus.textContent = 'SESI FOKUS SEDANG BERJALAN';
            btnPause.innerHTML = "<i class='bx bx-pause'></i> PAUSE";
            
            pomoInterval = setInterval(() => {
                if(!isPomoRunning) return;
                pomoTimeLeft--;
                updatePomoDisplay();
                if(pomoTimeLeft <= 0) {
                    clearInterval(pomoInterval);
                    pomoStatus.textContent = 'SESI FOKUS SELESAI!';
                    isPomoRunning = false;
                    
                    if(typeof axios !== 'undefined') {
                        axios.post('/app/api/exp/reward', { amount: 50, reason: 'Pomodoro' }).then(() => {
                            window.location.reload();
                        }).catch(()=>window.location.reload());
                    }
                }
            }, 1000);
        });
    }

    if(btnPause) {
        btnPause.addEventListener('click', () => {
            isPomoRunning = !isPomoRunning;
            btnPause.innerHTML = isPomoRunning ? "<i class='bx bx-play'></i> RESUME" : "<i class='bx bx-pause'></i> PAUSE";
            pomoStatus.textContent = isPomoRunning ? 'SESI FOKUS SEDANG BERJALAN' : 'SESI FOKUS DIHENTIKAN SEMENTARA';
        });
    }

    if(btnStop) {
        btnStop.addEventListener('click', () => {
            clearInterval(pomoInterval);
            isPomoRunning = false;
            if(normalView) normalView.style.display = 'flex';
            if(pomoView) pomoView.style.display = 'none';
        });
    }
})();
</script>
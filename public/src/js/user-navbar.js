// ── Navbar scroll ─────────────────────────────────────────────────
let isScrolled = false;

window.addEventListener("scroll", () => {
    const navbar = document.getElementById("navBar");
    if (!navbar) return;

    const emInPx = parseFloat(getComputedStyle(document.documentElement).fontSize);
    const triggerOn = 13 * emInPx;
    const triggerOff = 9 * emInPx;

    if (!isScrolled && window.scrollY > triggerOn) {
        navbar.classList.add("scrolled");
        isScrolled = true;
    } else if (isScrolled && window.scrollY < triggerOff) {
        navbar.classList.remove("scrolled");
        isScrolled = false;
    }
});

// ── Global Search Handler ─────────────────────────────────────────
(function () {
    const searchInput = document.getElementById('global-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            if (typeof window.__currentSearchHandler === 'function') {
                window.__currentSearchHandler(query);
            }
        });
    }
})();

// ── Unified System Panel Logic ────────────────────────────────────
(function () {
    const sysPanel = document.getElementById('sys-panel');
    const sysBackdrop = document.getElementById('sys-backdrop');
    if (!sysPanel || !sysBackdrop) return;

    // Time Display
    const timeDisplay = document.getElementById('sys-time-display');
    function updateTime() {
        if (!timeDisplay) return;
        const now = new Date();
        timeDisplay.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Toggle Panel
    function openPanel(targetPillId = 'sys-pill-profile') {
        sysPanel.classList.add('active');
        sysBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden';

        if (targetPillId) {
            const pill = document.getElementById(targetPillId);
            if (pill) pill.click();
        } else {
            // Default to profile card if no pill specified
            showCard('sys-card-profile');
            document.querySelectorAll('.sys-pill').forEach(p => p.classList.remove('active'));
        }
    }

    function closePanel() {
        sysPanel.classList.remove('active');
        sysBackdrop.classList.remove('active');
        document.body.style.overflow = '';
        // Also close external notif panel
        const np = document.getElementById('sys-notif-panel');
        if (np) np.classList.remove('active');
        const nPill = document.getElementById('sys-pill-notif');
        if (nPill) nPill.classList.remove('notif-active');
    }

    // Trigger Buttons (Navbar icons)
    const btnProfile = document.getElementById('btn-profile-popup');
    const btnGeneral = document.getElementById('btn-general-popup');

    if (btnProfile) btnProfile.addEventListener('click', (e) => { e.stopPropagation(); openPanel('sys-pill-account'); });
    if (btnGeneral) btnGeneral.addEventListener('click', (e) => { e.stopPropagation(); openPanel('sys-pill-notif'); });

    // Close Actions
    const btnClose = document.getElementById('btn-sys-close');
    if (btnClose) btnClose.addEventListener('click', closePanel);
    sysBackdrop.addEventListener('click', closePanel);

    // Pill interactions
    const pills = document.querySelectorAll('.sys-pill');
    const cards = document.querySelectorAll('.sys-card');
    const notifPanel = document.getElementById('sys-notif-panel');

    function isDesktop() {
        return window.innerWidth >= 769;
    }

    function showCard(cardId) {
        cards.forEach(c => c.classList.remove('active'));
        const target = document.getElementById(cardId);
        if (target) {
            target.classList.add('active');
        }
    }

    function hideNotifPanel() {
        if (notifPanel) notifPanel.classList.remove('active');
    }

    const notifPill = document.getElementById('sys-pill-notif');

    pills.forEach(pill => {
        pill.addEventListener('click', () => {
            const targetId = pill.getAttribute('data-target');

            // Handle notification pill separately on desktop
            if (targetId === 'sys-card-notif' && isDesktop()) {
                // Toggle external notif panel independently
                const isActive = notifPill && notifPill.classList.contains('notif-active');
                if (isActive) {
                    hideNotifPanel();
                    notifPill.classList.remove('notif-active');
                } else {
                    notifPill.classList.add('notif-active');
                    if (notifPanel) notifPanel.classList.add('active');
                }
                return;
            }

            // Normal pill behavior (don't touch notif pill)
            pills.forEach(p => {
                if (p.id !== 'sys-pill-notif') p.classList.remove('active');
            });
            pill.classList.add('active');
            
            if (targetId) {
                showCard(targetId);
            }
        });
    });

    // ── Settings Functionality ──
    const toggleDark = document.getElementById('toggle-darkmode');
    const darkKey = 'tc_dark_mode';

    function applyTheme(isDark) {
        document.documentElement.classList.toggle('dark-mode', isDark);
        if (toggleDark) toggleDark.checked = isDark;
        
        // Update optimize pill text
        const pillDark = document.getElementById('sys-pill-setting');
        if (pillDark && pillDark.querySelector('span')) {
            // Just updating settings pill subtitle
            pillDark.querySelector('span').textContent = isDark ? 'Gelap' : 'Terang';
        }
    }

    const isDark = localStorage.getItem(darkKey) === 'true';
    applyTheme(isDark);

    if (toggleDark) {
        toggleDark.addEventListener('change', () => {
            const on = toggleDark.checked;
            localStorage.setItem(darkKey, on);
            applyTheme(on);
        });
    }

    const toggleOptimize = document.getElementById('toggle-optimize');
    const pillOptimize = document.getElementById('sys-pill-optimize');
    const optimizeKey = 'tc_optimize_mode';

    function applyOptimize(isOn) {
        document.documentElement.classList.toggle('optimize-mode', isOn);
        if (pillOptimize) {
            pillOptimize.classList.toggle('active', isOn);
            pillOptimize.querySelector('span').textContent = isOn ? 'Aktif' : 'Mati';
        }
    }

    const isOptimize = localStorage.getItem(optimizeKey) === 'true';
    applyOptimize(isOptimize);

    if (pillOptimize) {
        pillOptimize.addEventListener('click', () => {
            const isCurrentlyOn = pillOptimize.classList.contains('active');
            const turnOn = !isCurrentlyOn;
            localStorage.setItem(optimizeKey, turnOn);
            applyOptimize(turnOn);
            // Don't change bottom card for optimize toggle
            showCard('sys-card-profile'); 
            pills.forEach(p => { if (p.id !== 'sys-pill-optimize') p.classList.remove('active') });
        });
    }


    // ── Notifications Functionality ──
    const badge = document.getElementById('notif-badge');
    const bodyEl = document.getElementById('notif-popup-body');
    const emptyEl = document.getElementById('notif-empty');
    const btnClearNotif = document.getElementById('btn-notif-clear');
    const STORAGE_KEY = 'tc_notifications_list';
    const MAX_NOTIFS = 50;

    function getNotifs() {
        try { return JSON.parse(localStorage.getItem(STORAGE_KEY)) || []; }
        catch { return []; }
    }

    function saveNotifs(arr) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(arr.slice(0, MAX_NOTIFS)));
    }

    function getUnreadCount() {
        return getNotifs().filter(n => !n.read).length;
    }

    window.__addNotification = function (title, body, color, type) {
        const notifs = getNotifs();
        notifs.unshift({
            id: Date.now() + '-' + Math.random().toString(36).substr(2, 5),
            title,
            body,
            color: color || '#6366f1',
            type: type || 'reminder',
            time: new Date().toISOString(),
            read: false,
        });
        saveNotifs(notifs);
        updateNotifUI();
    };

    function updateNotifUI() {
        const count = getUnreadCount();
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 9 ? '9+' : count;
                badge.classList.add('active');
            } else {
                badge.textContent = '';
                badge.classList.remove('active');
            }
        }
        
        const pillNotif = document.getElementById('sys-pill-notif');
        if (pillNotif && pillNotif.querySelector('span')) {
            pillNotif.querySelector('span').textContent = count > 0 ? `${count} Baru` : 'Kosong';
        }

        renderNotifs();
    }

    function renderNotifs() {
        if (!bodyEl) return;
        const notifs = getNotifs();

        bodyEl.querySelectorAll('.spd-pill.notif-pill').forEach(el => el.remove());

        if (notifs.length === 0) {
            if (emptyEl) emptyEl.style.display = 'flex';
            return;
        }

        if (emptyEl) emptyEl.style.display = 'none';

        const icons = {
            start: 'bx bx-target-lock',
            end: 'bx bx-coffee-togo',
            reminder: 'bx bx-radio-circle-marked',
            system: 'bx bx-terminal',
        };

        const frag = document.createDocumentFragment();

        notifs.forEach(n => {
            const timeStr = new Date(n.time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            const item = document.createElement('div');
            item.className = 'spd-pill notif-pill' + (n.read ? '' : ' unread');
            item.dataset.notifId = n.id;
            // Unread styling: more contrast for nothing os.
            const iconBg = n.read ? '#27272a' : '#fff';
            const iconColor = n.read ? '#a1a1aa' : '#000';
            const itemBorder = n.read ? '#27272a' : '#fff';

            item.innerHTML = `
                <div class="spd-pill-text">
                    <strong>${n.title}</strong>
                    <span>${n.body}</span>
                    <span style="font-size: 9px; opacity: 0.5; margin-top: 2px; text-transform: uppercase; font-family: var(--nothing-dot-font, monospace); letter-spacing: 0.5px;"><i class='bx bx-time-five'></i> ${timeStr}</span>
                </div>
                <button class="notif-item-dismiss" style="background: transparent; border: none; color: #a1a1aa; cursor: pointer; font-size: 20px; padding: 4px; display: flex;"><i class='bx bx-x'></i></button>
            `;
            item.style.marginBottom = "8px"; // add gap
            if (!n.read) {
                item.style.borderColor = "#fff";
                item.style.background = "#fff";
                item.style.color = "#000";
            }

            item.addEventListener('click', (e) => {
                if (e.target.closest('.notif-item-dismiss')) return;
                markRead(n.id);
            });

            item.querySelector('.notif-item-dismiss').addEventListener('click', (e) => {
                e.stopPropagation();
                dismissNotif(n.id, item);
            });

            frag.appendChild(item);
        });

        bodyEl.appendChild(frag);
    }

    function markRead(id) {
        const notifs = getNotifs();
        const n = notifs.find(x => x.id === id);
        if (n) n.read = true;
        saveNotifs(notifs);
        updateNotifUI();
    }

    function dismissNotif(id, el) {
        el.style.display = 'none';
        const notifs = getNotifs().filter(x => x.id !== id);
        saveNotifs(notifs);
        updateNotifUI();
    }

    if (btnClearNotif) {
        btnClearNotif.addEventListener('click', () => {
            saveNotifs([]);
            updateNotifUI();
        });
    }

    updateNotifUI();

    // Listen when Notif card opens
    const pillNotifClick = document.getElementById('sys-pill-notif');
    if (pillNotifClick) {
        pillNotifClick.addEventListener('click', () => {
            // Mark all read after a delay
            setTimeout(() => {
                const notifs = getNotifs();
                notifs.forEach(n => n.read = true);
                saveNotifs(notifs);
                updateNotifUI();
            }, 1000);
        });
    }


    // ── Friend Search Functionality ──
    const fsInput = document.getElementById('input-friend-search');
    const fsResultsContainer = document.getElementById('friend-search-results');
    const fsEmptyState = document.getElementById('friend-search-empty');
    const fsLoadingState = document.getElementById('friend-search-loading');

    if (fsInput) {
        let searchTimeout = null;

        fsInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                fsResultsContainer.innerHTML = '';
                fsLoadingState.style.display = 'none';
                fsEmptyState.style.display = 'flex';
                fsEmptyState.querySelector('p').innerText = 'Cari pengguna berdasarkan nama/email';
                return;
            }

            fsEmptyState.style.display = 'none';
            fsResultsContainer.innerHTML = '';
            fsLoadingState.style.display = 'flex';

            searchTimeout = setTimeout(() => {
                fetchFriends(query);
            }, 500);
        });

        async function fetchFriends(query) {
            try {
                const res = await fetch(document.getElementById('navBar').dataset.friendSearchUrl + '?q=' + encodeURIComponent(query));
                const data = await res.json();

                fsLoadingState.style.display = 'none';

                if (data.length === 0) {
                    fsEmptyState.style.display = 'flex';
                    fsEmptyState.querySelector('p').innerText = 'Tidak ditemukan pengguna.';
                    return;
                }

                fsResultsContainer.innerHTML = '';
                data.forEach(u => {
                    const el = document.createElement('div');
                    el.className = 'spd-pill';
                    el.style.marginBottom = '8px';

                    let actionHtml = '';
                    if (!u.friendship_status) {
                        actionHtml = `
                            <form action="/app/friend/add/${u.id}" method="POST" style="margin:0;">
                                <input type="hidden" name="_token" value="${document.getElementById('navBar').dataset.csrfToken}">
                                <button type="submit" class="spd-badge" style="border:none; cursor:pointer;"><i class='bx bx-user-plus'></i> ADD</button>
                            </form>
                        `;
                    } else if (u.friendship_status === 'pending') {
                        actionHtml = `<span class="spd-badge" style="opacity:0.5; border:none;">PENDING</span>`;
                    } else if (u.friendship_status === 'accepted') {
                        actionHtml = `<span class="spd-badge" style="opacity:0.5; border:none;"><i class='bx bx-check'></i> TEMAN</span>`;
                    }

                    el.innerHTML = `
                        <div class="spd-pill-icon" style="width: 36px; height: 36px; border-radius: 50%; overflow: hidden; border: 2px solid #3f3f46; margin-right: 4px;">
                            <img src="${u.avatar}" style="width:100%; height:100%; object-fit: cover;" alt="${u.name}">
                        </div>
                        <div class="spd-pill-text">
                            <strong>${u.name}</strong>
                            <span>${u.rank_name}</span>
                        </div>
                        <div class="spd-toggle">
                            ${actionHtml}
                        </div>
                    `;
                    fsResultsContainer.appendChild(el);
                });

            } catch (err) {
                fsLoadingState.style.display = 'none';
                fsEmptyState.style.display = 'flex';
                fsEmptyState.querySelector('p').innerText = 'Terjadi kesalahan jaringan.';
            }
        }
    }
    // ── Settings Functionality ──
    // Fullscreen Toggle
    const toggleFullscreen = document.getElementById('toggle-fullscreen');
    if (toggleFullscreen) {
        toggleFullscreen.checked = !!document.fullscreenElement;
        toggleFullscreen.addEventListener('change', () => {
            if (toggleFullscreen.checked) {
                document.documentElement.requestFullscreen().catch(() => {
                    toggleFullscreen.checked = false;
                });
            } else {
                if (document.fullscreenElement) document.exitFullscreen();
            }
        });
        document.addEventListener('fullscreenchange', () => {
            toggleFullscreen.checked = !!document.fullscreenElement;
        });
    }

    // Compact Mode Toggle
    const toggleCompact = document.getElementById('toggle-compact');
    if (toggleCompact) {
        const savedCompact = localStorage.getItem('tc-compact') === 'true';
        toggleCompact.checked = savedCompact;
        if (savedCompact) document.body.classList.add('compact-mode');
        
        toggleCompact.addEventListener('change', () => {
            document.body.classList.toggle('compact-mode', toggleCompact.checked);
            localStorage.setItem('tc-compact', toggleCompact.checked);
        });
    }

    // Sound FX Toggle
    const toggleSound = document.getElementById('toggle-sound');
    if (toggleSound) {
        const savedSound = localStorage.getItem('tc-sound');
        toggleSound.checked = savedSound !== 'false'; // default on
        
        toggleSound.addEventListener('change', () => {
            localStorage.setItem('tc-sound', toggleSound.checked);
        });

        // Add click sound to interactive elements
        document.addEventListener('click', (e) => {
            if (localStorage.getItem('tc-sound') === 'false') return;
            const el = e.target.closest('button, .sys-pill, .spd-card, a');
            if (el) {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 1800;
                osc.type = 'sine';
                gain.gain.value = 0.03;
                osc.start();
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.08);
                osc.stop(ctx.currentTime + 0.08);
            }
        });
    }

    // Font Size Cycling
    const btnFontSize = document.getElementById('btn-font-size');
    const fontSizeLabel = document.getElementById('font-size-label');
    if (btnFontSize && fontSizeLabel) {
        const sizes = ['small', 'normal', 'large'];
        const sizeValues = { small: '14px', normal: '16px', large: '18px' };
        const sizeLabels = { small: 'Kecil', normal: 'Normal', large: 'Besar' };
        let currentSize = localStorage.getItem('tc-font-size') || 'normal';
        
        document.documentElement.style.fontSize = sizeValues[currentSize];
        fontSizeLabel.textContent = sizeLabels[currentSize];

        btnFontSize.addEventListener('click', () => {
            const idx = sizes.indexOf(currentSize);
            currentSize = sizes[(idx + 1) % sizes.length];
            document.documentElement.style.fontSize = sizeValues[currentSize];
            fontSizeLabel.textContent = sizeLabels[currentSize];
            localStorage.setItem('tc-font-size', currentSize);
        });
    }

    // Animations Toggle
    const toggleAnimations = document.getElementById('toggle-animations');
    if (toggleAnimations) {
        const savedAnim = localStorage.getItem('tc-animations');
        toggleAnimations.checked = savedAnim !== 'false';
        if (savedAnim === 'false') document.body.classList.add('no-animations');

        toggleAnimations.addEventListener('change', () => {
            document.body.classList.toggle('no-animations', !toggleAnimations.checked);
            localStorage.setItem('tc-animations', toggleAnimations.checked);
        });
    }

    // Auto Scroll Toggle
    const toggleAutoScroll = document.getElementById('toggle-autoscroll');
    if (toggleAutoScroll) {
        const savedScroll = localStorage.getItem('tc-autoscroll');
        toggleAutoScroll.checked = savedScroll !== 'false';
        window.__tcAutoScroll = toggleAutoScroll.checked;

        toggleAutoScroll.addEventListener('change', () => {
            window.__tcAutoScroll = toggleAutoScroll.checked;
            localStorage.setItem('tc-autoscroll', toggleAutoScroll.checked);
        });
    }

    // Clear Cache
    const btnClearCache = document.getElementById('btn-clear-cache');
    if (btnClearCache) {
        btnClearCache.addEventListener('click', () => {
            if (confirm('Reset semua pengaturan panel ke default?')) {
                localStorage.removeItem('tc-compact');
                localStorage.removeItem('tc-sound');
                localStorage.removeItem('tc-font-size');
                localStorage.removeItem('tc-animations');
                localStorage.removeItem('tc-autoscroll');
                document.documentElement.style.fontSize = '';
                document.body.classList.remove('compact-mode', 'no-animations');
                location.reload();
            }
        });
    }

    // Report Bug
    const btnReportBug = document.getElementById('btn-report-bug');
    if (btnReportBug) {
        btnReportBug.addEventListener('click', () => {
            if (typeof window.openIssueReportModal === 'function') {
                window.openIssueReportModal();
                // Close the system panel after opening the modal
                const panel = document.getElementById('sys-panel');
                const backdrop = document.getElementById('sys-backdrop');
                if (panel) panel.classList.remove('active');
                if (backdrop) backdrop.classList.remove('active');
            } else {
                alert('Fitur laporan bug akan segera tersedia.');
            }
        });
    }

    // ── Music Player Functionality ──
    const musicFileInput = document.getElementById('sys-music-file');
    const btnMusicUpload = document.getElementById('btn-music-upload');
    const audioPlayer = document.getElementById('sys-audio-player');
    const btnPlay = document.getElementById('btn-music-play');
    const btnPrev = document.getElementById('btn-music-prev');
    const btnNext = document.getElementById('btn-music-next');
    const seekSlider = document.getElementById('sys-music-seek');
    const currTimeEl = document.getElementById('sys-music-curr');
    const durTimeEl = document.getElementById('sys-music-dur');
    const titleEl = document.getElementById('sys-music-title');
    const subtitlePill = document.getElementById('sys-music-subtitle');
    const vinylDisk = document.getElementById('sys-vinyl-disk');
    const volSlider = document.getElementById('sys-music-vol');
    const volFill = document.getElementById('sys-vol-fill');

    let currentMusicUrl = null;

    if (btnMusicUpload && musicFileInput) {
        btnMusicUpload.addEventListener('click', () => {
            musicFileInput.click();
        });

        musicFileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                if (currentMusicUrl) URL.revokeObjectURL(currentMusicUrl);
                currentMusicUrl = URL.createObjectURL(file);
                audioPlayer.src = currentMusicUrl;
                titleEl.textContent = file.name.replace(/\.[^/.]+$/, "");
                subtitlePill.textContent = "Siap Diputar";
                
                audioPlayer.load();
                audioPlayer.play().then(() => {
                    updatePlayState(true);
                }).catch(e => console.log(e));
            }
        });

        btnPlay.addEventListener('click', () => {
            if (!currentMusicUrl) return musicFileInput.click();
            if (audioPlayer.paused) {
                audioPlayer.play();
                updatePlayState(true);
            } else {
                audioPlayer.pause();
                updatePlayState(false);
            }
        });

        btnPrev.addEventListener('click', () => {
            audioPlayer.currentTime = 0;
            if (audioPlayer.paused && currentMusicUrl) {
                audioPlayer.play();
                updatePlayState(true);
            }
        });

        btnNext.addEventListener('click', () => {
            audioPlayer.pause();
            audioPlayer.currentTime = 0;
            updatePlayState(false);
            subtitlePill.textContent = "Berhenti";
        });

        const progressFill = document.getElementById('sys-music-progress-fill');

        audioPlayer.addEventListener('timeupdate', () => {
            if (!audioPlayer.duration) return;
            const current = audioPlayer.currentTime;
            const duration = audioPlayer.duration;
            const percentage = (current / duration) * 100;
            seekSlider.value = percentage;
            if (progressFill) progressFill.style.width = percentage + '%';
            
            if (currTimeEl) currTimeEl.textContent = formatTime(current);
            if (durTimeEl) durTimeEl.textContent = formatTime(duration);
        });

        audioPlayer.addEventListener('ended', () => {
            updatePlayState(false);
            seekSlider.value = 0;
            if (progressFill) progressFill.style.width = '0%';
            if (currTimeEl) currTimeEl.textContent = "0:00";
            if (subtitlePill) subtitlePill.textContent = "Selesai";
        });

        seekSlider.addEventListener('input', () => {
            if (!audioPlayer.duration) return;
            const seekTo = audioPlayer.duration * (seekSlider.value / 100);
            audioPlayer.currentTime = seekTo;
            if (progressFill) progressFill.style.width = seekSlider.value + '%';
        });

        if (volSlider && volFill) {
            audioPlayer.volume = volSlider.value / 100;
            volFill.style.width = volSlider.value + '%';
            
            volSlider.addEventListener('input', () => {
                audioPlayer.volume = volSlider.value / 100;
                volFill.style.width = volSlider.value + '%';
                
                // Change icon based on volume level
                const volIcon = volFill.querySelector('i');
                if (volSlider.value == 0) {
                    volIcon.className = 'bx bx-volume-mute';
                } else if (volSlider.value < 50) {
                    volIcon.className = 'bx bx-volume-low';
                } else {
                    volIcon.className = 'bx bx-volume-full';
                }
            });
        }

        function updatePlayState(isPlaying) {
            if (isPlaying) {
                btnPlay.classList.add('playing');
                vinylDisk.classList.add('playing');
                subtitlePill.textContent = "Memutar...";
            } else {
                btnPlay.classList.remove('playing');
                vinylDisk.classList.remove('playing');
                if(currentMusicUrl) subtitlePill.textContent = "Dijeda";
            }
        }

        function formatTime(seconds) {
            if (isNaN(seconds)) return "0:00";
            const min = Math.floor(seconds / 60);
            const sec = Math.floor(seconds % 60);
            return `${min}:${sec.toString().padStart(2, '0')}`;
        }
    }
})();
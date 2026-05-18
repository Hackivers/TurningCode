

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
    function openPanel(targetPillId = 'sys-pill-account') {
        sysPanel.classList.add('active');
        sysBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden';

        if (targetPillId) {
            const pill = document.getElementById(targetPillId);
            if (pill) pill.click();
        } else {
            document.querySelectorAll('.sys-tile').forEach(p => p.classList.remove('active'));
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

    // ── Tile Slider Logic ──
    const tileTrack = document.getElementById('sys-tile-track');
    const dotsContainer = document.getElementById('sys-dots');
    const dots = dotsContainer ? dotsContainer.querySelectorAll('.sys-dot') : [];
    const tilePages = tileTrack ? tileTrack.querySelectorAll('.sys-tile-page') : [];
    let currentSlide = 0;
    const totalSlides = dots.length || 1;

    function goToSlide(index) {
        if (index < 0 || index >= totalSlides) return;
        currentSlide = index;
        if (tileTrack) {
            tileTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        dots.forEach((d, i) => {
            d.classList.toggle('active', i === currentSlide);
        });
        tilePages.forEach((p, i) => {
            p.classList.toggle('active', i === currentSlide);
        });
    }

    // Init first page as active
    if (tilePages.length > 0) tilePages[0].classList.add('active');

    // Dot click
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const page = parseInt(dot.dataset.page);
            if (!isNaN(page)) goToSlide(page);
        });
    });

    // Swipe support on the slider
    const slider = document.getElementById('sys-tile-slider');
    if (slider) {
        let startX = 0, startY = 0, isDragging = false;

        slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            isDragging = true;
        }, { passive: true });

        slider.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            const diffX = startX - e.changedTouches[0].clientX;
            const diffY = startY - e.changedTouches[0].clientY;
            // Only swipe horizontally if distance > 40px and mostly horizontal
            if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
                if (diffX > 0) goToSlide(currentSlide + 1); // swipe left
                else goToSlide(currentSlide - 1); // swipe right
            }
        }, { passive: true });

        // Mouse drag for desktop
        slider.addEventListener('mousedown', (e) => {
            startX = e.clientX;
            isDragging = true;
        });
        slider.addEventListener('mouseup', (e) => {
            if (!isDragging) return;
            isDragging = false;
            const diffX = startX - e.clientX;
            if (Math.abs(diffX) > 40) {
                if (diffX > 0) goToSlide(currentSlide + 1);
                else goToSlide(currentSlide - 1);
            }
        });
    }

    // Pill interactions
    const pills = document.querySelectorAll('.sys-tile');
    const notifPanel = document.getElementById('sys-notif-panel');
    const notifPill = document.getElementById('sys-pill-notif');

    function hideNotifPanel() {
        if (notifPanel) notifPanel.classList.remove('active');
        if (notifPill) notifPill.classList.remove('notif-active');
    }

    function toggleNotifPanel() {
        if (!notifPanel || !notifPill) return;
        const isActive = notifPanel.classList.contains('active');
        if (isActive) {
            hideNotifPanel();
        } else {
            notifPanel.classList.add('active');
            notifPill.classList.add('notif-active');
        }
    }

    const dynamicPanelsContainer = document.getElementById('sys-dynamic-panels');
    const dynamicCards = document.querySelectorAll('.sys-panel-card');

    pills.forEach(pill => {
        pill.addEventListener('click', () => {
            if (pill.id === 'sys-pill-notif') {
                toggleNotifPanel();
                return;
            }

            // Mode Toggle (Independent)
            if (pill.id === 'sys-pill-mode') {
                const isCurrentlyDark = document.documentElement.classList.contains('dark-mode');
                const turnDark = !isCurrentlyDark;
                localStorage.setItem('tc_dark_mode', turnDark);
                applyTheme(turnDark);
                return;
            }

            // Report Bug (Independent)
            if (pill.id === 'btn-report-bug') {
                return;
            }

            const wasActive = pill.classList.contains('active');
            
            // Deactivate all normal pills
            pills.forEach(p => {
                if (p.id !== 'sys-pill-notif' && p.id !== 'sys-pill-mode') p.classList.remove('active');
            });

            // Hide all dynamic cards
            dynamicCards.forEach(c => c.classList.remove('active'));

            if (!wasActive) {
                // Activate the clicked pill
                pill.classList.add('active');
                
                // Show corresponding panel if exists
                const targetId = pill.getAttribute('data-target');
                const targetPanel = document.getElementById(targetId);
                
                if (targetPanel) {
                    if (dynamicPanelsContainer) dynamicPanelsContainer.style.display = 'block';
                    targetPanel.classList.add('active');
                } else {
                    // No target panel, hide container
                    if (dynamicPanelsContainer) dynamicPanelsContainer.style.display = 'none';
                }
            } else {
                // User toggled off the current active pill, hide container
                if (dynamicPanelsContainer) dynamicPanelsContainer.style.display = 'none';
            }
        });
    });

    // ── Settings Functionality ──
    const toggleDark = document.getElementById('toggle-darkmode');
    const darkKey = 'tc_dark_mode';

    function applyTheme(isDark) {
        document.documentElement.classList.toggle('dark-mode', isDark);
        if (toggleDark) toggleDark.checked = isDark;
        
        // Update mode pill text and active state
        const pillMode = document.getElementById('sys-pill-mode');
        if (pillMode) {
            pillMode.classList.toggle('active', isDark);
            if (pillMode.querySelector('span')) {
                pillMode.querySelector('span').textContent = isDark ? 'Gelap' : 'Terang';
            }
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
    const optimizeKey = 'tc_optimize_mode';

    function applyOptimize(isOn) {
        document.documentElement.classList.toggle('optimize-mode', isOn);
        if (toggleOptimize) toggleOptimize.checked = isOn;
    }

    const isOptimize = localStorage.getItem(optimizeKey) === 'true';
    applyOptimize(isOptimize);

    if (toggleOptimize) {
        toggleOptimize.addEventListener('change', () => {
            const on = toggleOptimize.checked;
            localStorage.setItem(optimizeKey, on);
            applyOptimize(on);
        });
    }

    // ── Info Slider Functionality ──
    const sipTrack = document.getElementById('sip-slider-track');
    const sipDots = document.querySelectorAll('#sip-dots .sip-dot');
    let currentSipSlide = 0;

    if (sipTrack && sipDots.length > 0) {
        function updateSipSlider() {
            sipTrack.style.transform = `translateX(-${currentSipSlide * (100 / 3)}%)`;
            sipDots.forEach(d => d.classList.remove('active'));
            sipDots[currentSipSlide].classList.add('active');
        }

        sipDots.forEach(dot => {
            dot.addEventListener('click', () => {
                currentSipSlide = parseInt(dot.dataset.slide);
                updateSipSlider();
            });
        });
    }

    // ── Font Size Slider ──
    const fontSlider = document.getElementById('ssp-font-slider');
    const fontValue = document.getElementById('ssp-font-value');
    const fontKey = 'tc_font_size';

    function applyFontSize(size) {
        // Since the site uses px instead of rem, we use zoom to scale the entire UI proportionally
        const scale = size / 16;
        document.body.style.zoom = scale;
        
        // Fallback for Firefox which doesn't support zoom well: use CSS transform
        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
            document.body.style.transform = `scale(${scale})`;
            document.body.style.transformOrigin = 'top left';
            document.body.style.width = `${100 / scale}%`;
        }

        if (fontSlider) fontSlider.value = size;
        if (fontValue) fontValue.textContent = size + 'px';
    }

    const savedFont = parseInt(localStorage.getItem(fontKey)) || 16;
    applyFontSize(savedFont);

    if (fontSlider) {
        fontSlider.addEventListener('input', () => {
            const size = parseInt(fontSlider.value);
            localStorage.setItem(fontKey, size);
            applyFontSize(size);
        });
    }

    // ── Friend Search Functionality ──
    const friendSearchInput = document.getElementById('sys-friend-search');
    const friendResults = document.getElementById('sys-friend-results');
    const friendEmpty = document.getElementById('sys-friend-empty');
    const navBar = document.getElementById('navBar');
    const searchUrl = navBar ? navBar.dataset.friendSearchUrl : '';
    const csrfToken = navBar ? navBar.dataset.csrfToken : '';
    let friendSearchTimer = null;

    if (friendSearchInput) {
        friendSearchInput.addEventListener('input', () => {
            clearTimeout(friendSearchTimer);
            const query = friendSearchInput.value.trim();

            if (query.length < 2) {
                // Show empty state
                friendResults.querySelectorAll('.sfp-user-card').forEach(el => el.remove());
                if (friendEmpty) friendEmpty.style.display = 'flex';
                return;
            }

            friendSearchTimer = setTimeout(async () => {
                try {
                    const res = await fetch(`${searchUrl}?q=${encodeURIComponent(query)}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                        credentials: 'same-origin',
                    });
                    if (!res.ok) return;
                    const users = await res.json();
                    renderFriendResults(users);
                } catch (e) { /* silent */ }
            }, 400);
        });
    }

    function renderFriendResults(users) {
        if (!friendResults) return;
        friendResults.querySelectorAll('.sfp-user-card').forEach(el => el.remove());

        if (users.length === 0) {
            if (friendEmpty) {
                friendEmpty.querySelector('span').textContent = 'Tidak ditemukan';
                friendEmpty.style.display = 'flex';
            }
            return;
        }

        if (friendEmpty) friendEmpty.style.display = 'none';

        users.forEach(u => {
            const card = document.createElement('div');
            card.className = 'sfp-user-card';

            let btnClass = 'sfp-add-btn';
            let btnIcon = '<i class="bx bx-plus"></i>';
            if (u.friendship_status === 'accepted') {
                btnClass += ' already';
                btnIcon = '<i class="bx bx-check"></i>';
            } else if (u.friendship_status === 'pending') {
                btnClass += ' sent';
                btnIcon = '<i class="bx bx-time-five"></i>';
            }

            const expFormatted = (u.exp || 0).toLocaleString('id-ID');

            card.innerHTML = `
                <img src="${u.avatar}" alt="" class="sfp-user-avatar" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=18181b&color=fff'">
                <div class="sfp-user-info">
                    <div class="sfp-user-name">${u.name}</div>
                    <div class="sfp-user-exp">${expFormatted} EXP</div>
                </div>
                <button class="${btnClass}" data-user-id="${u.id}">${btnIcon}</button>
            `;

            const addBtn = card.querySelector('.sfp-add-btn');
            if (!u.friendship_status && addBtn) {
                addBtn.addEventListener('click', async () => {
                    addBtn.disabled = true;
                    addBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';
                    try {
                        const res = await fetch(`/app/friend/add/${u.id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            credentials: 'same-origin',
                        });
                        const data = await res.json();
                        if (data.success) {
                            addBtn.className = 'sfp-add-btn sent';
                            addBtn.innerHTML = '<i class="bx bx-check"></i>';
                            if (typeof window.__addNotification === 'function') {
                                window.__addNotification('Permintaan Terkirim', `Permintaan pertemanan ke ${u.name} berhasil dikirim`);
                            }
                        } else {
                            addBtn.innerHTML = '<i class="bx bx-x"></i>';
                            addBtn.disabled = false;
                        }
                    } catch (e) {
                        addBtn.innerHTML = '<i class="bx bx-plus"></i>';
                        addBtn.disabled = false;
                    }
                });
            }

            friendResults.appendChild(card);
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
        catch (e) { return []; }
    }

    function saveNotifs(arr) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(arr.slice(0, MAX_NOTIFS)));
    }

    function getUnreadCount() {
        return getNotifs().filter(n => !n.read).length;
    }

    window.__addNotification = function (title, body) {
        const notifs = getNotifs();
        notifs.unshift({
            id: Date.now() + '-' + Math.random().toString(36).substr(2, 5),
            title,
            body,
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

        bodyEl.querySelectorAll('.scnp-item').forEach(el => el.remove());

        if (notifs.length === 0) {
            if (emptyEl) emptyEl.style.display = 'block';
            return;
        }

        if (emptyEl) emptyEl.style.display = 'none';

        const frag = document.createDocumentFragment();

        notifs.forEach(n => {
            const timeStr = new Date(n.time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }).replace('.', ':');
            const item = document.createElement('div');
            item.className = 'scnp-item' + (n.read ? ' read' : '');
            item.dataset.notifId = n.id;
            
            // If read, slightly dim it
            if (n.read) {
                item.style.opacity = '0.5';
            }

            item.innerHTML = `
                <div class="scnp-icon"><i class='bx bx-bell'></i></div>
                <div class="scnp-content">
                    <strong>${n.title}</strong>
                    <span>${n.body}</span>
                </div>
                <div class="scnp-time">${timeStr}</div>
            `;
            
            item.style.cursor = "pointer";
            
            item.addEventListener('click', (e) => {
                markRead(n.id);
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
            const el = e.target.closest('button, .sys-tile, .spd-card, a');
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
            // Remove old and new setting keys
            const keys = ['tc-compact', 'tc-sound', 'tc-font-size', 'tc-animations', 'tc-autoscroll', 'tc_dark_mode', 'tc_optimize_mode', 'tc_font_size'];
            keys.forEach(k => localStorage.removeItem(k));
            
            document.documentElement.style.fontSize = '';
            document.body.classList.remove('compact-mode', 'no-animations');
            
            btnClearCache.textContent = 'Selesai ✓';
            btnClearCache.classList.add('done');
            
            setTimeout(() => {
                location.reload();
            }, 600);
        });
    }

    // Report Bug
    const btnReportBug = document.getElementById('btn-report-bug');
    if (btnReportBug) {
        btnReportBug.addEventListener('click', () => {
            if (typeof window.openIssueReportModal === 'function') {
                window.openIssueReportModal();
                closePanel();
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
    const seekSlider = document.getElementById('sys-music-seek');
    const titleEl = document.getElementById('sys-music-title');
    const progressFill = document.getElementById('sys-music-progress-fill');
    const volSlider = document.getElementById('sys-music-vol');
    const volFill = document.getElementById('sys-vol-fill');
    const visualizerBars = document.querySelectorAll('.smp-bar-fill');

    if (volSlider && volFill) {
        const savedVol = localStorage.getItem('tc_music_vol');
        if (savedVol !== null) volSlider.value = savedVol;

        const updateVolUI = (val) => {
            if (audioPlayer) audioPlayer.volume = val / 100;
            volFill.style.width = val + '%';
            
            const volIcon = document.querySelector('.sys-vol-icon');
            if (volIcon) {
                if (val == 0) volIcon.className = 'bx bx-volume-mute sys-vol-icon';
                else if (val < 50) volIcon.className = 'bx bx-volume-low sys-vol-icon';
                else volIcon.className = 'bx bx-volume-full sys-vol-icon';
            }
        };

        updateVolUI(volSlider.value);
        
        volSlider.addEventListener('input', () => {
            updateVolUI(volSlider.value);
            localStorage.setItem('tc_music_vol', volSlider.value);
        });
    }

    let currentMusicUrl = null;
    let audioCtx = null;
    let analyser = null;
    let dataArray = null;
    let source = null;
    let isVisualizerRunning = false;

    function initAudioVisualizer() {
        if (audioCtx) return;
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        analyser = audioCtx.createAnalyser();
        analyser.fftSize = 64; // 32 frequency bins
        dataArray = new Uint8Array(analyser.frequencyBinCount);
        
        source = audioCtx.createMediaElementSource(audioPlayer);
        source.connect(analyser);
        analyser.connect(audioCtx.destination);
    }

    function drawVisualizer() {
        if (!isVisualizerRunning) return;
        requestAnimationFrame(drawVisualizer);
        
        if (analyser) {
            analyser.getByteFrequencyData(dataArray);
            
            // Map only the first 21 active bins to 7 visualizer frequency bands
            // (ignoring the very high empty frequencies at the top end of the spectrum)
            const binsPerBar = 3;
            const averages = [];
            
            for (let i = 0; i < 7; i++) {
                let sum = 0;
                for (let j = 0; j < binsPerBar; j++) {
                    sum += dataArray[(i * binsPerBar) + j];
                }
                averages.push(sum / binsPerBar);
            }
            
            // Arrange symmetrically: dominant bass (averages[0]) in the center
            const symmetricMapping = [
                averages[5], // far left
                averages[3],
                averages[1],
                averages[0], // center
                averages[2],
                averages[4],
                averages[6]  // far right
            ];
            
            for (let i = 0; i < 7; i++) {
                if (!visualizerBars[i]) continue;
                
                let average = symmetricMapping[i];
                
                // Convert 0-255 value to a pixel height between 6px and 120px
                let heightPx = 6 + (average / 255) * 114;
                visualizerBars[i].style.height = heightPx + 'px';
                visualizerBars[i].style.transition = 'none'; // Fast updates
            }
        }
    }

    function updatePlayState(isPlaying) {
        if (!btnPlay) return;
        const playSvg = btnPlay.querySelector('svg');
        
        if (isPlaying) {
            if (playSvg) playSvg.innerHTML = '<rect x="6" y="4" width="4" height="16" /><rect x="14" y="4" width="4" height="16" />';
            if (audioCtx && audioCtx.state === 'suspended') audioCtx.resume();
            
            if (!isVisualizerRunning) {
                isVisualizerRunning = true;
                drawVisualizer();
            }
        } else {
            if (playSvg) playSvg.innerHTML = '<polygon points="7,4 20,12 7,20" />';
            isVisualizerRunning = false;
            
            // Reset bars back to default CSS heights smoothly
            visualizerBars.forEach(bar => {
                bar.style.transition = 'height 0.3s ease';
                bar.style.height = ''; 
            });
        }
    }

    // IndexedDB setup for persisting music across reloads
    function openMusicDB() {
        return new Promise((resolve, reject) => {
            const req = indexedDB.open('tcMusicDB', 1);
            req.onupgradeneeded = (e) => {
                e.target.result.createObjectStore('music', { keyPath: 'id' });
            };
            req.onsuccess = () => resolve(req.result);
            req.onerror = () => reject(req.error);
        });
    }

    async function saveMusic(file) {
        try {
            const db = await openMusicDB();
            const tx = db.transaction('music', 'readwrite');
            tx.objectStore('music').put({ id: 'saved_track', file: file, name: file.name });
        } catch(e) {}
    }

    async function loadMusic() {
        try {
            const db = await openMusicDB();
            const tx = db.transaction('music', 'readonly');
            const req = tx.objectStore('music').get('saved_track');
            req.onsuccess = () => {
                if (req.result && req.result.file) {
                    const data = req.result;
                    currentMusicUrl = URL.createObjectURL(data.file);
                    audioPlayer.src = currentMusicUrl;
                    if (titleEl) titleEl.textContent = data.name.replace(/\.[^/.]+$/, "");
                    
                    const savedProgress = parseFloat(localStorage.getItem('tc_music_progress'));
                    audioPlayer.addEventListener('loadedmetadata', function onMetaLoad() {
                        if (savedProgress && savedProgress < audioPlayer.duration) {
                            audioPlayer.currentTime = savedProgress;
                        }
                        audioPlayer.removeEventListener('loadedmetadata', onMetaLoad);
                    });

                    audioPlayer.load();
                    initAudioVisualizer();
                }
            };
        } catch(e) {}
    }

    if (btnMusicUpload && musicFileInput) {
        loadMusic();
        btnMusicUpload.addEventListener('click', () => {
            musicFileInput.click();
        });

        musicFileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                saveMusic(file);
                localStorage.removeItem('tc_music_progress'); // reset progress for new file
                if (currentMusicUrl) URL.revokeObjectURL(currentMusicUrl);
                currentMusicUrl = URL.createObjectURL(file);
                audioPlayer.src = currentMusicUrl;
                if (titleEl) titleEl.textContent = file.name.replace(/\.[^/.]+$/, "");
                
                initAudioVisualizer();
                audioPlayer.load();
                audioPlayer.play().then(() => {
                    updatePlayState(true);
                }).catch(e => console.log(e));
            }
        });

        if (btnPlay) {
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
        }

        if (audioPlayer) {
            audioPlayer.addEventListener('timeupdate', () => {
                if (!audioPlayer.duration) return;
                const current = audioPlayer.currentTime;
                const duration = audioPlayer.duration;
                const percentage = (current / duration) * 100;
                
                // Save progress roughly every second to avoid hitting localStorage too rapidly
                if (Math.floor(current) % 2 === 0) {
                    localStorage.setItem('tc_music_progress', current);
                }
                
                if (seekSlider) seekSlider.value = percentage;
                if (progressFill) progressFill.style.width = percentage + '%';
            });

            audioPlayer.addEventListener('ended', () => {
                updatePlayState(false);
                localStorage.removeItem('tc_music_progress');
                if (seekSlider) seekSlider.value = 0;
                if (progressFill) progressFill.style.width = '0%';
            });
        }

        if (seekSlider) {
            seekSlider.addEventListener('input', () => {
                if (!audioPlayer.duration) return;
                const seekTo = audioPlayer.duration * (seekSlider.value / 100);
                audioPlayer.currentTime = seekTo;
                localStorage.setItem('tc_music_progress', seekTo);
                if (progressFill) progressFill.style.width = seekSlider.value + '%';
            });
        }
    }

        function formatTime(seconds) {
            if (isNaN(seconds)) return "0:00";
            const min = Math.floor(seconds / 60);
            const sec = Math.floor(seconds % 60);
            return `${min}:${sec.toString().padStart(2, '0')}`;
        }
})();
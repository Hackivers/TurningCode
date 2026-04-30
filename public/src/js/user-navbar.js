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

    // ── Profile Detail Popup ──────────────────────────────────────────
    (function () {
        const btnOpenProfile = document.getElementById('btn-profile-popup');
        const btnCloseProfile = document.getElementById('btn-profile-close');
        const profilePopup = document.getElementById('profile-popup');
        const backdrop = document.getElementById('setting-backdrop'); // We can reuse the setting backdrop
        const btnGotoAccount = document.getElementById('btn-profile-goto-account');

        if (!btnOpenProfile || !profilePopup) return;

        function openProfilePopup() {
            profilePopup.classList.add('active');
            if (backdrop) backdrop.classList.add('active');
        }

        function closeProfilePopup() {
            profilePopup.classList.remove('active');
            if (backdrop) {
                // Only remove backdrop active if setting popup is also not active
                const settingPopup = document.getElementById('setting-popup');
                if (!settingPopup || !settingPopup.classList.contains('active')) {
                    backdrop.classList.remove('active');
                }
            }
        }

        btnOpenProfile.addEventListener('click', (e) => {
            e.stopPropagation();
            if (profilePopup.classList.contains('active')) {
                closeProfilePopup();
            } else {
                openProfilePopup();
            }
        });

        if (btnCloseProfile) btnCloseProfile.addEventListener('click', closeProfilePopup);
        if (backdrop) backdrop.addEventListener('click', closeProfilePopup);

        if (btnGotoAccount) {
            btnGotoAccount.addEventListener('click', () => {
                closeProfilePopup();
            });
        }
    })();

    // ── Setting Popup ─────────────────────────────────────────────────
    (function () {
        const btnOpen = document.getElementById('btn-setting-popup');
        const btnClose = document.getElementById('btn-setting-close');
        const popup = document.getElementById('setting-popup');
        const backdrop = document.getElementById('setting-backdrop');
        const toggleDark = document.getElementById('toggle-darkmode');
        const toggleNotif = document.getElementById('toggle-notification');

        if (!btnOpen || !popup) return;

        function openPopup() {
            popup.classList.add('active');
            backdrop.classList.add('active');
        }

        function closePopup() {
            popup.classList.remove('active');
            backdrop.classList.remove('active');
        }

        btnOpen.addEventListener('click', (e) => {
            e.stopPropagation();
            if (popup.classList.contains('active')) {
                closePopup();
            } else {
                openPopup();
            }
        });

        if (btnClose) btnClose.addEventListener('click', closePopup);
        if (backdrop) backdrop.addEventListener('click', closePopup);

        // ── Dark Mode ──────────────────────────────────────────────
        const darkKey = 'tc_dark_mode';

        function applyTheme(isDark) {
            document.documentElement.classList.toggle('dark-mode', isDark);
            if (toggleDark) toggleDark.checked = isDark;

            // Update icon
            const icon = toggleDark ? toggleDark.closest('.spd-card').querySelector('.spd-card-icon i') : null;
            if (icon) {
                icon.className = isDark ? 'bx bxs-moon' : 'bx bx-moon';
            }
        }

        // Initial apply
        const isDark = localStorage.getItem(darkKey) === 'true';
        applyTheme(isDark);

        if (toggleDark) {
            toggleDark.addEventListener('change', () => {
                const on = toggleDark.checked;
                localStorage.setItem(darkKey, on);
                applyTheme(on);
            });
        }

        // ── Notifikasi ─────────────────────────────────────────────
        const notifKey = 'tc_notifications';

        // Cek state awal
        if (toggleNotif) {
            const notifStored = localStorage.getItem(notifKey);
            if (notifStored === 'true' && 'Notification' in window && Notification.permission === 'granted') {
                toggleNotif.checked = true;
            } else if (notifStored === null && 'Notification' in window && Notification.permission === 'granted') {
                toggleNotif.checked = true;
                localStorage.setItem(notifKey, 'true');
            }

            toggleNotif.addEventListener('change', async () => {
                if (toggleNotif.checked) {
                    if ('Notification' in window) {
                        const perm = await Notification.requestPermission();
                        if (perm === 'granted') {
                            localStorage.setItem(notifKey, 'true');
                            // Show test notification
                            try {
                                new Notification('🔔 Notifikasi Aktif', {
                                    body: 'Kamu akan menerima pengingat jadwal belajar.',
                                    icon: '/assets/img/img001non.jpg',
                                });
                            } catch { }
                        } else {
                            toggleNotif.checked = false;
                            localStorage.setItem(notifKey, 'false');
                        }
                    }
                } else {
                    localStorage.setItem(notifKey, 'false');
                }
            });
        }

        // ── Optimize Web ──────────────────────────────────────────────
        const toggleOptimize = document.getElementById('toggle-optimize');
        const optimizeKey = 'tc_optimize_mode';

        function applyOptimize(isOn) {
            document.documentElement.classList.toggle('optimize-mode', isOn);
            if (toggleOptimize) toggleOptimize.checked = isOn;

            // Update icon
            const icon = toggleOptimize ? toggleOptimize.closest('.spd-card').querySelector('.spd-card-icon i') : null;
            if (icon) {
                icon.className = isOn ? 'bx bxs-rocket' : 'bx bx-rocket';
            }
        }

        // Initial apply
        const isOptimize = localStorage.getItem(optimizeKey) === 'true';
        applyOptimize(isOptimize);

        if (toggleOptimize) {
            toggleOptimize.addEventListener('change', () => {
                const on = toggleOptimize.checked;
                localStorage.setItem(optimizeKey, on);
                applyOptimize(on);
            });
        }
    })();

    // ── Notification Popup ──────────────────────────────────────────────
    (function () {
        const btnOpen = document.getElementById('btn-notification-popup');
        const btnClose = document.getElementById('btn-notif-close');
        const btnClear = document.getElementById('btn-notif-clear');
        const popup = document.getElementById('notif-popup');
        const backdrop = document.getElementById('setting-backdrop');
        const badge = document.getElementById('notif-badge');
        const bodyEl = document.getElementById('notif-popup-body');
        const emptyEl = document.getElementById('notif-empty');

        if (!btnOpen || !popup) return;

        const STORAGE_KEY = 'tc_notifications_list';
        const MAX_NOTIFS = 50;

        // ── Notification Store ──────────────────────────────────────
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

        // ── Add notification (called by schedule notifier) ──────────
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
            updateBadge();
            renderNotifs();
        };

        // ── Badge ───────────────────────────────────────────────────
        function updateBadge() {
            if (!badge) return;
            const count = getUnreadCount();
            if (count > 0) {
                badge.textContent = count > 9 ? '9+' : count;
                badge.classList.add('active');
            } else {
                badge.textContent = '';
                badge.classList.remove('active');
            }
        }

        // ── Render ──────────────────────────────────────────────────
        function renderNotifs() {
            if (!bodyEl) return;
            const notifs = getNotifs();

            // Clear existing items (keep empty state)
            bodyEl.querySelectorAll('.notif-item').forEach(el => el.remove());

            if (notifs.length === 0) {
                if (emptyEl) emptyEl.style.display = 'flex';
                return;
            }

            if (emptyEl) emptyEl.style.display = 'none';

            const icons = {
                start: 'bx bx-book-open',
                end: 'bx bx-coffee',
                reminder: 'bx bx-bell',
                system: 'bx bx-info-circle',
            };

            // Group by date
            const groups = {};
            notifs.forEach(n => {
                const d = new Date(n.time);
                const today = new Date();
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);

                let label;
                if (d.toDateString() === today.toDateString()) {
                    label = 'Hari Ini';
                } else if (d.toDateString() === yesterday.toDateString()) {
                    label = 'Kemarin';
                } else {
                    label = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                }

                if (!groups[label]) groups[label] = [];
                groups[label].push(n);
            });

            // Insert before emptyEl
            const frag = document.createDocumentFragment();

            Object.entries(groups).forEach(([label, items]) => {
                const groupHeader = document.createElement('div');
                groupHeader.className = 'notif-item notif-date-header';
                groupHeader.innerHTML = `<h6>${label}</h6>`;
                frag.appendChild(groupHeader);

                items.forEach(n => {
                    const timeStr = new Date(n.time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    const item = document.createElement('div');
                    item.className = 'notif-item' + (n.read ? '' : ' unread');
                    item.dataset.notifId = n.id;
                    item.innerHTML = `
                        <div class="notif-item-icon" style="background: ${n.color}20; border-color: ${n.color}40">
                            <i class='${icons[n.type] || 'bx bx-bell'}' style="color: ${n.color}"></i>
                        </div>
                        <div class="notif-item-content">
                            <h5>${n.title}</h5>
                            <p>${n.body}</p>
                            <span class="notif-item-time"><i class='bx bx-time-five'></i> ${timeStr}</span>
                        </div>
                        <button class="notif-item-dismiss" title="Hapus">
                            <i class='bx bx-x'></i>
                        </button>
                    `;

                    // Click to mark as read
                    item.addEventListener('click', (e) => {
                        if (e.target.closest('.notif-item-dismiss')) return;
                        markRead(n.id);
                    });

                    // Dismiss single
                    item.querySelector('.notif-item-dismiss').addEventListener('click', (e) => {
                        e.stopPropagation();
                        dismissNotif(n.id, item);
                    });

                    frag.appendChild(item);
                });
            });

            bodyEl.insertBefore(frag, emptyEl);
        }

        function markRead(id) {
            const notifs = getNotifs();
            const n = notifs.find(x => x.id === id);
            if (n) n.read = true;
            saveNotifs(notifs);
            updateBadge();
            // Update UI
            const el = bodyEl.querySelector(`[data-notif-id="${id}"]`);
            if (el) el.classList.remove('unread');
        }

        function dismissNotif(id, el) {
            // Animate out
            el.style.transform = 'translateX(100%)';
            el.style.opacity = '0';
            el.style.maxHeight = el.scrollHeight + 'px';
            requestAnimationFrame(() => {
                el.style.maxHeight = '0';
                el.style.padding = '0';
                el.style.margin = '0';
            });

            setTimeout(() => {
                const notifs = getNotifs().filter(x => x.id !== id);
                saveNotifs(notifs);
                updateBadge();
                renderNotifs();
            }, 300);
        }

        // ── Open / Close ────────────────────────────────────────────
        function openNotifPopup() {
            // Close setting popup if open
            const settingPopup = document.getElementById('setting-popup');
            if (settingPopup) settingPopup.classList.remove('active');

            popup.classList.add('active');
            if (backdrop) backdrop.classList.add('active');
            renderNotifs();

            // Mark all as read when opening
            setTimeout(() => {
                const notifs = getNotifs();
                notifs.forEach(n => n.read = true);
                saveNotifs(notifs);
                updateBadge();
                bodyEl.querySelectorAll('.notif-item.unread').forEach(el => el.classList.remove('unread'));
            }, 1500);
        }

        function closeNotifPopup() {
            popup.classList.remove('active');
            if (backdrop) backdrop.classList.remove('active');
        }

        btnOpen.addEventListener('click', (e) => {
            e.stopPropagation();
            if (popup.classList.contains('active')) {
                closeNotifPopup();
            } else {
                openNotifPopup();
            }
        });

        if (btnClose) btnClose.addEventListener('click', closeNotifPopup);
        if (backdrop) {
            backdrop.addEventListener('click', () => {
                closeNotifPopup();
                // Also close setting popup
                const settingPopup = document.getElementById('setting-popup');
                if (settingPopup) settingPopup.classList.remove('active');
            });
        }

        // ── Clear All ───────────────────────────────────────────────
        if (btnClear) {
            btnClear.addEventListener('click', () => {
                saveNotifs([]);
                updateBadge();
                renderNotifs();
            });
        }

        // ── Initial ─────────────────────────────────────────────────
        updateBadge();
        renderNotifs();

        // Expose for schedule notifier
        window.__updateNotifBadge = updateBadge;
        window.__renderNotifs = renderNotifs;
    })();

    // ── Friend Search Popup ─────────────────────────────────────────────
    (function () {
        const btnOpen = document.getElementById('btn-friend-search-popup');
        const btnClose = document.getElementById('btn-friend-search-close');
        const popup = document.getElementById('friend-search-popup');
        const backdrop = document.getElementById('setting-backdrop');
        const input = document.getElementById('input-friend-search');
        const resultsContainer = document.getElementById('friend-search-results');
        const emptyState = document.getElementById('friend-search-empty');
        const loadingState = document.getElementById('friend-search-loading');

        if (!btnOpen || !popup) return;

        let searchTimeout = null;

        function openPopup() {
            const settingPopup = document.getElementById('setting-popup');
            if (settingPopup) settingPopup.classList.remove('active');
            const notifPopup = document.getElementById('notif-popup');
            if (notifPopup) notifPopup.classList.remove('active');

            popup.classList.add('active');
            if (backdrop) backdrop.classList.add('active');
            input.focus();
        }

        function closePopup() {
            popup.classList.remove('active');
            if (backdrop) backdrop.classList.remove('active');
        }

        btnOpen.addEventListener('click', (e) => {
            e.stopPropagation();
            if (popup.classList.contains('active')) {
                closePopup();
            } else {
                openPopup();
            }
        });

        if (btnClose) btnClose.addEventListener('click', closePopup);

        if (backdrop) {
            backdrop.addEventListener('click', () => {
                closePopup();
            });
        }

        input.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                resultsContainer.innerHTML = '';
                loadingState.style.display = 'none';
                emptyState.style.display = 'flex';
                emptyState.querySelector('h5').innerText = 'Ketik untuk mencari';
                emptyState.querySelector('p').innerText = 'Cari pengguna berdasarkan nama/email';
                return;
            }

            emptyState.style.display = 'none';
            resultsContainer.innerHTML = '';
            loadingState.style.display = 'flex';

            searchTimeout = setTimeout(() => {
                fetchFriends(query);
            }, 500);
        });

        async function fetchFriends(query) {
            try {
                const res = await fetch(document.getElementById('navBar').dataset.friendSearchUrl + '?q=' + encodeURIComponent(query));
                const data = await res.json();

                loadingState.style.display = 'none';

                if (data.length === 0) {
                    emptyState.style.display = 'flex';
                    emptyState.querySelector('h5').innerText = 'Tidak ditemukan';
                    emptyState.querySelector('p').innerText = 'Coba kata kunci lain';
                    return;
                }

                resultsContainer.innerHTML = '';
                data.forEach(u => {
                    const el = document.createElement('div');
                    el.className = 'fs-user-row';

                    let actionHtml = '';
                    if (!u.friendship_status) {
                        actionHtml = `
                            <form action="/app/friend/add/${u.id}" method="POST" style="margin:0;">
                                <input type="hidden" name="_token" value="${document.getElementById('navBar').dataset.csrfToken}">
                                <button type="submit" class="fs-btn fs-btn-add">
                                    <i class='bx bx-user-plus'></i> Add
                                </button>
                            </form>
                        `;
                    } else if (u.friendship_status === 'pending') {
                        actionHtml = `
                            <button disabled class="fs-btn fs-btn-pending">
                                <i class='bx bx-time'></i> Pending
                            </button>
                        `;
                    } else if (u.friendship_status === 'accepted') {
                        actionHtml = `
                            <button disabled class="fs-btn fs-btn-friends">
                                <i class='bx bx-check'></i> Friends
                            </button>
                        `;
                    }

                    el.innerHTML = `
                        <div class="fs-user-info">
                            <img src="${u.avatar}" class="fs-user-avatar" alt="${u.name}">
                            <div class="fs-user-meta">
                                <span class="fs-user-name">${u.name}</span>
                                <span class="fs-user-rank"><i class='bx bxs-star'></i> ${u.rank_name}</span>
                            </div>
                        </div>
                        <div class="fs-user-action">${actionHtml}</div>
                    `;
                    resultsContainer.appendChild(el);
                });

            } catch (err) {
                loadingState.style.display = 'none';
                emptyState.style.display = 'flex';
                emptyState.querySelector('h5').innerText = 'Terjadi kesalahan';
                emptyState.querySelector('p').innerText = 'Silakan coba lagi nanti';
            }
        }
    })();

    // ── Global No-Scroll on Popups ────────────────────────────────────
    (function () {
        const backdrop = document.getElementById('setting-backdrop');
        if (backdrop) {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        if (backdrop.classList.contains('active')) {
                            document.body.style.overflow = 'hidden';
                        } else {
                            document.body.style.overflow = '';
                        }
                    }
                });
            });
            observer.observe(backdrop, { attributes: true });
        }
    })();
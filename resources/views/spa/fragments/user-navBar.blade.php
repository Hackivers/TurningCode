<div class="container container-nav navbar @if (Auth::User()->role == "admin")
    admin
@endif" id="navBar">
    <main class="main-nav">
        <div class="wrapper-nav">
            <nav class="box-nav-profile">
                <div class="profile-img-nav btnAside">
                    <div>
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                        @else
                            <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                        @endif
                        <h5>Guest</h5>
                    </div>
                </div>
                @if (Auth::User()->role == 'user')
                    <div class="wrapper-profile-nav">
                        <div class="profile-setting-nav" id="btn-notification-popup">
                            <div>
                                <i class='bx bx-bell'></i>
                                <span class="notif-badge" id="notif-badge"></span>
                            </div>
                        </div>
                        <div class="profile-setting-nav" id="btn-setting-popup">
                            <div>
                                <i class='bx bx-dots-vertical-rounded'></i>
                            </div>
                        </div>
                    </div>
                @endif
            </nav>
            <nav class="box-nav-search">
                <div class="menu-nav-header btnAside">
                    <div>
                        <i class='bx bx-menu'></i>
                    </div>
                </div>
                <div>
                    <i class='bx bx-search'></i>
                    <input type="search" placeholder="Search">
                </div>
            </nav>
        </div>
    </main>
</div>

{{-- Setting Popup Backdrop --}}
<div class="setting-backdrop" id="setting-backdrop"></div>

{{-- Setting Popup (di luar nav agar tidak terperangkap stacking context) --}}
@if (Auth::User()->role == 'user')
    <div class="setting-popup" id="setting-popup">
        <div class="setting-popup-header">
            <h4>Pengaturan</h4>
            <button class="setting-popup-close" id="btn-setting-close">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div class="setting-popup-body">
            {{-- Dark Mode --}}
            <div class="setting-item">
                <div class="setting-item-info">
                    <div class="setting-item-icon">
                        <i class='bx bx-moon'></i>
                    </div>
                    <div>
                        <h5>Mode Gelap</h5>
                        <h6>Tampilan lebih nyaman di malam hari</h6>
                    </div>
                </div>
                <label class="setting-toggle">
                    <input type="checkbox" id="toggle-darkmode">
                    <span class="setting-toggle-slider"></span>
                </label>
            </div>

            <div class="setting-divider"></div>

            {{-- Notifikasi --}}
            <div class="setting-item">
                <div class="setting-item-info">
                    <div class="setting-item-icon">
                        <i class='bx bx-bell'></i>
                    </div>
                    <div>
                        <h5>Notifikasi</h5>
                        <h6>Pengingat jadwal belajar</h6>
                    </div>
                </div>
                <label class="setting-toggle">
                    <input type="checkbox" id="toggle-notification">
                    <span class="setting-toggle-slider"></span>
                </label>
            </div>
        </div>
    </div>
    {{-- Notification Popup --}}
    <div class="notif-popup" id="notif-popup">
        <div class="notif-popup-header">
            <h4>Notifikasi</h4>
            <div class="notif-popup-actions">
                <button class="notif-clear-btn" id="btn-notif-clear" title="Hapus semua">
                    <i class='bx bx-trash'></i>
                </button>
                <button class="setting-popup-close" id="btn-notif-close">
                    <i class='bx bx-x'></i>
                </button>
            </div>
        </div>
        <div class="notif-popup-body" id="notif-popup-body">
            {{-- Notifications will be injected here by JS --}}
            <div class="notif-empty" id="notif-empty">
                <div class="notif-empty-icon">
                    <i class='bx bx-bell-off'></i>
                </div>
                <h5>Belum ada notifikasi</h5>
                <p>Notifikasi jadwal belajar akan muncul di sini</p>
            </div>
        </div>
    </div>
@endif

<script>
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
        const isDark = localStorage.getItem(darkKey) === 'true';

        if (isDark) {
            document.body.classList.add('dark-mode');
            if (toggleDark) toggleDark.checked = true;
        }

        if (toggleDark) {
            toggleDark.addEventListener('change', () => {
                const on = toggleDark.checked;
                document.body.classList.toggle('dark-mode', on);
                localStorage.setItem(darkKey, on);

                // Update icon
                const icon = toggleDark.closest('.setting-item').querySelector('.setting-item-icon i');
                if (icon) {
                    icon.className = on ? 'bx bxs-moon' : 'bx bx-moon';
                }
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
    })();

    // ── Notification Popup ──────────────────────────────────────────────
    (function () {
        const btnOpen   = document.getElementById('btn-notification-popup');
        const btnClose  = document.getElementById('btn-notif-close');
        const btnClear  = document.getElementById('btn-notif-clear');
        const popup     = document.getElementById('notif-popup');
        const backdrop  = document.getElementById('setting-backdrop');
        const badge     = document.getElementById('notif-badge');
        const bodyEl    = document.getElementById('notif-popup-body');
        const emptyEl   = document.getElementById('notif-empty');

        if (!btnOpen || !popup) return;

        const STORAGE_KEY = 'tc_notifications_list';
        const MAX_NOTIFS  = 50;

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
                start:    'bx bx-book-open',
                end:      'bx bx-coffee',
                reminder: 'bx bx-bell',
                system:   'bx bx-info-circle',
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
</script>
















{{-- <div class="container container-nav navbar" id="navBar">
    <nav class="main-nav">
        <div class="wrapper-nav">
            <div class="box-nav">
                <div>
                    <div id="btnAside">
                        <i class="bx bx-menu"></i>
                    </div>
                    <div>
                        <h4>turning code
                            @if (auth()->user()->role == 'admin')
                            - admin
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
            <div class="box-nav">
                <div>
                    <div>
                        <i class="bx bx-message"></i>
                    </div>
                    <div>
                        <i class="bx bx-search" id="searchBar"></i>
                        <input type="search" placeholder="Pencarian">
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="space-nav-header"></div>
@if ($page == 'home')
<div class="container container-nav-header">
    <header class="main-nav-header">
        <div class="wrapper-nav-header">
            <main class="box-nav-header">
                <div class="cover-nav-header">
                    <div>
                        <h4>halloo!!, hanzzsama</h4>
                        <h5>bingung mau jadi apa?, sini jadi programmer </h5>
                    </div>
                </div>
                <div class="thumb-cover-nav-header">
                    <img src="{{ asset('assets/img/img001cover.jpg') }}" alt="">
                </div>
                <div class="thumb-nav-header">
                    <img src="{{ asset('assets/ico/img002.png') }}" alt="">
                </div>
            </main>
        </div>
    </header>
</div>
@endif
<script>
    window.addEventListener("scroll", () => {
        const navbar = document.getElementById("navBar");

        if (!navbar) return;

        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
</script> --}}
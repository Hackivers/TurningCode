<!-- ROTOOD MODERN NAVBAR -->
<div class="rtd-top-nav @if (Auth::User()->role == 'admin') admin @endif" id="navBar">
    <div class="rtd-nav-left">
        <button class="rtd-btn-icon btnAside">
            <i class='bx bx-menu'></i>
        </button>
        <div class="rtd-nav-title">
            <h4>TurningCode</h4>
            <p>Care with {{ explode(' ', Auth::user()->name)[0] }}</p>
        </div>
    </div>

    <div class="rtd-nav-center">
        <div class="rtd-search-pill">
            <i class='bx bx-search'></i>
            <input type="search" id="global-search-input" placeholder="Search for courses, hints...">
        </div>
    </div>

    <div class="rtd-nav-right">
        @if (Auth::User()->role == 'user')
            <button class="rtd-btn-icon" id="btn-friend-search-popup" title="Cari Teman">
                <i class='bx bx-user-plus'></i>
            </button>
            <button class="rtd-btn-icon" id="btn-notification-popup">
                <i class='bx bx-bell'></i>
                <span class="notif-badge" id="notif-badge"></span>
            </button>
            <button class="rtd-btn-icon" id="btn-setting-popup">
                <i class='bx bx-slider-alt'></i>
            </button>
            <div class="rtd-nav-profile {{ Auth::user()->isPenguasaSektor() ? 'sovereign-aura' : (Auth::user()->isElite() ? 'elite-aura' : '') }}"
                id="btn-profile-popup" data-elite-tier="{{ Auth::user()->elite_tier }}">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                @else
                    <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                @endif
            </div>
        @endif
    </div>
</div>

{{-- Setting Popup Backdrop --}}
<div class="setting-backdrop" id="setting-backdrop"></div>

{{-- ═══════════════════════════════════════════════════════
SETTINGS POPUP OVERLAY (ADMIN STYLE)
═══════════════════════════════════════════════════════ --}}
@if (Auth::User()->role == 'user')
    <div class="setting-popup-dark" id="setting-popup">
        <div class="spd-header">
            <div class="spd-header-left">
                <div class="spd-icon-wrapper">
                    <i class='bx bx-slider-alt'></i>
                </div>
                <div>
                    <h3>Pengaturan</h3>
                    <p>Kelola preferensi akun dan tampilan</p>
                </div>
            </div>
            <button class="spd-close" id="btn-setting-close"><i class='bx bx-x'></i></button>
        </div>
        <div class="spd-body">
            <div class="spd-grid">

                {{-- Notifikasi --}}
                <label class="spd-card" for="toggle-notification">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-bell'></i></div>
                        <div class="spd-toggle">
                            <input type="checkbox" id="toggle-notification">
                            <span class="spd-slider"></span>
                        </div>
                    </div>
                    <h4>Notifikasi</h4>
                    <p>Aktifkan pengingat jadwal belajar.</p>
                </label>

                {{-- Dark Mode --}}
                <label class="spd-card" for="toggle-darkmode">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-moon'></i></div>
                        <div class="spd-toggle">
                            <input type="checkbox" id="toggle-darkmode">
                            <span class="spd-slider"></span>
                        </div>
                    </div>
                    <h4>Mode Gelap</h4>
                    <p>Tampilan yang nyaman untuk malam hari.</p>
                </label>

                {{-- Data & Storage --}}
                <div class="spd-card" style="cursor: default; opacity: 0.7;">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-data'></i></div>
                        <span class="spd-badge">BETA</span>
                    </div>
                    <h4>Data & Penyimpanan</h4>
                    <p>Kelola riwayat cache perangkat.</p>
                </div>

                {{-- Bahasa --}}
                <div class="spd-card" style="cursor: default;">
                    <div class="spd-card-header">
                        <div class="spd-card-icon"><i class='bx bx-globe'></i></div>
                        <span class="spd-badge-green">ID</span>
                    </div>
                    <h4>Bahasa Server</h4>
                    <p>Bahasa standar sistem Indonesia.</p>
                </div>

            </div>
        </div>
    </div>
    {{-- Profile Detail Popup --}}
    <div class="profile-popup-dark" id="profile-popup">
        <div class="ppd-header">
            <div class="ppd-header-left">
                <div
                    class="ppd-avatar-wrap {{ Auth::user()->isPenguasaSektor() ? 'sovereign-aura-sm' : (Auth::user()->isElite() ? 'elite-aura-sm' : '') }}">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="">
                    @else
                        <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                    @endif
                </div>
                <div>
                    <h3
                        class="{{ Auth::user()->isPenguasaSektor() ? 'sovereign-name-sm' : (Auth::user()->isElite() ? 'elite-name-sm' : '') }}">
                        {{ Auth::user()->name }}
                    </h3>
                    <p>{{ explode('@', Auth::user()->email)[0] }}</p>
                </div>
            </div>
            <button class="ppd-close" id="btn-profile-close"><i class='bx bx-x'></i></button>
        </div>
        <div class="ppd-body">
            <div class="ppd-stats">
                <div class="ppd-stat-item">
                    <span class="ppd-stat-val">{{ number_format(Auth::user()->exp ?? 0) }}</span>
                    <span class="ppd-stat-lbl">EXP</span>
                </div>
                <div class="ppd-stat-item">
                    <span class="ppd-stat-val">{{ Auth::user()->rank_name }}</span>
                    <span class="ppd-stat-lbl">Rank</span>
                </div>
            </div>
            <div class="ppd-actions">
                <a href="#" data-spa-page="account" class="ppd-btn-action" id="btn-profile-goto-account">
                    <i class='bx bx-user'></i>
                    <span>Buka Profil Lengkap</span>
                </a>
                <a href="{{ route('logout') }}" class="ppd-btn-action logout">
                    <i class='bx bx-log-out'></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Notification Popup --}}
    <div class="notif-popup-dark" id="notif-popup">
        <div class="npd-header">
            <div class="npd-header-left">
                <div class="npd-icon-wrapper">
                    <i class='bx bx-bell'></i>
                </div>
                <div>
                    <h3>Notifikasi</h3>
                    <p>Pemberitahuan jadwal belajar</p>
                </div>
            </div>
            <div class="npd-actions">
                <button class="npd-btn" id="btn-notif-clear" title="Hapus semua">
                    <i class='bx bx-check-double'></i>
                </button>
                <button class="npd-btn" id="btn-notif-close">
                    <i class='bx bx-x'></i>
                </button>
            </div>
        </div>
        <div class="npd-body" id="notif-popup-body">
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

    {{-- Friend Search Popup --}}
    <div class="notif-popup-dark fs-popup" id="friend-search-popup">
        <div class="fs-header">
            <div class="fs-header-top">
                <div class="npd-header-left">
                    <div class="npd-icon-wrapper" style="background: rgba(16,185,129,0.1); color: #34d399;">
                        <i class='bx bx-user-plus'></i>
                    </div>
                    <div>
                        <h3>Cari Teman</h3>
                        <p>Tambahkan teman baru</p>
                    </div>
                </div>
                <button class="npd-btn" id="btn-friend-search-close">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <div class="fs-search-bar">
                <i class='bx bx-search'></i>
                <input type="text" id="input-friend-search" placeholder="Cari nama atau email..." autocomplete="off">
            </div>
        </div>
        <div class="fs-body" id="friend-search-body">
            <div class="fs-state" id="friend-search-empty">
                <div class="fs-state-icon">
                    <i class='bx bx-group'></i>
                </div>
                <h5>Ketik untuk mencari</h5>
                <p>Cari pengguna berdasarkan nama/email</p>
            </div>
            <div class="fs-state" id="friend-search-loading" style="display: none;">
                <i class='bx bx-loader-alt bx-spin' style="font-size: 28px; color: #52525b;"></i>
                <h5>Mencari...</h5>
            </div>
            <div class="fs-results" id="friend-search-results"></div>
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
                const res = await fetch(`{{ route('user.friend.search') }}?q=${encodeURIComponent(query)}`);
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
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
</script>

<style>
    /* ═══ NEO-LIGHT NAVBAR GLOBAL ═══ */
    .rtd-top-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 32px;
        background: transparent;
        transition: background 0.3s, backdrop-filter 0.3s, padding 0.3s;
        position: sticky;
        top: 0;
        z-index: 50;
        backdrop-filter: blur(16px);
        background: rgba(236, 236, 236, 0.85);
        font-family: 'Inter', sans-serif;
    }

    .rtd-top-nav.scrolled {
        background: rgba(236, 236, 236, 0.85);
        /* syncs with var(--neo-bg) */
        backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 12px 32px;
    }

    .rtd-nav-left,
    .rtd-nav-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .rtd-nav-title {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-left: 12px;
    }

    .rtd-nav-title h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 800;
        color: #121212;
        letter-spacing: 0.5px;
        line-height: 1.2;
    }

    .rtd-nav-title p {
        margin: 0;
        font-size: 11px;
        color: #666;
        font-weight: 500;
    }

    .rtd-btn-icon {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #444;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        padding: 0;
    }

    .rtd-btn-icon:hover {
        background: #121212;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border-color: #121212;
    }

    .notif-badge {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 16px;
        height: 16px;
        background: #121212;
        border-radius: 50%;
        color: white;
        border: 2px solid white;
        font-size: 9px;
        font-weight: bold;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .notif-badge.active {
        display: flex;
    }

    .rtd-search-pill {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        /* width: 400px; */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .rtd-search-pill:focus-within {
        border-color: #121212;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
    }

    .rtd-search-pill i {
        color: #888;
        font-size: 18px;
        margin: 0 15px;
    }

    .rtd-search-pill input {
        background: transparent;
        border: none;
        padding: 10px 24px;
        color: #121212;
        outline: none;
        font-size: 14px;
        font-weight: 500;
        /* width: 100%; */
        font-family: inherit;
    }

    .rtd-search-pill input::placeholder {
        color: #aaa;
        font-weight: 400;
    }

    .rtd-nav-profile {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s;
    }

    .rtd-nav-profile:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-color: #121212;
    }

    .rtd-nav-profile img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ═══ COSMIC AURA (Elite Users) ═══ */
    .rtd-nav-profile.elite-aura {
        border: 2px solid transparent;
        background-image: linear-gradient(#fff, #fff), linear-gradient(135deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        animation: auraRotate 3s linear infinite;
        box-shadow: 0 0 14px rgba(139, 92, 246, 0.3), 0 0 28px rgba(236, 72, 153, 0.15);
        position: relative;
    }

    .rtd-nav-profile.elite-aura::before {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: conic-gradient(from var(--aura-angle, 0deg), #8b5cf6, #ec4899, #f59e0b, #10b981, #3b82f6, #8b5cf6);
        z-index: -1;
        opacity: 0.4;
        filter: blur(6px);
        animation: auraGlow 3s linear infinite;
    }

    .rtd-nav-profile.elite-aura:hover {
        box-shadow: 0 0 20px rgba(139, 92, 246, 0.5), 0 0 40px rgba(236, 72, 153, 0.25);
        transform: translateY(-3px) scale(1.05);
    }

    @keyframes auraRotate {
        0% {
            background-image: linear-gradient(#fff, #fff), linear-gradient(0deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        }

        25% {
            background-image: linear-gradient(#fff, #fff), linear-gradient(90deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        }

        50% {
            background-image: linear-gradient(#fff, #fff), linear-gradient(180deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        }

        75% {
            background-image: linear-gradient(#fff, #fff), linear-gradient(270deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        }

        100% {
            background-image: linear-gradient(#fff, #fff), linear-gradient(360deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        }
    }

    /* ═══ SOVEREIGN AURA (Penguasa Sektor) ═══ */
    .rtd-nav-profile.sovereign-aura {
        border: 2px solid transparent;
        background-image: linear-gradient(#fff, #fff), linear-gradient(135deg, #d946ef, #fbbf24, #f59e0b, #d946ef);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        animation: auraRotate 3s linear infinite;
        box-shadow: 0 0 16px rgba(217, 70, 239, 0.4), 0 0 32px rgba(251, 191, 36, 0.2);
        position: relative;
    }

    .rtd-nav-profile.sovereign-aura::before {
        content: '';
        position: absolute;
        inset: -5px;
        border-radius: 50%;
        background: conic-gradient(from var(--aura-angle, 0deg), #d946ef, #fbbf24, #f59e0b, #a855f7, #d946ef);
        z-index: -1;
        opacity: 0.5;
        filter: blur(8px);
        animation: auraGlow 3s linear infinite;
    }

    .rtd-nav-profile.sovereign-aura:hover {
        box-shadow: 0 0 24px rgba(217, 70, 239, 0.6), 0 0 48px rgba(251, 191, 36, 0.3);
        transform: translateY(-3px) scale(1.05);
    }


    @keyframes auraGlow {
        0% {
            opacity: 0.3;
            transform: rotate(0deg);
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 0.3;
            transform: rotate(360deg);
        }
    }

    @media (max-width: 820px) {
        .rtd-top-nav {
            padding: 12px 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .rtd-top-nav.scrolled {
            padding: 12px 16px;
        }

        .rtd-nav-center {
            order: 3;
            width: 100%;
        }

        .rtd-search-pill {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .rtd-nav-title p {
            display: none;
        }

        .rtd-nav-left,
        .rtd-nav-right {
            gap: 8px;
        }

        .rtd-btn-icon {
            width: 36px;
            height: 36px;
            font-size: 18px;
        }

        .rtd-nav-profile {
            width: 36px;
            height: 36px;
        }
    }

    /* ═══ PROFILE DETAIL POPUP ═══ */
    .profile-popup-dark {
        position: fixed;
        top: 70px;
        right: 16px;
        width: 320px;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px) scale(0.98);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        transform-origin: top right;
        overflow: hidden;
    }

    .profile-popup-dark.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .ppd-header {
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        background: #fafafa;
    }

    .ppd-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .ppd-avatar-wrap {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
    }

    .ppd-avatar-wrap.elite-aura-sm {
        border: 2px solid transparent;
        background-image: linear-gradient(#fff, #fff), linear-gradient(135deg, #8b5cf6, #ec4899, #f59e0b, #8b5cf6);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        box-shadow: 0 0 10px rgba(139, 92, 246, 0.25), 0 0 20px rgba(236, 72, 153, 0.12);
    }

    .ppd-avatar-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ppd-header-left h3 {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 800;
        color: #121212;
        letter-spacing: -0.3px;
    }

    .ppd-header-left h3.elite-name-sm {
        background: linear-gradient(135deg, #8b5cf6, #ec4899);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
    }

    .ppd-avatar-wrap.sovereign-aura-sm {
        border: 2px solid transparent;
        background-image: linear-gradient(#fff, #fff), linear-gradient(135deg, #d946ef, #fbbf24, #f59e0b, #d946ef);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        box-shadow: 0 0 12px rgba(217, 70, 239, 0.3), 0 0 24px rgba(251, 191, 36, 0.15);
    }

    .ppd-header-left h3.sovereign-name-sm {
        background: linear-gradient(135deg, #fbbf24, #d946ef);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 900;
        letter-spacing: -0.2px;
    }

    .ppd-header-left p {
        margin: 0;
        font-size: 13px;
        color: #888;
        font-weight: 500;
    }

    .ppd-close {
        background: none;
        border: none;
        color: #888;
        font-size: 24px;
        cursor: pointer;
        padding: 4px;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ppd-close:hover {
        background: rgba(0, 0, 0, 0.05);
        color: #121212;
    }

    .ppd-body {
        padding: 20px 24px 24px;
    }

    .ppd-stats {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .ppd-stat-item {
        flex: 1;
        background: #f5f5f5;
        border-radius: 16px;
        padding: 12px;
        text-align: center;
    }

    .ppd-stat-val {
        display: block;
        font-size: 16px;
        font-weight: 800;
        color: #121212;
        margin-bottom: 2px;
    }

    .ppd-stat-lbl {
        display: block;
        font-size: 11px;
        color: #888;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .ppd-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .ppd-btn-action {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #f5f5f5;
        border-radius: 14px;
        color: #121212;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .ppd-btn-action:hover {
        background: #e5e5e5;
        transform: translateY(-2px);
    }

    .ppd-btn-action i {
        font-size: 20px;
        color: #888;
    }

    .ppd-btn-action:hover i {
        color: #121212;
    }

    .ppd-btn-action.logout {
        background: rgba(244, 63, 94, 0.1);
        color: #f43f5e;
    }

    .ppd-btn-action.logout:hover {
        background: rgba(244, 63, 94, 0.15);
    }

    .ppd-btn-action.logout i {
        color: #f43f5e;
    }

    @media (max-width: 820px) {
        .profile-popup-dark {
            width: calc(100% - 32px);
            right: 16px;
            left: 16px;
            top: 64px;
        }
    }

    /* ═══ ADMIN-STYLE SETTING POPUP ═══ */
    .setting-backdrop.active {
        background: rgba(0, 0, 0, 0.1) !important;
        backdrop-filter: blur(2px);
        opacity: 1;
        visibility: visible;
        position: fixed;
        inset: 0;
        z-index: 99;
        transition: all 0.3s;
    }

    .setting-popup-dark {
        position: fixed;
        top: 90px;
        right: 32px;
        transform: translateY(-10px) scale(0.95);
        transform-origin: top right;
        opacity: 0;
        visibility: hidden;
        width: calc(100% - 64px);
        max-width: 440px;
        background: #111113;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
        z-index: 100;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        color: #fff;
        font-family: 'Inter', sans-serif;
    }

    .setting-popup-dark.active {
        transform: translateY(0) scale(1);
        opacity: 1;
        visibility: visible;
    }

    @media (max-width: 768px) {
        .setting-popup-dark {
            top: 80px;
            right: 16px;
            width: calc(100% - 32px);
            max-width: 400px;
        }
    }

    .spd-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        border-bottom: 1px solid #27272a;
    }

    .spd-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .spd-icon-wrapper {
        width: 44px;
        height: 44px;
        background: #27272a;
        color: #d4d4d8;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .spd-header-left h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
        letter-spacing: 0.5px;
        color: #fff;
    }

    .spd-header-left p {
        margin: 0;
        font-size: 12px;
        color: #a1a1aa;
    }

    .spd-close {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: transparent;
        border: none;
        color: #71717a;
        font-size: 22px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .spd-close:hover {
        background: #27272a;
        color: #f4f4f5;
    }

    .spd-body {
        background: #111113;
        padding: 24px;
        border-radius: 0 0 24px 24px;
    }

    .spd-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .spd-card {
        background: #1a1a1e;
        border-radius: 18px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid #27272a;
        display: block;
    }

    .spd-card:hover {
        border-color: #3f3f46;
        background: #222226;
        transform: translateY(-2px);
    }

    .spd-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .spd-card-icon {
        width: 44px;
        height: 44px;
        background: #27272a;
        color: #a1a1aa;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: color 0.3s;
    }

    .spd-card:hover .spd-card-icon {
        color: #fff;
    }

    .spd-card h4 {
        margin: 0 0 6px 0;
        font-size: 15px;
        font-weight: 700;
        color: #f4f4f5;
    }

    .spd-card p {
        margin: 0;
        font-size: 12px;
        color: #a1a1aa;
        line-height: 1.5;
    }

    .spd-badge,
    .spd-badge-green {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 4px 10px;
        border-radius: 8px;
    }

    .spd-badge {
        color: #a1a1aa;
        background: #27272a;
    }

    .spd-badge-green {
        color: #34d399;
        background: rgba(52, 211, 153, 0.1);
    }

    .spd-toggle {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .spd-toggle input {
        display: none;
    }

    .spd-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #3f3f46;
        transition: .4s;
        border-radius: 24px;
    }

    .spd-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .spd-toggle input:checked+.spd-slider {
        background-color: #10b981;
    }

    .spd-toggle input:checked+.spd-slider:before {
        transform: translateX(20px);
    }

    /* ═══ NOTIFICATION POPUP DARK ═══ */
    .notif-popup-dark {
        position: fixed;
        top: 90px;
        right: 84px;
        /* Shift slightly left of profile */
        transform: translateY(-10px) scale(0.95);
        transform-origin: top right;
        opacity: 0;
        visibility: hidden;
        width: calc(100% - 64px);
        max-width: 420px;
        max-height: 520px;
        background: #111113;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
        z-index: 100;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        color: #fff;
        font-family: 'Inter', sans-serif;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .notif-popup-dark.active {
        transform: translateY(0) scale(1);
        opacity: 1;
        visibility: visible;
    }

    @media (max-width: 768px) {
        .notif-popup-dark {
            top: 80px;
            right: 16px;
            width: calc(100% - 32px);
            max-width: 400px;
        }
    }

    .npd-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #27272a;
        flex-shrink: 0;
    }

    .npd-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .npd-icon-wrapper {
        width: 38px;
        height: 38px;
        background: rgba(99, 102, 241, 0.1);
        color: #818cf8;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .npd-header-left h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 800;
        color: #fff;
    }

    .npd-header-left p {
        margin: 0;
        font-size: 11px;
        color: #a1a1aa;
    }

    .npd-actions {
        display: flex;
        gap: 8px;
    }

    .npd-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: transparent;
        border: none;
        color: #71717a;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .npd-btn:hover {
        background: #27272a;
        color: #fff;
    }

    .npd-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
        background: #0e0e10;
    }

    .notif-date-header h6 {
        margin: 12px 8px 8px 8px;
        font-size: 11px;
        color: #71717a;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        border-radius: 16px;
        cursor: pointer;
        transition: background 0.2s;
        margin-bottom: 4px;
        position: relative;
    }

    .notif-item:hover {
        background: #1a1a1e;
    }

    .notif-item.unread {
        background: rgba(255, 255, 255, 0.03);
    }

    .notif-item.unread:hover {
        background: #1a1a1e;
    }

    .notif-item-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        border: 1px solid transparent;
    }

    .notif-item-content {
        flex: 1;
        min-width: 0;
    }

    .notif-item-content h5 {
        margin: 0 0 4px 0;
        font-size: 14px;
        font-weight: 700;
        color: #f4f4f5;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .notif-item-content p {
        margin: 0 0 8px 0;
        font-size: 12px;
        color: #a1a1aa;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .notif-item-time {
        font-size: 10px;
        color: #52525b;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
    }

    .notif-item-dismiss {
        width: 28px;
        height: 28px;
        background: transparent;
        border: none;
        color: #52525b;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: all 0.2s;
    }

    .notif-item:hover .notif-item-dismiss {
        opacity: 1;
    }

    .notif-item-dismiss:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
    }

    .notif-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        text-align: center;
        height: 100%;
        min-height: 240px;
    }

    .notif-empty-icon {
        width: 56px;
        height: 56px;
        background: #1a1a1e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #3f3f46;
        margin-bottom: 20px;
    }

    .notif-empty h5 {
        margin: 0 0 8px 0;
        font-size: 15px;
        font-weight: 700;
        color: #d4d4d8;
    }

    .notif-empty p {
        margin: 0;
        font-size: 12px;
        color: #71717a;
    }

    .notif-badge.active {
        background: #ef4444 !important;
        color: #fff !important;
        border-color: #121212 !important;
    }

    /* ═══ FRIEND SEARCH POPUP ═══ */
    .fs-popup {
        max-height: 560px;
    }

    .fs-header {
        padding: 20px 20px 16px;
        border-bottom: 1px solid #27272a;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .fs-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .fs-search-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #1a1a1c;
        border: 1px solid #2a2a2e;
        border-radius: 12px;
        padding: 10px 14px;
        transition: border-color 0.2s;
    }

    .fs-search-bar:focus-within {
        border-color: #34d399;
    }

    .fs-search-bar i {
        color: #52525b;
        font-size: 18px;
        flex-shrink: 0;
    }

    .fs-search-bar input {
        background: transparent;
        border: none;
        outline: none;
        color: #f4f4f5;
        font-size: 14px;
        font-family: inherit;
        width: 100%;
    }

    .fs-search-bar input::placeholder {
        color: #52525b;
    }

    .fs-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
        background: #0e0e10;
    }

    .fs-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px 20px;
        text-align: center;
        min-height: 200px;
    }

    .fs-state-icon {
        width: 52px;
        height: 52px;
        background: #1a1a1e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #3f3f46;
        margin-bottom: 16px;
    }

    .fs-state h5 {
        margin: 0 0 6px;
        font-size: 14px;
        font-weight: 700;
        color: #d4d4d8;
    }

    .fs-state p {
        margin: 0;
        font-size: 12px;
        color: #52525b;
    }

    .fs-results {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .fs-user-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        border-radius: 12px;
        transition: background 0.15s;
    }

    .fs-user-row:hover {
        background: #1a1a1e;
    }

    .fs-user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }

    .fs-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid #27272a;
    }

    .fs-user-meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
        overflow: hidden;
    }

    .fs-user-name {
        font-weight: 600;
        font-size: 14px;
        color: #f4f4f5;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .fs-user-rank {
        font-size: 12px;
        color: #71717a;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .fs-user-rank i {
        color: #f59e0b;
        font-size: 12px;
    }

    .fs-user-action {
        flex-shrink: 0;
        margin-left: 12px;
    }

    .fs-btn {
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        gap: 4px;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.15s;
    }

    .fs-btn-add {
        background: #fff;
        color: #121212;
    }

    .fs-btn-add:hover {
        background: #34d399;
        color: #fff;
    }

    .fs-btn-pending {
        background: rgba(255, 255, 255, 0.06);
        color: #71717a;
        cursor: not-allowed;
    }

    .fs-btn-friends {
        background: rgba(16, 185, 129, 0.1);
        color: #34d399;
        cursor: default;
    }
</style>
















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
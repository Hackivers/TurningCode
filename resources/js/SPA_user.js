import './bootstrap';

const body = document.body;
const base = body.dataset.spaBase;
const urlParams = new URLSearchParams(window.location.search);
const initial = urlParams.get('page') || body.dataset.spaInitial || 'dashboard';
const initialParams = {};
urlParams.forEach((val, key) => {
    if (key !== 'page') initialParams[key] = val;
});
const el = document.getElementById('spa-content');

// ─────────────────────────────────────────────────────────────────────────────
// MATERIAL SLIDER
// Dipanggil setiap kali konten baru di-inject ke #spa-content
// ─────────────────────────────────────────────────────────────────────────────
function initMaterialSlider() {
    const wrapper = document.querySelector('.wrapper-materi');
    if (!wrapper) return;

    const cards = Array.from(wrapper.querySelectorAll('.box-materi'));
    if (!cards.length) return;

    // ── Helper: set satu card jadi active ────────────────────────────
    function setActive(targetCard) {
        cards.forEach(c => c.classList.remove('active'));
        targetCard.classList.add('active');
    }

    // ── Helper: scroll wrapper agar card tepat di tengah ─────────────
    // offsetLeft dan scrollLeft bekerja dalam coordinate space yang sama
    // di dalam scroll container, jadi TIDAK perlu kompensasi padding.
    function centerCard(card, smooth = true) {
        const targetLeft = card.offsetLeft + card.offsetWidth / 2 - wrapper.clientWidth / 2;

        if (smooth) {
            wrapper.scrollTo({ left: targetLeft, behavior: 'smooth' });
        } else {
            wrapper.scrollLeft = targetLeft;
        }
    }

    // ── Cari card paling dekat ke center viewport wrapper ─────────────
    function getClosestCard() {
        const viewCenter = wrapper.scrollLeft + wrapper.clientWidth / 2;

        let closest = null;
        let minDist = Infinity;

        cards.forEach(card => {
            const cardCenter = card.offsetLeft + card.offsetWidth / 2;
            const dist = Math.abs(viewCenter - cardCenter);
            if (dist < minDist) {
                minDist = dist;
                closest = card;
            }
        });

        return closest;
    }

    // ── Scroll handler: highlight realtime + snap setelah berhenti ────
    let scrollTimer = null;
    wrapper.addEventListener('scroll', () => {
        const closest = getClosestCard();
        if (closest) setActive(closest);

        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(() => {
            const snap = getClosestCard();
            if (snap) {
                setActive(snap);
                centerCard(snap, true);
            }
        }, 180);
    }, { passive: true });

    // ── Klik card di kiri/kanan → auto center + active ─────────────────
    cards.forEach(card => {
        card.addEventListener('click', (e) => {
            // Jika card belum active, center dulu dan stop event
            // agar .link-spa di dalamnya tidak langsung navigasi
            if (!card.classList.contains('active')) {
                e.preventDefault();
                e.stopPropagation();
                setActive(card);
                centerCard(card, true);
            }
        });
    });

    // ── Expose centerCard & setActive agar bisa dipakai body handler ──
    // Simpan referensi ke wrapper ini (support multi-instance)
    wrapper._sliderCenterCard = centerCard;
    wrapper._sliderSetActive = setActive;
    wrapper._sliderCards = cards;

    // ── Posisi awal: card tengah auto-center tanpa animasi ────────────
    // double-rAF: frame pertama untuk commit layout,
    // frame kedua untuk read offsetLeft setelah paint selesai,
    // + timeout kecil untuk pastikan gambar sudah mempengaruhi layout.
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            setTimeout(() => {
                const mid = Math.floor(cards.length / 2);
                const startCard = cards[mid] ?? cards[0];
                setActive(startCard);
                centerCard(startCard, false); // langsung, tanpa smooth
            }, 50);
        });
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// LOAD PAGE (SPA AJAX)
// ─────────────────────────────────────────────────────────────────────────────

/** Parse href ?page=X&key=val → { page, params } */
function parseSpaLink(href) {
    try {
        const url = new URL(href, location.origin);
        const page = url.searchParams.get('page');
        const params = {};
        url.searchParams.forEach((val, key) => {
            if (key !== 'page') params[key] = val;
        });
        return { page, params };
    } catch {
        return { page: null, params: {} };
    }
}

/** Highlight icon bottom-nav dan sidebar yang sesuai halaman aktif */
function updateNavBottom(activePage) {
    // Bottom Nav
    document.querySelectorAll('.box-nav-bottom').forEach(item => {
        const icon = item.querySelector('.icon-nav-bottom');
        if (!icon) return;
        icon.classList.toggle('active', item.dataset.page === activePage);
    });

    // Sidebar Nav (Neo-Minimalist)
    document.querySelectorAll('.neo-nav-link').forEach(link => {
        link.classList.toggle('active', link.dataset.spaPage === activePage);
    });
}

/** Re-execute <script> yang ada di dalam HTML yang baru di-inject */
function rehydrateScripts(container) {
    container.querySelectorAll('script').forEach(old => {
        const fresh = document.createElement('script');
        if (old.src) {
            fresh.src = old.src;
        } else {
            fresh.textContent = old.textContent;
        }
        old.replaceWith(fresh);
    });
}

async function loadPage(page, params = {}, pushState = true) {
    if (!base || !el) return;

    let url = `${base.replace(/\/$/, '')}/${encodeURIComponent(page)}`;
    const qs = new URLSearchParams(params).toString();
    if (qs) url += `?${qs}`;

    el.style.opacity = '1';
    el.innerHTML = `
        <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding: 4rem 1rem;">
            <svg class="animate-spin text-indigo-500" style="height:2rem; width:2rem; margin-bottom:1rem; animation: spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p style="font-size:0.875rem; color:#6b7280; font-weight:500;">Memuat data...</p>
            <style>
                @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                .animate-spin { animation: spin 1s linear infinite; }
            </style>
        </div>
    `;

    try {
        const res = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
            credentials: 'same-origin',
        });

        if (!res.ok) {
            el.innerHTML = '<p style="text-align:center;padding:2em;color:#ef4444;">Gagal memuat halaman.</p>';
            return;
        }

        const searchInput = document.getElementById('global-search-input');
        if (searchInput) searchInput.value = '';
        window.__currentSearchHandler = null;

        el.innerHTML = await res.text();
        rehydrateScripts(el);

        window.scrollTo({ top: 0, behavior: 'smooth' });
        updateNavBottom(page);

        const navBar = document.getElementById('navBar');
        if (navBar) {
            if (page === 'account') {
                navBar.style.display = 'none';
            } else {
                navBar.style.display = '';
            }
        }

        // ── Inisialisasi slider setelah konten di-inject ──────────────
        initMaterialSlider();

        // ── Push State ke URL (agar tidak reset saat refresh) ────────────
        if (pushState) {
            const qsObj = new URLSearchParams({ page, ...params });
            window.history.pushState({ page, params }, '', `?${qsObj.toString()}`);
        }

    } catch (err) {
        // Network error — store failed page for retry
        window.__lastFailedPage = { page, params };
        el.innerHTML = '<p style="text-align:center;padding:2em;color:#ef4444;">Gagal memuat halaman.</p>';
    } finally {
        el.style.opacity = '1';
    }
}

// Expose globally (dipakai tombol back di detail page)
window.loadPage = loadPage;

// ─────────────────────────────────────────────────────────────────────────────
// OFFLINE DETECTION & OVERLAY
// Menggunakan real internet check via external CDN ping, karena
// navigator.onLine hanya cek interface jaringan lokal (unreliable).
// ─────────────────────────────────────────────────────────────────────────────

let __isOffline = false;          // state tracking
let __connectivityTimer = null;   // interval ID

/**
 * Cek koneksi internet REAL dengan ping ke external resource.
 * Fetch tiny favicon dari CDN external (unpkg.com) dengan timeout 5 detik.
 * Return true jika internet tersedia, false jika tidak.
 */
async function checkRealInternet() {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 5000);

    try {
        // Ping ke CDN external yang sudah dipakai app ini (boxicons dari unpkg)
        // mode: 'no-cors' agar tidak kena CORS block, kita cuma perlu tahu berhasil/gagal
        await fetch('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css', {
            method: 'HEAD',
            mode: 'no-cors',
            cache: 'no-store',
            signal: controller.signal,
        });
        clearTimeout(timeoutId);
        return true;
    } catch {
        clearTimeout(timeoutId);
        return false;
    }
}

function showOfflineOverlay() {
    if (__isOffline) return; // sudah tampil
    __isOffline = true;

    const overlay = document.getElementById('offline-overlay');
    if (!overlay) return;
    overlay.classList.add('active');
    overlay.classList.remove('reconnecting');
    document.body.classList.add('no-scroll');

    // Reset ke state offline
    const icon = overlay.querySelector('.offline-icon i');
    const statusText = overlay.querySelector('.offline-status span:last-child');
    const title = overlay.querySelector('.offline-title');
    if (icon) { icon.className = 'bx bx-wifi-off'; }
    if (statusText) { statusText.textContent = 'Offline'; }
    if (title) { title.textContent = 'Tidak Ada Koneksi Internet'; }

    // Mulai polling auto-reconnect setiap 5 detik
    startConnectivityPolling();
}

function hideOfflineOverlay() {
    if (!__isOffline) return; // sudah hidden

    const overlay = document.getElementById('offline-overlay');
    if (!overlay || !overlay.classList.contains('active')) return;

    // Tampilkan animasi "reconnected" sebentar
    overlay.classList.add('reconnecting');

    const icon = overlay.querySelector('.offline-icon i');
    const statusText = overlay.querySelector('.offline-status span:last-child');
    const title = overlay.querySelector('.offline-title');
    if (icon) { icon.className = 'bx bx-wifi'; }
    if (statusText) { statusText.textContent = 'Online'; }
    if (title) { title.textContent = 'Koneksi Terhubung Kembali!'; }

    setTimeout(() => {
        overlay.classList.remove('active');
        overlay.classList.remove('reconnecting');
        document.body.classList.remove('no-scroll');
        __isOffline = false;

        // Reload halaman terakhir yang gagal
        const lastFailed = window.__lastFailedPage;
        if (lastFailed) {
            loadPage(lastFailed.page, lastFailed.params);
            window.__lastFailedPage = null;
        }
    }, 1200);

    // Stop polling
    stopConnectivityPolling();
}

/** Polling otomatis: cek koneksi setiap 5 detik saat offline */
function startConnectivityPolling() {
    stopConnectivityPolling();
    __connectivityTimer = setInterval(async () => {
        const online = await checkRealInternet();
        if (online) {
            hideOfflineOverlay();
        }
    }, 5000);
}

function stopConnectivityPolling() {
    if (__connectivityTimer) {
        clearInterval(__connectivityTimer);
        __connectivityTimer = null;
    }
}

// Retry button handler — manual retry
window.__retryConnection = async function () {
    const btn = document.getElementById('offline-retry-btn');
    if (btn) btn.classList.add('loading');

    const online = await checkRealInternet();

    if (btn) btn.classList.remove('loading');

    if (online) {
        hideOfflineOverlay();
    } else {
        // Masih offline — kasih feedback visual: shake icon
        const iconEl = document.querySelector('.offline-icon');
        if (iconEl) {
            iconEl.style.animation = 'none';
            iconEl.offsetHeight; // trigger reflow
            iconEl.style.animation = '';
        }
    }
};

// ─────────────────────────────────────────────────────────────────────────────
// BOOT
// ─────────────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    // ── Overlay dimulai dalam state "checking" (aktif, menutupi konten) ──
    // Cek koneksi internet DULU sebelum load halaman
    const overlay = document.getElementById('offline-overlay');
    const isOnline = await checkRealInternet();

    if (isOnline) {
        // Internet ada → buang overlay langsung tanpa animasi
        if (overlay) {
            overlay.classList.remove('active', 'checking', 'reconnecting');
            overlay.style.display = 'none';
            // Restore display setelah transisi selesai (untuk pakai nanti)
            setTimeout(() => { overlay.style.display = ''; }, 100);
        }
        __isOffline = false;
        document.body.classList.remove('no-scroll');
    } else {
        // Tidak ada internet → transisi dari "checking" ke offline UI
        if (overlay) {
            overlay.classList.remove('checking');
            // Overlay sudah active, sekarang tampilkan konten offline
        }
        __isOffline = true;
        document.body.classList.add('no-scroll');
        startConnectivityPolling();
    }

    // Load halaman (dari localhost tetap jalan, overlay di atas menutupi jika offline)
    loadPage(initial, initialParams, false);

    // Handle browser Back/Forward (popstate)
    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.page) {
            loadPage(e.state.page, e.state.params, false);
        } else {
            const popParams = new URLSearchParams(window.location.search);
            const popPage = popParams.get('page') || body.dataset.spaInitial || 'dashboard';
            const extraParams = {};
            popParams.forEach((val, key) => {
                if (key !== 'page') extraParams[key] = val;
            });
            loadPage(popPage, extraParams, false);
        }
    });

    document.body.addEventListener('click', e => {
        // [data-spa-page] — sidebar / bottom nav label
        const spaPageEl = e.target.closest('[data-spa-page]');
        if (spaPageEl) {
            e.preventDefault();
            const page = spaPageEl.dataset.spaPage;
            if (page) loadPage(page);
            return;
        }

        // .box-nav-bottom[data-page] — ikon bottom nav
        const navBottom = e.target.closest('.box-nav-bottom[data-page]');
        if (navBottom) {
            e.preventDefault();
            const page = navBottom.dataset.page;
            if (page) loadPage(page);
            return;
        }



        // .link-spa — link materi / submateri / detail
        const linkSpa = e.target.closest('.link-spa');
        if (linkSpa) {
            e.preventDefault();

            // Cek apakah link ini di dalam .box-materi (card slider)
            const parentCard = linkSpa.closest('.box-materi');
            if (parentCard) {
                const wrapper = parentCard.closest('.wrapper-materi');

                // Kalau card BELUM active → center dulu, jangan navigasi
                if (!parentCard.classList.contains('active')) {
                    if (wrapper && wrapper._sliderSetActive) {
                        wrapper._sliderSetActive(parentCard);
                        wrapper._sliderCenterCard(parentCard, true);
                    }
                    return; // ← batalkan navigasi
                }

                // Kalau card SUDAH active → boleh navigasi
            }

            const { page, params } = parseSpaLink(linkSpa.getAttribute('href'));
            if (page) loadPage(page, params);
            return;
        }
    });

    // ── Init schedule notification engine ──────────────────────────────
    initScheduleNotifier();

    // ── Browser offline/online events (sebagai trigger cepat) ──────────
    window.addEventListener('offline', () => {
        showOfflineOverlay();
    });

    window.addEventListener('online', async () => {
        // Browser bilang online, tapi verifikasi dulu dengan ping external
        const real = await checkRealInternet();
        if (real) {
            hideOfflineOverlay();
        }
    });

    // ── Monitoring berkala: cek koneksi setiap 10 detik ─────────────────
    // Menangkap kasus dimana internet putus tanpa trigger event browser
    setInterval(async () => {
        const online = await checkRealInternet();
        if (!online && !__isOffline) {
            showOfflineOverlay();
        }
    }, 10000);
});

// ─────────────────────────────────────────────────────────────────────────────
// FAVORITE TOGGLE
// ─────────────────────────────────────────────────────────────────────────────

window.toggleFavorite = async function (btn) {
    const id = btn.dataset.id;
    const type = btn.dataset.type; // 'materi' or 'sub'
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!id || !type) return;

    // Optimistic UI update
    const wasFav = btn.classList.contains('bxs-star');
    btn.classList.toggle('bx-star', wasFav);
    btn.classList.toggle('bxs-star', !wasFav);
    btn.classList.toggle('active', !wasFav);

    // Pulse animation
    btn.style.transform = 'scale(1.3)';
    setTimeout(() => btn.style.transform = '', 200);

    try {
        const res = await fetch('/app/favorite/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ type, id: parseInt(id) }),
            credentials: 'same-origin',
        });

        const data = await res.json();

        if (res.ok && data.success) {
            // Confirm final state
            btn.classList.toggle('bx-star', !data.is_favorited);
            btn.classList.toggle('bxs-star', data.is_favorited);
            btn.classList.toggle('active', data.is_favorited);

            showToast(
                data.is_favorited ? '⭐ Favorit!' : '✕ Dihapus',
                data.message,
                data.is_favorited ? '#f59e0b' : '#555',
                'reminder'
            );
        }
    } catch {
        // Revert on error
        btn.classList.toggle('bx-star', !wasFav);
        btn.classList.toggle('bxs-star', wasFav);
        btn.classList.toggle('active', wasFav);
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// SCHEDULE NOTIFICATION ENGINE
// Cek jadwal belajar setiap 30 detik, kirim notifikasi browser + toast in-app
// ─────────────────────────────────────────────────────────────────────────────

function initScheduleNotifier() {
    // Inject toast CSS
    injectToastCSS();

    // Request permission browser notification
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }

    // Track notifikasi yang sudah dikirim hari ini (reset tiap hari)
    const firedKey = 'schedule_notif_fired';
    const dayKey = 'schedule_notif_day';
    const todayStr = new Date().toDateString();

    // Reset jika hari berganti
    if (localStorage.getItem(dayKey) !== todayStr) {
        localStorage.setItem(dayKey, todayStr);
        localStorage.setItem(firedKey, JSON.stringify([]));
    }

    function getFired() {
        try { return JSON.parse(localStorage.getItem(firedKey)) || []; }
        catch { return []; }
    }
    function markFired(key) {
        const arr = getFired();
        arr.push(key);
        localStorage.setItem(firedKey, JSON.stringify(arr));
    }

    // Cache jadwal hari ini
    let todaySchedules = [];
    let lastFetch = 0;

    async function fetchSchedules() {
        try {
            const res = await fetch('/app/api/schedules/today', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                credentials: 'same-origin',
            });
            if (res.ok) {
                todaySchedules = await res.json();
                lastFetch = Date.now();
            }
        } catch { /* silent */ }
    }

    // ── Expose globally agar bisa dipanggil dari schedule CRUD ──────
    window.__refetchSchedules = fetchSchedules;

    function getCurrentHHMM() {
        const now = new Date();
        return String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
    }

    function checkSchedules() {
        const now = getCurrentHHMM();
        const fired = getFired();

        todaySchedules.forEach(s => {
            const startKey = `start-${s.id}-${s.start_time}`;
            const endKey = `end-${s.id}-${s.end_time}`;

            // Notif saat jam mulai
            if (s.start_time === now && !fired.includes(startKey)) {
                markFired(startKey);
                sendNotification(
                    '📚 Waktunya Belajar!',
                    `${s.title} — mulai sekarang (${s.start_time})`,
                    s.color || '#6366f1',
                    'start'
                );
            }

            // Notif saat jam selesai (istirahat)
            if (s.end_time && s.end_time === now && !fired.includes(endKey)) {
                markFired(endKey);
                sendNotification(
                    '☕ Waktunya Istirahat!',
                    `${s.title} — sesi selesai (${s.end_time})`,
                    '#10b981',
                    'end'
                );
            }

            // Notif 5 menit sebelum mulai
            const preKey = `pre-${s.id}-${s.start_time}`;
            const pre5 = subtractMinutes(s.start_time, 5);
            if (pre5 === now && !fired.includes(preKey)) {
                markFired(preKey);
                sendNotification(
                    '⏰ 5 Menit Lagi!',
                    `${s.title} dimulai pukul ${s.start_time}`,
                    s.color || '#f59e0b',
                    'reminder'
                );
            }
        });
    }

    function subtractMinutes(hhmm, mins) {
        const [h, m] = hhmm.split(':').map(Number);
        const d = new Date(2000, 0, 1, h, m - mins);
        return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
    }

    function sendNotification(title, body, color, type) {
        // 1) Browser notification
        if ('Notification' in window && Notification.permission === 'granted') {
            try {
                const n = new Notification(title, {
                    body,
                    icon: '/assets/img/img001non.jpg',
                    tag: `schedule-${type}-${Date.now()}`,
                });
                // Auto-close after 8s
                setTimeout(() => n.close(), 8000);
            } catch { /* mobile browsers may not support */ }
        }

        // 2) Push to notification panel
        if (typeof window.__addNotification === 'function') {
            window.__addNotification(title, body, color, type);
        }

        // 3) In-app toast
        showToast(title, body, color, type);
    }

    // ── Expose sendNotification globally ──────────────────────────
    window.__sendScheduleNotification = sendNotification;

    // ── Welcome notification: ringkasan jadwal hari ini ───────────
    async function showWelcomeNotif() {
        await fetchSchedules();

        // Hanya tampilkan sekali per hari
        const welcomeKey = 'schedule_welcome_' + todayStr;
        if (localStorage.getItem(welcomeKey)) return;
        localStorage.setItem(welcomeKey, '1');

        if (todaySchedules.length > 0) {
            const titles = todaySchedules.map(s => s.title).slice(0, 3);
            const extra = todaySchedules.length > 3 ? ` dan ${todaySchedules.length - 3} lainnya` : '';
            const body = titles.join(', ') + extra;

            // Hanya push ke panel, tanpa toast/browser notif
            if (typeof window.__addNotification === 'function') {
                window.__addNotification(
                    `📋 ${todaySchedules.length} jadwal hari ini`,
                    body,
                    '#6366f1',
                    'system'
                );
            }
        }
    }

    // ── Boot ──────────────────────────────────────────────────────
    showWelcomeNotif();

    // Cek setiap 15 detik (lebih reliable daripada 30 detik)
    setInterval(() => {
        // Re-fetch setiap 2 menit
        if (Date.now() - lastFetch > 2 * 60 * 1000) {
            fetchSchedules();
        }
        checkSchedules();
    }, 15_000);

    // Cek langsung saat load (delay 3s agar data ter-fetch)
    setTimeout(checkSchedules, 3000);
}

// ─────────────────────────────────────────────────────────────────────────────
// TOAST UI
// ─────────────────────────────────────────────────────────────────────────────

function showToast(title, body, color, type) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const icons = {
        start: 'bx bx-book-open',
        end: 'bx bx-coffee',
        reminder: 'bx bx-bell',
    };

    const toast = document.createElement('div');
    toast.className = 'schedule-toast';
    toast.style.setProperty('--toast-color', color);
    toast.innerHTML = `
        <div class="toast-icon"><i class='${icons[type] || 'bx bx-bell'}'></i></div>
        <div class="toast-content">
            <h5>${title}</h5>
            <p>${body}</p>
        </div>
        <button class="toast-close" onclick="this.closest('.schedule-toast').remove()">
            <i class='bx bx-x'></i>
        </button>
        <div class="toast-progress"></div>
    `;

    container.appendChild(toast);

    // Trigger animation
    requestAnimationFrame(() => toast.classList.add('show'));

    // Auto remove after 8s
    setTimeout(() => {
        toast.classList.remove('show');
        toast.classList.add('hide');
        setTimeout(() => toast.remove(), 400);
    }, 8000);
}

function injectToastCSS() {
    if (document.getElementById('toast-styles')) return;

    const style = document.createElement('style');
    style.id = 'toast-styles';
    style.textContent = `
        #toast-container {
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
            max-width: 380px;
            width: calc(100% - 32px);
        }
        .schedule-toast {
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: #191825;
            border-radius: 16px;
            border: 1px solid #1f1e2e;
            border-left: 4px solid var(--toast-color, #6366f1);
            box-shadow: 0 8px 32px rgba(0,0,0,0.45);
            transform: translateX(120%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .schedule-toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        .schedule-toast.hide {
            transform: translateX(120%);
            opacity: 0;
        }
        .toast-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--toast-color, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .toast-icon i {
            color: #fff;
            font-size: 20px;
        }
        .toast-content {
            flex: 1;
            min-width: 0;
        }
        .toast-content h5 {
            color: #E6E0E9;
            font-size: 13px;
            font-weight: 600;
        }
        .toast-content p {
            color: #8a898a;
            font-size: 12px;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .toast-close {
            background: none;
            border: none;
            color: #555;
            font-size: 18px;
            cursor: pointer;
            padding: 4px;
            flex-shrink: 0;
        }
        .toast-close:hover {
            color: #E6E0E9;
        }
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: var(--toast-color, #6366f1);
            border-radius: 0 0 0 16px;
            animation: toast-countdown 8s linear forwards;
        }
        @keyframes toast-countdown {
            from { width: 100%; }
            to   { width: 0%; }
        }
    `;
    document.head.appendChild(style);
}


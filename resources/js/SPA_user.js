import './bootstrap';

const body     = document.body;
const base     = body.dataset.spaBase;
const initial  = body.dataset.spaInitial || 'dashboard';
const el       = document.getElementById('spa-content');

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
    wrapper._sliderSetActive  = setActive;
    wrapper._sliderCards      = cards;

    // ── Posisi awal: card tengah auto-center tanpa animasi ────────────
    // double-rAF: frame pertama untuk commit layout,
    // frame kedua untuk read offsetLeft setelah paint selesai,
    // + timeout kecil untuk pastikan gambar sudah mempengaruhi layout.
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            setTimeout(() => {
                const mid       = Math.floor(cards.length / 2);
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
        const url    = new URL(href, location.origin);
        const page   = url.searchParams.get('page');
        const params = {};
        url.searchParams.forEach((val, key) => {
            if (key !== 'page') params[key] = val;
        });
        return { page, params };
    } catch {
        return { page: null, params: {} };
    }
}

/** Highlight icon bottom-nav yang sesuai halaman aktif */
function updateNavBottom(activePage) {
    document.querySelectorAll('.box-nav-bottom').forEach(item => {
        const icon = item.querySelector('.icon-nav-bottom');
        if (!icon) return;
        icon.classList.toggle('active', item.dataset.page === activePage);
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

async function loadPage(page, params = {}) {
    if (!base || !el) return;

    let url = `${base.replace(/\/$/, '')}/${encodeURIComponent(page)}`;
    const qs = new URLSearchParams(params).toString();
    if (qs) url += `?${qs}`;

    el.style.opacity = '0.5';

    try {
        const res = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
            credentials: 'same-origin',
        });

        if (!res.ok) {
            el.innerHTML = '<p style="text-align:center;padding:2em;color:#ef4444;">Gagal memuat halaman.</p>';
            return;
        }

        el.innerHTML = await res.text();
        rehydrateScripts(el);

        window.scrollTo({ top: 0, behavior: 'smooth' });
        updateNavBottom(page);

        // ── Inisialisasi slider setelah konten di-inject ──────────────
        initMaterialSlider();

    } finally {
        el.style.opacity = '1';
    }
}

// Expose globally (dipakai tombol back di detail page)
window.loadPage = loadPage;

// ─────────────────────────────────────────────────────────────────────────────
// BOOT
// ─────────────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    loadPage(initial);

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

        // .archive-btn — toggle favorite (star icon di materi/submateri)
        const archiveBtn = e.target.closest('.archive-btn');
        if (archiveBtn) {
            e.preventDefault();
            e.stopPropagation();
            toggleFavorite(archiveBtn);
            return;
        }
    });

    // ── Init schedule notification engine ──────────────────────────────
    initScheduleNotifier();
});

// ─────────────────────────────────────────────────────────────────────────────
// FAVORITE TOGGLE
// ─────────────────────────────────────────────────────────────────────────────

async function toggleFavorite(btn) {
    const id   = btn.dataset.id;
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
    const firedKey   = 'schedule_notif_fired';
    const dayKey     = 'schedule_notif_day';
    const todayStr   = new Date().toDateString();

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

    function getCurrentHHMM() {
        const now = new Date();
        return String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
    }

    function checkSchedules() {
        const now    = getCurrentHHMM();
        const fired  = getFired();

        todaySchedules.forEach(s => {
            const startKey = `start-${s.id}-${s.start_time}`;
            const endKey   = `end-${s.id}-${s.end_time}`;

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
            const pre5   = subtractMinutes(s.start_time, 5);
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

        // 2) In-app toast
        showToast(title, body, color, type);
    }

    // ── Fetch awal + interval ─────────────────────────────
    fetchSchedules();

    // Cek setiap 30 detik
    setInterval(() => {
        // Re-fetch setiap 5 menit
        if (Date.now() - lastFetch > 5 * 60 * 1000) {
            fetchSchedules();
        }
        checkSchedules();
    }, 30_000);

    // Cek langsung saat load (delay 2s agar data ter-fetch)
    setTimeout(checkSchedules, 2000);
}

// ─────────────────────────────────────────────────────────────────────────────
// TOAST UI
// ─────────────────────────────────────────────────────────────────────────────

function showToast(title, body, color, type) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const icons = {
        start:    'bx bx-book-open',
        end:      'bx bx-coffee',
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


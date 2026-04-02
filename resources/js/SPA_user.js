import './bootstrap';

const body = document.body;
const base = body.dataset.spaBase;
const initial = body.dataset.spaInitial || 'dashboard';
const el = document.getElementById('spa-content');

async function loadPage(page) {
    if (!base || !el) {
        return;
    }
    const url = `${base.replace(/\/$/, '')}/${encodeURIComponent(page)}`;
    const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
        credentials: 'same-origin',
    });
    if (!res.ok) {
        el.innerHTML = '<p class="text-sm text-red-600">Gagal memuat halaman.</p>';
        return;
    }
    el.innerHTML = await res.text();
}

document.addEventListener('DOMContentLoaded', () => {
    loadPage(initial);
    document.body.addEventListener('click', (e) => {
        const a = e.target.closest('[data-spa-page]');
        if (!a) {
            return;
        }
        e.preventDefault();
        const page = a.dataset.spaPage;
        if (page) {
            loadPage(page);
        }
    });
});

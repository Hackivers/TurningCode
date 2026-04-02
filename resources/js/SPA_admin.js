import './bootstrap';

const body = document.body;
const base = body.dataset.spaBase;
const initial = body.dataset.spaInitial || 'dashboard';
const el = document.getElementById('spa-content');

function setupMateriFormRows(container) {
    const wrap = container.querySelector('#materi-rows');
    const btn = container.querySelector('#btn-add-materi-row');
    if (!wrap || !btn) {
        return;
    }

    btn.addEventListener('click', () => {
        const rowIdx = wrap.querySelectorAll('.materi-row').length;
        const div = document.createElement('div');
        div.className = 'materi-row rounded-lg border border-zinc-200 bg-zinc-50/50 p-4';
        div.setAttribute('data-row', '');
        div.innerHTML =
            `<p class="text-xs font-medium text-zinc-500">Materi #<span class="row-num">${rowIdx + 1}</span></p>` +
            '<div class="mt-2 grid gap-3">' +
            '<div><label class="block text-xs text-zinc-600">Judul</label>' +
            `<input type="text" name="items[${rowIdx}][title]" maxlength="255" class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Judul materi">` +
            '</div>' +
            '<div><label class="block text-xs text-zinc-600">Deskripsi</label>' +
            `<textarea name="items[${rowIdx}][description]" rows="2" class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Deskripsi singkat"></textarea>` +
            '</div></div>';
        wrap.appendChild(div);
        wrap.querySelectorAll('.materi-row').forEach((row, i) => {
            const n = row.querySelector('.row-num');
            if (n) {
                n.textContent = String(i + 1);
            }
        });
    });
}

function sectionBlockHtml(idx) {
    return (
        `<div class="subm-section-block rounded-xl border border-zinc-200 bg-zinc-50/50 p-4" data-section-row>` +
        `<p class="mb-3 text-xs font-semibold text-zinc-500">Section <span class="section-num">${idx + 1}</span></p>` +
        '<div class="grid gap-3 sm:grid-cols-2">' +
        '<div><label class="text-xs text-zinc-600">Judul</label>' +
        `<input type="text" name="sections[${idx}][judul]" class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Judul"></div>` +
        '<div><label class="text-xs text-zinc-600">Subjudul</label>' +
        `<input type="text" name="sections[${idx}][subjudul]" class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Subjudul"></div>` +
        '<div><label class="text-xs text-zinc-600">Meta</label>' +
        `<input type="text" name="sections[${idx}][meta]" class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Meta title / tag"></div>` +
        '<div><label class="text-xs text-zinc-600">Meta description</label>' +
        `<textarea name="sections[${idx}][meta_desc]" rows="2" class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Meta description"></textarea></div>` +
        '</div>' +
        '<div class="mt-3"><label class="text-xs text-zinc-600">Artikel</label>' +
        `<textarea name="sections[${idx}][artikel]" rows="5" class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Isi artikel"></textarea></div>` +
        '<div class="mt-3"><label class="text-xs text-zinc-600">Thumbnail</label>' +
        `<input type="file" name="sections[${idx}][thumbnail]" accept="image/*" class="mt-0.5 block w-full text-sm text-zinc-600 file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm"></div>` +
        '</div>'
    );
}

function renumberSubmSections(rowsWrap) {
    rowsWrap.querySelectorAll('[data-section-row]').forEach((row, i) => {
        const n = row.querySelector('.section-num');
        if (n) {
            n.textContent = String(i + 1);
        }
    });
}

function setupSubMateriForm(container) {
    const root = container.querySelector('#submateri-app');
    if (!root) {
        return;
    }

    const apiBase = root.dataset.apiBase;
    const mainSel = container.querySelector('#subm-main-select');
    const materiWrap = container.querySelector('#subm-materi-wrap');
    const materiSel = container.querySelector('#subm-materi-select');
    const formWrap = container.querySelector('#subm-form-wrap');
    const rememberMain = container.querySelector('#remember-main-id');
    const oldMain = root.dataset.oldMain || '';
    const oldMateri = root.dataset.oldMateri || '';

    if (!mainSel || !materiWrap || !materiSel || !formWrap) {
        return;
    }

    async function loadMateris(mainId) {
        const res = await fetch(`${apiBase}/${mainId}/materis`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            credentials: 'same-origin',
        });
        if (!res.ok) {
            return;
        }
        const data = await res.json();
        materiSel.innerHTML = '<option value="">— pilih materi —</option>';
        data.forEach((m) => {
            const o = document.createElement('option');
            o.value = m.id;
            o.textContent = m.title;
            materiSel.appendChild(o);
        });
        materiWrap.classList.remove('hidden');
        if (oldMateri) {
            materiSel.value = oldMateri;
        }
    }

    mainSel.addEventListener('change', () => {
        const v = mainSel.value;
        if (rememberMain) {
            rememberMain.value = v;
        }
        if (!v) {
            materiWrap.classList.add('hidden');
            formWrap.classList.add('hidden');
            materiSel.innerHTML = '<option value="">— pilih main dulu —</option>';
            return;
        }
        loadMateris(v);
    });

    materiSel.addEventListener('change', () => {
        if (materiSel.value) {
            formWrap.classList.remove('hidden');
        } else {
            formWrap.classList.add('hidden');
        }
    });

    if (oldMain) {
        mainSel.value = oldMain;
        if (rememberMain) {
            rememberMain.value = oldMain;
        }
        loadMateris(oldMain).then(() => {
            if (oldMateri) {
                materiSel.value = oldMateri;
            }
            if (materiSel.value) {
                formWrap.classList.remove('hidden');
            }
        });
    }

    const btnAdd = container.querySelector('#btn-add-subm-section');
    const rowsWrap = container.querySelector('#subm-section-rows');
    if (btnAdd && rowsWrap) {
        btnAdd.addEventListener('click', () => {
            const idx = rowsWrap.querySelectorAll('[data-section-row]').length;
            const wrap = document.createElement('div');
            wrap.innerHTML = sectionBlockHtml(idx);
            const block = wrap.firstElementChild;
            if (block) {
                rowsWrap.appendChild(block);
            }
            renumberSubmSections(rowsWrap);
        });
    }
}

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
    setupMateriFormRows(el);
    setupSubMateriForm(el);
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

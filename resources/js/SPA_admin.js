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

// ─── Section types config ─────────────────────────────────
const SECTION_TYPES = {
    heading:    { label: 'Judul',       icon: 'H',  color: '#6366f1' },
    subheading: { label: 'Subjudul',    icon: 'H2', color: '#8b5cf6' },
    paragraph:  { label: 'Paragraf',    icon: 'P',  color: '#3b82f6' },
    code:       { label: 'Kode',        icon: '<>', color: '#10b981' },
    image:      { label: 'Gambar',      icon: '📷', color: '#f59e0b' },
    quote:      { label: 'Kutipan',     icon: '"',  color: '#ec4899' },
    list:       { label: 'Daftar/List', icon: '☰',  color: '#14b8a6' },
    divider:    { label: 'Pemisah',     icon: '—',  color: '#6b7280' },
};

function sectionInputHtml(type, idx) {
    const tw = 'mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm';

    switch (type) {
        case 'heading':
            return `<div><label class="text-xs text-zinc-600">Judul</label>
                <input type="text" name="sections[${idx}][content]" class="${tw}" placeholder="Tulis judul section..." required></div>`;

        case 'subheading':
            return `<div><label class="text-xs text-zinc-600">Subjudul</label>
                <input type="text" name="sections[${idx}][content]" class="${tw}" placeholder="Tulis subjudul..."></div>`;

        case 'paragraph':
            return `<div><label class="text-xs text-zinc-600">Paragraf</label>
                <textarea name="sections[${idx}][content]" rows="5" class="${tw}" placeholder="Isi paragraf / artikel..."></textarea></div>`;

        case 'code':
            return `<div class="grid gap-3 sm:grid-cols-2">
                <div><label class="text-xs text-zinc-600">Bahasa</label>
                <input type="text" name="sections[${idx}][language]" class="${tw}" placeholder="php, js, python..."></div>
                </div>
                <div><label class="text-xs text-zinc-600">Kode</label>
                <textarea name="sections[${idx}][content]" rows="6" class="${tw} font-mono bg-zinc-900 text-emerald-400" placeholder="Tulis kode di sini..."></textarea></div>`;

        case 'image':
            return `<div><label class="text-xs text-zinc-600">Upload gambar</label>
                <input type="file" name="sections[${idx}][file]" accept="image/*" class="mt-0.5 block w-full text-sm text-zinc-600 file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm"></div>
                <div><label class="text-xs text-zinc-600">Caption</label>
                <input type="text" name="sections[${idx}][content]" class="${tw}" placeholder="Caption gambar (opsional)"></div>`;

        case 'quote':
            return `<div><label class="text-xs text-zinc-600">Kutipan</label>
                <textarea name="sections[${idx}][content]" rows="3" class="${tw} border-l-4 border-l-pink-400 pl-4 italic" placeholder="Isi kutipan..."></textarea></div>
                <div><label class="text-xs text-zinc-600">Sumber</label>
                <input type="text" name="sections[${idx}][source]" class="${tw}" placeholder="Sumber kutipan (opsional)"></div>`;

        case 'list':
            return `<div><label class="text-xs text-zinc-600">Daftar (satu item per baris)</label>
                <textarea name="sections[${idx}][content]" rows="5" class="${tw}" placeholder="• Item pertama\n• Item kedua\n• Item ketiga"></textarea></div>
                <div class="flex gap-4 text-xs text-zinc-600">
                <label><input type="radio" name="sections[${idx}][list_type]" value="unordered" checked> • Bullet</label>
                <label><input type="radio" name="sections[${idx}][list_type]" value="ordered"> 1. Numbered</label></div>`;

        case 'divider':
            return `<p class="text-center text-xs text-zinc-400 py-2">── Garis pemisah ──</p>
                <input type="hidden" name="sections[${idx}][content]" value="---">`;

        default:
            return `<div><textarea name="sections[${idx}][content]" rows="4" class="${tw}" placeholder="Konten..."></textarea></div>`;
    }
}

function sectionBlockHtml(type, idx) {
    const meta = SECTION_TYPES[type] || { label: type, icon: '?', color: '#999' };

    return (
        `<div class="subm-section-block rounded-xl border border-zinc-200 bg-zinc-50/50 p-4" data-section-row data-section-type="${type}">` +
        `<input type="hidden" name="sections[${idx}][type]" value="${type}">` +
        `<input type="hidden" name="sections[${idx}][order]" value="${idx}">` +
        `<div class="flex items-center gap-2 mb-3">` +
        `<span class="inline-flex items-center justify-center w-7 h-7 rounded-md text-white text-xs font-bold" style="background:${meta.color}">${meta.icon}</span>` +
        `<span class="text-xs font-semibold text-zinc-600">${meta.label}</span>` +
        `<span class="section-num text-xs text-zinc-400 ml-auto">#${idx + 1}</span>` +
        `<button type="button" class="btn-move-section-up rounded border border-zinc-300 px-1.5 py-0.5 text-xs hover:bg-zinc-100" title="Pindah ke atas">▲</button>` +
        `<button type="button" class="btn-move-section-down rounded border border-zinc-300 px-1.5 py-0.5 text-xs hover:bg-zinc-100" title="Pindah ke bawah">▼</button>` +
        `<button type="button" class="btn-remove-section rounded border border-red-200 px-1.5 py-0.5 text-xs text-red-500 hover:bg-red-50" title="Hapus">✕</button>` +
        `</div>` +
        `<div class="space-y-3">${sectionInputHtml(type, idx)}</div>` +
        `</div>`
    );
}

function renumberSubmSections(rowsWrap) {
    rowsWrap.querySelectorAll('[data-section-row]').forEach((row, i) => {
        const n = row.querySelector('.section-num');
        if (n) {
            n.textContent = `#${i + 1}`;
        }
        const orderInput = row.querySelector('input[name$="[order]"]');
        if (orderInput) {
            orderInput.value = i;
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

    // ── Section toolbar with type buttons ──────────────────
    const rowsWrap = container.querySelector('#subm-section-rows');

    // Setup "add section" type buttons
    const typeToolbar = container.querySelector('#subm-section-toolbar');
    if (typeToolbar && rowsWrap) {
        typeToolbar.querySelectorAll('[data-add-type]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const type = btn.dataset.addType;
                const idx = rowsWrap.querySelectorAll('[data-section-row]').length;
                const wrap = document.createElement('div');
                wrap.innerHTML = sectionBlockHtml(type, idx);
                const block = wrap.firstElementChild;
                if (block) {
                    rowsWrap.appendChild(block);
                    attachSectionActions(block, rowsWrap);
                }
                renumberSubmSections(rowsWrap);
                // Focus first input
                const firstInput = block?.querySelector('input[type="text"], textarea');
                if (firstInput) firstInput.focus();
            });
        });
    }

    // Legacy single "+ Tambah section" button (fallback)
    const btnAdd = container.querySelector('#btn-add-subm-section');
    if (btnAdd && rowsWrap) {
        btnAdd.addEventListener('click', () => {
            const idx = rowsWrap.querySelectorAll('[data-section-row]').length;
            const wrap = document.createElement('div');
            wrap.innerHTML = sectionBlockHtml('paragraph', idx);
            const block = wrap.firstElementChild;
            if (block) {
                rowsWrap.appendChild(block);
                attachSectionActions(block, rowsWrap);
            }
            renumberSubmSections(rowsWrap);
        });
    }

    // Attach move/remove for existing server-rendered sections
    if (rowsWrap) {
        rowsWrap.querySelectorAll('[data-section-row]').forEach((block) => {
            attachSectionActions(block, rowsWrap);
        });
    }
}

function attachSectionActions(block, rowsWrap) {
    // Remove button
    const removeBtn = block.querySelector('.btn-remove-section');
    if (removeBtn) {
        removeBtn.addEventListener('click', () => {
            block.style.opacity = '0';
            block.style.transform = 'translateX(20px)';
            block.style.transition = 'opacity 0.25s, transform 0.25s';
            setTimeout(() => {
                block.remove();
                renumberSubmSections(rowsWrap);
            }, 250);
        });
    }

    // Move up
    const upBtn = block.querySelector('.btn-move-section-up');
    if (upBtn) {
        upBtn.addEventListener('click', () => {
            if (block.previousElementSibling) {
                rowsWrap.insertBefore(block, block.previousElementSibling);
                renumberSubmSections(rowsWrap);
            }
        });
    }

    // Move down
    const downBtn = block.querySelector('.btn-move-section-down');
    if (downBtn) {
        downBtn.addEventListener('click', () => {
            if (block.nextElementSibling) {
                rowsWrap.insertBefore(block.nextElementSibling, block);
                renumberSubmSections(rowsWrap);
            }
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

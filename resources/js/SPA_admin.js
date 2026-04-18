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

// ─── Question form management ─────────────────────────────
function questionRowHtml(idx) {
    const tw = 'mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500';
    const codeTw = 'mt-0.5 w-full rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-3 text-sm font-mono text-emerald-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500';
    return (
        `<div class="q-block rounded-xl border border-zinc-200 bg-zinc-50/50 p-5 transition-all" data-q-row style="animation: qFadeIn 0.3s ease-out">` +
        `<div class="flex items-center justify-between mb-4">` +
        `<span class="q-num inline-flex items-center gap-2 text-sm font-semibold text-zinc-700">` +
        `<span class="q-badge flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-500 text-xs font-bold text-white">${idx + 1}</span>` +
        `Soal #<span class="q-label-num">${idx + 1}</span>` +
        `</span>` +
        `<button type="button" class="btn-remove-q rounded-md border border-red-200 px-2 py-1 text-xs text-red-500 hover:bg-red-50 transition-colors">✕ Hapus</button>` +
        `</div>` +
        `<div class="space-y-3">` +
        // Question text
        `<div><label class="text-xs text-zinc-600">Pertanyaan</label>` +
        `<textarea name="questions[${idx}][question]" rows="3" required class="${tw}" placeholder="Tuliskan pertanyaan..."></textarea></div>` +
        // Code snippet toggle
        `<div class="q-code-section">` +
        `<button type="button" class="btn-toggle-code inline-flex items-center gap-1.5 rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-50 transition-colors">` +
        `<svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>` +
        `+ Tambah Kode</button>` +
        `<div class="q-code-fields mt-3 space-y-2 hidden">` +
        `<div class="flex gap-3">` +
        `<div class="w-40"><label class="text-xs text-zinc-600">Bahasa</label>` +
        `<input type="text" name="questions[${idx}][code_language]" class="${tw}" placeholder="php, js, python..."></div>` +
        `<div class="flex-1"><label class="text-xs text-zinc-600">Preview bahasa</label>` +
        `<p class="mt-0.5 px-3 py-2 text-xs text-zinc-400 italic">Bahasa ditampilkan di kiri atas blok kode</p></div>` +
        `</div>` +
        `<div><label class="text-xs text-zinc-600">Kode</label>` +
        `<textarea name="questions[${idx}][code_snippet]" rows="6" class="${codeTw}" placeholder="Tuliskan potongan kode di sini..." spellcheck="false"></textarea></div>` +
        `</div></div>` +
        // Options
        `<div class="grid gap-3 sm:grid-cols-2">` +
        // Option A
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="0" checked class="mr-1"> ` +
        `Opsi A <span class="text-emerald-500 text-[10px]">(klik = jawaban benar)</span></label>` +
        `<input type="text" name="questions[${idx}][option_a]" required class="${tw}" placeholder="Opsi A"></div>` +
        // Option B
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="1" class="mr-1"> Opsi B</label>` +
        `<input type="text" name="questions[${idx}][option_b]" required class="${tw}" placeholder="Opsi B"></div>` +
        // Option C
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="2" class="mr-1"> Opsi C</label>` +
        `<input type="text" name="questions[${idx}][option_c]" required class="${tw}" placeholder="Opsi C"></div>` +
        // Option D
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="3" class="mr-1"> Opsi D</label>` +
        `<input type="text" name="questions[${idx}][option_d]" required class="${tw}" placeholder="Opsi D"></div>` +
        `</div></div></div>`
    );
}

function renumberQuestions(rowsWrap) {
    rowsWrap.querySelectorAll('[data-q-row]').forEach((row, i) => {
        const badge = row.querySelector('.q-badge');
        const label = row.querySelector('.q-label-num');
        if (badge) badge.textContent = String(i + 1);
        if (label) label.textContent = String(i + 1);
    });
}

function setupQuestionForm(container) {
    const root = container.querySelector('#question-app');
    if (!root) return;

    const apiMateris = root.dataset.apiMateris;        // /admin/api/main
    const apiSubMateris = root.dataset.apiSubMateris;  // /admin/api/materi
    const mainSel = container.querySelector('#q-main-select');
    const materiWrap = container.querySelector('#q-materi-wrap');
    const materiSel = container.querySelector('#q-materi-select');
    const subMateriWrap = container.querySelector('#q-submateri-wrap');
    const subMateriSel = container.querySelector('#q-submateri-select');
    const formWrap = container.querySelector('#q-form-wrap');
    const infoBar = container.querySelector('#q-info-bar');
    const infoText = container.querySelector('#q-info-text');
    const rowsWrap = container.querySelector('#q-rows');
    const emptyState = container.querySelector('#q-empty-state');
    const btnAdd = container.querySelector('#btn-add-question');

    const oldMain = root.dataset.oldMain || '';
    const oldMateri = root.dataset.oldMateri || '';
    const oldSubMateri = root.dataset.oldSubMateri || '';

    if (!mainSel || !materiSel || !subMateriSel) return;

    // ── Load materis by main ──
    async function loadMateris(mainId) {
        const res = await fetch(`${apiMateris}/${mainId}/materis`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            credentials: 'same-origin',
        });
        if (!res.ok) return;
        const data = await res.json();
        materiSel.innerHTML = '<option value="">— pilih materi —</option>';
        data.forEach((m) => {
            const o = document.createElement('option');
            o.value = m.id;
            o.textContent = m.title;
            materiSel.appendChild(o);
        });
        materiWrap.classList.remove('hidden');
    }

    // ── Load sub-materis by materi ──
    async function loadSubMateris(materiId) {
        const res = await fetch(`${apiSubMateris}/${materiId}/sub-materis`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            credentials: 'same-origin',
        });
        if (!res.ok) return;
        const data = await res.json();
        subMateriSel.innerHTML = '<option value="">— pilih sub materi —</option>';
        data.forEach((sm) => {
            const o = document.createElement('option');
            o.value = sm.id;
            o.textContent = sm.title;
            subMateriSel.appendChild(o);
        });
        subMateriWrap.classList.remove('hidden');
    }

    // ── Main select change ──
    mainSel.addEventListener('change', () => {
        const v = mainSel.value;
        if (!v) {
            materiWrap.classList.add('hidden');
            subMateriWrap.classList.add('hidden');
            formWrap.classList.add('hidden');
            infoBar.classList.add('hidden');
            materiSel.innerHTML = '<option value="">— pilih main dulu —</option>';
            subMateriSel.innerHTML = '<option value="">— pilih materi dulu —</option>';
            return;
        }
        subMateriWrap.classList.add('hidden');
        formWrap.classList.add('hidden');
        infoBar.classList.add('hidden');
        subMateriSel.innerHTML = '<option value="">— pilih materi dulu —</option>';
        loadMateris(v);
    });

    // ── Materi select change ──
    materiSel.addEventListener('change', () => {
        const v = materiSel.value;
        if (!v) {
            subMateriWrap.classList.add('hidden');
            formWrap.classList.add('hidden');
            infoBar.classList.add('hidden');
            subMateriSel.innerHTML = '<option value="">— pilih materi dulu —</option>';
            return;
        }
        formWrap.classList.add('hidden');
        infoBar.classList.add('hidden');
        loadSubMateris(v);
    });

    // ── Sub Materi select change ──
    subMateriSel.addEventListener('change', () => {
        if (subMateriSel.value) {
            formWrap.classList.remove('hidden');
        } else {
            formWrap.classList.add('hidden');
            infoBar.classList.add('hidden');
        }
    });

    // ── Restore old values ──
    if (oldMain) {
        mainSel.value = oldMain;
        loadMateris(oldMain).then(() => {
            if (oldMateri) {
                materiSel.value = oldMateri;
                loadSubMateris(oldMateri).then(() => {
                    if (oldSubMateri) {
                        subMateriSel.value = oldSubMateri;
                        formWrap.classList.remove('hidden');
                    }
                });
            }
        });
    }

    // ── Add question row ──
    if (btnAdd && rowsWrap) {
        btnAdd.addEventListener('click', () => {
            const idx = rowsWrap.querySelectorAll('[data-q-row]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = questionRowHtml(idx);
            const block = wrapper.firstElementChild;
            if (block) {
                rowsWrap.appendChild(block);
                attachQuestionRowActions(block, rowsWrap, emptyState);
                // Focus the question textarea
                const firstInput = block.querySelector('textarea');
                if (firstInput) firstInput.focus();
            }
            if (emptyState) emptyState.classList.add('hidden');
            renumberQuestions(rowsWrap);
        });
    }

    // ── Attach actions for server-rendered rows ──
    if (rowsWrap) {
        rowsWrap.querySelectorAll('[data-q-row]').forEach((block) => {
            attachQuestionRowActions(block, rowsWrap, emptyState);
        });
    }
}

function attachQuestionRowActions(block, rowsWrap, emptyState) {
    // Remove button
    const removeBtn = block.querySelector('.btn-remove-q');
    if (removeBtn) {
        removeBtn.addEventListener('click', () => {
            block.style.opacity = '0';
            block.style.transform = 'translateX(20px)';
            block.style.transition = 'opacity 0.25s, transform 0.25s';
            setTimeout(() => {
                block.remove();
                renumberQuestions(rowsWrap);
                if (rowsWrap.querySelectorAll('[data-q-row]').length === 0 && emptyState) {
                    emptyState.classList.remove('hidden');
                }
            }, 250);
        });
    }

    // Code snippet toggle
    attachCodeToggle(block);
}

function attachCodeToggle(block) {
    const toggleBtn = block.querySelector('.btn-toggle-code');
    const codeFields = block.querySelector('.q-code-fields');
    if (!toggleBtn || !codeFields) return;

    toggleBtn.addEventListener('click', () => {
        const isHidden = codeFields.classList.contains('hidden');
        if (isHidden) {
            codeFields.classList.remove('hidden');
            codeFields.style.animation = 'qFadeIn 0.25s ease-out';
            toggleBtn.classList.remove('border-zinc-300', 'bg-white', 'text-zinc-600');
            toggleBtn.classList.add('border-emerald-300', 'bg-emerald-50', 'text-emerald-700');
            toggleBtn.innerHTML = `<svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg> ✓ Kode aktif`;
            // Focus code textarea
            const codeArea = codeFields.querySelector('textarea[name*="code_snippet"]');
            if (codeArea) setTimeout(() => codeArea.focus(), 100);
        } else {
            codeFields.classList.add('hidden');
            toggleBtn.classList.remove('border-emerald-300', 'bg-emerald-50', 'text-emerald-700');
            toggleBtn.classList.add('border-zinc-300', 'bg-white', 'text-zinc-600');
            toggleBtn.innerHTML = `<svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg> + Tambah Kode`;
            // Clear code values when hiding
            const codeArea = codeFields.querySelector('textarea[name*="code_snippet"]');
            const langInput = codeFields.querySelector('input[name*="code_language"]');
            if (codeArea) codeArea.value = '';
            if (langInput) langInput.value = '';
        }
    });
}

// ── Inject animation keyframe ──
if (!document.getElementById('q-anim-style')) {
    const style = document.createElement('style');
    style.id = 'q-anim-style';
    style.textContent = `@keyframes qFadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }`;
    document.head.appendChild(style);
}

// ─── Database Schema Viewer ───────────────────────────────────────
function setupDatabase(container) {
    const root = container.querySelector('#db-schema-root');
    if (!root) return;

    const searchInput = root.querySelector('#db-search');
    const cards = root.querySelectorAll('.db-table-card');
    const cardsContainer = root.querySelector('#db-cards-container');
    const btnList = root.querySelector('#db-view-list');
    const btnGrid = root.querySelector('#db-view-grid');

    // ── Search ──
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const q = e.target.value.toLowerCase();
            cards.forEach(card => {
                card.style.display = card.dataset.table.includes(q) ? '' : 'none';
            });
        });
    }

    // ── Accordion ──
    root.querySelectorAll('.db-accordion-trigger').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const card = trigger.parentElement;
            const content = card.querySelector('.db-accordion-content');
            const arrow = trigger.querySelector('.db-list-arrow');
            if (!content) return;

            const isGridMode = cardsContainer.hasAttribute('data-view');
            const isOpen = !content.classList.contains('hidden');

            if (isOpen) {
                content.classList.add('hidden');
                if (arrow) arrow.style.transform = '';
                trigger.classList.remove('bg-zinc-50');
                // Reset grid overlay styles
                if (isGridMode) {
                    content.style.position = '';
                    content.style.top = '';
                    content.style.left = '';
                    content.style.width = '';
                    content.style.zIndex = '';
                    content.style.background = '';
                    content.style.borderRadius = '';
                    content.style.boxShadow = '';
                    content.style.border = '';
                    card.style.overflow = '';
                }
            } else {
                // Close all other open accordions first
                root.querySelectorAll('.db-accordion-content').forEach(c => {
                    if (c !== content && !c.classList.contains('hidden')) {
                        c.classList.add('hidden');
                        c.style.position = '';
                        c.style.top = '';
                        c.style.left = '';
                        c.style.width = '';
                        c.style.zIndex = '';
                        c.style.background = '';
                        c.style.borderRadius = '';
                        c.style.boxShadow = '';
                        c.style.border = '';
                        c.parentElement.style.overflow = '';
                        const otherArrow = c.parentElement.querySelector('.db-list-arrow');
                        if (otherArrow) otherArrow.style.transform = '';
                        c.parentElement.querySelector('.db-accordion-trigger')?.classList.remove('bg-zinc-50');
                    }
                });

                content.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
                trigger.classList.add('bg-zinc-50');

                // In grid mode: make content overlay so it doesn't push neighbors
                if (isGridMode) {
                    card.style.overflow = 'visible';
                    content.style.position = 'absolute';
                    content.style.top = '100%';
                    content.style.left = '0';
                    content.style.width = '100%';
                    content.style.zIndex = '50';
                    content.style.background = '#fff';
                    content.style.borderRadius = '0 0 1rem 1rem';
                    content.style.boxShadow = '0 12px 32px -4px rgba(0,0,0,0.15)';
                    content.style.border = '1px solid #e4e4e7';
                    content.style.borderTop = 'none';
                }
            }
        });
    });

    // ── View Toggle (List / Grid) ──
    function setView(mode) {
        if (mode === 'grid') {
            cardsContainer.setAttribute('data-view', 'grid');

            // Use CSS Grid with inline styles (Tailwind JIT can't compile dynamic classes)
            cardsContainer.style.display = 'grid';
            cardsContainer.style.gap = '1rem';
            cardsContainer.style.alignItems = 'start'; // prevent row-height stretching

            const applyGridColumns = () => {
                const w = window.innerWidth;
                if (w >= 1024) cardsContainer.style.gridTemplateColumns = 'repeat(3, 1fr)';
                else if (w >= 768) cardsContainer.style.gridTemplateColumns = 'repeat(2, 1fr)';
                else cardsContainer.style.gridTemplateColumns = '1fr';
            };
            applyGridColumns();
            window._dbGridResize = applyGridColumns;
            window.addEventListener('resize', window._dbGridResize);

            btnGrid.classList.add('active');
            btnList.classList.remove('active');
            // In grid mode: hide accordion content, show grid stats, hide arrows
            root.querySelectorAll('.db-accordion-content').forEach(c => c.classList.add('hidden'));
            root.querySelectorAll('.db-list-arrow').forEach(a => { a.style.display = 'none'; a.style.transform = ''; });
            root.querySelectorAll('.db-grid-stats').forEach(s => { s.classList.remove('hidden'); s.classList.add('flex'); });
        } else {
            // Reset to single-column list
            cardsContainer.style.display = '';
            cardsContainer.style.gap = '';
            cardsContainer.style.alignItems = '';
            cardsContainer.style.gridTemplateColumns = '';
            cardsContainer.removeAttribute('data-view');
            if (window._dbGridResize) {
                window.removeEventListener('resize', window._dbGridResize);
                delete window._dbGridResize;
            }
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
            root.querySelectorAll('.db-list-arrow').forEach(a => { a.style.display = ''; });
            root.querySelectorAll('.db-grid-stats').forEach(s => { s.classList.add('hidden'); s.classList.remove('flex'); });
        }
    }

    if (btnList && btnGrid) {
        btnList.addEventListener('click', () => setView('list'));
        btnGrid.addEventListener('click', () => setView('grid'));
    }
}

async function loadPage(page) {
    if (!base || !el) {
        return;
    }
    
    let url;
    if (page.includes('?')) {
        const [p, q] = page.split('?');
        url = `${base.replace(/\/$/, '')}/${encodeURIComponent(p)}?${q}`;
    } else {
        url = `${base.replace(/\/$/, '')}/${encodeURIComponent(page)}`;
    }

    const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
        credentials: 'same-origin',
    });
    if (!res.ok) {
        el.innerHTML = '<p class="text-sm text-red-600">Gagal memuat halaman.</p>';
        return;
    }
    el.innerHTML = await res.text();
    
    // Update active nav state
    const basePage = page.split('?')[0];
    document.querySelectorAll('#spa-nav .nav-item').forEach(link => {
        if (link.dataset.spaPage === basePage) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    setupMateriFormRows(el);
    setupSubMateriForm(el);
    setupQuestionForm(el);
    setupCrud(el);
    setupDatabase(el);
}

// ─── Unified CRUD operations for SPA list ─────────────────────────────
function setupCrud(container) {
    const csrfToken = container.querySelector('[data-csrf]')?.dataset.csrf || document.querySelector('meta[name="csrf-token"]')?.content;
    
    // Toggle edit mode
    container.querySelectorAll('.btn-crud-edit').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('[data-crud-item]');
            item.querySelector('.crud-display').classList.add('hidden');
            item.querySelector('.crud-edit').classList.remove('hidden');
        });
    });

    container.querySelectorAll('.btn-crud-cancel').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const item = e.target.closest('[data-crud-item]');
            item.querySelector('.crud-edit').classList.add('hidden');
            item.querySelector('.crud-display').classList.remove('hidden');
        });
    });

    // Delete item
    container.querySelectorAll('.btn-crud-delete').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            if (!confirm('Yakin ingin menghapus item ini? Semua data terkait mungkin ikut terhapus.')) return;
            
            const item = e.target.closest('[data-crud-item]');
            const type = item.dataset.crudItem;
            const id = item.dataset.id;
            
            try {
                const res = await fetch(`/admin/${type}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                });
                const data = await res.json();
                
                if (data.success) {
                    item.style.backgroundColor = '#fef2f2';
                    item.style.opacity = '0';
                    item.style.transition = 'all 0.4s ease';
                    setTimeout(() => item.remove(), 400);
                } else {
                    alert('Gagal menghapus: ' + (data.message || 'Error tidak diketahui'));
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
            }
        });
    });

    // Save item
    container.querySelectorAll('.btn-crud-save').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const item = e.target.closest('[data-crud-item]');
            const type = item.dataset.crudItem;
            const id = item.dataset.id;
            const editBlock = item.querySelector('.crud-edit');
            
            // Build payload based on item type
            let payload = {};
            
            if (type === 'main-materi') {
                payload = {
                    title: editBlock.querySelector('.edit-title').value,
                    description: editBlock.querySelector('.edit-description').value,
                };
            } else if (type === 'materi') {
                payload = {
                    title: editBlock.querySelector('.edit-title').value,
                    description: editBlock.querySelector('.edit-description').value,
                    main_materi_id: editBlock.querySelector('.edit-main-materi-id').value,
                };
            } else if (type === 'question') {
                payload = {
                    question: editBlock.querySelector('.edit-question').value,
                    code_language: editBlock.querySelector('.edit-code-lang').value,
                    code_snippet: editBlock.querySelector('.edit-code-snippet').value,
                    option_a: editBlock.querySelector('.edit-opt-0').value,
                    option_b: editBlock.querySelector('.edit-opt-1').value,
                    option_c: editBlock.querySelector('.edit-opt-2').value,
                    option_d: editBlock.querySelector('.edit-opt-3').value,
                    correct_option: editBlock.querySelector(`input[name="edit_correct_${id}"]:checked`)?.value || '0',
                };
            }

            btn.innerHTML = 'Meyimpan...';
            btn.disabled = true;

            try {
                const res = await fetch(`/admin/${type}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                
                if (data.success) {
                    // Reload page to reflect changes
                    const pageStr = document.querySelector('[data-spa-page].active')?.dataset.spaPage || initial;
                    loadPage(pageStr);
                } else {
                    alert('Gagal menyimpan: ' + (data.message || 'Validasi gagal'));
                    btn.innerHTML = '💾 Simpan';
                    btn.disabled = false;
                }
            } catch (err) {
                alert('Terjadi kesalahan jaringan.');
                btn.innerHTML = '💾 Simpan';
                btn.disabled = false;
            }
        });
    });
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

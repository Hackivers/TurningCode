import './bootstrap';

const body = document.body;
const base = body.dataset.spaBase;
const initial = body.dataset.spaInitial || 'dashboard';
const el = document.getElementById('spa-content');

window.previewImage = function(input) {
    let container = input.nextElementSibling;
    if (!container || !container.classList.contains('image-preview-container')) {
        container = document.createElement('div');
        container.className = 'mt-2 image-preview-container hidden';
        container.innerHTML = '<img class="h-32 w-auto object-cover rounded-md border border-zinc-200 bg-white p-1 shadow-sm">';
        input.parentNode.insertBefore(container, input.nextSibling);
    }
    const img = container.querySelector('img');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                container.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
            return;
        }
    }
    img.src = '';
    container.classList.add('hidden');
};

window.previewAvatar = function(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            if (preview) {
                preview.src = e.target.result;
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
};

window.triggerExcelImport = function() {
    const subMateriSelect = document.getElementById('q-submateri-select');
    if (!subMateriSelect || !subMateriSelect.value) {
        alert('Silakan pilih Sub Materi terlebih dahulu sebelum import soal.');
        return;
    }
    document.getElementById('import_sub_materi_id').value = subMateriSelect.value;
    document.getElementById('import_excel_file').click();
};

window.submitImportExcel = function() {
    const fileInput = document.getElementById('import_excel_file');
    if (fileInput.files.length > 0) {
        document.getElementById('form-import-excel').submit();
        
        // Show loading state
        const btn = document.querySelector('button[onclick="triggerExcelImport()"]') || document.querySelector('button[onclick="window.triggerExcelImport()"]');
        if (btn) {
            btn.innerHTML = `<svg class="h-3.5 w-3.5 text-emerald-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="text-[10px] sm:text-xs font-bold uppercase tracking-widest text-emerald-700">Mengunggah...</span>`;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    }
};

// ── Main Materi Excel Import ───────────────────────────────────
window.triggerMainMateriExcelImport = function() {
    const fileInput = document.getElementById('import_main_materi_excel_file');
    if (fileInput) {
        fileInput.click();
    }
};

window.submitMainMateriImportExcel = function() {
    const fileInput = document.getElementById('import_main_materi_excel_file');
    if (fileInput && fileInput.files.length > 0) {
        document.getElementById('form-import-main-materi-excel').submit();
        
        const btn = document.querySelector('button[onclick="window.triggerMainMateriExcelImport()"]');
        if (btn) {
            btn.innerHTML = `<svg class="h-3.5 w-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="uppercase tracking-widest">Mengunggah...</span>`;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    }
};

// ── Materi Excel Import ───────────────────────────────────
window.triggerMateriExcelImport = function() {
    const fileInput = document.getElementById('import_materi_excel_file');
    if (fileInput) {
        fileInput.click();
    }
};

window.submitMateriImportExcel = function() {
    const fileInput = document.getElementById('import_materi_excel_file');
    if (fileInput && fileInput.files.length > 0) {
        document.getElementById('form-import-materi-excel').submit();
        
        const btn = document.querySelector('button[onclick="window.triggerMateriExcelImport()"]');
        if (btn) {
            btn.innerHTML = `<svg class="h-3.5 w-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="uppercase tracking-widest">Mengunggah...</span>`;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    }
};

// ── Report Detail Modal ───────────────────────────────────────
window.openReportDetailModal = function(report) {
    const assetUrl = '/storage';
    
    const avatarUrl = report.user && report.user.avatar 
        ? assetUrl + '/' + report.user.avatar 
        : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(report.user ? report.user.name : 'Anonim') + '&background=1C1C1E&color=ffffff';
    
    document.getElementById('rd-avatar').src = avatarUrl;
    document.getElementById('rd-user-name').innerText = report.user ? report.user.name : 'Anonim';
    document.getElementById('rd-user-role').innerText = report.user ? report.user.role : 'GUEST';
    document.getElementById('rd-user-email').innerText = report.user ? report.user.email : 'N/A';
    
    document.getElementById('rd-issue-title').innerText = report.name;
    document.getElementById('rd-issue-desc').innerText = report.description;
    
    const imgContainer = document.getElementById('rd-image-container');
    if (report.image_path) {
        const imgUrl = assetUrl + '/' + report.image_path;
        document.getElementById('rd-image').src = imgUrl;
        document.getElementById('rd-image-link').href = imgUrl;
        imgContainer.classList.remove('hidden');
    } else {
        imgContainer.classList.add('hidden');
    }

    const modal = document.getElementById('report-detail-modal');
    if (modal) {
        modal.classList.remove('hidden');
        // Trigger reflow for transition
        void modal.offsetWidth;
        modal.classList.remove('opacity-0');
        const transformEl = modal.querySelector('.transform');
        if (transformEl) transformEl.classList.remove('scale-95');
    }
};

window.closeReportDetailModal = function() {
    const modal = document.getElementById('report-detail-modal');
    if (modal) {
        modal.classList.add('opacity-0');
        const transformEl = modal.querySelector('.transform');
        if (transformEl) transformEl.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
};

// ── Sub Materi Excel Import ───────────────────────────────────
window.triggerSubMateriExcelImport = function() {
    const fileInput = document.getElementById('import_sub_materi_excel_file');
    if (fileInput) {
        fileInput.click();
    }
};

window.submitSubMateriImportExcel = function() {
    const fileInput = document.getElementById('import_sub_materi_excel_file');
    if (fileInput && fileInput.files.length > 0) {
        document.getElementById('form-import-sub-materi-excel').submit();
        
        const btn = document.querySelector('button[onclick="window.triggerSubMateriExcelImport()"]');
        if (btn) {
            btn.innerHTML = `<svg class="h-3.5 w-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="uppercase tracking-widest">Mengunggah...</span>`;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    }
};

// ── Event Management ───────────────────────────────────────────
function showEventAlert(msg, type) {
    const el = document.getElementById('event-alert');
    if (!el) return;
    el.style.display = 'block';
    el.className = type === 'success'
        ? 'rounded-2xl px-5 py-3 text-sm font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100'
        : 'rounded-2xl px-5 py-3 text-sm font-semibold bg-red-50 text-red-500 border border-red-100';
    el.textContent = msg;
    setTimeout(() => { el.style.display = 'none'; }, 4000);
}

function reloadAdminEvents() {
    const navLink = document.querySelector('[data-spa-page="events"]');
    if (navLink) navLink.click();
}

window.openAddEventModal = function() {
    const modal = document.getElementById('add-event-modal');
    if (modal) modal.style.display = 'flex';
};

window.closeAddEventModal = function() {
    const modal = document.getElementById('add-event-modal');
    if (modal) modal.style.display = 'none';
};

window.submitAddEvent = async function(e) {
    e.preventDefault();
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const form = document.getElementById('add-event-form');
    const btn = document.getElementById('btn-add-submit');
    const orig = btn.textContent;
    btn.textContent = 'Menyimpan...'; btn.disabled = true;

    const fd = new FormData(form);
    const body = {};
    fd.forEach((v, k) => { body[k] = v; });
    if (!fd.has('is_active')) body['is_active'] = false;

    try {
        const res = await fetch('/admin/events', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: JSON.stringify(body)
        });
        const data = await res.json();
        if (res.ok && data.success) {
            window.closeAddEventModal(); form.reset();
            showEventAlert(data.message, 'success');
            reloadAdminEvents();
        } else {
            const errors = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Gagal menyimpan.');
            showEventAlert(errors, 'error');
        }
    } catch (err) { showEventAlert('Terjadi kesalahan jaringan.', 'error'); }
    btn.textContent = orig; btn.disabled = false;
};

window.openEditEventModal = function(id, title, desc, mult, start, end, active) {
    document.getElementById('edit-event-id').value = id;
    document.getElementById('edit-title').value = title;
    document.getElementById('edit-description').value = desc;
    document.getElementById('edit-multiplier').value = mult;
    document.getElementById('edit-start').value = start;
    document.getElementById('edit-end').value = end;
    document.getElementById('edit-active').checked = active;
    const modal = document.getElementById('edit-event-modal');
    if (modal) modal.style.display = 'flex';
};

window.closeEditEventModal = function() {
    const modal = document.getElementById('edit-event-modal');
    if (modal) modal.style.display = 'none';
};

window.submitEditEvent = async function(e) {
    e.preventDefault();
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const id = document.getElementById('edit-event-id').value;
    const form = document.getElementById('edit-event-form');
    const btn = document.getElementById('btn-edit-submit');
    const orig = btn.textContent;
    btn.textContent = 'Memperbarui...'; btn.disabled = true;

    const fd = new FormData(form);
    const body = {};
    fd.forEach((v, k) => { if (k !== '_token' && k !== '_method') body[k] = v; });
    if (!fd.has('is_active')) body['is_active'] = false;

    try {
        const res = await fetch(`/admin/events/${id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: JSON.stringify(body)
        });
        const data = await res.json();
        if (res.ok && data.success) {
            window.closeEditEventModal();
            showEventAlert(data.message, 'success');
            reloadAdminEvents();
        } else {
            const errors = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Gagal memperbarui.');
            showEventAlert(errors, 'error');
        }
    } catch (err) { showEventAlert('Terjadi kesalahan jaringan.', 'error'); }
    btn.textContent = orig; btn.disabled = false;
};

window.deleteEvent = async function(id) {
    if (!confirm('Yakin ingin menghapus event ini?')) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    try {
        const res = await fetch(`/admin/events/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        });
        const data = await res.json();
        if (res.ok && data.success) {
            const card = document.getElementById(`event-card-${id}`);
            if (card) {
                card.style.transition = 'opacity 0.3s, transform 0.3s';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95) translateY(8px)';
                setTimeout(() => card.remove(), 300);
            }
            showEventAlert(data.message, 'success');
        } else {
            showEventAlert(data.message || 'Gagal menghapus.', 'error');
        }
    } catch (err) { showEventAlert('Terjadi kesalahan jaringan.', 'error'); }
};

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
    table:      { label: 'Tabel',       icon: '▦',  color: '#f97316' },
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
                <input type="file" name="sections[${idx}][file]" accept="image/*" class="mt-0.5 block w-full text-sm text-zinc-600 file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm" onchange="window.previewImage(this)"></div>
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

        case 'table':
            return `<div><label class="text-xs text-zinc-600">Tabel (Baris dipisah Enter, Kolom dipisah |)</label>
                <p class="text-[10px] text-zinc-400 mb-1">Contoh:<br>Kolom 1 | Kolom 2<br>Data 1 | Data 2</p>
                <textarea name="sections[${idx}][content]" rows="5" class="${tw} font-mono" placeholder="Header 1 | Header 2\nData 1 | Data 2\nData 3 | Data 4"></textarea></div>`;

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
        // Update visual label
        const n = row.querySelector('.section-num');
        if (n) {
            n.textContent = `#${i + 1}`;
        }

        // Update order hidden input
        const orderInput = row.querySelector('input[name$="[order]"]');
        if (orderInput) {
            orderInput.value = i;
        }

        // Re-index ALL name attributes from old index → new index `i`
        row.querySelectorAll('[name]').forEach((input) => {
            const oldName = input.getAttribute('name');
            // Match sections[ANY_NUMBER][field]
            const updated = oldName.replace(/^sections\[\d+\]/, `sections[${i}]`);
            if (updated !== oldName) {
                input.setAttribute('name', updated);
            }
        });
    });
    
    // Auto-sync the Layer Panel
    updateLayerPanel(rowsWrap);
}

function updateLayerPanel(rowsWrap) {
    const rootContainer = rowsWrap.closest('.spa-fragment') || document;
    const list = rootContainer.querySelector('#subm-layer-list');
    if (!list) return;
    
    const rows = rowsWrap.querySelectorAll('[data-section-row]');
    if (rows.length === 0) {
        list.innerHTML = '<li class="text-center py-4 text-[10px] text-zinc-400 font-mono italic">Kosong</li>';
        return;
    }
    
    list.innerHTML = '';
    let currentBabIndex = 0;
    
    rows.forEach((row, idx) => {
        const type = row.dataset.sectionType;
        const meta = SECTION_TYPES[type] || { label: type, icon: '?', color: '#999' };
        
        let labelText = meta.label;
        if (type === 'bab') {
             currentBabIndex++;
             labelText = `Bab ${currentBabIndex}`;
        }
        
        const txtInput = row.querySelector('textarea[name$="[content]"], input[type="text"][name$="[content]"]');
        let snippet = txtInput ? txtInput.value.substring(0, 20).trim() : '';
        if (snippet.length >= 20) snippet += '...';
        
        const li = document.createElement('li');
        li.className = 'flex items-center justify-between p-2 rounded-lg bg-zinc-50 border border-zinc-100 hover:border-sky-200 hover:bg-sky-50 transition-colors cursor-pointer group shadow-sm';
        
        li.innerHTML = `
           <div class="flex items-center gap-2 overflow-hidden flex-1">
               <span class="inline-flex shrink-0 w-6 h-6 items-center justify-center rounded text-[10px] font-bold text-white shadow-sm" style="background:${meta.color}">${meta.icon}</span>
               <div class="flex flex-col min-w-0 flex-1">
                   <div class="flex items-center gap-1.5">
                       <span class="text-[10px] font-bold text-zinc-700 uppercase tracking-widest">${labelText}</span>
                       <span class="text-[8px] font-mono bg-zinc-200 text-zinc-500 px-1 rounded">#${idx + 1}</span>
                   </div>
                   <span class="text-[9px] text-zinc-500 truncate" title="${snippet || '—'}">${snippet || '—'}</span>
               </div>
           </div>
           <div class="flex flex-col gap-0.5 opacity-0 group-hover:opacity-100 transition-opacity ml-2">
               <button type="button" class="btn-layer-up p-1 rounded hover:bg-white hover:text-sky-600 hover:shadow-sm transition-all flex items-center justify-center text-zinc-400" title="Geser ke Atas">
                   <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
               </button>
               <button type="button" class="btn-layer-down p-1 rounded hover:bg-white hover:text-sky-600 hover:shadow-sm transition-all flex items-center justify-center text-zinc-400" title="Geser ke Bawah">
                   <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
               </button>
           </div>
        `;
        
        li.draggable = true;
        
        li.addEventListener('dragstart', (e) => {
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', idx);
            li.classList.add('opacity-40', 'scale-95');
        });
        
        li.addEventListener('dragend', () => {
            li.classList.remove('opacity-40', 'scale-95');
            list.querySelectorAll('li').forEach(item => {
                item.classList.remove('border-sky-400', 'border-t-2', 'border-b-2');
            });
        });

        li.addEventListener('dragover', (e) => {
            e.preventDefault(); // Necessary to allow dropping
            e.dataTransfer.dropEffect = 'move';
        });

        li.addEventListener('dragenter', (e) => {
            e.preventDefault();
            li.classList.add('border-sky-400', 'border-b-2');
        });

        li.addEventListener('dragleave', (e) => {
            // Prevent flickering when hovering over children
            if (e.relatedTarget === null || !li.contains(e.relatedTarget)) {
                li.classList.remove('border-sky-400', 'border-b-2');
            }
        });

        li.addEventListener('drop', (e) => {
            e.stopPropagation();
            li.classList.remove('border-sky-400', 'border-b-2');
            
            const dragIndex = parseInt(e.dataTransfer.getData('text/plain'), 10);
            const dropIndex = idx;
            
            if (dragIndex === dropIndex || isNaN(dragIndex)) return;
            
            const allRows = Array.from(rowsWrap.querySelectorAll('[data-section-row]'));
            const draggedRow = allRows[dragIndex];
            const targetRow = allRows[dropIndex];
            
            if (!draggedRow || !targetRow) return;
            
            if (dragIndex < dropIndex) {
                targetRow.parentNode.insertBefore(draggedRow, targetRow.nextSibling);
            } else {
                targetRow.parentNode.insertBefore(draggedRow, targetRow);
            }
            
            renumberSubmSections(rowsWrap);
        });

        // Auto-scroll action when clicking the card body (not the buttons)
        li.addEventListener('click', (e) => {
             const btn = e.target.closest('button');
             if (!btn) {
                 row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                 row.classList.add('ring-2', 'ring-sky-500', 'bg-sky-50/50');
                 setTimeout(() => {
                     row.classList.remove('ring-2', 'ring-sky-500', 'bg-sky-50/50');
                 }, 1500);
             }
        });
        
        // Move up/down actions from the layer panel
        li.querySelector('.btn-layer-up').addEventListener('click', (e) => {
             e.stopPropagation();
             const upBtn = row.querySelector('.btn-move-section-up');
             if (upBtn) {
                 upBtn.click();
             }
        });
        li.querySelector('.btn-layer-down').addEventListener('click', (e) => {
             e.stopPropagation();
             const downBtn = row.querySelector('.btn-move-section-down');
             if (downBtn) {
                 downBtn.click();
             }
        });
        
        list.appendChild(li);
        
        // Bind input event to update snippet live
        if (txtInput && !txtInput.dataset.boundLayer) {
             txtInput.dataset.boundLayer = "1";
             txtInput.addEventListener('input', () => updateLayerPanel(rowsWrap));
        }
    });

    // (Minimize/Maximize binding moved to setupSubMateriForm)
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
                
                // Auto-scroll to the newly added block, then focus
                if (block) {
                    // Focus first without native scrolling to prevent jumping
                    const firstInput = block.querySelector('input[type="text"], textarea');
                    if (firstInput) {
                        firstInput.focus({ preventScroll: true });
                    }
                    
                    // Then trigger smooth center scroll
                    setTimeout(() => {
                        block.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        block.classList.add('ring-2', 'ring-sky-500', 'bg-sky-50/50', 'transition-all');
                        setTimeout(() => {
                            block.classList.remove('ring-2', 'ring-sky-500', 'bg-sky-50/50');
                        }, 1500);
                    }, 50);
                }
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
        // Initial render for layer panel on page load
        updateLayerPanel(rowsWrap);
    }
    
    // Minimize/Maximize Layer Panel Toggle
    const btnToggleLayer = container.querySelector('#btn-toggle-layer');
    const panelContent = container.querySelector('#subm-layer-content');
    const toggleIcon = container.querySelector('#icon-toggle-layer');
    const panel = container.querySelector('#subm-layer-panel');
    const panelTitle = btnToggleLayer ? btnToggleLayer.querySelector('h3') : null;
    // root = #submateri-app which IS the .spa-fragment element

    if (btnToggleLayer && panelContent && toggleIcon && panel) {
        // Start completely minimized by default
        let isMinimized = true;
        
        // Prepare initial content styles for fade effect
        panelContent.style.opacity = '0';
        panelContent.style.transition = 'opacity 0.3s ease';
        if (panelTitle) {
            panelTitle.style.opacity = '0';
            panelTitle.style.transition = 'opacity 0.3s ease';
        }

        function setPanelExpanded() {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            
            // Expand panel dimensions
            panel.style.width = '288px';
            panel.style.borderRadius = '1rem';
            panel.style.overflow = '';
            
            // Show content layout, then fade in fast
            panelContent.style.display = '';
            if (panelTitle) panelTitle.style.display = '';
            setTimeout(() => {
                panelContent.style.opacity = '1';
                if (panelTitle) panelTitle.style.opacity = '1';
            }, 20);

            // Adjust form padding
            if (window.innerWidth >= 1024) {
                root.style.paddingRight = '300px';
            }
            btnToggleLayer.style.padding = '16px';
            btnToggleLayer.style.justifyContent = 'space-between';
            toggleIcon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>';
        }
        
        function setPanelMinimized() {
            panel.classList.remove('hidden');
            panel.classList.add('flex');
            
            // Fade out content fast
            panelContent.style.opacity = '0';
            if (panelTitle) panelTitle.style.opacity = '0';
            
            // Shrink panel
            panel.style.width = '56px';
            panel.style.borderRadius = '9999px';
            panel.style.overflow = 'hidden';
            
            // Hide content from layout after faster fade
            setTimeout(() => {
                if (isMinimized) {
                    panelContent.style.display = 'none';
                    if (panelTitle) panelTitle.style.display = 'none';
                }
            }, 150);

            // Remove form padding
            root.style.removeProperty('padding-right');
            btnToggleLayer.style.padding = '12px';
            btnToggleLayer.style.justifyContent = 'center';
            toggleIcon.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
        }
        
        // Setup modern easing transitions but much faster
        const modernEasing = 'cubic-bezier(0.2, 0.8, 0.2, 1)';
        root.style.transition = `padding-right 0.2s ${modernEasing}`;
        panel.style.transition = `width 0.2s ${modernEasing}, border-radius 0.2s ${modernEasing}`;
        btnToggleLayer.style.transition = `padding 0.2s ${modernEasing}`;
        panelContent.style.transition = 'opacity 0.15s ease';
        if (panelTitle) panelTitle.style.transition = 'opacity 0.15s ease';
        
        // Initial: form loads at 100%, then panel icon appears after delay on ALL screen sizes
        setTimeout(() => setPanelMinimized(), 400);
        
        // Click handler for toggle
        btnToggleLayer.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            isMinimized = !isMinimized;
            if (isMinimized) {
                setPanelMinimized();
            } else {
                setPanelExpanded();
            }
        });
    }

    // Frontend validation to prevent Silent Data Loss on Validation Error Redirects
    const form = root.tagName === 'FORM' ? root : root.querySelector('form') || root.closest('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            let valid = true;
            let msg = '';

            // Check file sizes (Max 5MB)
            const files = form.querySelectorAll('input[type="file"]');
            files.forEach(f => {
                if (f.files && f.files.length > 0) {
                    if (f.files[0].size > 5 * 1024 * 1024) {
                        valid = false;
                        msg += `❌ File "${f.files[0].name}" terlalu besar (Max 5MB).\n`;
                    }
                }
            });

            // Check hasContent
            const activeRows = form.querySelectorAll('[data-section-row]');
            if (activeRows.length > 0) {
                let hasContent = false;
                activeRows.forEach(r => {
                    const t = r.getAttribute('data-section-type') || r.querySelector('input[name$="[type]"]')?.value;
                    if (t === 'divider' || t === 'image') {
                        hasContent = true;
                    } else {
                        // Find any text/textarea that contains the word [content]
                        const txt = r.querySelector('textarea[name$="[content]"], input[type="text"][name$="[content]"]');
                        if (txt && txt.value.trim() !== '') {
                            hasContent = true;
                        }
                    }
                });

                if (!hasContent) {
                    valid = false;
                    msg += `❌ Minimal satu section harus berisi konten (teks, gambar, atau garis pemisah).\n`;
                }
            }

            if (!valid) {
                e.preventDefault();
                alert('Terdapat Kesalahan Sebelum Disimpan:\n\n' + msg + '\nMohon perbaiki agar file yang di-upload tidak hilang.');
            }
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
function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe.toString().replace(/[&<"'>]/g, function (m) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
    });
}

function questionRowHtml(idx, data = {}) {
    const tw = 'mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500';
    const codeTw = 'mt-0.5 w-full rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-3 text-sm font-mono text-emerald-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500';
    
    // Parse options array if it exists
    const options = data.options ? (typeof data.options === 'string' ? JSON.parse(data.options) : data.options) : [];
    const optA = options[0] || data.option_a || '';
    const optB = options[1] || data.option_b || '';
    const optC = options[2] || data.option_c || '';
    const optD = options[3] || data.option_d || '';
    
    const correctOpt = data.correct_option !== undefined ? parseInt(data.correct_option) : 0;
    const hasCode = data.code_snippet && data.code_snippet.trim() !== '';

    return (
        `<div class="q-block rounded-xl border border-zinc-200 bg-zinc-50/50 p-5 transition-all" data-q-row style="animation: qFadeIn 0.3s ease-out">` +
        `<input type="hidden" name="questions[${idx}][id]" value="${data.id || ''}">` +
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
        `<textarea name="questions[${idx}][question]" rows="3" required class="${tw}" placeholder="Tuliskan pertanyaan...">${escapeHtml(data.question || '')}</textarea></div>` +
        // Code snippet toggle
        `<div class="q-code-section">` +
        `<button type="button" class="btn-toggle-code inline-flex items-center gap-1.5 rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-600 hover:bg-zinc-50 transition-colors">` +
        `<svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>` +
        `+ Tambah Kode</button>` +
        `<div class="q-code-fields mt-3 space-y-2 hidden">` +
        `<div class="flex gap-3">` +
        `<div class="w-40"><label class="text-xs text-zinc-600">Bahasa</label>` +
        `<input type="text" name="questions[${idx}][code_language]" value="${escapeHtml(data.code_language || '')}" class="${tw}" placeholder="php, js, python..."></div>` +
        `<div class="flex-1"><label class="text-xs text-zinc-600">Preview bahasa</label>` +
        `<p class="mt-0.5 px-3 py-2 text-xs text-zinc-400 italic">Bahasa ditampilkan di kiri atas blok kode</p></div>` +
        `</div>` +
        `<div><label class="text-xs text-zinc-600">Kode</label>` +
        `<textarea name="questions[${idx}][code_snippet]" rows="6" class="${codeTw}" placeholder="Tuliskan potongan kode di sini..." spellcheck="false">${escapeHtml(data.code_snippet || '')}</textarea></div>` +
        `</div></div>` +
        // Options
        `<div class="grid gap-3 sm:grid-cols-2">` +
        // Option A
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="0" ${correctOpt === 0 ? 'checked' : ''} class="mr-1"> ` +
        `Opsi A <span class="text-emerald-500 text-[10px]">(klik = jawaban benar)</span></label>` +
        `<input type="text" name="questions[${idx}][option_a]" value="${escapeHtml(optA)}" required class="${tw}" placeholder="Opsi A"></div>` +
        // Option B
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="1" ${correctOpt === 1 ? 'checked' : ''} class="mr-1"> Opsi B</label>` +
        `<input type="text" name="questions[${idx}][option_b]" value="${escapeHtml(optB)}" required class="${tw}" placeholder="Opsi B"></div>` +
        // Option C
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="2" ${correctOpt === 2 ? 'checked' : ''} class="mr-1"> Opsi C</label>` +
        `<input type="text" name="questions[${idx}][option_c]" value="${escapeHtml(optC)}" required class="${tw}" placeholder="Opsi C"></div>` +
        // Option D
        `<div class="relative"><label class="text-xs text-zinc-600">` +
        `<input type="radio" name="questions[${idx}][correct_option]" value="3" ${correctOpt === 3 ? 'checked' : ''} class="mr-1"> Opsi D</label>` +
        `<input type="text" name="questions[${idx}][option_d]" value="${escapeHtml(optD)}" required class="${tw}" placeholder="Opsi D"></div>` +
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

    // ── Expose loadQuestionGroup to global for the Blade template ──
    window.loadQuestionGroup = async function(mainId, materiId, subMateriId, questionsJsonStr) {
        let qs = [];
        try {
            qs = JSON.parse(questionsJsonStr);
        } catch (e) {
            console.error("Failed to parse questions", e);
        }

        // Set Main
        mainSel.value = mainId;
        await loadMateris(mainId);
        
        // Set Materi
        materiSel.value = materiId;
        await loadSubMateris(materiId);
        
        // Set Sub Materi
        subMateriSel.value = subMateriId;
        formWrap.classList.remove('hidden');

        // Set Sync mode to 1 so backend knows to delete missing items
        let syncInput = container.querySelector('#q-sync-mode');
        if (!syncInput) {
            syncInput = document.createElement('input');
            syncInput.type = 'hidden';
            syncInput.name = 'sync_mode';
            syncInput.id = 'q-sync-mode';
            container.querySelector('form').appendChild(syncInput);
        }
        syncInput.value = '1';

        // Clear existing rows
        rowsWrap.innerHTML = '';
        if (qs.length === 0) {
            if (emptyState) emptyState.classList.remove('hidden');
        } else {
            if (emptyState) emptyState.classList.add('hidden');
            qs.forEach((q, idx) => {
                const wrapper = document.createElement('div');
                wrapper.innerHTML = questionRowHtml(idx, q);
                const block = wrapper.firstElementChild;
                if (block) {
                    rowsWrap.appendChild(block);
                    attachQuestionRowActions(block, rowsWrap, emptyState);
                    // Open code section if it has code
                    if (q.code_snippet && q.code_snippet.trim() !== '') {
                        block.querySelector('.btn-toggle-code').click();
                    }
                }
            });
            renumberQuestions(rowsWrap);
        }

        // Scroll up to form smoothly
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    // ── Expose deleteQuestionGroup to global for the Blade template ──
    window.deleteQuestionGroup = function(subMateriId, subMateriTitle) {
        if (!confirm(`Apakah Anda yakin ingin menghapus seluruh soal untuk sub-materi "${subMateriTitle}"?`)) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
            || document.querySelector('[data-csrf]')?.dataset.csrf 
            || document.querySelector('input[name="_token"]')?.value;

        fetch(`/admin/question/sub-materi/${subMateriId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Berhasil menghapus soal.');
                window.location.reload();
            } else {
                alert(data.message || 'Gagal menghapus soal.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus.');
        });
    };
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

    // ═══════════════════════════════════════════════════════
    //  DATABASE TABLE DATA CRUD (View / Edit / Delete)
    // ═══════════════════════════════════════════════════════
    let _dbCurrentTable = null;
    let _dbCurrentColumns = [];
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // ── Data button click handlers ──
    container.querySelectorAll('[data-view-table]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const tableName = btn.dataset.viewTable;
            openDataModal(tableName);
        });
    });

    // ── Modal controls ──
    const dataModal = document.getElementById('db-data-modal');
    const dataBackdrop = document.getElementById('db-data-backdrop');
    const dataContent = document.getElementById('db-data-content');
    const editModal = document.getElementById('db-edit-modal');
    const editBackdrop = document.getElementById('db-edit-backdrop');
    const editContent = document.getElementById('db-edit-content');

    document.getElementById('db-data-close-btn')?.addEventListener('click', closeDataModal);
    document.getElementById('db-data-refresh-btn')?.addEventListener('click', async () => {
        if (!_dbCurrentTable) return;
        const icon = document.getElementById('db-data-refresh-icon');
        icon.classList.add('animate-spin');
        await loadTableData(_dbCurrentTable);
        setTimeout(() => icon.classList.remove('animate-spin'), 500);
    });
    document.getElementById('db-edit-close-btn')?.addEventListener('click', closeEditModal);
    document.getElementById('db-edit-cancel-btn')?.addEventListener('click', closeEditModal);
    document.getElementById('db-edit-save-btn')?.addEventListener('click', saveEdit);

    dataBackdrop?.addEventListener('click', closeDataModal);
    editBackdrop?.addEventListener('click', closeEditModal);

    // ── Open Data Modal ──
    async function openDataModal(tableName) {
        _dbCurrentTable = tableName;
        document.getElementById('db-data-title').textContent = tableName;
        document.getElementById('db-data-body').innerHTML = `
            <div class="flex items-center justify-center py-16 text-zinc-400">
                <svg class="w-6 h-6 animate-spin mr-3 text-indigo-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                <span class="text-sm font-medium">Memuat data...</span>
            </div>`;
        dataModal.classList.remove('hidden');
        setTimeout(() => {
            dataBackdrop.classList.remove('opacity-0');
            dataContent.classList.remove('scale-95', 'opacity-0');
        }, 10);
        await loadTableData(tableName);
    }

    function closeDataModal() {
        dataBackdrop.classList.add('opacity-0');
        dataContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => dataModal.classList.add('hidden'), 300);
    }

    // ── Load Table Data ──
    async function loadTableData(tableName) {
        try {
            const res = await fetch(`/admin/api/table/${tableName}/rows`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                credentials: 'same-origin',
            });
            if (!res.ok) throw new Error('Failed');
            const data = await res.json();

            _dbCurrentColumns = data.columns;
            document.getElementById('db-data-count').textContent = `${data.total} total records — menampilkan ${data.rows.length} data terbaru`;

            if (!data.rows.length) {
                document.getElementById('db-data-body').innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 text-zinc-400">
                        <svg class="w-10 h-10 mb-3 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                        <p class="text-sm font-semibold">Tabel kosong</p>
                        <p class="text-xs mt-1">Tidak ada data dalam tabel ini.</p>
                    </div>`;
                return;
            }

            const visibleCols = data.columns.slice(0, 8);
            const hasMore = data.columns.length > 8;

            let html = `<div class="overflow-x-auto"><table class="w-full text-left text-sm">`;
            html += `<thead class="bg-zinc-50 text-[11px] uppercase tracking-wider text-zinc-400 font-bold border-b border-zinc-200 sticky top-0 z-10"><tr>`;
            visibleCols.forEach(col => { html += `<th class="px-4 py-3 whitespace-nowrap">${escapeHtml(col)}</th>`; });
            if (hasMore) html += `<th class="px-4 py-3 whitespace-nowrap text-zinc-300">+${data.columns.length - 8} more</th>`;
            html += `<th class="px-4 py-3 text-right whitespace-nowrap">Aksi</th></tr></thead><tbody class="divide-y divide-zinc-100">`;

            data.rows.forEach((row, rowIdx) => {
                html += `<tr class="hover:bg-zinc-50/80 transition-colors">`;
                visibleCols.forEach(col => {
                    let val = row[col];
                    let display = val === null ? '<span class="text-zinc-300 text-[10px] font-mono">NULL</span>' : escapeHtml(String(val));
                    if (typeof val === 'string' && val.length > 50) {
                        display = escapeHtml(val.substring(0, 50)) + '<span class="text-zinc-400">…</span>';
                    }
                    html += `<td class="px-4 py-3 text-[13px] text-zinc-700 whitespace-nowrap max-w-[200px] truncate">${display}</td>`;
                });
                if (hasMore) html += `<td class="px-4 py-3 text-zinc-300 text-xs">...</td>`;

                html += `<td class="px-4 py-3 text-right whitespace-nowrap">
                    <div class="flex items-center justify-end gap-1.5">
                        <button data-edit-idx="${rowIdx}" class="db-row-edit inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            Edit
                        </button>
                        <button data-delete-id="${row.id || ''}" class="db-row-delete inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-bold bg-red-50 text-red-500 hover:bg-red-100 border border-red-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            Hapus
                        </button>
                    </div>
                </td></tr>`;
            });
            html += `</tbody></table></div>`;

            document.getElementById('db-data-body').innerHTML = html;

            // Attach edit/delete handlers
            document.querySelectorAll('#db-data-body .db-row-edit').forEach(btn => {
                btn.addEventListener('click', () => {
                    const idx = parseInt(btn.dataset.editIdx);
                    openEditModal(data.rows[idx]);
                });
            });
            document.querySelectorAll('#db-data-body .db-row-delete').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const rowId = btn.dataset.deleteId;
                    if (!confirm('Apakah kamu yakin ingin menghapus data ini?')) return;
                    try {
                        const res = await fetch(`/admin/api/table/${_dbCurrentTable}/row/${rowId}`, {
                            method: 'DELETE',
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                            credentials: 'same-origin',
                        });
                        if (!res.ok) throw new Error('Gagal menghapus');
                        await loadTableData(_dbCurrentTable);
                    } catch (err) { alert('Error: ' + err.message); }
                });
            });

        } catch (err) {
            document.getElementById('db-data-body').innerHTML = `
                <div class="flex flex-col items-center justify-center py-16 text-red-400">
                    <p class="text-sm font-semibold">Gagal memuat data</p>
                    <p class="text-xs mt-1">${err.message}</p>
                </div>`;
        }
    }

    // ── Edit Row Modal ──
    function openEditModal(rowData) {
        document.getElementById('db-edit-title').textContent = `Edit Row — ${_dbCurrentTable}`;
        document.getElementById('db-edit-subtitle').textContent = `ID: ${rowData.id || '?'}`;

        const formContainer = document.getElementById('db-edit-form-container');
        const skipFields = ['id', 'created_at', 'updated_at', 'remember_token', 'email_verified_at'];
        let html = '';

        _dbCurrentColumns.forEach(col => {
            const val = rowData[col];
            const isReadOnly = skipFields.includes(col);
            const displayVal = val === null ? '' : String(val);

            if (isReadOnly) {
                html += `<div>
                    <label class="block text-[11px] uppercase font-bold text-zinc-400 mb-1.5 tracking-wider">${escapeHtml(col)} <span class="text-zinc-300">(read-only)</span></label>
                    <div class="w-full px-4 py-2.5 rounded-xl bg-zinc-100 border border-zinc-200 text-sm text-zinc-500 font-mono truncate">${escapeHtml(displayVal) || '<span class="text-zinc-300">NULL</span>'}</div>
                </div>`;
            } else {
                const isLong = displayVal.length > 100;
                if (isLong) {
                    html += `<div>
                        <label class="block text-[11px] uppercase font-bold text-zinc-400 mb-1.5 tracking-wider">${escapeHtml(col)}</label>
                        <textarea name="${escapeHtml(col)}" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-white border border-zinc-200 text-sm text-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition-all resize-y font-mono">${escapeHtml(displayVal)}</textarea>
                    </div>`;
                } else {
                    html += `<div>
                        <label class="block text-[11px] uppercase font-bold text-zinc-400 mb-1.5 tracking-wider">${escapeHtml(col)}</label>
                        <input type="text" name="${escapeHtml(col)}" value="${escapeHtml(displayVal)}" class="w-full px-4 py-2.5 rounded-xl bg-white border border-zinc-200 text-sm text-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition-all" />
                    </div>`;
                }
            }
        });

        formContainer.innerHTML = html;
        formContainer.dataset.rowId = rowData.id || 0;

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
        setTimeout(() => {
            editBackdrop.classList.remove('opacity-0');
            editContent.classList.remove('scale-95', 'opacity-0');
        }, 10);
    }

    function closeEditModal() {
        editBackdrop.classList.add('opacity-0');
        editContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { editModal.classList.add('hidden'); editModal.classList.remove('flex'); }, 300);
    }

    async function saveEdit() {
        const formContainer = document.getElementById('db-edit-form-container');
        const rowId = formContainer.dataset.rowId;
        const saveBtn = document.getElementById('db-edit-save-btn');
        const inputs = formContainer.querySelectorAll('input[name], textarea[name]');

        const data = {};
        inputs.forEach(inp => { data[inp.name] = inp.value; });

        saveBtn.disabled = true;
        saveBtn.textContent = 'Menyimpan...';

        try {
            const res = await fetch(`/admin/api/table/${_dbCurrentTable}/row/${rowId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                credentials: 'same-origin',
                body: JSON.stringify(data),
            });
            if (!res.ok) throw new Error('Gagal menyimpan');
            closeEditModal();
            await loadTableData(_dbCurrentTable);
        } catch (err) {
            alert('Error: ' + err.message);
        } finally {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Simpan';
        }
    }
}

async function loadPage(page, push = true) {
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

    const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
        credentials: 'same-origin',
    });
    if (!res.ok) {
        el.innerHTML = '<p class="text-sm text-red-600">Gagal memuat halaman.</p>';
        return;
    }
    el.innerHTML = await res.text();
    
    // Auto-scroll to top smoothly
    window.scrollTo({ top: 0, behavior: 'smooth' });
    
    // Update active nav state
    const basePage = page.split('?')[0];

    // Push state and update URL
    if (push) {
        const newUrl = new URL(window.location.href);
        newUrl.searchParams.set('page', page);
        if (window.history.state?.spaPage !== page) {
            window.history.pushState({ spaPage: page }, '', newUrl.toString());
        }
    }

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
                    status: editBlock.querySelector('.edit-status')?.value || 'draft',
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
    // Determine the exact page string from URL search params first, fallback to dataset.spaInitial
    const urlParams = new URLSearchParams(window.location.search);
    const initialPage = urlParams.get('page') || initial;

    // Load initial page and set initial history state
    loadPage(initialPage, true);

    document.body.addEventListener('click', (e) => {
        const a = e.target.closest('[data-spa-page]');
        if (!a) {
            return;
        }
        e.preventDefault();
        const page = a.dataset.spaPage;
        if (page) {
            loadPage(page, true);
        }
    });

    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.spaPage) {
            loadPage(e.state.spaPage, false);
        } else {
            loadPage(initialPage, false);
        }
    });
});

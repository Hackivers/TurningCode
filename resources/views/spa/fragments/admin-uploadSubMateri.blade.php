<div class="tittle-uploadsubmateri">
    <div>
        <h4>upload submateri yok, biar ada update baru nih!!...</h4>
        <h5>user newbie nugguin nih, nggk sabar belajar mereka</h5>
    </div>
</div>
<div class="container container-uploadsubmateri">
    <main class="main-uploadsubmateri">
        <div class="wrapper-uploadsubmateri">
            <form class="wrapper-uploadsubmateri" action="{{ route('admin.sub-materi.store') }}" method="POST"
                id="form-submateri" enctype="multipart/form-data">
                @csrf

                {{-- ═══════════════════════════════════════════════
                    STEP 1 : Pilih Main Materi → Materi
                ═══════════════════════════════════════════════ --}}
                <div>
                    <div class="tittle-kategori-submateri select-materi">
                        <div>
                            <h4>pilih main materi apa</h4>
                            <h5>pilih lah berdasarkan main materi yak!!, jangan asal pilih</h5>
                        </div>
                        <div>
                            <select id="mainSelect">
                                <option value="">-- pilih main materi --</option>
                                @foreach ($mainMateris as $main)
                                    <option value="{{ $main->id }}">{{ $main->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="tittle-kategori-submateri select-materi" id="materiWrapper" style="display:none;">
                        <div>
                            <h4>pilih materi apa untuk lanjut buat submateri baru</h4>
                            <h5>pilih lah sesuai kategori materi yang sesuai yak!!...</h5>
                        </div>
                        <div>
                            <select name="materi_id" id="materiSelect" required>
                                <option value="">-- pilih materi --</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════
                    STEP 2 : Metadata sub-materi
                ═══════════════════════════════════════════════ --}}
                <div class="wrapper-desc-submateri" id="formWrapper" style="display:none;">
                    <div>
                        <div class="tittle-kategori-submateri">
                            <div>
                                <h4>isi data yang sesuai</h4>
                                <h5>isi dengan benar dan teliti agar tidak typo</h5>
                            </div>
                        </div>
                        <div class="input">
                            <input type="text" name="title" placeholder="Judul Utama" required>
                            <input type="text" name="subtitle" placeholder="Sub Judul">
                        </div>
                        <div class="input">
                            <input type="text" name="author" placeholder="Author">
                            <input type="file" name="thumbnail">
                        </div>
                        <div class="input">
                            <input type="text" name="meta_title" placeholder="Meta Title">
                            <textarea name="meta_description" placeholder="Meta Description"></textarea>
                        </div>
                        <div class="check-publish">
                            <label class="checkbox">
                                <input type="checkbox" name="is_published" value="1" checked>
                                Publish
                            </label>
                        </div>

                        {{-- ═══════════════════════════════════════════════
                            STEP 3 : Artikel sections (dynamic)
                        ═══════════════════════════════════════════════ --}}
                        <div class="wrapper-artikel-submateri">
                            <div class="tittle-kategori-submateri">
                                <div>
                                    <h4>isi artikel yang sesuai</h4>
                                    <h5>klik tombol di bawah untuk menambah section baru</h5>
                                </div>
                            </div>
                            <div class="toolbar" id="section-toolbar">
                                <button type="button" onclick="addSection('heading')">+ Judul</button>
                                <button type="button" onclick="addSection('subheading')">+ Subjudul</button>
                                <button type="button" onclick="addSection('paragraph')">+ Paragraf</button>
                                <button type="button" onclick="addSection('code')">+ Kode</button>
                                <button type="button" onclick="addSection('image')">+ Gambar</button>
                                <button type="button" onclick="addSection('quote')">+ Kutipan</button>
                                <button type="button" onclick="addSection('list')">+ Daftar/List</button>
                                <button type="button" onclick="addSection('divider')">+ Pemisah</button>
                            </div>
                            <div id="sections-wrapper"></div>

                            @if ($errors->any())
                                <div class="error-list">
                                    <ul>
                                        @foreach ($errors->all() as $err)
                                            <li>⚠️ {{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <button type="submit" class="btn-submit">💾 Simpan SubMateri</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     JAVASCRIPT : addSection, remove, reorder, cascading select
═══════════════════════════════════════════════════════════════ --}}
<script>
    // ─── Section counter ────────────────────────────────────
    let sectionIndex = 0;

    // ─── Section type config ────────────────────────────────
    const SECTION_META = {
        heading:    { label: '📌 Judul',       icon: 'H',  color: '#6366f1' },
        subheading: { label: '📎 Subjudul',    icon: 'H2', color: '#8b5cf6' },
        paragraph:  { label: '📝 Paragraf',    icon: 'P',  color: '#3b82f6' },
        code:       { label: '💻 Kode',        icon: '<>', color: '#10b981' },
        image:      { label: '🖼️ Gambar',     icon: '📷', color: '#f59e0b' },
        quote:      { label: '💬 Kutipan',     icon: '"',  color: '#ec4899' },
        list:       { label: '📋 Daftar/List', icon: '☰',  color: '#14b8a6' },
        divider:    { label: '➖ Pemisah',     icon: '—',  color: '#6b7280' },
    };

    /**
     *  Tambah section baru ke dalam wrapper.
     *  Setiap section disimpan sebagai: sections[idx][type] dan sections[idx][content]
     */
    function addSection(type) {
        const wrapper = document.getElementById('sections-wrapper');
        const meta = SECTION_META[type] || { label: type, icon: '?', color: '#999' };
        const idx = sectionIndex++;

        const block = document.createElement('div');
        block.className = 'section-block';
        block.setAttribute('data-section-idx', idx);
        block.style.borderLeftColor = meta.color;

        let inputHtml = '';

        switch (type) {
            case 'heading':
                inputHtml = `<input type="text" name="sections[${idx}][content]"
                                placeholder="Tulis judul section..." class="section-input" required>`;
                break;

            case 'subheading':
                inputHtml = `<input type="text" name="sections[${idx}][content]"
                                placeholder="Tulis subjudul section..." class="section-input">`;
                break;

            case 'paragraph':
                inputHtml = `<textarea name="sections[${idx}][content]" rows="5"
                                placeholder="Tulis paragraf / artikel di sini..." class="section-textarea"></textarea>`;
                break;

            case 'code':
                inputHtml = `
                    <input type="text" name="sections[${idx}][language]"
                        placeholder="Bahasa (php, js, python, dll)" class="section-input section-input-sm">
                    <textarea name="sections[${idx}][content]" rows="6"
                        placeholder="Tulis kode di sini..." class="section-textarea section-code"></textarea>`;
                break;

            case 'image':
                inputHtml = `
                    <input type="file" name="sections[${idx}][file]" accept="image/*" class="section-file">
                    <input type="text" name="sections[${idx}][content]"
                        placeholder="Caption / keterangan gambar (opsional)" class="section-input">`;
                break;

            case 'quote':
                inputHtml = `
                    <textarea name="sections[${idx}][content]" rows="3"
                        placeholder="Isi kutipan..." class="section-textarea section-quote"></textarea>
                    <input type="text" name="sections[${idx}][source]"
                        placeholder="Sumber kutipan (opsional)" class="section-input section-input-sm">`;
                break;

            case 'list':
                inputHtml = `
                    <textarea name="sections[${idx}][content]" rows="5"
                        placeholder="Satu item per baris...&#10;• Item pertama&#10;• Item kedua&#10;• Item ketiga"
                        class="section-textarea"></textarea>
                    <div class="section-list-type">
                        <label><input type="radio" name="sections[${idx}][list_type]" value="unordered" checked> • Bullet</label>
                        <label><input type="radio" name="sections[${idx}][list_type]" value="ordered"> 1. Numbered</label>
                    </div>`;
                break;

            case 'divider':
                inputHtml = `<p class="section-divider-preview">── Garis pemisah akan ditampilkan di sini ──</p>
                             <input type="hidden" name="sections[${idx}][content]" value="---">`;
                break;
        }

        block.innerHTML = `
            <input type="hidden" name="sections[${idx}][type]" value="${type}">
            <input type="hidden" name="sections[${idx}][order]" value="${idx}">
            <div class="section-header">
                <div class="section-badge" style="background:${meta.color}">${meta.icon}</div>
                <span class="section-label">${meta.label}</span>
                <span class="section-number">#${idx + 1}</span>
                <div class="section-actions">
                    <button type="button" class="btn-move-up" onclick="moveSection(this, -1)" title="Pindah ke atas">▲</button>
                    <button type="button" class="btn-move-down" onclick="moveSection(this, 1)" title="Pindah ke bawah">▼</button>
                    <button type="button" class="btn-remove" onclick="removeSection(this)" title="Hapus section">✕</button>
                </div>
            </div>
            <div class="section-body">
                ${inputHtml}
            </div>
        `;

        wrapper.appendChild(block);
        renumberSections();

        // auto-focus first input
        const firstInput = block.querySelector('input[type="text"], textarea');
        if (firstInput) firstInput.focus();
    }

    /**
     *  Hapus section
     */
    function removeSection(btn) {
        const block = btn.closest('.section-block');
        if (block) {
            block.style.opacity = '0';
            block.style.transform = 'translateX(30px)';
            setTimeout(() => {
                block.remove();
                renumberSections();
            }, 250);
        }
    }

    /**
     *  Pindahkan section ke atas / bawah
     */
    function moveSection(btn, direction) {
        const block = btn.closest('.section-block');
        const wrapper = document.getElementById('sections-wrapper');
        if (!block || !wrapper) return;

        if (direction === -1 && block.previousElementSibling) {
            wrapper.insertBefore(block, block.previousElementSibling);
        } else if (direction === 1 && block.nextElementSibling) {
            wrapper.insertBefore(block.nextElementSibling, block);
        }
        renumberSections();
    }

    /**
     *  Renumber semua sections setelah add / remove / move
     */
    function renumberSections() {
        const wrapper = document.getElementById('sections-wrapper');
        wrapper.querySelectorAll('.section-block').forEach((block, i) => {
            const numEl = block.querySelector('.section-number');
            if (numEl) numEl.textContent = `#${i + 1}`;

            // update order hidden input
            const orderInput = block.querySelector('input[name$="[order]"]');
            if (orderInput) orderInput.value = i;
        });
    }

    // ─── Cascading select: Main Materi → Materi ─────────────
    document.addEventListener('DOMContentLoaded', () => {
        const mainSelect   = document.getElementById('mainSelect');
        const materiWrapper = document.getElementById('materiWrapper');
        const materiSelect  = document.getElementById('materiSelect');
        const formWrapper   = document.getElementById('formWrapper');
        const apiBase       = '{{ url("/admin/api/main") }}';

        if (mainSelect) {
            mainSelect.addEventListener('change', async () => {
                const mainId = mainSelect.value;
                if (!mainId) {
                    materiWrapper.style.display = 'none';
                    formWrapper.style.display   = 'none';
                    materiSelect.innerHTML = '<option value="">-- pilih materi --</option>';
                    return;
                }

                try {
                    const res = await fetch(`${apiBase}/${mainId}/materis`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                        credentials: 'same-origin',
                    });
                    if (!res.ok) throw new Error('Gagal memuat materi');
                    const data = await res.json();

                    materiSelect.innerHTML = '<option value="">-- pilih materi --</option>';
                    data.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.id;
                        opt.textContent = m.title;
                        materiSelect.appendChild(opt);
                    });
                    materiWrapper.style.display = '';
                } catch (e) {
                    console.error(e);
                }
            });
        }

        if (materiSelect) {
            materiSelect.addEventListener('change', () => {
                formWrapper.style.display = materiSelect.value ? '' : 'none';
            });
        }
    });
</script>

{{-- ═══════════════════════════════════════════════════════════════
     INLINE CSS : Styles untuk dynamic sections
═══════════════════════════════════════════════════════════════ --}}
<style>
    /* ── Section block ──────────────────────────────────── */
    .section-block {
        background: #fafafa;
        border: 1px solid #e5e7eb;
        border-left: 4px solid #6366f1;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 12px;
        transition: opacity 0.25s ease, transform 0.25s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .section-block:hover {
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
    }

    /* ── Section header ─────────────────────────────────── */
    .section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    .section-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        color: #fff;
        font-weight: 700;
        font-size: 11px;
        flex-shrink: 0;
    }
    .section-label {
        font-weight: 600;
        font-size: 14px;
        color: #374151;
    }
    .section-number {
        font-size: 12px;
        color: #9ca3af;
        margin-left: auto;
    }

    /* ── Section actions ────────────────────────────────── */
    .section-actions {
        display: flex;
        gap: 4px;
    }
    .section-actions button {
        width: 28px;
        height: 28px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, border-color 0.15s;
    }
    .section-actions button:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }
    .btn-remove:hover {
        background: #fef2f2 !important;
        border-color: #fca5a5 !important;
        color: #dc2626;
    }

    /* ── Section inputs ─────────────────────────────────── */
    .section-body {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .section-input,
    .section-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
        box-sizing: border-box;
    }
    .section-input:focus,
    .section-textarea:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }
    .section-input-sm {
        max-width: 280px;
    }
    .section-textarea {
        resize: vertical;
        min-height: 60px;
    }
    .section-code {
        font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
        background: #1e1e2e;
        color: #a6e3a1;
        border-color: #313244;
        border-radius: 8px;
    }
    .section-code:focus {
        border-color: #89b4fa;
        box-shadow: 0 0 0 3px rgba(137,180,250,0.15);
    }
    .section-quote {
        border-left: 3px solid #ec4899;
        padding-left: 16px;
        font-style: italic;
        color: #6b7280;
    }
    .section-file {
        font-size: 14px;
        color: #4b5563;
    }
    .section-list-type {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: #6b7280;
    }
    .section-list-type label {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }
    .section-divider-preview {
        text-align: center;
        color: #9ca3af;
        font-size: 13px;
        padding: 8px 0;
        letter-spacing: 2px;
    }

    /* ── Toolbar ─────────────────────────────────────────── */
    .toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 16px;
    }
    .toolbar button {
        padding: 8px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .toolbar button:hover {
        background: #6366f1;
        color: #fff;
        border-color: #6366f1;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.25);
    }

    /* ── Error list ──────────────────────────────────────── */
    .error-list {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 12px 16px;
        margin: 12px 0;
    }
    .error-list ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .error-list li {
        color: #dc2626;
        font-size: 13px;
        padding: 2px 0;
    }

    /* ── Submit button ───────────────────────────────────── */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 16px;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,0.35);
    }
    .btn-submit:active {
        transform: translateY(0);
    }

    /* ── Empty state ─────────────────────────────────────── */
    #sections-wrapper:empty::before {
        content: '⬇️ Klik tombol di atas untuk menambah section konten';
        display: block;
        text-align: center;
        color: #9ca3af;
        font-size: 14px;
        padding: 32px 16px;
        background: #f9fafb;
        border: 2px dashed #e5e7eb;
        border-radius: 10px;
    }
</style>

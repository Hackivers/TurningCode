<div class="container-schedule">
    <main class="main-schedule">
        <div class="wrapper-schedule">

            {{-- Header --}}
            <div class="schedule-header">
                <div>
                    <h4>jadwal belajar mu</h4>
                    <h5>atur waktu belajar biar makin konsisten!</h5>
                </div>
                <button class="btn-add-schedule" id="btn-open-form">
                    <i class='bx bx-plus'></i>
                </button>
            </div>

            {{-- Jadwal Hari Ini --}}
            <div class="schedule-section">
                <div class="schedule-section-title">
                    <i class='bx bx-sun'></i>
                    <h5>hari ini</h5>
                    <span class="badge-count" id="today-count">{{ $today->count() }}</span>
                </div>
                <div class="schedule-list" id="today-list">
                    @forelse ($today as $s)
                        @include('spa.fragments.partials.schedule-card', ['s' => $s])
                    @empty
                        <div class="schedule-empty">
                            <p>Tidak ada jadwal hari ini 😴</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Jadwal Mendatang --}}
            @if ($upcoming->count())
                <div class="schedule-section">
                    <div class="schedule-section-title">
                        <i class='bx bx-calendar-event'></i>
                        <h5>mendatang</h5>
                        <span class="badge-count">{{ $upcoming->count() }}</span>
                    </div>
                    <div class="schedule-list">
                        @foreach ($upcoming as $s)
                            @include('spa.fragments.partials.schedule-card', ['s' => $s])
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Semua Jadwal --}}
            <div class="schedule-section">
                <div class="schedule-section-title">
                    <i class='bx bx-list-ul'></i>
                    <h5>semua jadwal</h5>
                    <span class="badge-count">{{ $schedules->count() }}</span>
                </div>
                <div class="schedule-list" id="all-list">
                    @forelse ($schedules as $s)
                        @include('spa.fragments.partials.schedule-card', ['s' => $s])
                    @empty
                        <div class="schedule-empty">
                            <p>Belum ada jadwal. Yok buat jadwal pertama!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>
</div>

{{-- Modal Form Tambah/Edit --}}
<div class="schedule-modal-overlay" id="schedule-modal" style="display:none;">
    <div class="schedule-modal">
        <div class="modal-header">
            <h4 id="modal-title">Buat Jadwal Baru</h4>
            <button class="btn-close-modal" id="btn-close-modal"><i class='bx bx-x'></i></button>
        </div>
        <form id="schedule-form" class="modal-body">
            <input type="hidden" id="edit-id" value="">

            <div class="form-group">
                <label>Judul</label>
                <input type="text" id="f-title" name="title" placeholder="contoh: Belajar JavaScript" required>
            </div>

            <div class="form-group">
                <label>Deskripsi (opsional)</label>
                <textarea id="f-desc" name="description" rows="2" placeholder="Catatan tambahan..."></textarea>
            </div>

            <div class="form-group">
                <label>Tipe Jadwal</label>
                <div class="type-tabs" id="type-tabs">
                    <button type="button" class="type-tab active" data-type="daily">Harian</button>
                    <button type="button" class="type-tab" data-type="weekly">Mingguan</button>
                    <button type="button" class="type-tab" data-type="monthly">Bulanan</button>
                    <button type="button" class="type-tab" data-type="custom">Custom</button>
                </div>
            </div>

            {{-- Weekly: hari --}}
            <div class="form-group type-field" id="field-weekly" style="display:none;">
                <label>Pilih Hari</label>
                <div class="day-picker">
                    @foreach (['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $i => $d)
                        <label class="day-chip">
                            <input type="checkbox" name="days_of_week[]" value="{{ $i }}">
                            <span>{{ $d }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Monthly: tanggal --}}
            <div class="form-group type-field" id="field-monthly" style="display:none;">
                <label>Tanggal</label>
                <input type="number" id="f-dom" name="day_of_month" min="1" max="31" placeholder="1-31">
            </div>

            {{-- Custom: tanggal spesifik --}}
            <div class="form-group type-field" id="field-custom" style="display:none;">
                <label>Pilih Tanggal</label>
                <input type="date" id="f-date" name="custom_date">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Jam Mulai</label>
                    <input type="time" id="f-start" name="start_time" required>
                </div>
                <div class="form-group">
                    <label>Jam Selesai</label>
                    <input type="time" id="f-end" name="end_time">
                </div>
            </div>

            <div class="form-group">
                <label>Warna</label>
                <div class="color-picker" id="color-picker">
                    <label class="color-chip active" style="--c:#6366f1"><input type="radio" name="color" value="#6366f1" checked><span></span></label>
                    <label class="color-chip" style="--c:#8b5cf6"><input type="radio" name="color" value="#8b5cf6"><span></span></label>
                    <label class="color-chip" style="--c:#ec4899"><input type="radio" name="color" value="#ec4899"><span></span></label>
                    <label class="color-chip" style="--c:#f59e0b"><input type="radio" name="color" value="#f59e0b"><span></span></label>
                    <label class="color-chip" style="--c:#10b981"><input type="radio" name="color" value="#10b981"><span></span></label>
                    <label class="color-chip" style="--c:#3b82f6"><input type="radio" name="color" value="#3b82f6"><span></span></label>
                    <label class="color-chip" style="--c:#ef4444"><input type="radio" name="color" value="#ef4444"><span></span></label>
                    <label class="color-chip" style="--c:#75bbed"><input type="radio" name="color" value="#75bbed"><span></span></label>
                </div>
            </div>

            <div id="form-msg" class="form-message" style="display:none;"></div>

            <button type="submit" class="btn-submit-schedule" id="btn-submit">
                <i class='bx bx-check'></i> Simpan Jadwal
            </button>
        </form>
    </div>
</div>

<script>
(function() {
    const csrf    = document.querySelector('meta[name="csrf-token"]')?.content;
    const modal   = document.getElementById('schedule-modal');
    const form    = document.getElementById('schedule-form');
    const editId  = document.getElementById('edit-id');
    const msgBox  = document.getElementById('form-msg');
    const btnSubmit = document.getElementById('btn-submit');

    const BASE = '{{ url("/app/schedule") }}';

    // ── Type tabs ─────────────────────────────────────────
    let currentType = 'daily';
    document.querySelectorAll('.type-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.type-tab').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentType = btn.dataset.type;

            document.querySelectorAll('.type-field').forEach(f => f.style.display = 'none');
            const field = document.getElementById('field-' + currentType);
            if (field) field.style.display = '';
        });
    });

    // ── Color picker ──────────────────────────────────────
    document.querySelectorAll('.color-chip input').forEach(inp => {
        inp.addEventListener('change', () => {
            document.querySelectorAll('.color-chip').forEach(c => c.classList.remove('active'));
            inp.closest('.color-chip').classList.add('active');
        });
    });

    // ── Open modal (add) ──────────────────────────────────
    document.getElementById('btn-open-form')?.addEventListener('click', () => {
        form.reset();
        editId.value = '';
        document.getElementById('modal-title').textContent = 'Buat Jadwal Baru';
        btnSubmit.innerHTML = '<i class="bx bx-check"></i> Simpan Jadwal';
        // Reset type to daily
        document.querySelectorAll('.type-tab').forEach(b => b.classList.remove('active'));
        document.querySelector('.type-tab[data-type="daily"]').classList.add('active');
        currentType = 'daily';
        document.querySelectorAll('.type-field').forEach(f => f.style.display = 'none');
        // Reset color
        document.querySelectorAll('.color-chip').forEach(c => c.classList.remove('active'));
        document.querySelector('.color-chip:first-child').classList.add('active');
        document.querySelector('.color-chip:first-child input').checked = true;
        msgBox.style.display = 'none';
        modal.style.display = 'flex';
    });

    // ── Close modal ───────────────────────────────────────
    document.getElementById('btn-close-modal')?.addEventListener('click', () => {
        modal.style.display = 'none';
    });
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
    });

    // ── Submit form ───────────────────────────────────────
    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        msgBox.style.display = 'none';
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';

        const body = {
            title:         document.getElementById('f-title').value,
            description:   document.getElementById('f-desc').value || null,
            schedule_type: currentType,
            start_time:    document.getElementById('f-start').value,
            end_time:      document.getElementById('f-end').value || null,
            color:         form.querySelector('input[name="color"]:checked')?.value || '#6366f1',
        };

        // Type-specific
        if (currentType === 'weekly') {
            body.days_of_week = Array.from(form.querySelectorAll('input[name="days_of_week[]"]:checked'))
                                     .map(c => parseInt(c.value));
        }
        if (currentType === 'monthly') {
            body.day_of_month = parseInt(document.getElementById('f-dom').value) || null;
        }
        if (currentType === 'custom') {
            body.custom_date = document.getElementById('f-date').value || null;
        }

        const isEdit = editId.value !== '';
        const url    = isEdit ? `${BASE}/${editId.value}` : BASE;
        const method = isEdit ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(body),
                credentials: 'same-origin',
            });

            const data = await res.json();

            if (res.ok && data.success) {
                modal.style.display = 'none';
                // Reload halaman schedule lewat SPA
                loadPage('schedule');
            } else {
                let msg = data.message || 'Gagal menyimpan';
                if (data.errors) msg = Object.values(data.errors).flat().join('\n');
                msgBox.textContent = msg;
                msgBox.className = 'form-message error';
                msgBox.style.display = 'block';
            }
        } catch {
            msgBox.textContent = 'Kesalahan jaringan';
            msgBox.className = 'form-message error';
            msgBox.style.display = 'block';
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bx bx-check"></i> Simpan Jadwal';
        }
    });

    // ── Toggle active ─────────────────────────────────────
    document.querySelectorAll('.btn-toggle-schedule').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            try {
                const res = await fetch(`${BASE}/${id}/toggle`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });
                if (res.ok) loadPage('schedule');
            } catch {}
        });
    });

    // ── Delete ─────────────────────────────────────────────
    document.querySelectorAll('.btn-delete-schedule').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('Hapus jadwal ini?')) return;
            const id = btn.dataset.id;
            try {
                const res = await fetch(`${BASE}/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin',
                });
                if (res.ok) loadPage('schedule');
            } catch {}
        });
    });

    // ── Edit (populate form) ──────────────────────────────
    document.querySelectorAll('.btn-edit-schedule').forEach(btn => {
        btn.addEventListener('click', () => {
            const d = JSON.parse(btn.dataset.schedule);
            editId.value = d.id;
            document.getElementById('modal-title').textContent = 'Edit Jadwal';
            btnSubmit.innerHTML = '<i class="bx bx-check"></i> Update Jadwal';
            document.getElementById('f-title').value = d.title;
            document.getElementById('f-desc').value  = d.description || '';
            document.getElementById('f-start').value = d.start_time?.substring(0,5) || '';
            document.getElementById('f-end').value   = d.end_time?.substring(0,5) || '';

            // Type
            currentType = d.schedule_type;
            document.querySelectorAll('.type-tab').forEach(b => b.classList.remove('active'));
            document.querySelector(`.type-tab[data-type="${currentType}"]`)?.classList.add('active');
            document.querySelectorAll('.type-field').forEach(f => f.style.display = 'none');
            const field = document.getElementById('field-' + currentType);
            if (field) field.style.display = '';

            // Days of week
            form.querySelectorAll('input[name="days_of_week[]"]').forEach(c => c.checked = false);
            (d.days_of_week || []).forEach(day => {
                const c = form.querySelector(`input[name="days_of_week[]"][value="${day}"]`);
                if (c) c.checked = true;
            });

            // Day of month
            document.getElementById('f-dom').value = d.day_of_month || '';
            // Custom date
            document.getElementById('f-date').value = d.custom_date ? d.custom_date.substring(0,10) : '';

            // Color
            document.querySelectorAll('.color-chip').forEach(c => c.classList.remove('active'));
            const colorInput = form.querySelector(`input[name="color"][value="${d.color}"]`);
            if (colorInput) {
                colorInput.checked = true;
                colorInput.closest('.color-chip').classList.add('active');
            }

            msgBox.style.display = 'none';
            modal.style.display = 'flex';
        });
    });
})();
</script>

<style>
    .container-schedule {
        display: flex;
        justify-content: center;
        margin-top: 1.5em;
        padding-bottom: 6em;
    }
    .main-schedule {
        width: 100%;
        max-width: 79em;
        margin: 0 10px;
    }
    .wrapper-schedule {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    /* Header */
    .schedule-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .schedule-header h4 {
        font-weight: 550;
        font-size: 16px;
        color: #E6E0E9;
        text-transform: capitalize;
    }
    .schedule-header h5 {
        margin-top: 6px;
        font-size: 12px;
        color: #8a898a;
    }
    .btn-add-schedule {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(99,102,241,0.35);
    }
    .btn-add-schedule:hover {
        transform: scale(1.1);
    }

    /* Section */
    .schedule-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }
    .schedule-section-title i {
        color: #75bbed;
        font-size: 16px;
    }
    .schedule-section-title h5 {
        color: #8a898a;
        font-size: 13px;
        text-transform: capitalize;
    }
    .badge-count {
        background: #222430;
        color: #75bbed;
        padding: 1px 10px;
        border-radius: 20px;
        font-size: 11px;
    }

    /* List */
    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .schedule-empty {
        text-align: center;
        padding: 20px;
        color: #555;
        font-size: 13px;
    }

    /* Card */
    .sched-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        background: #191825;
        border-radius: 16px;
        border: 1px solid #1f1e2e;
        transition: all 0.2s ease;
    }
    .sched-card:hover {
        border-color: #2a2c3a;
    }
    .sched-card.inactive {
        opacity: 0.45;
    }
    .sched-color {
        width: 4px;
        height: 40px;
        border-radius: 4px;
        flex-shrink: 0;
    }
    .sched-info {
        flex: 1;
        min-width: 0;
    }
    .sched-info h4 {
        color: #E6E0E9;
        font-weight: 500;
        font-size: 14px;
        text-transform: capitalize;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sched-info h6 {
        color: #8a898a;
        font-size: 11px;
        margin-top: 3px;
    }
    .sched-time {
        text-align: right;
        flex-shrink: 0;
    }
    .sched-time h5 {
        color: #E6E0E9;
        font-size: 13px;
        font-weight: 500;
    }
    .sched-time h6 {
        color: #555;
        font-size: 10px;
        margin-top: 2px;
    }
    .sched-actions {
        display: flex;
        gap: 4px;
        flex-shrink: 0;
    }
    .sched-actions button {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: 1px solid #2a2c3a;
        background: transparent;
        color: #8a898a;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: all 0.15s;
    }
    .sched-actions button:hover {
        background: #222430;
        color: #E6E0E9;
    }
    .sched-actions .btn-delete-schedule:hover {
        color: #f87171;
        border-color: #991b1b;
    }

    /* ── Modal ─────────────────────────────── */
    .schedule-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 100;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: flex-end;
        justify-content: center;
    }
    .schedule-modal {
        background: #191825;
        border-radius: 24px 24px 0 0;
        width: 100%;
        max-width: 500px;
        max-height: 85vh;
        overflow-y: auto;
        border: 1px solid #1f1e2e;
        border-bottom: none;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 20px 0;
    }
    .modal-header h4 {
        color: #E6E0E9;
        font-weight: 600;
        font-size: 16px;
    }
    .btn-close-modal {
        background: none;
        border: none;
        color: #8a898a;
        font-size: 22px;
        cursor: pointer;
    }
    .modal-body {
        padding: 16px 20px 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .modal-body .form-group label {
        color: #8a898a;
        font-size: 12px;
        margin-bottom: 6px;
        display: block;
        text-transform: capitalize;
    }
    .modal-body input[type="text"],
    .modal-body input[type="number"],
    .modal-body input[type="date"],
    .modal-body input[type="time"],
    .modal-body textarea {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #2a2c3a;
        background: #13121c;
        color: #E6E0E9;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }
    .modal-body input:focus,
    .modal-body textarea:focus {
        border-color: #6366f1;
    }
    .modal-body textarea {
        resize: vertical;
        min-height: 50px;
    }
    .form-row {
        display: flex;
        gap: 10px;
    }
    .form-row .form-group {
        flex: 1;
    }

    /* Type tabs */
    .type-tabs {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .type-tab {
        padding: 7px 16px;
        border-radius: 20px;
        border: 1px solid #2a2c3a;
        background: transparent;
        color: #8a898a;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .type-tab.active {
        background: #6366f1;
        border-color: #6366f1;
        color: #fff;
    }

    /* Day picker */
    .day-picker {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .day-chip {
        cursor: pointer;
    }
    .day-chip input { display: none; }
    .day-chip span {
        display: block;
        padding: 6px 12px;
        border-radius: 10px;
        border: 1px solid #2a2c3a;
        color: #8a898a;
        font-size: 13px;
        transition: all 0.15s;
    }
    .day-chip input:checked + span {
        background: #6366f1;
        border-color: #6366f1;
        color: #fff;
    }

    /* Color picker */
    .color-picker {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .color-chip {
        cursor: pointer;
    }
    .color-chip input { display: none; }
    .color-chip span {
        display: block;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--c);
        border: 2px solid transparent;
        transition: all 0.15s;
    }
    .color-chip.active span {
        border-color: #fff;
        box-shadow: 0 0 0 3px var(--c);
    }

    /* Submit */
    .btn-submit-schedule {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border-radius: 14px;
        border: none;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-submit-schedule:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99,102,241,0.35);
    }
    .btn-submit-schedule:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* Message */
    .form-message {
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        white-space: pre-line;
    }
    .form-message.error {
        background: #2d1215;
        border: 1px solid #991b1b;
        color: #f87171;
    }
</style>

<div class="title-example">
    <div>
        <h4>Jadwal mu hari ini apa?</h4>
        <h5>kapan kamu terakhir berlajar</h5>
    </div>
</div>
<div class="container-schedule">
    <main class="main-schedule">
        <div class="wrapper-schedule">
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

    {{-- Tombol Tambah Jadwal (FAB) --}}
    <button class="btn-add-schedule" id="btn-open-form" title="Tambah Jadwal">
        <i class='bx bx-plus'></i>
    </button>
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
                    @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $i => $d)
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
                    <label class="color-chip active" style="--c:#6366f1"><input type="radio" name="color"
                            value="#6366f1" checked><span></span></label>
                    <label class="color-chip" style="--c:#8b5cf6"><input type="radio" name="color"
                            value="#8b5cf6"><span></span></label>
                    <label class="color-chip" style="--c:#ec4899"><input type="radio" name="color"
                            value="#ec4899"><span></span></label>
                    <label class="color-chip" style="--c:#f59e0b"><input type="radio" name="color"
                            value="#f59e0b"><span></span></label>
                    <label class="color-chip" style="--c:#10b981"><input type="radio" name="color"
                            value="#10b981"><span></span></label>
                    <label class="color-chip" style="--c:#3b82f6"><input type="radio" name="color"
                            value="#3b82f6"><span></span></label>
                    <label class="color-chip" style="--c:#ef4444"><input type="radio" name="color"
                            value="#ef4444"><span></span></label>
                    <label class="color-chip" style="--c:#75bbed"><input type="radio" name="color"
                            value="#75bbed"><span></span></label>
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
    (function () {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        const modal = document.getElementById('schedule-modal');
        const form = document.getElementById('schedule-form');
        const editId = document.getElementById('edit-id');
        const msgBox = document.getElementById('form-msg');
        const btnSubmit = document.getElementById('btn-submit');

        const BASE = '{{ url('/app/schedule') }}';

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
                title: document.getElementById('f-title').value,
                description: document.getElementById('f-desc').value || null,
                schedule_type: currentType,
                start_time: document.getElementById('f-start').value,
                end_time: document.getElementById('f-end').value || null,
                color: form.querySelector('input[name="color"]:checked')?.value || '#6366f1',
            };

            // Type-specific
            if (currentType === 'weekly') {
                body.days_of_week = Array.from(form.querySelectorAll(
                    'input[name="days_of_week[]"]:checked'))
                    .map(c => parseInt(c.value));
            }
            if (currentType === 'monthly') {
                body.day_of_month = parseInt(document.getElementById('f-dom').value) || null;
            }
            if (currentType === 'custom') {
                body.custom_date = document.getElementById('f-date').value || null;
            }

            const isEdit = editId.value !== '';
            const url = isEdit ? `${BASE}/${editId.value}` : BASE;
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

                    // Kirim notifikasi konfirmasi
                    const timeLabel = body.start_time + (body.end_time ? ' - ' + body.end_time : '');
                    if (typeof window.__addNotification === 'function') {
                        window.__addNotification(
                            isEdit ? '✏️ Jadwal Diperbarui' : '📅 Jadwal Baru Dibuat',
                            `${body.title} — ${timeLabel}`,
                            body.color || '#6366f1',
                            'system'
                        );
                    }

                    // Re-fetch jadwal untuk notifier
                    if (typeof window.__refetchSchedules === 'function') {
                        window.__refetchSchedules();
                    }

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
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                    });
                    if (res.ok) {
                        if (typeof window.__refetchSchedules === 'function') {
                            window.__refetchSchedules();
                        }
                        loadPage('schedule');
                    }
                } catch { }
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
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin',
                    });
                    if (res.ok) {
                        if (typeof window.__addNotification === 'function') {
                            window.__addNotification(
                                '🗑️ Jadwal Dihapus',
                                'Jadwal berhasil dihapus dari daftar',
                                '#ef4444',
                                'system'
                            );
                        }
                        if (typeof window.__refetchSchedules === 'function') {
                            window.__refetchSchedules();
                        }
                        loadPage('schedule');
                    }
                } catch { }
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
                document.getElementById('f-desc').value = d.description || '';
                document.getElementById('f-start').value = d.start_time?.substring(0, 5) || '';
                document.getElementById('f-end').value = d.end_time?.substring(0, 5) || '';

                // Type
                currentType = d.schedule_type;
                document.querySelectorAll('.type-tab').forEach(b => b.classList.remove('active'));
                document.querySelector(`.type-tab[data-type="${currentType}"]`)?.classList.add(
                    'active');
                document.querySelectorAll('.type-field').forEach(f => f.style.display = 'none');
                const field = document.getElementById('field-' + currentType);
                if (field) field.style.display = '';

                // Days of week
                form.querySelectorAll('input[name="days_of_week[]"]').forEach(c => c.checked =
                    false);
                (d.days_of_week || []).forEach(day => {
                    const c = form.querySelector(
                        `input[name="days_of_week[]"][value="${day}"]`);
                    if (c) c.checked = true;
                });

                // Day of month
                document.getElementById('f-dom').value = d.day_of_month || '';
                // Custom date
                document.getElementById('f-date').value = d.custom_date ? d.custom_date.substring(0,
                    10) : '';

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

    // ── Search Handler ────────────────────────────────────────────
    window.__currentSearchHandler = function(query) {
        document.querySelectorAll('.fav-sched-card').forEach(card => {
            const title = card.querySelector('.fsc-title')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.fsc-body')?.textContent.toLowerCase() || '';
            const type = card.querySelector('.fsc-badge')?.textContent.toLowerCase() || '';
            const label = card.querySelector('.fsc-detail-row')?.textContent.toLowerCase() || '';
            if (title.includes(query) || desc.includes(query) || type.includes(query) || label.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        if (query !== '') {
            const firstVisible = Array.from(document.querySelectorAll('.fav-sched-card')).find(c => c.style.display !== 'none');
            if (firstVisible) {
                // Gunakan timeout kecil agar DOM layout update sebelum scroll
                setTimeout(() => {
                    firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 50);
            }
        }
    };
</script>

<style>
/* ═══ NEO BENTO LIGHT — SCHEDULE PAGE ═══ */
.title-example { display: none !important; }

.container-schedule {
    display: flex;
    justify-content: center;
    padding: 0 24px;
    margin-bottom: 50px;
    background: transparent;
}
.main-schedule {
    width: 100%;
    max-width: 79em;
}
.wrapper-schedule {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    margin-top: 1rem;
}
.schedule-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1.25rem;
    font-family: 'Inter', sans-serif;
}
.schedule-section-title i {
    font-size: 20px;
    color: #121212;
    background: #fff;
    padding: 10px;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.05);
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}
.schedule-section-title h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #121212;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.badge-count {
    background: #fff;
    color: #121212;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid rgba(0,0,0,0.05);
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}

.schedule-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 16px;
}

.fav-sched-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,0.04);
    border-radius: 24px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.03);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
    transition: all 0.25s ease;
    font-family: 'Inter', sans-serif;
}
.fav-sched-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.06);
    border-color: rgba(0,0,0,0.08);
}
.fav-sched-card.inactive {
    opacity: 0.6;
    filter: grayscale(0.8);
}

.fsc-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.fsc-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.fsc-badge {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 6px 12px;
    border-radius: 20px;
    border: 1px solid;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 6px;
}
.fsc-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.fsc-main { }
.fsc-title {
    font-size: 17px;
    font-weight: 800;
    color: #121212;
    margin: 0;
    line-height: 1.3;
    letter-spacing: -0.3px;
}
.fsc-desc {
    font-size: 13px;
    color: #666;
    margin: 6px 0 0;
    line-height: 1.4;
}

.fsc-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid rgba(0,0,0,0.04);
}
.fsc-detail-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #888;
    font-weight: 600;
}
.fsc-detail-pill i { font-size: 14px; color: #666; }

.fsc-time {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 800;
}
.fsc-time i { font-size: 15px; }

.fsc-actions {
    display: flex;
    gap: 6px;
}
.fsc-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 10px;
    border: 1px solid rgba(0,0,0,0.05);
    background: #fdfdfd;
    color: #888;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 15px;
}
.fsc-btn:hover {
    background: #121212;
    color: #fff;
    border-color: #121212;
}
.fsc-btn.btn-delete:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border-color: transparent;
}

.schedule-empty {
    grid-column: 1 / -1;
    padding: 40px;
    text-align: center;
    background: #fff;
    border-radius: 24px;
    border: 1px dashed rgba(0,0,0,0.1);
    color: #888;
    font-size: 14px;
    font-weight: 600;
}

/* ─── FAB Button ─── */
.btn-add-schedule {
    background: #121212 !important;
    color: #fff !important;
    border: none !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15) !important;
}
.btn-add-schedule:hover {
    transform: scale(1.1) !important;
    background: #000 !important;
}

/* ─── Modal Light Neo-Bento ─── */
.schedule-modal-overlay {
    background: rgba(0,0,0,0.4) !important;
    backdrop-filter: blur(4px) !important;
}
.schedule-modal {
    background: #fff !important;
    border-radius: 28px !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    box-shadow: 0 30px 60px rgba(0,0,0,0.1) !important;
}
.schedule-modal .modal-header {
    border-bottom: 1px solid rgba(0,0,0,0.05) !important;
}
.schedule-modal .modal-header h4 {
    color: #121212 !important;
    font-weight: 800 !important;
}
.schedule-modal .btn-close-modal {
    background: rgba(0,0,0,0.03) !important;
    color: #666 !important;
    border: none !important;
}
.schedule-modal .btn-close-modal:hover {
    background: #121212 !important;
    color: #fff !important;
}
.schedule-modal label {
    color: #666 !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    font-size: 11px !important;
}
.schedule-modal input[type="text"],
.schedule-modal input[type="number"],
.schedule-modal input[type="date"],
.schedule-modal input[type="time"],
.schedule-modal textarea {
    background: #f9f9f9 !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    color: #121212 !important;
    border-radius: 14px !important;
}
.schedule-modal input:focus, .schedule-modal textarea:focus {
    background: #fff !important;
    border-color: #121212 !important;
    box-shadow: 0 0 0 3px rgba(0,0,0,0.05) !important;
}
.schedule-modal .type-tab {
    background: #f9f9f9 !important;
    color: #888 !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    font-weight: 600 !important;
}
.schedule-modal .type-tab.active {
    background: #121212 !important;
    color: #fff !important;
    border-color: #121212 !important;
}
.schedule-modal .day-chip span {
    background: #f9f9f9 !important;
    color: #666 !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    font-weight: 600 !important;
}
.schedule-modal .day-chip input:checked + span {
    background: #121212 !important;
    color: #fff !important;
    border-color: #121212 !important;
}
.schedule-modal .color-chip span {
    border: 2px solid transparent !important;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
}
.schedule-modal .color-chip.active span {
    border-color: #121212 !important;
    transform: scale(1.1);
}
.schedule-modal .btn-submit-schedule {
    background: #121212 !important;
    color: #fff !important;
    border-radius: 14px !important;
    font-weight: 700 !important;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    border: none !important;
}
.schedule-modal .btn-submit-schedule:hover {
    transform: translateY(-2px) !important;
    opacity: 0.9 !important;
}

@media (max-width: 768px) {
    .schedule-list {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="neo-dashboard rtd-dashboard">
<div class="neo-bento-container">

<a href="?page=dashboard" class="link-spa" data-page="dashboard" style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#888;text-decoration:none;margin-bottom:24px;transition:color 0.2s;" onmouseover="this.style.color='#121212'" onmouseout="this.style.color='#888'">
    <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
</a>

<div style="margin-bottom:32px;">
    <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Jadwal Belajar</h3>
    <p style="font-size:16px;color:#555;margin:0;">Kelola jadwal belajar harian, mingguan, dan kustom.</p>
</div>

{{-- Hari Ini --}}
<div style="margin-bottom:32px;">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
        <div style="width:40px;height:40px;border-radius:12px;background:rgba(0,0,0,0.04);display:flex;align-items:center;justify-content:center;"><i class='bx bx-sun' style="font-size:20px;color:#121212;"></i></div>
        <h4 style="margin:0;font-size:16px;font-weight:700;color:#121212;text-transform:uppercase;letter-spacing:1px;">Hari Ini</h4>
        <span class="neo-pill" style="padding:2px 12px;font-size:12px;" id="today-count">{{ $today->count() }}</span>
    </div>
    <div class="schedule-list" id="today-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px;">
        @forelse ($today as $s)
            @include('spa.fragments.partials.schedule-card', ['s' => $s])
        @empty
            <div class="neo-card neo-card-light" style="grid-column:1/-1;text-align:center;padding:40px;"><p style="color:#888;font-size:14px;font-weight:600;margin:0;">Tidak ada jadwal hari ini 😴</p></div>
        @endforelse
    </div>
</div>

{{-- Mendatang --}}
@if ($upcoming->count())
<div style="margin-bottom:32px;">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
        <div style="width:40px;height:40px;border-radius:12px;background:rgba(0,0,0,0.04);display:flex;align-items:center;justify-content:center;"><i class='bx bx-calendar-event' style="font-size:20px;color:#121212;"></i></div>
        <h4 style="margin:0;font-size:16px;font-weight:700;color:#121212;text-transform:uppercase;letter-spacing:1px;">Mendatang</h4>
        <span class="neo-pill" style="padding:2px 12px;font-size:12px;">{{ $upcoming->count() }}</span>
    </div>
    <div class="schedule-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px;">
        @foreach ($upcoming as $s)
            @include('spa.fragments.partials.schedule-card', ['s' => $s])
        @endforeach
    </div>
</div>
@endif

{{-- Semua --}}
<div style="margin-bottom:32px;">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
        <div style="width:40px;height:40px;border-radius:12px;background:rgba(0,0,0,0.04);display:flex;align-items:center;justify-content:center;"><i class='bx bx-list-ul' style="font-size:20px;color:#121212;"></i></div>
        <h4 style="margin:0;font-size:16px;font-weight:700;color:#121212;text-transform:uppercase;letter-spacing:1px;">Semua Jadwal</h4>
        <span class="neo-pill" style="padding:2px 12px;font-size:12px;">{{ $schedules->count() }}</span>
    </div>
    <div class="schedule-list" id="all-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:16px;">
        @forelse ($schedules as $s)
            @include('spa.fragments.partials.schedule-card', ['s' => $s])
        @empty
            <div class="neo-card neo-card-light" style="grid-column:1/-1;text-align:center;padding:40px;"><p style="color:#888;font-size:14px;font-weight:600;margin:0;">Belum ada jadwal. Yok buat jadwal pertama!</p></div>
        @endforelse
    </div>
</div>

{{-- FAB --}}
<button class="btn-add-schedule" id="btn-open-form" title="Tambah Jadwal" style="position:fixed;bottom:90px;right:24px;z-index:100;width:56px;height:56px;border-radius:50%;background:#121212;color:#fff;border:none;font-size:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 8px 24px rgba(0,0,0,0.2);transition:all 0.2s;">
    <i class='bx bx-plus'></i>
</button>

</div>
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
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --neo-bg: #ececec;
    --neo-card-light: #e5e5e5;
    --neo-radius: 32px;
    --neo-text-dark: #121212;
}

body { background-color: var(--neo-bg) !important; }

.neo-dashboard {
    background-color: var(--neo-bg);
    color: var(--neo-text-dark);
    font-family: 'Inter', sans-serif;
    padding: 32px 0;
    min-height: 100vh;
    width: 100%;
}
.neo-bento-container { max-width: 1400px; margin: 0 auto; width: 100%; }
.neo-title { font-size: 24px; font-weight: 600; margin: 0; line-height: 1.25; letter-spacing: -0.03em; }
.neo-pill {
    background: transparent;
    color: var(--neo-text-dark);
    border: 1px solid rgba(0,0,0,0.3);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
}
.neo-card {
    border-radius: var(--neo-radius);
    padding: 32px;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
}
.neo-card-light { background: var(--neo-card-light); color: var(--neo-text-dark); }

/* ═══ SCHEDULE CARDS ═══ */
.title-example { display: none !important; }

.fav-sched-card {
    background: var(--neo-card-light);
    border: 1px solid rgba(0,0,0,0.04);
    border-radius: 28px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    font-family: 'Inter', sans-serif;
}
.fav-sched-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.06);
}
.fav-sched-card.inactive {
    opacity: 0.5;
    filter: grayscale(0.8);
}

.fsc-content {
    padding: 24px;
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
    border-top: 1px solid rgba(0,0,0,0.06);
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
.fsc-actions { display: flex; gap: 6px; }
.fsc-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 10px;
    border: 1px solid rgba(0,0,0,0.08);
    background: rgba(255,255,255,0.5);
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
    background: rgba(239,68,68,0.1);
    color: #ef4444;
    border-color: transparent;
}

/* ═══ MODAL ═══ */
.schedule-modal-overlay {
    background: rgba(0,0,0,0.4) !important;
    backdrop-filter: blur(6px) !important;
}
.schedule-modal {
    background: #f5f5f5 !important;
    border-radius: 28px !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    box-shadow: 0 30px 60px rgba(0,0,0,0.12) !important;
}
.schedule-modal .modal-header {
    border-bottom: 1px solid rgba(0,0,0,0.06) !important;
}
.schedule-modal .modal-header h4 {
    color: #121212 !important;
    font-weight: 800 !important;
}
.schedule-modal .btn-close-modal {
    background: rgba(0,0,0,0.04) !important;
    color: #666 !important;
    border: none !important;
    border-radius: 50% !important;
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
    background: #fff !important;
    border: 1px solid rgba(0,0,0,0.06) !important;
    color: #121212 !important;
    border-radius: 14px !important;
}
.schedule-modal input:focus,
.schedule-modal textarea:focus {
    border-color: #121212 !important;
    box-shadow: 0 0 0 3px rgba(0,0,0,0.05) !important;
}
.schedule-modal .type-tab {
    background: #fff !important;
    color: #888 !important;
    border: 1px solid rgba(0,0,0,0.06) !important;
    font-weight: 600 !important;
    border-radius: 12px !important;
}
.schedule-modal .type-tab.active {
    background: #121212 !important;
    color: #fff !important;
    border-color: #121212 !important;
}
.schedule-modal .day-chip span {
    background: #fff !important;
    color: #666 !important;
    border: 1px solid rgba(0,0,0,0.06) !important;
    font-weight: 600 !important;
}
.schedule-modal .day-chip input:checked + span {
    background: #121212 !important;
    color: #fff !important;
    border-color: #121212 !important;
}
.schedule-modal .color-chip span {
    border: 2px solid transparent !important;
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.08);
}
.schedule-modal .color-chip.active span {
    border-color: #121212 !important;
    transform: scale(1.15);
}
.schedule-modal .btn-submit-schedule {
    background: #121212 !important;
    color: #fff !important;
    border-radius: 16px !important;
    font-weight: 700 !important;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    border: none !important;
}
.schedule-modal .btn-submit-schedule:hover {
    transform: translateY(-2px) !important;
    opacity: 0.9 !important;
}

@media (max-width: 768px) {
    .neo-dashboard { padding: 24px 16px; }
    .schedule-list { grid-template-columns: 1fr !important; }
}
</style>

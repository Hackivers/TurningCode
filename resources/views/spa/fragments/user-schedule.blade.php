<div class="neo-dashboard rtd-dashboard">
<div class="neo-bento-container">

        <a href="?page=dashboard" class="link-spa" data-page="dashboard"
            style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:700;color:#888;text-decoration:none;margin-bottom:32px;transition:color 0.2s; background: rgba(0,0,0,0.03); padding: 8px 16px; border-radius: 20px;"
            onmouseover="this.style.color='#121212'; this.style.background='rgba(0,0,0,0.05)';" 
            onmouseout="this.style.color='#888'; this.style.background='rgba(0,0,0,0.03)';">
            <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
        </a>

        {{-- Header --}}
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: #121212;">Jadwal Belajar</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Kelola jadwal belajar harian, mingguan, dan kustom.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #121212, #2a2a2a); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                <i class='bx bx-calendar-star' style="font-size: 28px; color: #f59e0b;"></i>
            </div>
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
<button class="btn-add-schedule" id="btn-open-form" title="Tambah Jadwal" style="position:fixed;bottom:90px;right:24px;z-index:100;width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg, #121212, #2a2a2a);color:#fff;border:none;font-size:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 8px 24px rgba(0,0,0,0.2);transition:all 0.2s; border: 1px solid rgba(255,255,255,0.1);">
    <i class='bx bx-plus'></i>
</button>

</div>
</div>

{{-- Modal Form Tambah/Edit --}}
<div class="schedule-modal-overlay" id="schedule-modal" style="display:none;">
    <div class="schedule-modal">
        <div class="modal-header">
            <div class="mh-left">
                <div class="mh-icon-wrap">
                    <i class='bx bx-calendar-star'></i>
                </div>
                <div class="mh-text">
                    <h4 id="modal-title">Buat Jadwal</h4>
                    <p>Atur waktu belajarmu</p>
                </div>
            </div>
            <button type="button" class="btn-close-modal" id="btn-close-modal"><i class='bx bx-x'></i></button>
        </div>
        <form id="schedule-form" class="modal-body">
            <input type="hidden" id="edit-id" value="">

            <div class="form-section">
                <div class="form-group">
                    <label><i class='bx bx-bookmark'></i> Judul Jadwal</label>
                    <input type="text" id="f-title" name="title" placeholder="contoh: Belajar JavaScript" required>
                </div>

                <div class="form-group">
                    <label><i class='bx bx-align-left'></i> Deskripsi <span class="opt-label">(opsional)</span></label>
                    <textarea id="f-desc" name="description" rows="2" placeholder="Tuliskan catatan tambahan..."></textarea>
                </div>
            </div>

            <div class="form-section">
                <div class="form-group">
                    <label><i class='bx bx-repeat'></i> Tipe Pengulangan</label>
                    <div class="type-tabs" id="type-tabs">
                        <button type="button" class="type-tab active" data-type="daily">Harian</button>
                        <button type="button" class="type-tab" data-type="weekly">Mingguan</button>
                        <button type="button" class="type-tab" data-type="monthly">Bulanan</button>
                        <button type="button" class="type-tab" data-type="custom">Custom</button>
                    </div>
                </div>

                {{-- Weekly: hari --}}
                <div class="form-group type-field" id="field-weekly" style="display:none;">
                    <label><i class='bx bx-calendar-week'></i> Pilih Hari</label>
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
                    <label><i class='bx bx-calendar'></i> Tanggal Bulanan</label>
                    <div class="input-with-icon">
                        <input type="number" id="f-dom" name="day_of_month" min="1" max="31" placeholder="Pilih tanggal 1-31">
                    </div>
                </div>

                {{-- Custom: tanggal spesifik --}}
                <div class="form-group type-field" id="field-custom" style="display:none;">
                    <label><i class='bx bx-calendar-event'></i> Tanggal Spesifik</label>
                    <input type="date" id="f-date" name="custom_date">
                </div>
            </div>

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group">
                        <label><i class='bx bx-time-five'></i> Jam Mulai</label>
                        <input type="time" id="f-start" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label><i class='bx bx-time'></i> Jam Selesai</label>
                        <input type="time" id="f-end" name="end_time">
                    </div>
                </div>
            </div>

            <div class="form-section" style="border-bottom:none; padding-bottom:0;">
                <div class="form-group">
                    <label><i class='bx bx-palette'></i> Label Warna</label>
                    <div class="color-picker" id="color-picker">
                        <label class="color-chip active" style="--c:#6366f1"><input type="radio" name="color" value="#6366f1" checked><span class="c-box"><i class='bx bx-check'></i></span></label>
                        <label class="color-chip" style="--c:#8b5cf6"><input type="radio" name="color" value="#8b5cf6"><span class="c-box"><i class='bx bx-check'></i></span></label>
                        <label class="color-chip" style="--c:#ec4899"><input type="radio" name="color" value="#ec4899"><span class="c-box"><i class='bx bx-check'></i></span></label>
                        <label class="color-chip" style="--c:#f59e0b"><input type="radio" name="color" value="#f59e0b"><span class="c-box"><i class='bx bx-check'></i></span></label>
                        <label class="color-chip" style="--c:#10b981"><input type="radio" name="color" value="#10b981"><span class="c-box"><i class='bx bx-check'></i></span></label>
                        <label class="color-chip" style="--c:#3b82f6"><input type="radio" name="color" value="#3b82f6"><span class="c-box"><i class='bx bx-check'></i></span></label>
                        <label class="color-chip" style="--c:#ef4444"><input type="radio" name="color" value="#ef4444"><span class="c-box"><i class='bx bx-check'></i></span></label>
                        <label class="color-chip" style="--c:#121212"><input type="radio" name="color" value="#121212"><span class="c-box"><i class='bx bx-check'></i></span></label>
                    </div>
                </div>
            </div>

            <div id="form-msg" class="form-message" style="display:none;"></div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit-schedule" id="btn-submit">
                    <i class='bx bx-check-circle'></i> Simpan Jadwal
                </button>
            </div>
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

/* Removed hardcoded neo variables and body background to support Dark Mode */
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
    background: var(--neo-bg, rgba(255,255,255,0.5));
    color: #888;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 15px;
}
.fsc-btn:hover {
    background: var(--neo-text-dark, #121212);
    color: var(--neo-bg, #fff);
    border-color: var(--neo-text-dark, #121212);
}
.fsc-btn.btn-delete:hover {
    background: rgba(239,68,68,0.1);
    color: #ef4444;
    border-color: transparent;
}

/* ═══ PREMIUM MODAL ═══ */
.schedule-modal-overlay {
    background: rgba(18, 18, 18, 0.45) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    z-index: 9999;
}
.schedule-modal {
    background: var(--neo-card-light, #ffffff) !important;
    border-radius: 32px !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    box-shadow: 0 40px 100px rgba(0,0,0,0.1), 0 10px 40px rgba(0,0,0,0.06) !important;
    width: 100%;
    max-width: 480px !important;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    animation: modalPop 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes modalPop {
    0% { transform: scale(0.95) translateY(20px); opacity: 0; }
    100% { transform: scale(1) translateY(0); opacity: 1; }
}
.schedule-modal .modal-header {
    padding: 28px 32px 24px;
    border-bottom: 1px solid rgba(0,0,0,0.04) !important;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
}
.schedule-modal .mh-left {
    display: flex;
    gap: 16px;
    align-items: center;
}
.schedule-modal .mh-icon-wrap {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #121212 0%, #2a2a2a 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 24px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.schedule-modal .mh-text h4 {
    color: var(--neo-text-dark, #121212) !important;
    font-weight: 800 !important;
    font-size: 22px;
    margin: 0 0 4px 0;
    letter-spacing: -0.5px;
}
.schedule-modal .mh-text p {
    color: #64748b;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
}
.schedule-modal .btn-close-modal {
    background: var(--neo-bg, #f1f5f9) !important;
    color: var(--neo-text-dark, #64748b) !important;
    border: 1px solid rgba(0,0,0,0.05) !important;
    border-radius: 50% !important;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.schedule-modal .btn-close-modal:hover {
    background: #ef4444 !important;
    color: #fff !important;
    transform: rotate(90deg) scale(1.1);
}
.schedule-modal .modal-body {
    padding: 0 32px 32px;
    overflow-y: auto;
    flex: 1;
}
.schedule-modal .modal-body::-webkit-scrollbar {
    width: 6px;
}
.schedule-modal .modal-body::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.1);
    border-radius: 10px;
}
.schedule-modal .form-section {
    padding: 24px 0;
    border-bottom: 1px dashed rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.schedule-modal .form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.schedule-modal label {
    color: var(--neo-text-dark, #334155) !important;
    font-weight: 700 !important;
    font-size: 13px !important;
    display: flex;
    align-items: center;
    gap: 6px;
    text-transform: none !important;
    letter-spacing: 0 !important;
}
.schedule-modal label i {
    color: #94a3b8;
    font-size: 16px;
}
.schedule-modal .opt-label {
    color: #94a3b8;
    font-weight: 500;
    font-size: 11px;
}
.schedule-modal input[type="text"],
.schedule-modal input[type="number"],
.schedule-modal input[type="date"],
.schedule-modal input[type="time"],
.schedule-modal textarea {
    background: var(--neo-bg, #f8fafc) !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
    color: var(--neo-text-dark, #0f172a) !important;
    border-radius: 16px !important;
    padding: 14px 16px !important;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%;
    box-sizing: border-box;
}
.schedule-modal input:focus,
.schedule-modal textarea:focus {
    background: #fff !important;
    border-color: #121212 !important;
    box-shadow: 0 0 0 4px rgba(18, 18, 18, 0.05) !important;
    outline: none;
}
.schedule-modal textarea {
    resize: none;
}
.schedule-modal .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.schedule-modal .type-tabs {
    display: flex;
    gap: 8px;
    background: var(--neo-bg, #f1f5f9);
    padding: 6px;
    border-radius: 16px;
}
.schedule-modal .type-tab {
    background: transparent !important;
    color: var(--neo-text-dark, #64748b) !important;
    border: none !important;
    font-weight: 700 !important;
    border-radius: 12px !important;
    padding: 10px 8px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    flex: 1;
    text-align: center;
}
.schedule-modal .type-tab:hover {
    color: #121212 !important;
}
.schedule-modal .type-tab.active {
    background: var(--neo-card-light, #fff) !important;
    color: var(--neo-text-dark, #121212) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.05) !important;
}
.schedule-modal .day-picker {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.schedule-modal .day-chip input {
    display: none;
}
.schedule-modal .day-chip span {
    background: var(--neo-bg, #f8fafc) !important;
    color: var(--neo-text-dark, #64748b) !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
    font-weight: 700 !important;
    border-radius: 14px !important;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    font-size: 13px;
}
.schedule-modal .day-chip span:hover {
    border-color: #cbd5e1 !important;
    background: #f1f5f9 !important;
}
.schedule-modal .day-chip input:checked + span {
    background: #121212 !important;
    color: #fff !important;
    border-color: #121212 !important;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important;
    transform: translateY(-2px);
}
.schedule-modal .color-picker {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    padding: 4px 0;
}
.schedule-modal .color-chip input {
    display: none;
}
.schedule-modal .color-chip .c-box {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--c);
    color: #fff;
    box-shadow: inset 0 2px 4px rgba(255,255,255,0.2), inset 0 -2px 4px rgba(0,0,0,0.1);
}
.schedule-modal .color-chip .c-box i {
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    font-size: 20px;
}
.schedule-modal .color-chip.active .c-box {
    transform: scale(1.15) translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15), inset 0 2px 4px rgba(255,255,255,0.3);
}
.schedule-modal .color-chip.active .c-box i {
    opacity: 1;
    transform: scale(1);
}
.schedule-modal .modal-footer {
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid rgba(0,0,0,0.06);
}
.schedule-modal .btn-submit-schedule {
    background: linear-gradient(135deg, #121212, #2a2a2a) !important;
    color: #fff !important;
    border-radius: 20px !important;
    font-weight: 800 !important;
    box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
    width: 100%;
    padding: 18px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.schedule-modal .btn-submit-schedule i {
    font-size: 22px;
}
.schedule-modal .btn-submit-schedule:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
    background: linear-gradient(135deg, #2a2a2a, #3a3a3a) !important;
}

@media (max-width: 768px) {
    .neo-dashboard { 
        padding: 16px 0; 
        overflow-x: hidden; 
    }
    
    .neo-bento-container,
    .neo-bento-container * {
        box-sizing: border-box;
    }

    .neo-bento-container {
        padding: 0 16px;
        max-width: 100vw;
    }

    .schedule-list { 
        grid-template-columns: 1fr !important; 
        gap: 12px !important;
    }

    .neo-title { font-size: 20px !important; }
    
    .neo-card {
        padding: 20px !important;
        border-radius: 20px !important;
    }

    /* Modal Compression */
    .schedule-modal {
        border-radius: 24px !important;
        max-width: calc(100vw - 32px) !important;
    }
    .schedule-modal .modal-header {
        padding: 20px 24px 16px;
    }
    .schedule-modal .mh-text h4 {
        font-size: 18px;
    }
    .schedule-modal .modal-body {
        padding: 0 24px 24px;
    }
    .schedule-modal .form-section {
        padding: 16px 0;
        gap: 16px;
    }
    .schedule-modal .form-row {
        grid-template-columns: 1fr;
    }
    .schedule-modal .type-tab {
        font-size: 11px;
        padding: 8px 4px;
    }
    .schedule-modal .day-chip span {
        width: 38px;
        height: 38px;
        font-size: 11px;
    }
    .schedule-modal .color-chip .c-box {
        width: 32px;
        height: 32px;
    }
    .schedule-modal .btn-submit-schedule {
        padding: 14px;
        font-size: 14px;
        border-radius: 16px !important;
    }
    .schedule-modal .modal-footer {
        margin-top: 24px;
        padding-top: 16px;
    }
}
</style>

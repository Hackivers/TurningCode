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
        document.querySelectorAll('.modern-sched-card').forEach(card => {
            const title = card.querySelector('.msc-header h4')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.msc-body')?.textContent.toLowerCase() || '';
            const type = card.querySelector('.msc-badge')?.textContent.toLowerCase() || '';
            const label = card.querySelector('.msc-detail')?.textContent.toLowerCase() || '';
            if (title.includes(query) || desc.includes(query) || type.includes(query) || label.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        if (query !== '') {
            const firstVisible = Array.from(document.querySelectorAll('.modern-sched-card')).find(c => c.style.display !== 'none');
            if (firstVisible) {
                // Gunakan timeout kecil agar DOM layout update sebelum scroll
                setTimeout(() => {
                    firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 50);
            }
        }
    };
</script>

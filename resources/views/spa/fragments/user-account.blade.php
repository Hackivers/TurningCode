<div class="container-account">
    <main class="main-account">
        <div class="wrapper-account">

            {{-- Profile Header --}}
            <div class="account-header">
                <div class="account-avatar">
                    <div class="avatar-circle">
                        <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="account-info">
                    <h3 id="display-name">{{ $user->name }}</h3>
                    <h6>{{ $user->email }}</h6>
                    <span class="account-badge">{{ $user->role }}</span>
                </div>
            </div>

            {{-- Edit Profile Form --}}
            <div class="account-section">
                <div class="section-title">
                    <i class='bx bx-edit-alt'></i>
                    <h4>edit profile</h4>
                </div>

                <form id="form-profile" class="account-form">
                    <div class="form-group">
                        <label for="input-name">Nama</label>
                        <input type="text" id="input-name" name="name"
                               value="{{ $user->name }}" required
                               placeholder="Masukkan nama kamu">
                    </div>

                    <div class="form-group">
                        <label for="input-email">Email</label>
                        <input type="email" id="input-email" name="email"
                               value="{{ $user->email }}" required
                               placeholder="Masukkan email kamu">
                    </div>

                    <div class="form-divider">
                        <span>ganti password (opsional)</span>
                    </div>

                    <div class="form-group">
                        <label for="input-password">Password Baru</label>
                        <div class="input-password-wrap">
                            <input type="password" id="input-password" name="password"
                                   placeholder="Kosongkan jika tidak ingin ganti" minlength="8">
                            <button type="button" class="btn-toggle-pw" onclick="togglePw('input-password', this)">
                                <i class='bx bx-hide'></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="input-password-confirm">Konfirmasi Password</label>
                        <div class="input-password-wrap">
                            <input type="password" id="input-password-confirm" name="password_confirmation"
                                   placeholder="Ulangi password baru" minlength="8">
                            <button type="button" class="btn-toggle-pw" onclick="togglePw('input-password-confirm', this)">
                                <i class='bx bx-hide'></i>
                            </button>
                        </div>
                    </div>

                    <div id="form-message" class="form-message" style="display:none;"></div>

                    <button type="submit" class="btn-save" id="btn-save">
                        <i class='bx bx-check'></i> Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Stats --}}
            <div class="account-section">
                <div class="section-title">
                    <i class='bx bx-bar-chart-alt-2'></i>
                    <h4>statistik</h4>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class='bx bx-time-five'></i>
                        <div>
                            <h5>Bergabung</h5>
                            <h4>{{ $user->created_at->translatedFormat('d M Y') }}</h4>
                        </div>
                    </div>
                    <div class="stat-card">
                        <i class='bx bx-envelope'></i>
                        <div>
                            <h5>Email terverifikasi</h5>
                            <h4>{{ $user->email_verified_at ? $user->email_verified_at->translatedFormat('d M Y') : 'Belum' }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Logout --}}
            <div class="account-section">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class='bx bx-log-out'></i> Keluar dari akun
                    </button>
                </form>
            </div>

        </div>
    </main>
</div>

<script>
    // Toggle password visibility
    function togglePw(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bx bx-show';
        } else {
            input.type = 'password';
            icon.className = 'bx bx-hide';
        }
    }

    // Submit profile form via AJAX
    (function() {
        const form    = document.getElementById('form-profile');
        const msgBox  = document.getElementById('form-message');
        const btnSave = document.getElementById('btn-save');

        if (!form) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            msgBox.style.display = 'none';

            // Password match check
            const pw   = form.querySelector('[name="password"]').value;
            const pwC  = form.querySelector('[name="password_confirmation"]').value;
            if (pw && pw !== pwC) {
                msgBox.textContent = 'Password dan konfirmasi tidak sama!';
                msgBox.className = 'form-message error';
                msgBox.style.display = 'block';
                return;
            }

            btnSave.disabled = true;
            btnSave.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            try {
                const res = await fetch('{{ route("user.profile.update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                    credentials: 'same-origin',
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    msgBox.textContent = data.message;
                    msgBox.className = 'form-message success';
                    msgBox.style.display = 'block';

                    // Update display name
                    const dn = document.getElementById('display-name');
                    if (dn && data.user) dn.textContent = data.user.name;

                    // Clear password fields
                    form.querySelector('[name="password"]').value = '';
                    form.querySelector('[name="password_confirmation"]').value = '';
                } else {
                    // Validation errors
                    let errMsg = data.message || 'Gagal menyimpan';
                    if (data.errors) {
                        errMsg = Object.values(data.errors).flat().join('\n');
                    }
                    msgBox.textContent = errMsg;
                    msgBox.className = 'form-message error';
                    msgBox.style.display = 'block';
                }
            } catch (err) {
                msgBox.textContent = 'Terjadi kesalahan jaringan';
                msgBox.className = 'form-message error';
                msgBox.style.display = 'block';
            } finally {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="bx bx-check"></i> Simpan Perubahan';
            }
        });
    })();
</script>

<style>
    .container-account {
        display: flex;
        justify-content: center;
        margin-top: 1.5em;
        padding-bottom: 6em;
    }
    .main-account {
        width: 100%;
        max-width: 79em;
        margin: 0 10px;
    }
    .wrapper-account {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* ── Header ──────────────────── */
    .account-header {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #191825;
        border-radius: 20px;
        border: 1px solid #1f1e2e;
        padding: 24px 20px;
    }
    .avatar-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .avatar-circle span {
        color: #fff;
        font-size: 24px;
        font-weight: 700;
    }
    .account-info h3 {
        color: #E6E0E9;
        font-weight: 600;
        font-size: 18px;
        text-transform: capitalize;
    }
    .account-info h6 {
        color: #8a898a;
        font-size: 12px;
        margin-top: 4px;
    }
    .account-badge {
        display: inline-block;
        margin-top: 6px;
        padding: 2px 12px;
        border-radius: 20px;
        background: #222430;
        border: 1px solid #2a2c3a;
        color: #75bbed;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ── Section ──────────────────── */
    .account-section {
        background: #191825;
        border-radius: 20px;
        border: 1px solid #1f1e2e;
        padding: 20px;
    }
    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }
    .section-title i {
        color: #75bbed;
        font-size: 18px;
    }
    .section-title h4 {
        color: #E6E0E9;
        font-weight: 550;
        font-size: 15px;
        text-transform: capitalize;
    }

    /* ── Form ─────────────────────── */
    .account-form {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-group label {
        color: #8a898a;
        font-size: 12px;
        text-transform: capitalize;
    }
    .form-group input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #2a2c3a;
        background: #13121c;
        color: #E6E0E9;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .form-group input:focus {
        border-color: #6366f1;
    }
    .form-group input::placeholder {
        color: #555;
    }

    /* Password toggle */
    .input-password-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-password-wrap input {
        padding-right: 44px;
    }
    .btn-toggle-pw {
        position: absolute;
        right: 8px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
    }
    .btn-toggle-pw i {
        color: #8a898a;
        font-size: 18px;
    }

    /* Divider between fields */
    .form-divider {
        display: flex;
        align-items: center;
        margin: 8px 0;
    }
    .form-divider::before,
    .form-divider::after {
        content: '';
        flex: 1;
        border-top: 1px solid #2a2c3a;
    }
    .form-divider span {
        padding: 0 12px;
        color: #555;
        font-size: 12px;
        white-space: nowrap;
        text-transform: capitalize;
    }

    /* Message box */
    .form-message {
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        white-space: pre-line;
    }
    .form-message.success {
        background: #0d2818;
        border: 1px solid #166534;
        color: #4ade80;
    }
    .form-message.error {
        background: #2d1215;
        border: 1px solid #991b1b;
        color: #f87171;
    }

    /* Save button */
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 14px;
        border: none;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.35);
    }
    .btn-save:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* ── Stats ────────────────────── */
    .stats-grid {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .stat-card {
        flex: 1;
        min-width: 140px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: #13121c;
        border-radius: 14px;
        border: 1px solid #2a2c3a;
    }
    .stat-card > i {
        font-size: 22px;
        color: #75bbed;
    }
    .stat-card h5 {
        color: #8a898a;
        font-size: 11px;
    }
    .stat-card h4 {
        color: #E6E0E9;
        font-size: 13px;
        font-weight: 500;
        margin-top: 2px;
    }

    /* ── Logout ───────────────────── */
    .btn-logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        border-radius: 14px;
        border: 1px solid #991b1b;
        background: transparent;
        color: #f87171;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-logout:hover {
        background: #2d1215;
    }
</style>

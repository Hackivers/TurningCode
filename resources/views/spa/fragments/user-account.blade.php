<div class="container-account">
    <main class="main-account">
        <div class="wrapper-account">

            {{-- Profile Header --}}
            <div class="account-header">
                <div class="account-avatar">
                    <div class="avatar-circle" id="header-avatar">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="avatar-img">
                        @else
                            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>
                <div class="account-info">
                    <h3 id="display-name">{{ $user->name }}</h3>
                    <h6>{{ $user->email }}</h6>
                    <span class="account-badge">{{ $user->role }}</span>
                </div>
            </div>

            {{-- Edit Profile Photo --}}
            <div class="account-section">
                <div class="section-title">
                    <i class='bx bx-camera'></i>
                    <h4>foto profil</h4>
                </div>

                <div class="avatar-editor">
                    <div class="avatar-preview-wrap">
                        <div class="avatar-preview" id="avatar-preview">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="preview-img">
                            @else
                                <div class="avatar-placeholder" id="avatar-placeholder">
                                    <i class='bx bx-user'></i>
                                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="avatar-overlay" id="avatar-overlay" onclick="document.getElementById('input-avatar').click()">
                            <i class='bx bx-camera'></i>
                            <span>Ganti Foto</span>
                        </div>
                    </div>

                    <div class="avatar-actions">
                        <input type="file" id="input-avatar" accept="image/jpeg,image/png,image/webp" hidden>
                        <button type="button" class="btn-upload-avatar" id="btn-upload-avatar" onclick="document.getElementById('input-avatar').click()">
                            <i class='bx bx-upload'></i> Pilih Foto
                        </button>
                        @if($user->avatar)
                        <button type="button" class="btn-remove-avatar" id="btn-remove-avatar">
                            <i class='bx bx-trash'></i> Hapus Foto
                        </button>
                        @endif
                        <p class="avatar-hint">Format: JPG, PNG, WEBP · Maks. 2MB</p>
                    </div>
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

    // ── Avatar Upload ─────────────────────────────────────────────
    (function() {
        const inputAvatar     = document.getElementById('input-avatar');
        const avatarPreview   = document.getElementById('avatar-preview');
        const avatarOverlay   = document.getElementById('avatar-overlay');
        const btnRemove       = document.getElementById('btn-remove-avatar');
        const headerAvatar    = document.getElementById('header-avatar');
        const csrfToken       = document.querySelector('meta[name="csrf-token"]')?.content;

        let pendingAvatarFile = null;
        let pendingRemove     = false;

        if (inputAvatar) {
            inputAvatar.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                // Validate client-side
                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    showAvatarToast('Format harus JPG, PNG, atau WEBP', 'error');
                    return;
                }
                if (file.size > 2 * 1024 * 1024) {
                    showAvatarToast('Ukuran maksimal 2MB', 'error');
                    return;
                }

                pendingAvatarFile = file;
                pendingRemove = false;

                // Preview
                const reader = new FileReader();
                reader.onload = (ev) => {
                    avatarPreview.innerHTML = `<img src="${ev.target.result}" alt="Preview" id="preview-img">`;
                    // Also update header avatar
                    headerAvatar.innerHTML = `<img src="${ev.target.result}" alt="Avatar" class="avatar-img">`;
                    // Show remove button
                    if (!btnRemove) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn-remove-avatar';
                        btn.id = 'btn-remove-avatar';
                        btn.innerHTML = "<i class='bx bx-trash'></i> Hapus Foto";
                        btn.addEventListener('click', handleRemoveAvatar);
                        document.querySelector('.avatar-actions').insertBefore(btn, document.querySelector('.avatar-hint'));
                    }
                };
                reader.readAsDataURL(file);

                // Auto-upload immediately
                uploadAvatar(file);
            });
        }

        function handleRemoveAvatar() {
            if (!confirm('Hapus foto profil?')) return;
            pendingRemove = true;
            pendingAvatarFile = null;

            // Reset preview to initial letter
            const userName = document.getElementById('display-name')?.textContent || 'U';
            const initial = userName.charAt(0).toUpperCase();
            avatarPreview.innerHTML = `<div class="avatar-placeholder" id="avatar-placeholder"><i class='bx bx-user'></i><span>${initial}</span></div>`;
            headerAvatar.innerHTML = `<span>${initial}</span>`;

            // Send remove request
            removeAvatar();
        }

        if (btnRemove) {
            btnRemove.addEventListener('click', handleRemoveAvatar);
        }

        async function uploadAvatar(file) {
            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('name', document.getElementById('input-name').value);
            formData.append('email', document.getElementById('input-email').value);

            showAvatarToast('Mengupload foto...', 'loading');

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
                    showAvatarToast('Foto berhasil diupload! 📸', 'success');
                    if (data.user?.avatar) {
                        avatarPreview.innerHTML = `<img src="${data.user.avatar}" alt="Avatar" id="preview-img">`;
                        headerAvatar.innerHTML = `<img src="${data.user.avatar}" alt="Avatar" class="avatar-img">`;

                        // Update navbar & sidebar avatars
                        updateGlobalAvatars(data.user.avatar);
                    }
                    // Ensure remove button exists
                    ensureRemoveButton();
                } else {
                    let errMsg = data.message || 'Gagal upload';
                    if (data.errors?.avatar) errMsg = data.errors.avatar[0];
                    showAvatarToast(errMsg, 'error');
                }
            } catch (err) {
                showAvatarToast('Gagal mengupload foto', 'error');
            }
        }

        async function removeAvatar() {
            const formData = new FormData();
            formData.append('remove_avatar', '1');
            formData.append('name', document.getElementById('input-name').value);
            formData.append('email', document.getElementById('input-email').value);

            showAvatarToast('Menghapus foto...', 'loading');

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
                    showAvatarToast('Foto berhasil dihapus', 'success');
                    // Remove the remove button
                    const rb = document.getElementById('btn-remove-avatar');
                    if (rb) rb.remove();

                    // Reset global avatars
                    updateGlobalAvatars(null);
                } else {
                    showAvatarToast('Gagal menghapus foto', 'error');
                }
            } catch (err) {
                showAvatarToast('Gagal menghapus foto', 'error');
            }
        }

        function updateGlobalAvatars(avatarUrl) {
            // Update sidebar avatar
            const sidebarImg = document.querySelector('.user-img img');
            if (sidebarImg && avatarUrl) {
                sidebarImg.src = avatarUrl;
            }
            // Update navbar avatar
            const navImg = document.querySelector('.profile-img-nav img');
            if (navImg && avatarUrl) {
                navImg.src = avatarUrl;
            }
        }

        function ensureRemoveButton() {
            if (!document.getElementById('btn-remove-avatar')) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn-remove-avatar';
                btn.id = 'btn-remove-avatar';
                btn.innerHTML = "<i class='bx bx-trash'></i> Hapus Foto";
                btn.addEventListener('click', handleRemoveAvatar);
                const hint = document.querySelector('.avatar-hint');
                if (hint) hint.parentElement.insertBefore(btn, hint);
            }
        }

        function showAvatarToast(msg, type) {
            // Remove existing toast
            const existing = document.getElementById('avatar-toast');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'avatar-toast';
            toast.className = `avatar-toast ${type}`;

            let icon = '';
            if (type === 'success') icon = "<i class='bx bx-check-circle'></i>";
            else if (type === 'error') icon = "<i class='bx bx-error-circle'></i>";
            else if (type === 'loading') icon = "<i class='bx bx-loader-alt bx-spin'></i>";

            toast.innerHTML = `${icon} <span>${msg}</span>`;
            document.querySelector('.avatar-editor')?.appendChild(toast);

            if (type !== 'loading') {
                setTimeout(() => toast.classList.add('fade-out'), 3000);
                setTimeout(() => toast.remove(), 3500);
            }
        }
    })();

    // ── Submit profile form via AJAX ──────────────────────────────
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
        overflow: hidden;
    }
    .avatar-circle span {
        color: #fff;
        font-size: 24px;
        font-weight: 700;
    }
    .avatar-circle .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
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

    /* ── Avatar Editor ────────────── */
    .avatar-editor {
        display: flex;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
    }
    .avatar-preview-wrap {
        position: relative;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        flex-shrink: 0;
        cursor: pointer;
    }
    .avatar-preview {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #2a2c3a;
        transition: border-color 0.3s ease;
    }
    .avatar-preview-wrap:hover .avatar-preview {
        border-color: #6366f1;
    }
    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2px;
    }
    .avatar-placeholder i {
        color: rgba(255,255,255,0.4);
        font-size: 28px;
    }
    .avatar-placeholder span {
        color: #fff;
        font-size: 28px;
        font-weight: 700;
    }
    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }
    .avatar-preview-wrap:hover .avatar-overlay {
        opacity: 1;
    }
    .avatar-overlay i {
        color: #fff;
        font-size: 24px;
    }
    .avatar-overlay span {
        color: #fff;
        font-size: 11px;
        font-weight: 500;
    }
    .avatar-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .btn-upload-avatar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 12px;
        border: 1px solid #2a2c3a;
        background: #13121c;
        color: #E6E0E9;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-upload-avatar:hover {
        border-color: #6366f1;
        background: #1a1930;
        transform: translateY(-1px);
    }
    .btn-upload-avatar i {
        font-size: 16px;
        color: #6366f1;
    }
    .btn-remove-avatar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 12px;
        border: 1px solid #991b1b;
        background: transparent;
        color: #f87171;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-remove-avatar:hover {
        background: #2d1215;
        transform: translateY(-1px);
    }
    .btn-remove-avatar i {
        font-size: 16px;
    }
    .avatar-hint {
        color: #555;
        font-size: 11px;
        margin: 0;
    }

    /* ── Avatar Toast ─────────────── */
    .avatar-toast {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        margin-top: 12px;
        width: 100%;
        animation: toastSlideIn 0.3s ease;
    }
    .avatar-toast.success {
        background: #0d2818;
        border: 1px solid #166534;
        color: #4ade80;
    }
    .avatar-toast.error {
        background: #2d1215;
        border: 1px solid #991b1b;
        color: #f87171;
    }
    .avatar-toast.loading {
        background: #1a1930;
        border: 1px solid #2a2c3a;
        color: #75bbed;
    }
    .avatar-toast.fade-out {
        animation: toastFadeOut 0.5s ease forwards;
    }
    @keyframes toastSlideIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes toastFadeOut {
        from { opacity: 1; }
        to   { opacity: 0; transform: translateY(-8px); }
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

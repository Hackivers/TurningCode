{{-- ═══════════════════════════════════════════════════════════════
PROFILE HEADER CARD
═══════════════════════════════════════════════════════════════ --}}
<div class="container container-account">
    <main class="main-account">
        <div class="wrapper-account">
            <div class="account-profile-user">
                <div>
                    <div class="account-profile-emblem">
                        <div>
                            <img src="{{ asset('assets/ico/' . $user->emblem_image) }}" alt="">
                            <h6>score</h6>
                            <h4>{{ $user->exp ?? 0 }}</h4>
                        </div>
                    </div>
                    <div class="account-profile-name">
                        <div class="emblem-name">
                            <h4 id="display-name">{{ $user->name }}</h4>
                            <img src="{{ asset('assets/ico/' . $user->emblem_image) }}" alt="">
                        </div>
                        <h5 id="display-email">{{ $user->email }}</h5>
                    </div>
                    <div class="account-profile-btn">
                        <div class="account-profile-role">
                            <span>
                                <h5>{{ $user->rank_name }}</h5>
                            </span>
                            <span>
                                <h5>{{ (int) $user->created_at->diffInDays(now()) }} hari</h5>
                            </span>
                        </div>
                        <button id="btn-open-edit-profile">edit profile</button>
                    </div>
                </div>
            </div>
            <div class="account-profile-img">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="avatar-img"
                        id="profile-cover-img">
                @else
                    <img src="{{ asset('assets/ico/devlab.jpg') }}" alt="Avatar" class="avatar-img" id="profile-cover-img">
                @endif
            </div>
        </div>
    </main>
</div>

{{-- ═══════════════════════════════════════════════════════════════
STATS SECTION
═══════════════════════════════════════════════════════════════ --}}
<div class="container container-edit-profile">
    <div class="edit-profile-section">
        <div>
            <div class="ep-section-title">
                <i class='bx bx-bar-chart-alt-2'></i>
                <h4>Statistik</h4>
            </div>
            <div class="ep-stats-grid">
                <div class="ep-stat-card">
                    <i class='bx bx-time-five'></i>
                    <div>
                        <h5>Bergabung</h5>
                        <h4>{{ $user->created_at->translatedFormat('d M Y') }}</h4>
                    </div>
                </div>
                <div class="ep-stat-card">
                    <i class='bx bx-envelope'></i>
                    <div>
                        <h5>Email terverifikasi</h5>
                        <h4>{{ $user->email_verified_at ? $user->email_verified_at->translatedFormat('d M Y') : 'Belum' }}
                        </h4>
                    </div>
                </div>
                <div class="ep-stat-card">
                    <i class='bx bx-meteor'></i>
                    <div>
                        <h5>Total EXP</h5>
                        <h4>{{ $user->exp ?? 0 }} EXP</h4>
                    </div>
                </div>
                <div class="ep-stat-card">
                    <i class='bx bx-trophy'></i>
                    <div>
                        <h5>Rank</h5>
                        <h4>{{ $user->rank_name }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
LOGOUT
═══════════════════════════════════════════════════════════════ --}}
<form class="wrapper-account-logout" action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn-logout">
        <i class='bx bx-log-out'></i>
        <h5>Keluar dari akun</h5>
    </button>
</form>

{{-- ═══════════════════════════════════════════════════════════════
EDIT PROFILE MODAL (Slide-up)
═══════════════════════════════════════════════════════════════ --}}
<div class="ep-modal-backdrop" id="ep-modal-backdrop"></div>
<div class="ep-modal" id="ep-modal">
    <div class="ep-modal-handle" id="ep-modal-handle"><span></span></div>

    <div class="ep-modal-header">
        <h4>Edit Profile</h4>
        <button class="ep-modal-close" id="ep-modal-close"><i class='bx bx-x'></i></button>
    </div>

    <div class="ep-modal-body">
        {{-- Avatar Section --}}
        <div class="ep-avatar-section">
            <div class="ep-avatar-wrap">
                <div class="ep-avatar" id="ep-avatar-preview">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="ep-avatar-img">
                    @else
                        <div class="ep-avatar-placeholder">
                            <i class='bx bx-user'></i>
                            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <div class="ep-avatar-overlay" id="ep-avatar-overlay">
                    <i class='bx bx-camera'></i>
                </div>
            </div>
            <div class="ep-avatar-actions">
                <input type="file" id="ep-input-avatar" accept="image/jpeg,image/png,image/webp" hidden>
                <button type="button" class="ep-btn-upload" id="ep-btn-upload">
                    <i class='bx bx-upload'></i> Ganti Foto
                </button>
                @if($user->avatar)
                    <button type="button" class="ep-btn-remove" id="ep-btn-remove">
                        <i class='bx bx-trash'></i> Hapus
                    </button>
                @endif
                <p class="ep-avatar-hint">JPG, PNG, WEBP · Maks. 2MB</p>
            </div>
        </div>
        <div id="ep-avatar-toast"></div>

        {{-- Divider --}}
        <div class="ep-divider"></div>

        {{-- Profile Form --}}
        <form id="ep-form-profile" class="ep-form">
            <div class="ep-form-group">
                <label for="ep-input-name">Nama</label>
                <div class="ep-input-wrap">
                    <i class='bx bx-user'></i>
                    <input type="text" id="ep-input-name" name="name" value="{{ $user->name }}" required
                        placeholder="Masukkan nama kamu">
                </div>
            </div>

            <div class="ep-form-group">
                <label for="ep-input-email">Email</label>
                <div class="ep-input-wrap">
                    <i class='bx bx-envelope'></i>
                    <input type="email" id="ep-input-email" name="email" value="{{ $user->email }}" required
                        placeholder="Masukkan email kamu">
                </div>
            </div>

            <div class="ep-form-divider">
                <span>Ganti Password (Opsional)</span>
            </div>

            <div class="ep-form-group">
                <label for="ep-input-password">Password Baru</label>
                <div class="ep-input-wrap ep-input-password">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" id="ep-input-password" name="password"
                        placeholder="Kosongkan jika tidak ingin ganti" minlength="8">
                    <button type="button" class="ep-btn-toggle-pw" data-target="ep-input-password">
                        <i class='bx bx-hide'></i>
                    </button>
                </div>
            </div>

            <div class="ep-form-group">
                <label for="ep-input-pw-confirm">Konfirmasi Password</label>
                <div class="ep-input-wrap ep-input-password">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" id="ep-input-pw-confirm" name="password_confirmation"
                        placeholder="Ulangi password baru" minlength="8">
                    <button type="button" class="ep-btn-toggle-pw" data-target="ep-input-pw-confirm">
                        <i class='bx bx-hide'></i>
                    </button>
                </div>
            </div>

            <div id="ep-form-message" class="ep-form-message" style="display:none;"></div>

            <button type="submit" class="ep-btn-save" id="ep-btn-save">
                <i class='bx bx-check'></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
JAVASCRIPT
═══════════════════════════════════════════════════════════════ --}}
<script>
    (function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const profileUpdateUrl = '{{ route("user.profile.update") }}';

        // ── Modal Open / Close ──────────────────────────────────────
        const modal = document.getElementById('ep-modal');
        const backdrop = document.getElementById('ep-modal-backdrop');
        const btnOpen = document.getElementById('btn-open-edit-profile');
        const btnClose = document.getElementById('ep-modal-close');
        const handle = document.getElementById('ep-modal-handle');

        function openModal() {
            modal.classList.add('active');
            backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            modal.classList.remove('active');
            backdrop.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (btnOpen) btnOpen.addEventListener('click', openModal);
        if (btnClose) btnClose.addEventListener('click', closeModal);
        if (backdrop) backdrop.addEventListener('click', closeModal);
        if (handle) handle.addEventListener('click', closeModal);

        // ── Password Toggle ─────────────────────────────────────────
        document.querySelectorAll('.ep-btn-toggle-pw').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.target);
                const icon = btn.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bx bx-show';
                } else {
                    input.type = 'password';
                    icon.className = 'bx bx-hide';
                }
            });
        });

        // ── Toast Helper ────────────────────────────────────────────
        function showToast(msg, type) {
            const container = document.getElementById('ep-avatar-toast');
            if (!container) return;
            container.innerHTML = '';

            const toast = document.createElement('div');
            toast.className = `ep-toast ${type}`;

            let icon = '';
            if (type === 'success') icon = "<i class='bx bx-check-circle'></i>";
            else if (type === 'error') icon = "<i class='bx bx-error-circle'></i>";
            else if (type === 'loading') icon = "<i class='bx bx-loader-alt bx-spin'></i>";

            toast.innerHTML = `${icon} <span>${msg}</span>`;
            container.appendChild(toast);

            if (type !== 'loading') {
                setTimeout(() => toast.classList.add('fade-out'), 3000);
                setTimeout(() => toast.remove(), 3500);
            }
        }

        // ── Avatar Upload ───────────────────────────────────────────
        const inputAvatar = document.getElementById('ep-input-avatar');
        const btnUpload = document.getElementById('ep-btn-upload');
        const avatarOverlay = document.getElementById('ep-avatar-overlay');
        const avatarPreview = document.getElementById('ep-avatar-preview');
        let btnRemove = document.getElementById('ep-btn-remove');

        if (btnUpload) btnUpload.addEventListener('click', () => inputAvatar.click());
        if (avatarOverlay) avatarOverlay.addEventListener('click', () => inputAvatar.click());

        if (inputAvatar) {
            inputAvatar.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    showToast('Format harus JPG, PNG, atau WEBP', 'error');
                    return;
                }
                if (file.size > 2 * 1024 * 1024) {
                    showToast('Ukuran maksimal 2MB', 'error');
                    return;
                }

                // Preview
                const reader = new FileReader();
                reader.onload = (ev) => {
                    avatarPreview.innerHTML = `<img src="${ev.target.result}" alt="Preview" id="ep-avatar-img">`;
                };
                reader.readAsDataURL(file);

                // Upload
                uploadAvatar(file);
            });
        }

        async function uploadAvatar(file) {
            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('name', document.getElementById('ep-input-name').value);
            formData.append('email', document.getElementById('ep-input-email').value);

            showToast('Mengupload foto...', 'loading');

            try {
                const res = await fetch(profileUpdateUrl, {
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
                    showToast('Foto berhasil diupload! 📸', 'success');
                    if (data.user?.avatar) {
                        avatarPreview.innerHTML = `<img src="${data.user.avatar}" alt="Avatar" id="ep-avatar-img">`;
                        // Update profile cover
                        const coverImg = document.getElementById('profile-cover-img');
                        if (coverImg) coverImg.src = data.user.avatar;
                        // Update navbar avatar
                        updateGlobalAvatars(data.user.avatar);
                    }
                    ensureRemoveButton();
                } else {
                    let errMsg = data.message || 'Gagal upload';
                    if (data.errors?.avatar) errMsg = data.errors.avatar[0];
                    showToast(errMsg, 'error');
                }
            } catch (err) {
                showToast('Gagal mengupload foto', 'error');
            }
        }

        // ── Avatar Remove ───────────────────────────────────────────
        function handleRemoveAvatar() {
            if (!confirm('Hapus foto profil?')) return;

            const userName = document.getElementById('display-name')?.textContent || 'U';
            const initial = userName.charAt(0).toUpperCase();
            avatarPreview.innerHTML = `<div class="ep-avatar-placeholder"><i class='bx bx-user'></i><span>${initial}</span></div>`;

            removeAvatar();
        }

        if (btnRemove) btnRemove.addEventListener('click', handleRemoveAvatar);

        async function removeAvatar() {
            const formData = new FormData();
            formData.append('remove_avatar', '1');
            formData.append('name', document.getElementById('ep-input-name').value);
            formData.append('email', document.getElementById('ep-input-email').value);

            showToast('Menghapus foto...', 'loading');

            try {
                const res = await fetch(profileUpdateUrl, {
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
                    showToast('Foto berhasil dihapus', 'success');
                    const rb = document.getElementById('ep-btn-remove');
                    if (rb) rb.remove();
                    // Reset cover
                    const coverImg = document.getElementById('profile-cover-img');
                    if (coverImg) coverImg.src = '{{ asset("assets/ico/devlab.jpg") }}';
                    updateGlobalAvatars(null);
                } else {
                    showToast('Gagal menghapus foto', 'error');
                }
            } catch (err) {
                showToast('Gagal menghapus foto', 'error');
            }
        }

        function ensureRemoveButton() {
            if (!document.getElementById('ep-btn-remove')) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'ep-btn-remove';
                btn.id = 'ep-btn-remove';
                btn.innerHTML = "<i class='bx bx-trash'></i> Hapus";
                btn.addEventListener('click', handleRemoveAvatar);
                const hint = document.querySelector('.ep-avatar-hint');
                if (hint) hint.parentElement.insertBefore(btn, hint);
            }
        }

        function updateGlobalAvatars(avatarUrl) {
            const sidebarImg = document.querySelector('.user-img img');
            if (sidebarImg && avatarUrl) sidebarImg.src = avatarUrl;
            const navImg = document.querySelector('.profile-img-nav img');
            if (navImg && avatarUrl) navImg.src = avatarUrl;
        }

        // ── Profile Form Submit ─────────────────────────────────────
        const form = document.getElementById('ep-form-profile');
        const msgBox = document.getElementById('ep-form-message');
        const btnSave = document.getElementById('ep-btn-save');

        if (form) {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                msgBox.style.display = 'none';

                const pw = form.querySelector('[name="password"]').value;
                const pwC = form.querySelector('[name="password_confirmation"]').value;
                if (pw && pw !== pwC) {
                    msgBox.textContent = 'Password dan konfirmasi tidak sama!';
                    msgBox.className = 'ep-form-message error';
                    msgBox.style.display = 'block';
                    return;
                }

                btnSave.disabled = true;
                btnSave.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';

                const formData = new FormData(form);

                try {
                    const res = await fetch(profileUpdateUrl, {
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
                        msgBox.className = 'ep-form-message success';
                        msgBox.style.display = 'block';

                        // Update display
                        const dn = document.getElementById('display-name');
                        const de = document.getElementById('display-email');
                        if (dn && data.user) dn.textContent = data.user.name;
                        if (de && data.user) de.textContent = data.user.email;

                        // Update navbar name
                        const navName = document.querySelector('.profile-img-nav h5');
                        if (navName && data.user) navName.textContent = data.user.name;

                        // Clear password fields
                        form.querySelector('[name="password"]').value = '';
                        form.querySelector('[name="password_confirmation"]').value = '';
                    } else {
                        let errMsg = data.message || 'Gagal menyimpan';
                        if (data.errors) {
                            errMsg = Object.values(data.errors).flat().join('\n');
                        }
                        msgBox.textContent = errMsg;
                        msgBox.className = 'ep-form-message error';
                        msgBox.style.display = 'block';
                    }
                } catch (err) {
                    msgBox.textContent = 'Terjadi kesalahan jaringan';
                    msgBox.className = 'ep-form-message error';
                    msgBox.style.display = 'block';
                } finally {
                    btnSave.disabled = false;
                    btnSave.innerHTML = '<i class="bx bx-check"></i> Simpan Perubahan';
                }
            });
        }
    })();
</script>

<style>
    /* ═══════════════════════════════════════════════════════════════
   EDIT PROFILE — STATS & MODAL STYLES
   ═══════════════════════════════════════════════════════════════ */

    /* ── Stats Section ──────────────────────────────────────────── */
    .container-edit-profile {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        padding: 0 10px;
    }

    .edit-profile-section {
        width: 100%;
        max-width: 79em;
        background: #191825;
        border-radius: 20px;
        border: 1px solid #1f1e2e;
    }

    .edit-profile-section>div {
        margin: 20px;
    }

    .ep-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }

    .ep-section-title i {
        color: #8b5cf6;
        font-size: 20px;
        background: rgba(139, 92, 246, 0.1);
        padding: 6px;
        border-radius: 10px;
    }

    .ep-section-title h4 {
        color: #E6E0E9;
        font-weight: 600;
        font-size: 15px;
        text-transform: capitalize;
    }

    .ep-stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .ep-stat-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: rgba(19, 18, 28, 0.6);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.04);
        transition: all 0.3s ease;
    }

    .ep-stat-card:hover {
        border-color: rgba(139, 92, 246, 0.2);
        background: rgba(19, 18, 28, 0.9);
    }

    .ep-stat-card>i {
        font-size: 22px;
        color: #8b5cf6;
        flex-shrink: 0;
    }

    .ep-stat-card h5 {
        color: #8a898a;
        font-size: 11px;
        font-weight: 400;
    }

    .ep-stat-card h4 {
        color: #E6E0E9;
        font-size: 13px;
        font-weight: 500;
        margin-top: 2px;
    }

    /* ── Modal ───────────────────────────────────────────────────── */
    .ep-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 998;
        background: rgba(9, 8, 14, 0.7);
        backdrop-filter: blur(6px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.35s ease;
    }

    .ep-modal-backdrop.active {
        opacity: 1;
        visibility: visible;
    }

    .ep-modal {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 999;
        max-height: 90vh;
        overflow-y: auto;
        background: #191825;
        border-radius: 28px 28px 0 0;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        box-shadow: 0 -20px 60px rgba(0, 0, 0, 0.5);
        transform: translateY(100%);
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .ep-modal.active {
        transform: translateY(0);
    }

    .ep-modal::-webkit-scrollbar {
        width: 4px;
    }

    .ep-modal::-webkit-scrollbar-thumb {
        background: #2a2c3a;
        border-radius: 4px;
    }

    .ep-modal-handle {
        display: flex;
        justify-content: center;
        padding: 12px 0 4px;
        cursor: pointer;
    }

    .ep-modal-handle span {
        width: 40px;
        height: 4px;
        background: #2a2c3a;
        border-radius: 4px;
    }

    .ep-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 24px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .ep-modal-header h4 {
        color: #E6E0E9;
        font-size: 18px;
        font-weight: 650;
    }

    .ep-modal-close {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.05);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ep-modal-close:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(90deg);
    }

    .ep-modal-close i {
        color: #8a898a;
        font-size: 20px;
    }

    .ep-modal-body {
        padding: 20px 24px 40px;
    }

    /* ── Avatar Section ──────────────────────────────────────────── */
    .ep-avatar-section {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .ep-avatar-wrap {
        position: relative;
        width: 90px;
        height: 90px;
        flex-shrink: 0;
        border-radius: 50%;
        cursor: pointer;
    }

    .ep-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        overflow: hidden;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #2a2c3a;
        transition: border-color 0.3s ease;
    }

    .ep-avatar-wrap:hover .ep-avatar {
        border-color: #6366f1;
    }

    .ep-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ep-avatar-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .ep-avatar-placeholder i {
        color: rgba(255, 255, 255, 0.3);
        font-size: 24px;
    }

    .ep-avatar-placeholder span {
        color: #fff;
        font-size: 28px;
        font-weight: 700;
    }

    .ep-avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .ep-avatar-wrap:hover .ep-avatar-overlay {
        opacity: 1;
    }

    .ep-avatar-overlay i {
        color: #fff;
        font-size: 24px;
    }

    .ep-avatar-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .ep-btn-upload {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 12px;
        border: 1px solid #2a2c3a;
        background: rgba(19, 18, 28, 0.6);
        color: #E6E0E9;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ep-btn-upload:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
    }

    .ep-btn-upload i {
        font-size: 16px;
        color: #6366f1;
    }

    .ep-btn-remove {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 12px;
        border: 1px solid rgba(153, 27, 27, 0.5);
        background: transparent;
        color: #f87171;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ep-btn-remove:hover {
        background: rgba(153, 27, 27, 0.15);
    }

    .ep-btn-remove i {
        font-size: 16px;
    }

    .ep-avatar-hint {
        color: #555;
        font-size: 11px;
        margin: 0;
    }

    /* ── Toast ────────────────────────────────────────────────────── */
    .ep-toast {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        margin-top: 12px;
        animation: epToastIn 0.3s ease;
    }

    .ep-toast.success {
        background: rgba(13, 40, 24, 0.8);
        border: 1px solid #166534;
        color: #4ade80;
    }

    .ep-toast.error {
        background: rgba(45, 18, 21, 0.8);
        border: 1px solid #991b1b;
        color: #f87171;
    }

    .ep-toast.loading {
        background: rgba(26, 25, 48, 0.8);
        border: 1px solid #2a2c3a;
        color: #75bbed;
    }

    .ep-toast.fade-out {
        animation: epToastOut 0.5s ease forwards;
    }

    @keyframes epToastIn {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes epToastOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            transform: translateY(-6px);
        }
    }

    /* ── Divider ──────────────────────────────────────────────────── */
    .ep-divider {
        height: 1px;
        background: rgba(255, 255, 255, 0.04);
        margin: 20px 0;
    }

    /* ── Form ─────────────────────────────────────────────────────── */
    .ep-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .ep-form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .ep-form-group label {
        color: #8a898a;
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
    }

    .ep-input-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0 14px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        background: rgba(19, 18, 28, 0.6);
        transition: all 0.2s ease;
    }

    .ep-input-wrap:focus-within {
        border-color: #6366f1;
        background: rgba(19, 18, 28, 0.9);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
    }

    .ep-input-wrap>i {
        color: #555;
        font-size: 18px;
        flex-shrink: 0;
    }

    .ep-input-wrap input {
        flex: 1;
        padding: 12px 0;
        border: none;
        background: transparent;
        color: #E6E0E9;
        font-size: 14px;
        outline: none;
        font-family: inherit;
    }

    .ep-input-wrap input::placeholder {
        color: #444;
    }

    .ep-btn-toggle-pw {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        flex-shrink: 0;
    }

    .ep-btn-toggle-pw i {
        color: #8a898a;
        font-size: 18px;
    }

    .ep-form-divider {
        display: flex;
        align-items: center;
        margin: 4px 0;
    }

    .ep-form-divider::before,
    .ep-form-divider::after {
        content: '';
        flex: 1;
        border-top: 1px solid rgba(255, 255, 255, 0.04);
    }

    .ep-form-divider span {
        padding: 0 12px;
        color: #555;
        font-size: 12px;
        white-space: nowrap;
    }

    .ep-form-message {
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 13px;
        white-space: pre-line;
    }

    .ep-form-message.success {
        background: rgba(13, 40, 24, 0.8);
        border: 1px solid #166534;
        color: #4ade80;
    }

    .ep-form-message.error {
        background: rgba(45, 18, 21, 0.8);
        border: 1px solid #991b1b;
        color: #f87171;
    }

    .ep-btn-save {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        border-radius: 16px;
        border: none;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
        margin-top: 4px;
    }

    .ep-btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(99, 102, 241, 0.4);
    }

    .ep-btn-save:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* ── Responsive ───────────────────────────────────────────────── */
    @media (max-width: 480px) {
        .ep-stats-grid {
            grid-template-columns: 1fr;
        }

        .ep-avatar-section {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .ep-avatar-actions {
            align-items: center;
        }
    }
</style>
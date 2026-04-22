<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const profileUpdateUrl = '{{ route("user.profile.update") }}';

    // ── Toast ───────────────────────────────────────────────────
    window.showFriendToast = function (msg, type = 'success') {
        const c = document.getElementById('friend-toast-container');
        if (!c) return;
        const t = document.createElement('div');
        t.className = `friend-toast ${type}`;
        t.innerHTML = `<i class='bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'}'></i> <span>${msg}</span>`;
        c.appendChild(t);
        setTimeout(() => t.classList.add('fade-out'), 3000);
        setTimeout(() => t.remove(), 3500);
    };
    function toast(m, t) { window.showFriendToast(m, t); }

    function showToast(msg, type) {
        const container = document.getElementById('ep-avatar-toast');
        if (!container) return;
        container.innerHTML = '';
        const t = document.createElement('div');
        t.style.cssText = `display:flex;align-items:center;gap:8px;padding:10px 16px;border-radius:12px;font-size:13px;margin-top:12px;background:${type==='success'?'#ecfdf5':'#fef2f2'};border:1px solid ${type==='success'?'#10b981':'#ef4444'};color:${type==='success'?'#10b981':'#ef4444'};`;
        let icon = type === 'success' ? 'bx-check-circle' : (type === 'error' ? 'bx-error-circle' : 'bx-loader-alt bx-spin');
        t.innerHTML = `<i class='bx ${icon}'></i> <span>${msg}</span>`;
        container.appendChild(t);
        if (type !== 'loading') { setTimeout(() => { t.style.opacity = '0'; t.style.transition = 'opacity 0.4s'; }, 3000); setTimeout(() => t.remove(), 3500); }
    }

    // ── Modal Open/Close ────────────────────────────────────────
    const modal = document.getElementById('ep-modal');
    const backdrop = document.getElementById('ep-modal-backdrop');
    function openModal() { modal.classList.add('active'); backdrop.classList.add('active'); document.body.style.overflow = 'hidden'; }
    function closeModal() { modal.classList.remove('active'); backdrop.classList.remove('active'); document.body.style.overflow = ''; }

    document.getElementById('btn-open-edit-profile')?.addEventListener('click', openModal);
    document.getElementById('btn-open-edit-profile-2')?.addEventListener('click', openModal);
    document.getElementById('ep-modal-close')?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);
    document.getElementById('ep-modal-handle')?.addEventListener('click', closeModal);

    // ── Password Toggle ─────────────────────────────────────────
    document.querySelectorAll('.ep-btn-toggle-pw').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            const icon = btn.querySelector('i');
            if (input.type === 'password') { input.type = 'text'; icon.className = 'bx bx-show'; }
            else { input.type = 'password'; icon.className = 'bx bx-hide'; }
        });
    });

    // ── Avatar Upload ───────────────────────────────────────────
    const inputAvatar = document.getElementById('ep-input-avatar');
    const avatarPreview = document.getElementById('ep-avatar-preview');
    document.getElementById('ep-btn-upload')?.addEventListener('click', () => inputAvatar.click());
    document.getElementById('ep-avatar-overlay')?.addEventListener('click', () => inputAvatar?.click());

    if (inputAvatar) {
        inputAvatar.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;
            if (!['image/jpeg','image/png','image/webp'].includes(file.type)) { showToast('Format harus JPG, PNG, atau WEBP', 'error'); return; }
            if (file.size > 2*1024*1024) { showToast('Ukuran maksimal 2MB', 'error'); return; }
            const reader = new FileReader();
            reader.onload = (ev) => { avatarPreview.innerHTML = `<img src="${ev.target.result}" alt="Preview" id="ep-avatar-img" style="width:100%;height:100%;object-fit:cover;">`; };
            reader.readAsDataURL(file);
            uploadAvatar(file);
        });
    }

    async function uploadAvatar(file) {
        const fd = new FormData();
        fd.append('avatar', file);
        fd.append('name', document.getElementById('ep-input-name').value);
        fd.append('email', document.getElementById('ep-input-email').value);
        showToast('Mengupload foto...', 'loading');
        try {
            const res = await fetch(profileUpdateUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }, body: fd, credentials: 'same-origin' });
            const data = await res.json();
            if (res.ok && data.success) {
                showToast('Foto berhasil diupload! 📸', 'success');
                if (data.user?.avatar) { avatarPreview.innerHTML = `<img src="${data.user.avatar}" alt="Avatar" id="ep-avatar-img" style="width:100%;height:100%;object-fit:cover;">`; const c = document.getElementById('profile-cover-img'); if (c) c.src = data.user.avatar; }
            } else { showToast(data.errors?.avatar?.[0] || data.message || 'Gagal upload', 'error'); }
        } catch { showToast('Gagal mengupload foto', 'error'); }
    }

    // ── Avatar Remove ───────────────────────────────────────────
    document.getElementById('ep-btn-remove')?.addEventListener('click', async function() {
        if (!confirm('Hapus foto profil?')) return;
        const n = document.getElementById('display-name')?.textContent || 'U';
        avatarPreview.innerHTML = `<div class="ep-avatar-placeholder"><i class='bx bx-user' style="color:#888;font-size:24px;"></i><span style="color:#121212;font-size:24px;font-weight:700;">${n.charAt(0).toUpperCase()}</span></div>`;
        const fd = new FormData(); fd.append('remove_avatar', '1'); fd.append('name', document.getElementById('ep-input-name').value); fd.append('email', document.getElementById('ep-input-email').value);
        showToast('Menghapus foto...', 'loading');
        try {
            const res = await fetch(profileUpdateUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }, body: fd, credentials: 'same-origin' });
            const data = await res.json();
            if (res.ok && data.success) { showToast('Foto berhasil dihapus', 'success'); const c = document.getElementById('profile-cover-img'); if (c) c.src = '{{ asset("assets/ico/devlab.jpg") }}'; }
            else { showToast('Gagal menghapus foto', 'error'); }
        } catch { showToast('Gagal menghapus foto', 'error'); }
    });

    // ── Profile Form ────────────────────────────────────────────
    const form = document.getElementById('ep-form-profile');
    const msgBox = document.getElementById('ep-form-message');
    const btnSave = document.getElementById('ep-btn-save');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            msgBox.style.display = 'none';
            const pw = form.querySelector('[name="password"]').value;
            const pwC = form.querySelector('[name="password_confirmation"]').value;
            if (pw && pw !== pwC) { msgBox.textContent = 'Password dan konfirmasi tidak sama!'; msgBox.style.background = '#fef2f2'; msgBox.style.color = '#ef4444'; msgBox.style.border = '1px solid #ef4444'; msgBox.style.display = 'block'; return; }
            btnSave.disabled = true; btnSave.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Menyimpan...';
            try {
                const res = await fetch(profileUpdateUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }, body: new FormData(form), credentials: 'same-origin' });
                const data = await res.json();
                if (res.ok && data.success) {
                    msgBox.textContent = data.message; msgBox.style.background = '#ecfdf5'; msgBox.style.color = '#10b981'; msgBox.style.border = '1px solid #10b981'; msgBox.style.display = 'block';
                    const dn = document.getElementById('display-name'); const de = document.getElementById('display-email');
                    if (dn && data.user) dn.textContent = data.user.name; if (de && data.user) de.textContent = data.user.email;
                    form.querySelector('[name="password"]').value = ''; form.querySelector('[name="password_confirmation"]').value = '';
                } else {
                    let err = data.message || 'Gagal menyimpan'; if (data.errors) err = Object.values(data.errors).flat().join('\n');
                    msgBox.textContent = err; msgBox.style.background = '#fef2f2'; msgBox.style.color = '#ef4444'; msgBox.style.border = '1px solid #ef4444'; msgBox.style.display = 'block';
                }
            } catch { msgBox.textContent = 'Kesalahan jaringan'; msgBox.style.background = '#fef2f2'; msgBox.style.color = '#ef4444'; msgBox.style.border = '1px solid #ef4444'; msgBox.style.display = 'block';
            } finally { btnSave.disabled = false; btnSave.innerHTML = '<i class="bx bx-check"></i> Simpan Perubahan'; }
        });
    }

    // ── ACCEPT Friend ───────────────────────────────────────────
    document.querySelectorAll('.btn-accept-friend').forEach(btn => {
        btn.addEventListener('click', async function() {
            const url = this.dataset.url, senderId = this.dataset.senderId, name = this.dataset.senderName, avatar = this.dataset.senderAvatar, rank = this.dataset.senderRank;
            const item = this.closest('.friend-req-item');
            this.disabled = true; this.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i>`;
            try {
                const res = await fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' }, credentials: 'same-origin' });
                const data = await res.json();
                if (res.ok && data.success) {
                    item.style.opacity = '0'; item.style.transform = 'translateX(20px)';
                    setTimeout(() => { item.remove(); const b = document.getElementById('friend-req-badge'); if (b) { const c = parseInt(b.textContent) - 1; if (c <= 0) b.style.display = 'none'; else b.textContent = c; } if (!document.querySelectorAll('.friend-req-item').length) document.getElementById('friend-requests-list').innerHTML = '<div style="text-align:center;padding:24px;color:#888;font-size:14px;">Tidak ada permintaan masuk.</div>'; }, 300);
                    const fl = document.getElementById('friends-list'); const nm = document.getElementById('no-friends-msg'); if (nm) nm.remove();
                    const el = document.createElement('div'); el.className = 'friend-item'; el.dataset.friendId = senderId;
                    el.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px;background:rgba(255,255,255,0.5);border-radius:16px;border:1px solid rgba(0,0,0,0.04);transition:all 0.3s;opacity:0;transform:translateY(-8px);';
                    el.innerHTML = `<div style="display:flex;align-items:center;gap:12px;"><img src="${avatar}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;"><div><div style="font-weight:600;font-size:14px;color:#121212;">${name}</div><div style="font-size:12px;color:#888;">${rank}</div></div></div><button class="btn-remove-friend" data-url="{{ url('/app/friend/remove') }}/${senderId}" style="padding:6px 10px;font-size:12px;background:transparent;border:1px solid rgba(0,0,0,0.1);color:#888;border-radius:10px;cursor:pointer;"><i class='bx bx-user-minus'></i> Hapus</button>`;
                    fl.appendChild(el); el.querySelector('.btn-remove-friend').addEventListener('click', handleRemove);
                    requestAnimationFrame(() => { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; });
                    const cnt = document.getElementById('friend-count'); if (cnt) cnt.textContent = parseInt(cnt.textContent) + 1;
                    toast(data.message, 'success');
                } else { this.disabled = false; this.innerHTML = `<i class='bx bx-check'></i>`; toast(data.message || 'Gagal', 'error'); }
            } catch { this.disabled = false; this.innerHTML = `<i class='bx bx-check'></i>`; toast('Kesalahan koneksi.', 'error'); }
        });
    });

    // ── REJECT Friend ───────────────────────────────────────────
    document.querySelectorAll('.btn-reject-friend').forEach(btn => {
        btn.addEventListener('click', async function() {
            const url = this.dataset.url, item = this.closest('.friend-req-item');
            this.disabled = true; this.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i>`;
            try {
                const res = await fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' }, credentials: 'same-origin' });
                const data = await res.json();
                if (res.ok && data.success) {
                    item.style.opacity = '0'; item.style.transform = 'translateX(20px)';
                    setTimeout(() => { item.remove(); const b = document.getElementById('friend-req-badge'); if (b) { const c = parseInt(b.textContent) - 1; if (c <= 0) b.style.display = 'none'; else b.textContent = c; } if (!document.querySelectorAll('.friend-req-item').length) document.getElementById('friend-requests-list').innerHTML = '<div style="text-align:center;padding:24px;color:#888;font-size:14px;">Tidak ada permintaan masuk.</div>'; }, 300);
                    toast(data.message, 'success');
                } else { this.disabled = false; this.innerHTML = `<i class='bx bx-x'></i>`; toast(data.message || 'Gagal', 'error'); }
            } catch { this.disabled = false; this.innerHTML = `<i class='bx bx-x'></i>`; toast('Kesalahan koneksi.', 'error'); }
        });
    });

    // ── REMOVE Friend ───────────────────────────────────────────
    function handleRemove() {
        const url = this.dataset.url, item = this.closest('.friend-item');
        if (!confirm('Hapus dari daftar teman?')) return;
        this.disabled = true; this.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i>`;
        fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' }, credentials: 'same-origin' })
        .then(r => r.json()).then(data => {
            if (data.success) {
                item.style.opacity = '0'; item.style.transform = 'translateX(20px)';
                setTimeout(() => { item.remove(); const cnt = document.getElementById('friend-count'); if (cnt) cnt.textContent = Math.max(0, parseInt(cnt.textContent) - 1); if (!document.querySelectorAll('.friend-item').length) document.getElementById('friends-list').innerHTML = '<div style="text-align:center;padding:24px;color:#888;font-size:14px;">Belum ada teman.</div>'; }, 300);
                toast(data.message, 'success');
            } else { this.disabled = false; this.innerHTML = `<i class='bx bx-user-minus'></i> Hapus`; toast(data.message || 'Gagal', 'error'); }
        }).catch(() => { this.disabled = false; this.innerHTML = `<i class='bx bx-user-minus'></i> Hapus`; toast('Kesalahan koneksi.', 'error'); });
    }
    document.querySelectorAll('.btn-remove-friend').forEach(btn => btn.addEventListener('click', handleRemove));
})();
</script>

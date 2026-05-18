{{-- Discussion Section — Nothing OS Dark Aesthetic --}}
<div id="discussion-section" class="nw-disc-section">
    <div class="nw-disc-header">
        <div class="nw-disc-header-left">
            <div class="nw-disc-icon"><i class='bx bx-message-square-dots'></i></div>
            <div>
                <h3>DISKUSI</h3>
                <p>Tanya jawab & komentar</p>
            </div>
        </div>
        <span class="nw-disc-count">{{ isset($discussions) ? $discussions->count() : 0 }}</span>
    </div>

    {{-- Comment Input --}}
    <div class="nw-disc-input-card">
        <div class="nw-disc-input-row">
            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/ico/' . (auth()->user()->emblem_image ?? 'default-user.jpg')) }}"
                alt="" class="nw-disc-avatar">
            <div class="nw-disc-input-wrap">
                <textarea id="discussion-input" placeholder="// tulis pertanyaan atau komentar..." rows="2"></textarea>
                <div class="nw-disc-input-actions">
                    <span class="nw-disc-hint"><i class='bx bx-info-circle'></i> Markdown didukung</span>
                    <button id="discussion-submit-btn" data-sub-materi-id="{{ $subMateri->id }}">
                        <i class='bx bx-send'></i> KIRIM
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Discussion Thread List --}}
    <div id="discussion-list" class="nw-disc-list">
        @if(isset($discussions) && $discussions->count() > 0)
            @foreach($discussions as $disc)
                <div class="disc-thread nw-disc-thread" data-id="{{ $disc->id }}">
                    {{-- Vote Column --}}
                    <div class="nw-disc-vote">
                        <button class="disc-vote-btn nw-vote-btn {{ in_array($disc->id, $myVotes ?? []) ? 'voted' : '' }}" data-url="{{ route('user.discussion.vote', $disc->id) }}">
                            <i class='bx {{ in_array($disc->id, $myVotes ?? []) ? 'bxs-up-arrow' : 'bx-up-arrow-alt' }}'></i>
                        </button>
                        <span class="disc-vote-count">{{ $disc->upvotes }}</span>
                    </div>

                    {{-- Content --}}
                    <div class="nw-disc-body">
                        <div class="nw-disc-meta">
                            <a href="?page=profile&id={{ $disc->user->id }}" class="link-spa nw-disc-author" data-page="profile&id={{ $disc->user->id }}">{{ $disc->user->name }}</a>
                            <span class="nw-disc-rank">{{ $disc->user->rank_name }}</span>
                            <span class="nw-disc-time">{{ $disc->created_at->diffForHumans() }}</span>
                            @if($disc->upvotes >= 3)
                                <span class="nw-disc-best">★ TOP</span>
                            @endif
                        </div>
                        <p class="nw-disc-text">{{ $disc->body }}</p>

                        {{-- Actions --}}
                        <div class="nw-disc-actions">
                            <button class="disc-reply-toggle nw-action-btn" data-id="{{ $disc->id }}">
                                <i class='bx bx-reply'></i> BALAS {{ $disc->replies->count() > 0 ? '(' . $disc->replies->count() . ')' : '' }}
                            </button>
                            @if($disc->user_id === auth()->id())
                                <button class="disc-delete-btn nw-action-btn nw-action-danger" data-url="{{ route('user.discussion.delete', $disc->id) }}" data-id="{{ $disc->id }}">
                                    <i class='bx bx-trash'></i> HAPUS
                                </button>
                            @endif
                        </div>

                        {{-- Replies --}}
                        @if($disc->replies->count() > 0)
                            <div class="disc-replies nw-disc-replies" data-parent="{{ $disc->id }}">
                                @foreach($disc->replies as $reply)
                                    <div class="nw-reply-item">
                                        <img src="{{ $reply->user->avatar ? asset('storage/' . $reply->user->avatar) : asset('assets/ico/' . ($reply->user->emblem_image ?? 'default-user.jpg')) }}"
                                            alt="" class="nw-reply-avatar">
                                        <div class="nw-reply-body">
                                            <div class="nw-reply-meta">
                                                <span class="nw-reply-name">{{ $reply->user->name }}</span>
                                                <span class="nw-reply-time">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p>{{ $reply->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Reply Form (hidden) --}}
                        <div class="disc-reply-form nw-reply-form" data-parent="{{ $disc->id }}" style="display: none;">
                            <div class="nw-reply-input-row">
                                <textarea class="disc-reply-input" placeholder="// balas komentar..." rows="1"></textarea>
                                <button class="disc-reply-submit nw-reply-send" data-parent-id="{{ $disc->id }}" data-sub-materi-id="{{ $subMateri->id }}">
                                    <i class='bx bx-send'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div id="discussion-empty" class="nw-disc-empty">
                <i class='bx bx-message-rounded-dots'></i>
                <h5>BELUM ADA DISKUSI</h5>
                <p>Jadilah yang pertama bertanya atau berkomentar!</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* ═══ DISCUSSION — NOTHING OS DARK ═══ */
    .nw-disc-section {
        margin-top: 48px;
        padding-top: 32px;
        border-top: 1px solid rgba(255,255,255,0.08);
    }

    .nw-disc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .nw-disc-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .nw-disc-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(234,21,21,0.1);
        border: 1px solid rgba(234,21,21,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: var(--accent-primary);
    }
    .nw-disc-header h3 {
        margin: 0;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 1px;
    }
    .nw-disc-header p {
        margin: 2px 0 0;
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
        color: #a1a1aa;
    }
    .nw-disc-count {
        font-family: 'Outfit', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #a1a1aa;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 4px 12px;
        border-radius: 9999px;
    }

    /* Input Card */
    .nw-disc-input-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .nw-disc-input-row {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }
    .nw-disc-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        margin-top: 4px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .nw-disc-input-wrap {
        flex: 1;
    }
    .nw-disc-input-wrap textarea {
        width: 100%;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        resize: vertical;
        outline: none;
        transition: border-color 0.2s;
        background: rgba(255,255,255,0.03);
        color: #eeeeee;
        box-sizing: border-box;
    }
    .nw-disc-input-wrap textarea::placeholder {
        color: #555;
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
    }
    .nw-disc-input-wrap textarea:focus {
        border-color: rgba(255,255,255,0.2);
    }
    .nw-disc-input-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }
    .nw-disc-hint {
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        color: #555;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .nw-disc-input-actions button {
        padding: 8px 18px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05);
        color: #ffffff;
        border-radius: 8px;
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .nw-disc-input-actions button:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
    }

    /* Thread List */
    .nw-disc-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Thread Item */
    .nw-disc-thread {
        display: flex;
        gap: 16px;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.06);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.2s;
    }
    .nw-disc-thread:hover {
        border-color: rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.03);
    }

    /* Vote */
    .nw-disc-vote {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2px;
        flex-shrink: 0;
        padding-top: 2px;
    }
    .nw-vote-btn {
        border: none;
        background: none;
        cursor: pointer;
        padding: 4px;
        font-size: 20px;
        color: #555;
        transition: all 0.2s;
    }
    .nw-vote-btn:hover, .nw-vote-btn.voted {
        color: #f59e0b;
    }
    .disc-vote-count {
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #a1a1aa;
    }

    /* Body */
    .nw-disc-body {
        flex: 1;
        min-width: 0;
    }
    .nw-disc-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }
    .nw-disc-author {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 700;
        color: #ffffff;
        text-decoration: none;
        transition: color 0.2s;
    }
    .nw-disc-author:hover { color: var(--accent-primary); }
    .nw-disc-rank {
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        font-weight: 700;
        color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245,158,11,0.2);
        padding: 2px 8px;
        border-radius: 4px;
    }
    .nw-disc-time {
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        color: #555;
    }
    .nw-disc-best {
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        font-weight: 700;
        color: #a6e3a1;
        background: rgba(166, 227, 161, 0.1);
        border: 1px solid rgba(166,227,161,0.2);
        padding: 2px 8px;
        border-radius: 4px;
    }
    .nw-disc-text {
        margin: 0;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #a1a1aa;
        line-height: 1.65;
        white-space: pre-wrap;
    }

    /* Actions */
    .nw-disc-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
    }
    .nw-action-btn {
        border: none;
        background: none;
        color: #555;
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 0;
        transition: color 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .nw-action-btn:hover { color: #ffffff; }
    .nw-action-danger:hover { color: var(--accent-primary); }

    /* Replies */
    .nw-disc-replies {
        margin-top: 16px;
        padding-left: 16px;
        border-left: 2px solid rgba(255,255,255,0.06);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .nw-reply-item {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    .nw-reply-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .nw-reply-body p {
        margin: 0;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #a1a1aa;
        line-height: 1.5;
        white-space: pre-wrap;
    }
    .nw-reply-meta {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }
    .nw-reply-name {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #eeeeee;
    }
    .nw-reply-time {
        font-family: 'Outfit', sans-serif;
        font-size: 10px;
        color: #555;
    }

    /* Reply Form */
    .nw-reply-form {
        margin-top: 12px;
        padding-left: 16px;
        border-left: 2px solid rgba(255,255,255,0.06);
    }
    .nw-reply-input-row {
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }
    .nw-reply-input-row textarea {
        flex: 1;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        resize: none;
        outline: none;
        background: rgba(255,255,255,0.03);
        color: #eeeeee;
        box-sizing: border-box;
        transition: border-color 0.2s;
    }
    .nw-reply-input-row textarea::placeholder {
        color: #555;
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
    }
    .nw-reply-input-row textarea:focus {
        border-color: rgba(255,255,255,0.2);
    }
    .nw-reply-send {
        padding: 10px 14px;
        border: 1px solid rgba(255,255,255,0.08);
        background: rgba(255,255,255,0.05);
        color: #ffffff;
        border-radius: 8px;
        font-size: 14px;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.2s;
    }
    .nw-reply-send:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
    }

    /* Empty State */
    .nw-disc-empty {
        text-align: center;
        padding: 48px 20px;
        background: rgba(255,255,255,0.02);
        border: 1px dashed rgba(255,255,255,0.08);
        border-radius: 16px;
    }
    .nw-disc-empty i {
        font-size: 40px;
        color: #333;
        margin-bottom: 12px;
    }
    .nw-disc-empty h5 {
        font-family: 'Outfit', sans-serif;
        color: #a1a1aa;
        margin: 0 0 4px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .nw-disc-empty p {
        font-family: 'Inter', sans-serif;
        color: #555;
        margin: 0;
        font-size: 13px;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .nw-disc-thread { padding: 16px; gap: 12px; }
        .nw-disc-input-card { padding: 16px; }
        .nw-disc-header-left { gap: 10px; }
        .nw-disc-icon { width: 36px; height: 36px; font-size: 18px; border-radius: 10px; }
        .nw-disc-header h3 { font-size: 12px; }
    }
</style>

<script>
(function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const storeUrl = @json(route('user.discussion.store'));

    // Submit new comment
    const submitBtn = document.getElementById('discussion-submit-btn');
    const inputEl = document.getElementById('discussion-input');
    if (submitBtn && inputEl) {
        submitBtn.addEventListener('click', async () => {
            const body = inputEl.value.trim();
            if (!body) return;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i> MENGIRIM...`;

            try {
                const res = await fetch(storeUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                    body: JSON.stringify({ sub_materi_id: submitBtn.dataset.subMateriId, body }),
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    inputEl.value = '';
                    document.getElementById('discussion-empty')?.remove();
                    const list = document.getElementById('discussion-list');
                    const d = data.discussion;
                    const html = `
                        <div class="disc-thread nw-disc-thread" data-id="${d.id}">
                            <div class="nw-disc-vote">
                                <button class="disc-vote-btn nw-vote-btn" style="border:none;background:none;cursor:pointer;padding:4px;font-size:20px;color:#555;">
                                    <i class='bx bx-up-arrow-alt'></i>
                                </button>
                                <span class="disc-vote-count">0</span>
                            </div>
                            <div class="nw-disc-body">
                                <div class="nw-disc-meta">
                                    <span class="nw-disc-author">${d.user.name}</span>
                                    <span class="nw-disc-rank">${d.user.rank_name}</span>
                                    <span class="nw-disc-time">${d.created_at}</span>
                                </div>
                                <p class="nw-disc-text">${d.body}</p>
                            </div>
                        </div>`;
                    list.insertAdjacentHTML('afterbegin', html);
                    if (window.showFriendToast) window.showFriendToast(data.message, 'success');
                }
            } catch (err) {
                if (window.showFriendToast) window.showFriendToast('Gagal mengirim komentar.', 'error');
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class='bx bx-send'></i> KIRIM`;
        });
    }

    // Vote
    document.querySelectorAll('.disc-vote-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const url = this.dataset.url;
            if (!url) return;
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    const countEl = this.parentElement.querySelector('.disc-vote-count');
                    if (countEl) countEl.textContent = data.upvotes;
                    const icon = this.querySelector('i');
                    if (data.voted) {
                        this.style.color = '#f59e0b';
                        this.classList.add('voted');
                        if (icon) icon.className = 'bx bxs-up-arrow';
                    } else {
                        this.style.color = '#555';
                        this.classList.remove('voted');
                        if (icon) icon.className = 'bx bx-up-arrow-alt';
                    }
                }
            } catch (err) {}
        });
    });

    // Reply toggle
    document.querySelectorAll('.disc-reply-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const form = document.querySelector(`.disc-reply-form[data-parent="${id}"]`);
            if (form) {
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        });
    });

    // Reply submit
    document.querySelectorAll('.disc-reply-submit').forEach(btn => {
        btn.addEventListener('click', async function() {
            const parentId = this.dataset.parentId;
            const subMateriId = this.dataset.subMateriId;
            const input = this.parentElement.querySelector('.disc-reply-input');
            const body = input?.value.trim();
            if (!body) return;

            try {
                const res = await fetch(storeUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    credentials: 'same-origin',
                    body: JSON.stringify({ sub_materi_id: subMateriId, parent_id: parentId, body }),
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    input.value = '';
                    const repliesContainer = document.querySelector(`.disc-replies[data-parent="${parentId}"]`);
                    const d = data.discussion;
                    const html = `
                        <div class="nw-reply-item">
                            <img src="${d.user.avatar}" alt="" class="nw-reply-avatar">
                            <div class="nw-reply-body">
                                <div class="nw-reply-meta">
                                    <span class="nw-reply-name">${d.user.name}</span>
                                    <span class="nw-reply-time">${d.created_at}</span>
                                </div>
                                <p>${d.body}</p>
                            </div>
                        </div>`;
                    if (repliesContainer) {
                        repliesContainer.insertAdjacentHTML('beforeend', html);
                    } else {
                        const thread = document.querySelector(`.disc-thread[data-id="${parentId}"] .nw-disc-body`);
                        if (thread) {
                            const newContainer = document.createElement('div');
                            newContainer.className = 'disc-replies nw-disc-replies';
                            newContainer.dataset.parent = parentId;
                            newContainer.innerHTML = html;
                            const form = thread.querySelector('.disc-reply-form');
                            thread.insertBefore(newContainer, form);
                        }
                    }
                    if (window.showFriendToast) window.showFriendToast('Balasan berhasil dikirim! 💬', 'success');
                }
            } catch (err) {
                if (window.showFriendToast) window.showFriendToast('Gagal mengirim balasan.', 'error');
            }
        });
    });

    // Delete
    document.querySelectorAll('.disc-delete-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            if (!confirm('Hapus komentar ini?')) return;
            const url = this.dataset.url;
            const id = this.dataset.id;
            try {
                const res = await fetch(url, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    credentials: 'same-origin',
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    document.querySelector(`.disc-thread[data-id="${id}"]`)?.remove();
                    if (window.showFriendToast) window.showFriendToast(data.message, 'success');
                }
            } catch (err) {}
        });
    });
})();
</script>

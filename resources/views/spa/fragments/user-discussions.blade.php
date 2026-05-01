{{-- Discussion Section for SubMateri Detail Page --}}
<div id="discussion-section" style="margin-top: 48px; padding-top: 32px; border-top: 1px solid rgba(0,0,0,0.06);">
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
        <i class='bx bx-chat' style="font-size: 22px; color: #555;"></i>
        <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #121212;">Diskusi & Tanya Jawab</h3>
        <span style="font-size: 12px; font-weight: 600; color: #888; background: rgba(0,0,0,0.05); padding: 2px 10px; border-radius: 8px;">{{ isset($discussions) ? $discussions->count() : 0 }}</span>
    </div>

    {{-- Comment Input --}}
    <div class="neo-card neo-card-light" style="padding: 16px 20px; margin-bottom: 24px; border-radius: 14px;">
        <div style="display: flex; gap: 12px; align-items: flex-start;">
            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('assets/ico/' . (auth()->user()->emblem_image ?? 'default-user.jpg')) }}"
                alt="" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; flex-shrink: 0; margin-top: 4px;">
            <div style="flex: 1;">
                <textarea id="discussion-input" placeholder="Tulis pertanyaan atau komentar..." rows="2"
                    style="width: 100%; border: 1px solid rgba(0,0,0,0.1); border-radius: 10px; padding: 10px 14px; font-size: 14px; font-family: 'Inter', sans-serif; resize: vertical; outline: none; transition: border-color 0.2s; background: rgba(0,0,0,0.02); box-sizing: border-box;"
                    onfocus="this.style.borderColor='#555'" onblur="this.style.borderColor='rgba(0,0,0,0.1)'"></textarea>
                <div style="display: flex; justify-content: flex-end; margin-top: 8px;">
                    <button id="discussion-submit-btn" data-sub-materi-id="{{ $subMateri->id }}"
                        style="padding: 8px 18px; border: none; background: #121212; color: #fff; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.2s;"
                        onmouseover="this.style.background='#333'" onmouseout="this.style.background='#121212'">
                        <i class='bx bx-send'></i> Kirim
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Discussion Thread List --}}
    <div id="discussion-list" style="display: flex; flex-direction: column; gap: 12px;">
        @if(isset($discussions) && $discussions->count() > 0)
            @foreach($discussions as $disc)
                <div class="disc-thread" data-id="{{ $disc->id }}">
                    <div class="neo-card neo-card-light" style="padding: 16px 20px; border-radius: 14px;">
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            {{-- Upvote --}}
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 2px; flex-shrink: 0; margin-top: 2px;">
                                <button class="disc-vote-btn" data-url="{{ route('user.discussion.vote', $disc->id) }}"
                                    style="border: none; background: none; cursor: pointer; padding: 4px; font-size: 18px; color: {{ in_array($disc->id, $myVotes ?? []) ? '#f59e0b' : '#ccc' }}; transition: color 0.2s;"
                                    onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='{{ in_array($disc->id, $myVotes ?? []) ? '#f59e0b' : '#ccc' }}'">
                                    <i class='bx {{ in_array($disc->id, $myVotes ?? []) ? 'bxs-up-arrow' : 'bx-up-arrow-alt' }}'></i>
                                </button>
                                <span class="disc-vote-count" style="font-size: 13px; font-weight: 700; color: #555;">{{ $disc->upvotes }}</span>
                            </div>

                            {{-- Content --}}
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                                    <a href="?page=profile&id={{ $disc->user->id }}" class="link-spa" data-page="profile&id={{ $disc->user->id }}"
                                        style="font-size: 14px; font-weight: 700; color: #121212; text-decoration: none;">{{ $disc->user->name }}</a>
                                    <span style="font-size: 11px; font-weight: 600; color: #f59e0b; background: rgba(245, 158, 11, 0.1); padding: 1px 6px; border-radius: 4px;">{{ $disc->user->rank_name }}</span>
                                    <span style="font-size: 11px; color: #aaa;">&bull; {{ $disc->created_at->diffForHumans() }}</span>
                                    @if($disc->upvotes >= 3)
                                        <span style="font-size: 10px; font-weight: 700; color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 1px 6px; border-radius: 4px;">⭐ Jawaban Terbaik</span>
                                    @endif
                                </div>
                                <p style="margin: 0; font-size: 14px; color: #333; line-height: 1.6; white-space: pre-wrap;">{{ $disc->body }}</p>

                                {{-- Actions --}}
                                <div style="display: flex; align-items: center; gap: 12px; margin-top: 10px;">
                                    <button class="disc-reply-toggle" data-id="{{ $disc->id }}" style="border: none; background: none; color: #888; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; padding: 0; transition: color 0.2s;"
                                        onmouseover="this.style.color='#555'" onmouseout="this.style.color='#888'">
                                        <i class='bx bx-reply'></i> Balas {{ $disc->replies->count() > 0 ? '(' . $disc->replies->count() . ')' : '' }}
                                    </button>
                                    @if($disc->user_id === auth()->id())
                                        <button class="disc-delete-btn" data-url="{{ route('user.discussion.delete', $disc->id) }}" data-id="{{ $disc->id }}" style="border: none; background: none; color: #ccc; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; padding: 0; transition: color 0.2s;"
                                            onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#ccc'">
                                            <i class='bx bx-trash'></i> Hapus
                                        </button>
                                    @endif
                                </div>

                                {{-- Replies --}}
                                @if($disc->replies->count() > 0)
                                    <div class="disc-replies" data-parent="{{ $disc->id }}" style="margin-top: 12px; padding-left: 16px; border-left: 2px solid rgba(0,0,0,0.06); display: flex; flex-direction: column; gap: 10px;">
                                        @foreach($disc->replies as $reply)
                                            <div style="display: flex; gap: 10px; align-items: flex-start;">
                                                <img src="{{ $reply->user->avatar ? asset('storage/' . $reply->user->avatar) : asset('assets/ico/' . ($reply->user->emblem_image ?? 'default-user.jpg')) }}"
                                                    alt="" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                                                <div>
                                                    <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                                                        <span style="font-size: 13px; font-weight: 700; color: #333;">{{ $reply->user->name }}</span>
                                                        <span style="font-size: 10px; color: #aaa;">&bull; {{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p style="margin: 0; font-size: 13px; color: #555; line-height: 1.5; white-space: pre-wrap;">{{ $reply->body }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Reply Form (hidden by default) --}}
                                <div class="disc-reply-form" data-parent="{{ $disc->id }}" style="display: none; margin-top: 10px; padding-left: 16px; border-left: 2px solid rgba(0,0,0,0.06);">
                                    <div style="display: flex; gap: 8px; align-items: flex-start;">
                                        <textarea class="disc-reply-input" placeholder="Tulis balasan..." rows="1"
                                            style="flex: 1; border: 1px solid rgba(0,0,0,0.1); border-radius: 8px; padding: 8px 12px; font-size: 13px; font-family: 'Inter', sans-serif; resize: none; outline: none; background: rgba(0,0,0,0.02); box-sizing: border-box;"
                                            onfocus="this.style.borderColor='#555'" onblur="this.style.borderColor='rgba(0,0,0,0.1)'"></textarea>
                                        <button class="disc-reply-submit" data-parent-id="{{ $disc->id }}" data-sub-materi-id="{{ $subMateri->id }}"
                                            style="padding: 8px 14px; border: none; background: #121212; color: #fff; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; flex-shrink: 0; transition: all 0.2s;">
                                            <i class='bx bx-send'></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div id="discussion-empty" class="neo-card neo-card-light" style="text-align: center; padding: 40px 20px; border-radius: 14px;">
                <i class='bx bx-message-rounded-dots' style="font-size: 40px; color: #ccc; margin-bottom: 8px;"></i>
                <h5 style="color: #888; margin: 0 0 4px 0; font-size: 15px; font-weight: 600;">Belum ada diskusi</h5>
                <p style="color: #aaa; margin: 0; font-size: 13px;">Jadilah yang pertama bertanya atau berkomentar!</p>
            </div>
        @endif
    </div>
</div>

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
            submitBtn.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i> Mengirim...`;

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
                    // Remove empty state
                    document.getElementById('discussion-empty')?.remove();
                    // Prepend new comment
                    const list = document.getElementById('discussion-list');
                    const d = data.discussion;
                    const html = `
                        <div class="disc-thread" data-id="${d.id}">
                            <div class="neo-card neo-card-light" style="padding: 16px 20px; border-radius: 14px;">
                                <div style="display: flex; gap: 12px; align-items: flex-start;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 2px; flex-shrink: 0; margin-top: 2px;">
                                        <button class="disc-vote-btn" style="border: none; background: none; cursor: pointer; padding: 4px; font-size: 18px; color: #ccc;">
                                            <i class='bx bx-up-arrow-alt'></i>
                                        </button>
                                        <span class="disc-vote-count" style="font-size: 13px; font-weight: 700; color: #555;">0</span>
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                            <span style="font-size: 14px; font-weight: 700; color: #121212;">${d.user.name}</span>
                                            <span style="font-size: 11px; font-weight: 600; color: #f59e0b; background: rgba(245, 158, 11, 0.1); padding: 1px 6px; border-radius: 4px;">${d.user.rank_name}</span>
                                            <span style="font-size: 11px; color: #aaa;">&bull; ${d.created_at}</span>
                                        </div>
                                        <p style="margin: 0; font-size: 14px; color: #333; line-height: 1.6; white-space: pre-wrap;">${d.body}</p>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    list.insertAdjacentHTML('afterbegin', html);
                    if (window.showFriendToast) window.showFriendToast(data.message, 'success');
                }
            } catch (err) {
                if (window.showFriendToast) window.showFriendToast('Gagal mengirim komentar.', 'error');
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class='bx bx-send'></i> Kirim`;
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
                        if (icon) icon.className = 'bx bxs-up-arrow';
                    } else {
                        this.style.color = '#ccc';
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
                        <div style="display: flex; gap: 10px; align-items: flex-start;">
                            <img src="${d.user.avatar}" alt="" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                                    <span style="font-size: 13px; font-weight: 700; color: #333;">${d.user.name}</span>
                                    <span style="font-size: 10px; color: #aaa;">&bull; ${d.created_at}</span>
                                </div>
                                <p style="margin: 0; font-size: 13px; color: #555; line-height: 1.5; white-space: pre-wrap;">${d.body}</p>
                            </div>
                        </div>`;
                    if (repliesContainer) {
                        repliesContainer.insertAdjacentHTML('beforeend', html);
                    } else {
                        const thread = document.querySelector(`.disc-thread[data-id="${parentId}"] .neo-card > div > div:nth-child(2)`);
                        if (thread) {
                            const newContainer = document.createElement('div');
                            newContainer.className = 'disc-replies';
                            newContainer.dataset.parent = parentId;
                            newContainer.style.cssText = 'margin-top: 12px; padding-left: 16px; border-left: 2px solid rgba(0,0,0,0.06); display: flex; flex-direction: column; gap: 10px;';
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

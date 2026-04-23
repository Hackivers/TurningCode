<div style="margin-top: 48px; margin-bottom: 32px;">
    <h3 class="neo-title" style="font-size: 28px; margin: 0 0 8px 0; color: #121212;">Peringkat Teratas</h3>
    <p style="font-size: 16px; color: #555; margin: 0;">Lihat siapa saja yang paling rajin belajar minggu ini.</p>
</div>

@if (isset($topUsers) && $topUsers->count())
    <div class="neo-card neo-card-light">
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach ($topUsers as $i => $u)
                <div class="leaderboard-row"
                    style="display: flex; align-items: center; gap: 20px; padding: 20px 24px; position: relative; background: rgba(255,255,255,0.5); border-radius: 24px; {{ $i === 0 ? 'border: 2px solid rgba(245, 158, 11, 0.6); box-shadow: 0 8px 24px rgba(245, 158, 11, 0.15);' : 'border: 1px solid rgba(255,255,255,0.2);' }}">

                    @if ($i === 0)
                        <div style="position: absolute; top: -14px; left: 12px; font-size: 28px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.15)); z-index: 2; transform: rotate(-15deg);">
                            👑
                        </div>
                    @endif

                    <!-- Rank Number -->
                    <div style="width: 30px; text-align: center; font-size: 18px; font-weight: 800; color: {{ $i === 0 ? '#f59e0b' : ($i === 1 ? '#64748b' : ($i === 2 ? '#b45309' : '#888')) }};">
                        #{{ $loop->iteration }}
                    </div>

                    <!-- Avatar -->
                    <div style="position: relative;">
                        <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}">
                            <img src="{{ $u->avatar ? asset('storage/' . $u->avatar) : asset('assets/ico/' . ($u->emblem_image ?? 'default-user.jpg')) }}"
                                alt="{{ $u->name }}"
                                style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05); {{ $i === 0 ? 'border: 2px solid #f59e0b;' : '' }}; transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </a>
                    </div>

                    <!-- Info -->
                    <div style="width: 25%; min-width: 150px; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
                        <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}" style="text-decoration:none; color:inherit;">
                            <h4 class="{{ $u->isPenguasaSektor() ? 'sovereign-name-leaderboard' : ($u->isElite() ? 'elite-name-leaderboard' : '') }}" style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: #121212; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                @if($u->isPenguasaSektor())
                                    <i class='bx bxs-crown' style="color:#fbbf24; margin-right:2px; font-size: 14px;"></i>
                                @endif
                                {{ $u->name }}
                            </h4>
                        </a>
                        <div style="font-size: 13px; color: #555; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                            <span style="color: #f59e0b; font-size: 14px;"><i class='bx bxs-star'></i></span>
                            {{ $u->rank_name ?? 'Beginner' }}
                        </div>
                    </div>

                    <!-- Achievements -->
                    <div style="flex: 1; display: flex; align-items: center;">
                        @if (isset($u->achievements) && is_array($u->achievements) && count($u->achievements) > 0)
                            <div style="display: flex; gap: 10px; align-items: center;">
                                @foreach ($u->achievements as $ach)
                                    <div style="position: relative;" class="ach-badge-wrap">
                                        <img src="{{ asset('assets/ico/' . $ach['icon']) }}" alt="{{ $ach['label'] }}"
                                            title="{{ $ach['label'] }}: {{ $ach['desc'] }}"
                                            style="width: 30px; height: 30px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1)); cursor: help; transition: transform 0.2s;"
                                            onmouseover="this.style.transform='scale(1.2)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="font-size: 12px; color: #a1a1aa; font-style: italic; letter-spacing: 0.5px;">Belum memiliki lencana</div>
                        @endif
                    </div>

                    <!-- Add Friend Action (AJAX — no page reload) -->
                    @if ($u->id !== auth()->id() && isset($myFriendships))
                        @php
                            $friendship = $myFriendships->where('user_id', $u->id)->where('friend_id', auth()->id())->first()
                                        ?? $myFriendships->where('friend_id', $u->id)->where('user_id', auth()->id())->first();
                            $fStatus = $friendship ? $friendship->status : null;
                        @endphp
                        <div style="margin-right: 16px;">
                            @if (!$friendship)
                                <button
                                    class="ldb-friend-btn"
                                    data-url="{{ route('user.friend.add', $u->id) }}"
                                    style="padding: 6px 12px; font-size: 12px; background: #fff; border: 1px solid #ddd; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                    <i class='bx bx-user-plus'></i> Add
                                </button>
                            @elseif ($fStatus === 'pending')
                                <button disabled
                                    style="padding: 6px 12px; font-size: 12px; background: #f1f5f9; border: 1px solid #ddd; color: #64748b; border-radius: 8px; display: flex; align-items: center; gap: 4px; cursor: not-allowed;">
                                    <i class='bx bx-time'></i> Pending
                                </button>
                            @elseif ($fStatus === 'accepted')
                                <button disabled
                                    style="padding: 6px 12px; font-size: 12px; background: #ecfdf5; border: 1px solid #10b981; color: #10b981; border-radius: 8px; display: flex; align-items: center; gap: 4px; cursor: default;">
                                    <i class='bx bx-check'></i> Friends
                                </button>
                            @endif
                        </div>
                    @endif

                    <!-- EXP -->
                    <div style="text-align: right;">
                        <div style="font-size: 18px; font-weight: 800; color: #121212;">{{ number_format($u->exp) }}</div>
                        <div style="font-size: 11px; color: #888; font-weight: 600; letter-spacing: 0.5px;">EXP</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="neo-card neo-card-light" style="text-align:center; padding: 40px 20px;">
        <i class='bx bx-trophy' style="font-size: 48px; color: #aaa; margin-bottom: 12px;"></i>
        <h5 style="color: #666; font-size: 15px; font-weight: 500; margin: 0;">Belum ada data peringkat.</h5>
    </div>
@endif

<!-- Global Toast Container (shared by leaderboard & account page) -->
<div id="friend-toast-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;"></div>

<style>
    .leaderboard-row { transition: background-color 0.2s; }
    .leaderboard-row:hover { background-color: rgba(0, 0, 0, 0.015); }

    .ldb-friend-btn { transition: all 0.2s; }

    /* Toast */
    .friend-toast {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        color: #fff;
        box-shadow: 0 8px 24px rgba(0,0,0,0.18);
        pointer-events: auto;
        animation: friendSlideIn 0.3s cubic-bezier(0.16,1,0.3,1);
        min-width: 220px;
    }
    .friend-toast.success { background: #10b981; }
    .friend-toast.error   { background: #ef4444; }
    .friend-toast.fade-out { opacity: 0; transition: opacity 0.4s; }

    @keyframes friendSlideIn {
        from { transform: translateY(20px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }

    .elite-name-leaderboard {
        background: linear-gradient(135deg, #8b5cf6, #ec4899) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        font-weight: 800 !important;
    }

    .sovereign-name-leaderboard {
        background: linear-gradient(135deg, #fbbf24, #d946ef) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        font-weight: 900 !important;
        letter-spacing: -0.2px;
    }
</style>

<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // ── Global toast helper (window-level so account page can reuse it) ─
    window.showFriendToast = function (msg, type = 'success') {
        const container = document.getElementById('friend-toast-container');
        if (!container) return;
        const toast = document.createElement('div');
        toast.className = `friend-toast ${type}`;
        const icon = type === 'success' ? 'bx-check-circle' : 'bx-error-circle';
        toast.innerHTML = `<i class='bx ${icon}'></i> <span>${msg}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.classList.add('fade-out'), 3000);
        setTimeout(() => toast.remove(), 3500);
    };

    // ── Add Friend (AJAX) ─────────────────────────────────────────────
    document.querySelectorAll('.ldb-friend-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            const url = this.dataset.url;
            if (!url) return;

            // Optimistic: disable & show spinner
            this.disabled = true;
            this.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i> Mengirim...`;
            this.style.cursor = 'not-allowed';

            try {
                const res  = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    credentials: 'same-origin',
                });
                const data = await res.json();

                if (res.ok && data.success) {
                    // Transition button → Pending state
                    this.innerHTML             = `<i class='bx bx-time'></i> Pending`;
                    this.style.background      = '#f1f5f9';
                    this.style.border          = '1px solid #ddd';
                    this.style.color           = '#64748b';
                    this.style.cursor          = 'not-allowed';
                    this.disabled              = true;
                    window.showFriendToast(data.message, 'success');
                } else {
                    // Revert on error
                    this.innerHTML        = `<i class='bx bx-user-plus'></i> Add`;
                    this.style.background = '#fff';
                    this.style.color      = '';
                    this.style.cursor     = 'pointer';
                    this.disabled         = false;
                    window.showFriendToast(data.message || 'Gagal mengirim permintaan.', 'error');
                }
            } catch (err) {
                this.innerHTML        = `<i class='bx bx-user-plus'></i> Add`;
                this.style.background = '#fff';
                this.style.color      = '';
                this.style.cursor     = 'pointer';
                this.disabled         = false;
                window.showFriendToast('Terjadi kesalahan koneksi. Coba lagi.', 'error');
            }
        });
    });
})();
</script>
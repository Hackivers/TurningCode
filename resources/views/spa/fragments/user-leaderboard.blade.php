<div style="margin-top: 48px; margin-bottom: 32px;">
    <h3 class="neo-title" style="font-size: 28px; margin: 0 0 8px 0; color: #121212;">Peringkat Teratas</h3>
    <p style="font-size: 16px; color: #555; margin: 0;">Lihat siapa saja yang paling rajin belajar minggu ini.</p>
</div>

@if (isset($topUsers) && $topUsers->count())
    <div class="neo-card neo-card-light">
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach ($topUsers as $i => $u)
                <div class="leaderboard-row {{ $u->isPenguasaSektor() ? 'leaderboard-row-sovereign' : '' }}"
                    style="display: flex; align-items: center; gap: 20px; padding: 20px 24px; position: relative; border-radius: 24px; {{ $u->isPenguasaSektor() ? '' : ($i === 0 ? 'background: rgba(255,255,255,0.5); border: 2px solid rgba(245, 158, 11, 0.6); box-shadow: 0 8px 24px rgba(245, 158, 11, 0.15);' : 'background: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.2);') }}">

                    @if ($i === 0)
                        <div
                            style="position: absolute; top: -14px; left: 12px; font-size: 28px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.15)); z-index: 2; transform: rotate(-15deg);">
                            👑
                        </div>
                    @endif

                    <!-- Rank Number -->
                    <div
                        style="width: 30px; text-align: center; font-size: 18px; font-weight: 800; color: {{ $i === 0 ? '#f59e0b' : ($i === 1 ? '#64748b' : ($i === 2 ? '#b45309' : '#888')) }};">
                        #{{ $loop->iteration }}
                    </div>

                    <!-- Avatar -->
                    <div class="ldb-col-avatar" style="position: relative;">
                        <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}">
                            <img src="{{ $u->avatar ? asset('storage/' . $u->avatar) : asset('assets/ico/' . ($u->emblem_image ?? 'default-user.jpg')) }}"
                                alt="{{ $u->name }}"
                                style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05); {{ $i === 0 ? 'border: 2px solid #f59e0b;' : '' }}; transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </a>
                    </div>

                    <!-- Info -->
                    <div class="ldb-col-info"
                        style="width: 25%; min-width: 150px; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
                        <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}"
                            style="text-decoration:none; color:inherit;">
                            <h4 class="{{ $u->isPenguasaSektor() ? 'sovereign-name-leaderboard' : ($u->isElite() ? 'elite-name-leaderboard' : '') }}"
                                style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: #121212; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                @if($u->isPenguasaSektor())
                                    <i class='bx bxs-crown' style="color:#fbbf24; margin-right:2px; font-size: 14px;"></i>
                                @endif
                                {{ $u->name }}
                            </h4>
                        </a>
                        <div style="font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px;"
                            class="{{ $u->isPenguasaSektor() ? 'sovereign-text-muted' : '' }}">
                            <span style="color: #f59e0b; font-size: 14px;"><i class='bx bxs-star'></i></span>
                            {{ $u->rank_name ?? 'Beginner' }}
                        </div>
                    </div>

                    <!-- Achievements -->
                    <div class="ldb-col-achievements" style="flex: 1; display: flex; align-items: center;">
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
                            <div style="font-size: 12px; color: #a1a1aa; font-style: italic; letter-spacing: 0.5px;">Belum memiliki
                                lencana</div>
                        @endif
                    </div>

                    <!-- Add Friend Action (AJAX — no page reload) -->
                    @if ($u->id !== auth()->id() && isset($myFriendships))
                        @php
                            $friendship = $myFriendships->where('user_id', $u->id)->where('friend_id', auth()->id())->first()
                                ?? $myFriendships->where('friend_id', $u->id)->where('user_id', auth()->id())->first();
                            $fStatus = $friendship ? $friendship->status : null;
                        @endphp
                        <div class="ldb-col-action" style="margin-right: 16px;">
                            @if (!$friendship)
                                <button class="ldb-btn ldb-btn-add ldb-friend-btn" data-url="{{ route('user.friend.add', $u->id) }}">
                                    <i class='bx bx-user-plus'></i> Add
                                </button>
                            @elseif ($fStatus === 'pending')
                                <button disabled class="ldb-btn ldb-btn-pending">
                                    <i class='bx bx-time'></i> Pending
                                </button>
                            @elseif ($fStatus === 'accepted')
                                <button disabled class="ldb-btn ldb-btn-friends">
                                    <i class='bx bx-check'></i> Friends
                                </button>
                            @endif
                        </div>
                    @endif

                    <!-- EXP -->
                    <div class="ldb-col-exp" style="text-align: right;">
                        <div style="font-size: 18px; font-weight: 800;"
                            class="{{ $u->isPenguasaSektor() ? 'sovereign-text-light' : '' }}">{{ number_format($u->exp) }}
                        </div>
                        <div style="font-size: 11px; font-weight: 600; letter-spacing: 0.5px;"
                            class="{{ $u->isPenguasaSektor() ? 'sovereign-text-muted' : '' }}">EXP</div>
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
<div id="friend-toast-container"
    style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;">
</div>

<style>
    .leaderboard-row {
        transition: background-color 0.2s;
    }

    .leaderboard-row:hover {
        background-color: rgba(0, 0, 0, 0.015);
    }

    .ldb-friend-btn {
        transition: all 0.2s;
    }

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
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
        pointer-events: auto;
        animation: friendSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        min-width: 220px;
    }

    .friend-toast.success {
        background: #10b981;
    }

    .friend-toast.error {
        background: #ef4444;
    }

    .friend-toast.fade-out {
        opacity: 0;
        transition: opacity 0.4s;
    }

    @keyframes friendSlideIn {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
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

    /* Leaderboard Buttons */
    .ldb-btn {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .ldb-btn-add {
        background: #fff;
        border: 1px solid #ddd;
        color: #121212;
        cursor: pointer;
    }

    .ldb-btn-add:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .ldb-btn-pending {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #64748b;
        cursor: not-allowed;
    }

    .ldb-btn-friends {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #10b981;
        cursor: default;
    }

    /* Sovereign Tier Button Colors */
    .leaderboard-row-sovereign .ldb-btn-add {
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(251, 191, 36, 0.4) !important;
        color: #fbbf24 !important;
        backdrop-filter: blur(4px);
    }

    .leaderboard-row-sovereign .ldb-btn-add:hover {
        background: rgba(251, 191, 36, 0.15) !important;
        border-color: rgba(251, 191, 36, 0.8) !important;
        color: #fff !important;
        box-shadow: 0 0 12px rgba(251, 191, 36, 0.25);
    }

    .leaderboard-row-sovereign .ldb-btn-pending {
        background: rgba(255, 255, 255, 0.04) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #a1a1aa !important;
    }

    .leaderboard-row-sovereign .ldb-btn-friends {
        background: rgba(16, 185, 129, 0.1) !important;
        border: 1px solid rgba(16, 185, 129, 0.3) !important;
        color: #34d399 !important;
    }

    /* Sovereign Row Special Styling */
    .leaderboard-row-sovereign {
        background: linear-gradient(135deg, #1f1f1f, #121212) !important;
        border: none !important;
        box-shadow: 0 12px 32px rgba(251, 191, 36, 0.2) !important;
    }

    .leaderboard-row-sovereign::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 24px;
        padding: 2px;
        background: linear-gradient(135deg, #fbbf24, #d946ef, #fbbf24);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        animation: sovereignBorderRotate 4s linear infinite;
    }

    .leaderboard-row-sovereign .sovereign-text-light {
        color: #fff !important;
    }

    .leaderboard-row-sovereign .sovereign-text-muted {
        color: #a1a1aa !important;
    }

    @keyframes sovereignBorderRotate {
        0% {
            filter: hue-rotate(0deg);
        }

        100% {
            filter: hue-rotate(360deg);
        }
    }

    /* ═══ MOBILE RESPONSIVENESS ═══ */
    @media (max-width: 768px) {
        .leaderboard-row {
            display: grid !important;
            grid-template-columns: auto 1fr;
            grid-template-areas:
                "avatar info"
                "achievements achievements"
                "action action";
            align-items: center !important;
            gap: 4px 10px !important;
            padding: 10px 12px !important;
            border-radius: 25px !important;
        }

        .ldb-col-rank {
            position: absolute;
            top: 10px;
            right: 12px;
            width: auto !important;
            z-index: 2;
            font-size: 13px !important;
        }

        .ldb-col-avatar {
            grid-area: avatar;
            margin-bottom: 0 !important;
        }

        .ldb-col-avatar img {
            width: 38px !important;
            height: 38px !important;
        }

        .ldb-col-info {
            grid-area: info;
            width: 100% !important;
            min-width: 0 !important;
            margin-right: 32px;
            /* Space for rank */
        }

        .ldb-col-info h4 {
            font-size: 13px !important;
            margin-bottom: 0 !important;
        }

        .ldb-col-info>div {
            font-size: 10px !important;
        }

        .ldb-col-achievements {
            grid-area: achievements;
            flex: none !important;
            width: 100% !important;
            margin-top: 2px !important;
        }

        .ldb-col-achievements img {
            width: 20px !important;
            height: 20px !important;
        }

        .ldb-col-action {
            grid-area: action;
            width: auto !important;
            margin-right: 0 !important;
            margin-top: 0 !important;
        }

        .ldb-btn {
            padding: 4px 8px !important;
            font-size: 10px !important;
            width: fit-content;
        }

        .ldb-col-exp {
            position: absolute;
            bottom: 10px;
            right: 12px;
            text-align: right !important;
        }

        .ldb-col-exp div:first-child {
            font-size: 14px !important;
        }

        .ldb-col-exp div:last-child {
            font-size: 9px !important;
        }

        /* Adjust crown size for top user */
        .leaderboard-row>div:first-child[style*="rotate"] {
            font-size: 16px !important;
            top: -6px !important;
            left: 6px !important;
        }
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
                    const res = await fetch(url, {
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
                        this.innerHTML = `<i class='bx bx-time'></i> Pending`;
                        this.style.background = '#f1f5f9';
                        this.style.border = '1px solid #ddd';
                        this.style.color = '#64748b';
                        this.style.cursor = 'not-allowed';
                        this.disabled = true;
                        window.showFriendToast(data.message, 'success');
                    } else {
                        // Revert on error
                        this.innerHTML = `<i class='bx bx-user-plus'></i> Add`;
                        this.style.background = '#fff';
                        this.style.color = '';
                        this.style.cursor = 'pointer';
                        this.disabled = false;
                        window.showFriendToast(data.message || 'Gagal mengirim permintaan.', 'error');
                    }
                } catch (err) {
                    this.innerHTML = `<i class='bx bx-user-plus'></i> Add`;
                    this.style.background = '#fff';
                    this.style.color = '';
                    this.style.cursor = 'pointer';
                    this.disabled = false;
                    window.showFriendToast('Terjadi kesalahan koneksi. Coba lagi.', 'error');
                }
            });
        });
    })();
</script>
<div style="margin-top: 48px; margin-bottom: 32px;">
    <div
        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <div style="width: 6px; height: 6px; background: #d71921; border-radius: 50%;"></div>
                <div
                    style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--text-muted);">
                    RANKINGS</div>
            </div>
            <h3
                style="font-size: 24px; font-weight: 800; margin: 0; color: var(--text-primary); letter-spacing: -0.5px; font-family: 'Space Mono', monospace; text-transform: uppercase;">
                Peringkat Teratas</h3>
        </div>

        <!-- Tab Filter — Nothing OS pill segmented -->
        <div style="display: flex; border: 1px solid var(--border-color); border-radius: 9999px; overflow: hidden;">
            <button class="ldb-tab active" data-tab="global" onclick="switchLeaderboardTab('global')"
                style="padding: 8px 20px; border: none; background: var(--border-color); color: var(--text-primary); font-size: 11px; font-weight: 700; cursor: pointer; transition: all 0.15s; text-transform: uppercase; letter-spacing: 1px; font-family: var(--nothing-dot-font, 'DotGothic16', monospace);">
                Global
            </button>
            <button class="ldb-tab" data-tab="friends" onclick="switchLeaderboardTab('friends')"
                style="padding: 8px 20px; border: none; border-left: 1px solid var(--border-color); background: transparent; color: var(--text-muted); font-size: 11px; font-weight: 700; cursor: pointer; transition: all 0.15s; text-transform: uppercase; letter-spacing: 1px; font-family: var(--nothing-dot-font, 'DotGothic16', monospace);">
                Teman
            </button>
        </div>
    </div>
</div>

{{-- Friend Leaderboard Data (hidden, for JS) --}}
@if(isset($friendUsers) && $friendUsers->count() > 0)
    @php
        $friendDataJson = json_encode($friendUsers->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'rank_name' => $u->rank_name,
                'exp' => $u->exp,
                'avatar' => $u->avatar ? asset('storage/' . $u->avatar) : asset('assets/ico/' . ($u->emblem_image ?? 'default-user.jpg')),
            ];
        })->values());
    @endphp
    <div id="ldb-friends-data" style="display: none;" data-friends='{!! $friendDataJson !!}'></div>
@endif

{{-- Friend Leaderboard Container (hidden by default) --}}
<div id="ldb-friends-container" style="display: none;">
    @if(isset($friendUsers) && $friendUsers->count() > 0)
        <div
            style="padding: 0; overflow: hidden; border-radius: 16px; border: 1px solid var(--border-color); background: var(--bg-secondary);">
            @foreach($friendUsers as $i => $u)
                <div class="nothing-ldb-row"
                    style="display: flex; align-items: center; gap: 16px; padding: 16px 20px; {{ $i > 0 ? 'border-top: 1px solid rgba(0,0,0,0.06);' : '' }} {{ $i === 0 ? 'background: var(--bg-primary); color: var(--text-primary);' : '' }}">
                    <!-- Rank -->
                    <div
                        style="width: 28px; text-align: center; font-family: var(--nothing-dot-font); font-size: 18px; font-weight: 400; color: {{ $i === 0 ? '#fff' : '#aaa' }};">
                        {{ $loop->iteration }}</div>
                    <!-- Avatar -->
                    <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}">
                        <img src="{{ $u->avatar ? asset('storage/' . $u->avatar) : asset('assets/ico/' . ($u->emblem_image ?? 'default-user.jpg')) }}"
                            alt="{{ $u->name }}"
                            style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; {{ $i === 0 ? 'border: 2px solid var(--text-primary);' : 'border: 1px solid rgba(0,0,0,0.08);' }}">
                    </a>
                    <!-- Info -->
                    <div class="ldb-col-info" style="flex: 1; min-width: 0;">
                        <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}"
                            style="text-decoration:none; color:inherit;">
                            <h4
                                style="margin: 0 0 2px 0; font-size: 14px; font-weight: 700; color: {{ $i === 0 ? '#fff' : '#000' }}; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                {{ $u->name }}</h4>
                        </a>
                        <div
                            style="font-size: 11px; font-weight: 600; color: {{ $i === 0 ? 'var(--text-muted)' : '#888' }}; text-transform: uppercase; letter-spacing: 0.5px;">
                            {{ $u->rank_name ?? 'Beginner' }}</div>
                    </div>
                    <!-- EXP -->
                    <div class="ldb-col-exp" style="text-align: right;">
                        <div
                            style="font-family: var(--nothing-dot-font); font-size: 16px; font-weight: 400; color: {{ $i === 0 ? '#fff' : '#f7f7f7ff' }};">
                            {{ number_format($u->exp) }}</div>
                        <div
                            style="font-size: 9px; font-weight: 700; letter-spacing: 1px; color: {{ $i === 0 ? 'var(--text-muted)' : '#aaa' }}; text-transform: uppercase;">
                            EXP</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div
            style="text-align:center; padding: 40px 20px; border-radius: 16px; border: 1px solid var(--border-color); background: var(--bg-secondary);">
            <div
                style="width: 48px; height: 48px; border: 1px solid rgba(0,0,0,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class='bx bx-group' style="font-size: 24px; color: var(--text-muted);"></i>
            </div>
            <h5
                style="color: var(--text-muted); font-size: 13px; font-weight: 600; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                Belum ada teman</h5>
        </div>
    @endif
</div>

{{-- Global Leaderboard Container --}}
<div id="ldb-global-container">

    @if (isset($topUsers) && $topUsers->count())
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach ($topUsers as $i => $u)
                @php
                    $isTop = $i === 0;
                    $isSov = $u->isPenguasaSektor();
                    $isDark = $isTop || $isSov;
                @endphp
                <div class="nothing-ldb-card {{ $isSov ? 'nothing-ldb-sovereign' : '' }} {{ $isTop ? 'nothing-ldb-first' : '' }}"
                    style="display: flex; align-items: center; gap: 16px; padding: 20px 24px; position: relative;
                        background: {{ $isTop || $isSov ? 'var(--bg-tertiary)' : 'var(--bg-secondary)' }};
                        border: 2px solid {{ $isSov ? '#d71921' : ($isTop ? 'var(--text-primary)' : 'var(--border-color)') }};
                        border-radius: 16px;
                        box-shadow: 4px 4px 0px rgba(0,0,0,0.05);
                        transition: transform 0.2s, box-shadow 0.2s;">

                    @if ($isTop)
                        <div
                            style="position: absolute; top: 10px; right: 16px; width: 6px; height: 6px; background: #d71921; border-radius: 50%;">
                        </div>
                    @endif

                    <div
                        style="width: 32px; text-align: center; font-family: var(--nothing-dot-font, 'DotGothic16', monospace); font-size: 20px; color: var(--text-muted);">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="ldb-col-avatar">
                        <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}">
                            <img src="{{ $u->avatar ? asset('storage/' . $u->avatar) : asset('assets/ico/' . ($u->emblem_image ?? 'default-user.jpg')) }}"
                                alt="{{ $u->name }}"
                                style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border-color);">
                        </a>
                    </div>

                    <div class="ldb-col-info" style="flex: 1; min-width: 0; overflow: hidden;">
                        <a href="?page=profile&id={{ $u->id }}" class="link-spa" data-page="profile&id={{ $u->id }}"
                            style="text-decoration:none; color:inherit;">
                            <h4
                                style="margin: 0 0 2px 0; font-size: 14px; font-weight: 700; color: var(--text-primary); white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                                @if($isSov)<span style="color: #d71921; margin-right: 4px;">●</span>@endif
                                {{ $u->name }}
                            </h4>
                        </a>
                        <div
                            style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted);">
                            {{ $u->rank_name ?? 'Beginner' }}
                        </div>
                    </div>

                    <div class="ldb-col-achievements" style="display: flex; align-items: center; gap: 8px;">
                        @if (isset($u->achievements) && is_array($u->achievements) && count($u->achievements) > 0)
                            @foreach ($u->achievements as $ach)
                                <img src="{{ asset('assets/ico/' . $ach['icon']) }}" alt="{{ $ach['label'] }}"
                                    title="{{ $ach['label'] }}: {{ $ach['desc'] }}"
                                    style="width: 24px; height: 24px; object-fit: contain; filter: brightness(1.2); cursor: help;">
                            @endforeach
                        @else
                            <div style="font-size: 10px; color: var(--border-color); font-weight: 600;">—</div>
                        @endif
                    </div>

                    @if ($u->id !== auth()->id() && isset($myFriendships))
                        @php
                            $friendship = $myFriendships->where('user_id', $u->id)->where('friend_id', auth()->id())->first()
                                ?? $myFriendships->where('friend_id', $u->id)->where('user_id', auth()->id())->first();
                            $fStatus = $friendship ? $friendship->status : null;
                        @endphp
                        <div class="ldb-col-action">
                            @if (!$friendship)
                                <button class="nothing-ldb-btn ldb-friend-btn" data-url="{{ route('user.friend.add', $u->id) }}">
                                    <i class='bx bx-plus'></i> ADD
                                </button>
                            @elseif ($fStatus === 'pending')
                                <button disabled class="nothing-ldb-btn nothing-ldb-btn-muted">PENDING</button>
                            @elseif ($fStatus === 'accepted')
                                <button disabled class="nothing-ldb-btn nothing-ldb-btn-done">✓</button>
                            @endif
                        </div>
                    @endif

                    <div class="ldb-col-exp" style="text-align: right;">
                        <div
                            style="font-family: var(--nothing-dot-font, 'DotGothic16', monospace); font-size: 16px; color: {{ $isDark ? '#fff' : '#000' }};">
                            {{ number_format($u->exp) }}</div>
                        <div
                            style="font-size: 9px; font-weight: 700; letter-spacing: 1px; color: {{ $isDark ? 'var(--text-muted)' : '#aaa' }}; text-transform: uppercase;">
                            EXP</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div
            style="text-align:center; padding: 40px 20px; border-radius: 16px; border: 1px solid var(--border-color); background: var(--bg-secondary);">
            <div
                style="width: 48px; height: 48px; border: 2px solid #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class='bx bx-trophy' style="font-size: 24px; color: var(--text-muted);"></i>
            </div>
            <h5
                style="color: var(--text-muted); font-size: 13px; font-weight: 600; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                Belum ada data</h5>
        </div>
    @endif
</div>

<!-- Toast Container -->
<div id="friend-toast-container"
    style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none;">
</div>

<script>
    window.switchLeaderboardTab = function (tab) {
        const globalContainer = document.getElementById('ldb-global-container');
        const friendsContainer = document.getElementById('ldb-friends-container');
        const tabs = document.querySelectorAll('.ldb-tab');

        tabs.forEach(t => {
            if (t.dataset.tab === tab) {
                t.style.background = 'var(--border-color)';
                t.style.color = '#fff';
                t.classList.add('active');
            } else {
                t.style.background = 'transparent';
                t.style.color = '#888';
                t.classList.remove('active');
            }
        });

        if (tab === 'global') {
            if (globalContainer) globalContainer.style.display = '';
            if (friendsContainer) friendsContainer.style.display = 'none';
        } else {
            if (globalContainer) globalContainer.style.display = 'none';
            if (friendsContainer) friendsContainer.style.display = '';
        }
    };
</script>

<style>
    .nothing-ldb-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .nothing-ldb-card:hover {
        transform: translateY(-4px);
        box-shadow: none !important;
        border-color: var(--border-color);
    }

    .nothing-ldb-first:hover {
        box-shadow: none !important;
        border-color: var(--text-muted);
    }

    /* Nothing OS Buttons */
    .nothing-ldb-btn {
        padding: 6px 14px;
        font-size: 10px;
        font-weight: 700;
        border-radius: 9999px;
        border: 2px solid #000;
        background: transparent;
        color: #000;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        transition: all 0.15s;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .nothing-ldb-btn:hover {
        background: var(--bg-primary);
        color: var(--text-primary);
        border-color: #000;
    }

    .nothing-ldb-btn-muted {
        padding: 6px 14px;
        font-size: 10px;
        font-weight: 700;
        border-radius: 9999px;
        border: 2px solid rgba(0, 0, 0, 0.15);
        background: transparent;
        color: var(--text-muted);
        cursor: not-allowed;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
    }

    .nothing-ldb-btn-done {
        padding: 6px 14px;
        font-size: 10px;
        font-weight: 700;
        border-radius: 9999px;
        border: 2px solid #000;
        background: transparent;
        color: #000;
        cursor: default;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
    }

    /* Sovereign card — red accent buttons */
    .nothing-ldb-sovereign .nothing-ldb-btn {
        border-color: var(--text-muted) !important;
        color: var(--text-primary) !important;
    }

    .nothing-ldb-sovereign .nothing-ldb-btn:hover {
        background: #d71921 !important;
        border-color: #d71921 !important;
    }

    /* Toast */
    .friend-toast {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        color: var(--text-primary);
        pointer-events: auto;
        animation: friendSlideIn 0.2s ease-out;
        min-width: 200px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid var(--border-color);
    }

    .friend-toast.success {
        background: var(--bg-primary);
    }

    .friend-toast.error {
        background: #d71921;
    }

    .friend-toast.fade-out {
        opacity: 0;
        transition: opacity 0.3s;
    }

    @keyframes friendSlideIn {
        from {
            transform: translateY(10px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* ═══ MOBILE ═══ */
    @media (max-width: 768px) {
        .nothing-ldb-card {
            display: grid !important;
            grid-template-columns: auto 1fr;
            grid-template-areas:
                "avatar info"
                "achievements achievements"
                "action action";
            align-items: center !important;
            gap: 4px 10px !important;
            padding: 16px 18px !important;
            border-radius: 20px !important;
        }

        .ldb-col-avatar {
            grid-area: avatar;
        }

        .ldb-col-avatar img {
            width: 32px !important;
            height: 32px !important;
        }

        .ldb-col-info {
            grid-area: info;
            margin-right: 32px;
        }

        .ldb-col-info h4 {
            font-size: 12px !important;
        }

        .ldb-col-achievements {
            grid-area: achievements;
            width: 100% !important;
            margin-top: 4px !important;
        }

        .ldb-col-achievements img {
            width: 18px !important;
            height: 18px !important;
        }

        .ldb-col-action {
            grid-area: action;
            margin-top: 4px !important;
        }

        .ldb-col-exp {
            position: absolute;
            top: 12px;
            right: 14px;
        }

        .ldb-col-exp div:first-child {
            font-size: 13px !important;
        }

        .ldb-col-exp div:last-child {
            font-size: 8px !important;
        }
    }
</style>

<script>
    (function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

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

        document.querySelectorAll('.ldb-friend-btn').forEach(btn => {
            btn.addEventListener('click', async function () {
                const url = this.dataset.url;
                if (!url) return;

                this.disabled = true;
                this.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i>`;
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
                        this.innerHTML = `PENDING`;
                        this.style.color = '#aaa';
                        this.style.borderColor = 'rgba(0,0,0,0.08)';
                        this.disabled = true;
                        window.showFriendToast(data.message, 'success');
                    } else {
                        this.innerHTML = `<i class='bx bx-plus'></i> ADD`;
                        this.style.cursor = 'pointer';
                        this.disabled = false;
                        window.showFriendToast(data.message || 'Gagal.', 'error');
                    }
                } catch (err) {
                    this.innerHTML = `<i class='bx bx-plus'></i> ADD`;
                    this.style.cursor = 'pointer';
                    this.disabled = false;
                    window.showFriendToast('Koneksi error.', 'error');
                }
            });
        });
    })();
</script>
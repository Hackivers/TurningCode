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
                        <!-- Crown icon for #1 -->
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

                    <!-- Avatar or Emblem -->
                    <div style="position: relative;">
                        <img src="{{ $u->avatar ? asset('storage/' . $u->avatar) : asset('assets/ico/' . ($u->emblem_image ?? 'default-user.jpg')) }}"
                            alt="{{ $u->name }}"
                            style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05); {{ $i === 0 ? 'border: 2px solid #f59e0b;' : '' }}">
                    </div>

                    <!-- Info -->
                    <!-- Info -->
                    <div
                        style="width: 25%; min-width: 150px; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
                        <h4
                            style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: #121212; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                            {{ $u->name }}
                        </h4>
                        <div
                            style="font-size: 13px; color: #555; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                            <span style="color: #f59e0b; font-size: 14px;"><i class='bx bxs-star'></i></span>
                            {{ $u->rank_name ?? 'Beginner' }}
                        </div>
                    </div>

                    <!-- Achievements (Tengah) -->
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
                            <div style="font-size: 12px; color: #a1a1aa; font-style: italic; letter-spacing: 0.5px;">Belum memiliki
                                lencana</div>
                        @endif
                    </div>

                    <!-- Add Friend Action -->
                    @if ($u->id !== auth()->id() && isset($myFriendships))
                        @php
                            $friendship = $myFriendships->where('user_id', $u->id)->where('friend_id', auth()->id())->first() 
                                        ?? $myFriendships->where('friend_id', $u->id)->where('user_id', auth()->id())->first();
                        @endphp
                        <div style="margin-right: 16px;">
                            @if (!$friendship)
                                <form action="{{ route('user.friend.add', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="neo-btn" style="padding: 6px 12px; font-size: 12px; background: #fff; border: 1px solid #ddd; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                                        <i class='bx bx-user-plus'></i> Add
                                    </button>
                                </form>
                            @elseif ($friendship->status === 'pending')
                                <button disabled style="padding: 6px 12px; font-size: 12px; background: #f1f5f9; border: 1px solid #ddd; color: #64748b; border-radius: 8px; display: flex; align-items: center; gap: 4px; cursor: not-allowed;">
                                    <i class='bx bx-time'></i> Pending
                                </button>
                            @elseif ($friendship->status === 'accepted')
                                <button disabled style="padding: 6px 12px; font-size: 12px; background: #ecfdf5; border: 1px solid #10b981; color: #10b981; border-radius: 8px; display: flex; align-items: center; gap: 4px; cursor: default;">
                                    <i class='bx bx-check'></i> Friends
                                </button>
                            @endif
                        </div>
                    @endif

                    <!-- EXP points -->
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

<style>
    .leaderboard-row {
        transition: background-color 0.2s;
    }

    .leaderboard-row:hover {
        background-color: rgba(0, 0, 0, 0.015);
    }
</style>
<div style="margin-top: 48px; margin-bottom: 32px;">
    <h3 class="neo-title" style="font-size: 28px; margin: 0 0 8px 0; color: #121212;">Peringkat Teratas</h3>
    <p style="font-size: 16px; color: #555; margin: 0;">Lihat siapa saja yang paling rajin belajar minggu ini.</p>
</div>

@if (isset($topUsers) && $topUsers->count())
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        @foreach ($topUsers as $i => $u)
            <div class="neo-card neo-card-light leaderboard-card" style="padding: 24px; position: relative; {{ $i === 0 ? 'border: 2px solid #ffd700;' : '' }}">
                @if ($i === 0)
                    <!-- Crown icon for #1 -->
                    <div style="position: absolute; top: -16px; right: 24px; font-size: 32px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
                        👑
                    </div>
                @endif
                
                <div style="display: flex; align-items: center; gap: 16px;">
                    <!-- Avatar or Emblem -->
                    <div style="position: relative;">
                        <img src="{{ $u->avatar ? asset('storage/' . $u->avatar) : asset('assets/ico/' . ($u->emblem_image ?? 'default-user.jpg')) }}" 
                             alt="{{ $u->name }}" 
                             style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                        <div style="position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%); background: #121212; color: #fff; font-size: 11px; font-weight: 800; border-radius: 12px; padding: 2px 8px; border: 2px solid #e5e5e5;">
                            #{{ $loop->iteration }}
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div style="flex: 1; overflow: hidden;">
                        <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: #121212; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                            {{ explode(' ', $u->name)[0] }}
                        </h4>
                        <div style="font-size: 13px; color: #666; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                            <span style="color: #f59e0b;"><i class='bx bxs-star'></i></span>
                            {{ $u->rank_name ?? 'Beginner' }}
                        </div>
                    </div>
                    
                    <!-- EXP points -->
                    <div style="text-align: right; margin-left: auto;">
                        <div style="font-size: 20px; font-weight: 800; color: #121212;">{{ number_format($u->exp) }}</div>
                        <div style="font-size: 11px; color: #888; font-weight: 600;">EXP</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="neo-card neo-card-light" style="text-align:center; padding: 40px 20px;">
        <i class='bx bx-trophy' style="font-size: 48px; color: #aaa; margin-bottom: 12px;"></i>
        <h5 style="color: #666; font-size: 15px; font-weight: 500; margin: 0;">Belum ada data peringkat.</h5>
    </div>
@endif

<style>
.leaderboard-card {
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s;
    background: linear-gradient(145deg, #ffffff, #f0f0f0);
}
.leaderboard-card:hover {
    transform: translateY(-4px) scale(1.02);
    box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}
</style>

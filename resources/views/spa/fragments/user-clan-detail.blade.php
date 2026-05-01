<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        <style>
            .gdb-header {
                background: #18181b;
                border-radius: 32px;
                padding: 40px;
                position: relative;
                overflow: hidden;
                color: #fff;
                margin-bottom: 40px;
                display: flex;
                flex-direction: column;
                gap: 32px;
                box-shadow: 0 24px 48px rgba(0,0,0,0.12);
            }
            .gdb-header-bg {
                position: absolute;
                top: -50%;
                right: -10%;
                width: 800px; height: 800px;
                background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 50%);
                pointer-events: none;
                z-index: 0;
            }
            .gdb-emblem {
                width: 96px; height: 96px;
                background: rgba(255,255,255,0.04);
                border-radius: 28px;
                padding: 20px;
                border: 1px solid rgba(255,255,255,0.08);
                backdrop-filter: blur(10px);
                flex-shrink: 0;
            }
            .gdb-title {
                font-size: 38px;
                font-weight: 900;
                letter-spacing: -1px;
                margin: 0;
            }
            .gdb-desc {
                color: #a1a1aa;
                font-size: 15px;
                line-height: 1.6;
                max-width: 600px;
                margin-top: 10px;
            }
            .gdb-stats-row {
                display: flex;
                gap: 16px;
                margin-top: 28px;
                flex-wrap: wrap;
            }
            .gdb-stat {
                background: rgba(255,255,255,0.04);
                padding: 14px 24px;
                border-radius: 20px;
                border: 1px solid rgba(255,255,255,0.06);
            }
            .gdb-stat span { display: block; font-size: 11px; color: #a1a1aa; text-transform: uppercase; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px; }
            .gdb-stat strong { font-size: 20px; color: #fff; font-weight: 800; }

            .gdb-members-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 16px;
            }
            .gdb-member-card {
                background: #fff;
                border: 1px solid rgba(0,0,0,0.05);
                border-radius: 24px;
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .gdb-member-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 32px rgba(0,0,0,0.04);
                border-color: rgba(0,0,0,0.08);
            }
            
            @media (min-width: 900px) {
                .gdb-header-content { flex-direction: row; align-items: flex-start; justify-content: space-between; }
            }
            .gdb-header-content { display: flex; flex-direction: column; gap: 24px; position: relative; z-index: 1; }
        </style>

        <!-- ═══ Guild Header Bento ═══ -->
        <div class="gdb-header">
            <div class="gdb-header-bg"></div>
            
            <button onclick="window.location.hash='clans'" style="position: absolute; top: 32px; right: 32px; background: rgba(255,255,255,0.1); border: none; width: 44px; height: 44px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; z-index: 2;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                <i class='bx bx-x' style="font-size: 24px;"></i>
            </button>

            <div class="gdb-header-content">
                <div style="display: flex; gap: 24px; flex-wrap: wrap;">
                    <div class="gdb-emblem">
                        <img src="{{ asset('assets/ico/' . $clan->emblem) }}" style="width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 4px 12px rgba(0,0,0,0.2));">
                    </div>
                    
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 4px; flex-wrap: wrap;">
                            <h1 class="gdb-title">{{ $clan->name }}</h1>
                            <span class="neo-pill" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); font-weight: 800; font-size: 13px; padding: 6px 14px;"><i class='bx bxs-star'></i> Lvl {{ $clan->level }}</span>
                        </div>
                        <p class="gdb-desc">{{ $clan->description ?? 'Guild ini belum mengatur deskripsi.' }}</p>
                        
                        <div class="gdb-stats-row">
                            <div class="gdb-stat">
                                <span>Ketua Guild</span>
                                <strong>{{ $clan->leader->name }}</strong>
                            </div>
                            <div class="gdb-stat">
                                <span>Anggota</span>
                                <strong>{{ $clan->members->count() }} <span style="color: #71717a; font-size: 14px; font-weight: 600;">/ 50</span></strong>
                            </div>
                            <div class="gdb-stat">
                                <span>Guild EXP</span>
                                <strong style="color: #10b981;"><i class='bx bxs-bolt'></i> {{ number_format($clan->exp) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                @if($userMember)
                <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; min-width: 200px;">
                    <button onclick="
                        const url = new URL(window.location.href);
                        url.searchParams.set('page', 'clan-detail');
                        url.searchParams.set('id', '{{ $clan->id }}');
                        url.hash = '';
                        navigator.clipboard.writeText(url.toString()).then(() => {
                            Swal.fire({title: 'Tersalin!', text: 'Link undangan guild berhasil disalin ke clipboard.', icon: 'success', timer: 2000, showConfirmButton: false});
                        });
                    " style="background: #fff; color: #18181b; border: none; padding: 14px 24px; border-radius: 100px; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.2s; box-shadow: 0 8px 16px rgba(0,0,0,0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(255,255,255,0.15)';" onmouseout="this.style.transform=''; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)';">
                        <i class='bx bx-user-plus' style="font-size: 20px;"></i> Invite Teman
                    </button>
                    
                    @if(strtolower($userMember->role) !== 'leader')
                    <button onclick="leaveClan()" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 14px 24px; border-radius: 100px; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#ef4444'">
                        <i class='bx bx-log-out' style="font-size: 20px;"></i> Keluar
                    </button>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- ═══ Members Grid ═══ -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
            <h3 class="neo-title" style="font-size: 22px; margin: 0;">Anggota Guild ({{ $clan->members->count() }})</h3>
        </div>

        <div class="gdb-members-grid">
            @foreach($clan->members->sortByDesc(function($m) { return $m->role === 'leader' ? 2 : ($m->role === 'co_leader' ? 1 : 0); }) as $member)
                <div class="gdb-member-card">
                    <div style="position: relative; flex-shrink: 0;">
                        <img src="{{ $member->user->avatar ? asset('storage/' . $member->user->avatar) : asset('assets/ico/' . ($member->user->emblem_image ?? 'default-user.jpg')) }}" alt="Avatar" style="width: 56px; height: 56px; border-radius: 18px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                        @if($member->user->id === Auth::id())
                            <div style="position: absolute; bottom: -4px; right: -4px; background: #10b981; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff;">
                                <i class='bx bx-user' style="font-size: 11px;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                            <h4 class="neo-title" style="margin: 0; font-size: 16px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-right: 8px;">
                                {{ $member->user->name }}
                            </h4>
                            <div>
                                @if(strtolower($member->role) === 'leader')
                                    <span class="neo-pill" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245,158,11,0.2); padding: 4px 10px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px;">KETUA</span>
                                @elseif(strtolower($member->role) === 'co_leader')
                                    <span class="neo-pill" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59,130,246,0.2); padding: 4px 10px; font-size: 10px; font-weight: 800; letter-spacing: 0.5px;">WAKIL</span>
                                @else
                                    <span class="neo-pill" style="background: #f4f4f5; color: #71717a; border: none; padding: 4px 10px; font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">ANGGOTA</span>
                                @endif
                            </div>
                        </div>
                        
                        <div style="font-size: 13px; color: #71717a; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <span style="color: #8b5cf6;"><i class='bx bxs-medal'></i> {{ $member->user->rank_name }}</span>
                            <span style="color: #e4e4e7;">•</span>
                            <span style="color: #f59e0b;">{{ number_format($member->user->exp) }} EXP</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<script>
    async function leaveClan() {
        const result = await Swal.fire({
            title: 'Keluar dari Guild?',
            text: "Anda akan kehilangan akses ke fitur guild ini.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal'
        });

        if(!result.isConfirmed) return;

        try {
            const res = await fetch('{{ route('user.clan.leave') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                setTimeout(() => {
                    window.location.hash = 'clans';
                    window.location.reload();
                }, 1500);
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        } catch (err) {
            if(window.showFriendToast) window.showFriendToast('Terjadi kesalahan koneksi.', 'error');
        }
    }
</script>

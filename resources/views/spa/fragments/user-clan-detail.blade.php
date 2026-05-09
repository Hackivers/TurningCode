<style>
    /* Editorial Layout Styles */
    .tc-editorial-container {
        font-family: 'Space Mono', monospace;
        color: #18181b;
        margin-bottom: 40px;
    }

    .tc-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .tc-header-text {
        flex: 1;
    }

    .tc-headline {
        font-size: clamp(40px, 5vw, 64px);
        font-weight: 900;
        text-transform: uppercase;
        line-height: 1.05;
        letter-spacing: -2px;
        margin: 0 0 8px 0;
        color: #18181b;
    }

    .tc-subheadline {
        font-size: 16px;
        color: #a1a1aa;
        margin: 0;
        font-weight: 500;
        letter-spacing: -0.2px;
    }

    .tc-btn-dark {
        background: #18181b;
        color: var(--text-primary);
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .tc-btn-dark:hover {
        background: #27272a;
        transform: translateY(-2px);
    }

    /* Hero Section */
    .tc-hero-section {
        position: relative;
        height: 400px;
        border-radius: 32px;
        overflow: hidden;
        margin-bottom: 16px;
        background: #000;
    }

    .tc-hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(100%) contrast(1.2) brightness(0.6);
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    /* Glassmorphic Overlay */
    .tc-hero-overlay {
        position: absolute;
        bottom: 24px;
        left: 24px;
        right: 24px;
        background: var(--border-color);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1;
        gap: 16px;
    }

    .tc-overlay-content {
        display: flex;
        align-items: center;
        gap: 16px;
        color: var(--text-primary);
    }

    .tc-overlay-emblem {
        width: 56px;
        height: 56px;
        background: var(--border-color);
        border-radius: 16px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tc-badge-pill {
        display: inline-block;
        background: var(--text-primary);
        color: #18181b;
        font-size: 10px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 100px;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .tc-overlay-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 2px 0;
    }

    .tc-overlay-subtitle {
        font-size: 13px;
        color: rgba(255,255,255,0.7);
        margin: 0;
    }

    .tc-circle-btn {
        width: 48px;
        height: 48px;
        background: var(--text-primary);
        color: #18181b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: transform 0.2s;
        flex-shrink: 0;
    }

    .tc-circle-btn:hover {
        transform: scale(1.05);
    }

    .tc-circle-btn i {
        font-size: 24px;
    }

    /* Bento Stats Row */
    .tc-bento-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .tc-bento-stats {
            grid-template-columns: 1fr;
        }
        .tc-hero-section {
            height: 300px;
        }
        .tc-hero-overlay {
            flex-direction: column;
            align-items: flex-start;
        }
        .tc-circle-btn {
            align-self: flex-end;
            margin-top: -30px;
        }
    }

    .tc-stat-card {
        background: #f4f4f5;
        border-radius: 24px;
        padding: 24px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        min-height: 120px;
    }

    .tc-stat-card.dark {
        background: #18181b;
        color: var(--text-primary);
    }

    .tc-stat-num {
        font-size: 36px;
        font-weight: 900;
        letter-spacing: -1px;
        margin: 0 0 4px 0;
        line-height: 1;
    }

    .tc-stat-label {
        font-size: 12px;
        font-weight: 700;
        color: #71717a;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .tc-stat-card.dark .tc-stat-label {
        color: #a1a1aa;
    }

    .tc-stat-action {
        position: absolute;
        bottom: 24px;
        right: 24px;
        width: 32px;
        height: 32px;
        background: #18181b;
        color: var(--text-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .tc-stat-badge {
        position: absolute;
        top: 24px;
        right: 24px;
        border: 1px solid rgba(0,0,0,0.1);
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        color: #52525b;
        letter-spacing: 0.5px;
    }

    /* Additional Action buttons */
    .tc-actions-row {
        display: flex;
        gap: 12px;
    }

    .tc-btn-danger {
        background: transparent;
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tc-btn-danger:hover {
        background: #ef4444;
        color: var(--text-primary);
    }

    .tc-btn-primary {
        background: #3b82f6;
        color: var(--text-primary);
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .tc-btn-primary:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    /* Members Grid Reset */
    .tc-members-section {
        margin-top: 24px;
    }
    
    .tc-section-title {
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 20px 0;
        color: #18181b;
        letter-spacing: -0.5px;
    }

    .tc-members-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 16px;
    }
    
    .tc-member-card {
        background: var(--text-primary);
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
</style>

<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container tc-editorial-container">

        <!-- 1. Header Top -->
        <div class="tc-header-top">
            <div class="tc-header-text">
                <h1 class="tc-headline">{{ strtoupper($clan->name) }}</h1>
                <p class="tc-subheadline">{{ $clan->description ?? 'Exceeding Standards in Elite Collaboration' }}</p>
            </div>
            <div class="tc-actions-row">
                @if($userMember)
                    <button data-action="invite" data-clan-id="{{ $clan->id }}" class="tc-btn-primary"><i class='bx bx-user-plus'></i> Invite Teman</button>
                    <button data-action="leave" data-clan-id="{{ $clan->id }}" class="tc-btn-danger"><i class='bx bx-log-out'></i> Keluar</button>
                @endif
                <button data-action="back" class="tc-btn-dark"><i class='bx bx-arrow-back'></i> Kembali</button>
            </div>
        </div>

        <!-- 2. Hero Section -->
        <div class="tc-hero-section">
            <img src="{{ asset('assets/img/guild-hero.png') }}" class="tc-hero-img" alt="Guild Hero">
            
            <div class="tc-hero-overlay">
                <div class="tc-overlay-content">
                    <div class="tc-overlay-emblem">
                        <img src="{{ asset('assets/ico/' . $clan->emblem) }}" style="width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                    </div>
                    <div>
                        <span class="tc-badge-pill">LVL {{ $clan->level }}</span>
                        <h3 class="tc-overlay-title">{{ $clan->name }}</h3>
                        <p class="tc-overlay-subtitle">Dipimpin oleh {{ $clan->leader->name }}</p>
                    </div>
                </div>
                
                @if($userMember)
                <button class="tc-circle-btn" data-action="invite" data-clan-id="{{ $clan->id }}" title="Salin Link Invite">
                    <i class='bx bx-share-alt'></i>
                </button>
                @endif
            </div>
        </div>

        <!-- 3. Bento Stats Grid -->
        <div class="tc-bento-stats">
            <!-- Card 1 -->
            <div class="tc-stat-card">
                <h2 class="tc-stat-num">{{ $clan->members->count() }}</h2>
                <p class="tc-stat-label">Total Anggota</p>
                <div class="tc-stat-action"><i class='bx bx-right-arrow-alt' style="transform: rotate(-45deg);"></i></div>
            </div>
            
            <!-- Card 2 -->
            <div class="tc-stat-card">
                <h2 class="tc-stat-num">{{ number_format($clan->exp) }}</h2>
                <p class="tc-stat-label">Guild EXP</p>
                <span class="tc-stat-badge">ACTIVE</span>
            </div>

            <!-- Card 3 -->
            <div class="tc-stat-card dark">
                <h2 class="tc-stat-num">{{ $clan->level }}</h2>
                <p class="tc-stat-label">Level Guild</p>
            </div>
        </div>

        <!-- 4. Members Grid -->
        <div class="tc-members-section">
            <h3 class="tc-section-title">Anggota Terdaftar ({{ $clan->members->count() }})</h3>
            <div class="tc-members-grid">
                @foreach($clan->members->sortByDesc(function($m) { return $m->role === 'leader' ? 2 : ($m->role === 'co_leader' ? 1 : 0); }) as $member)
                    <div class="tc-member-card">
                        <div style="position: relative; flex-shrink: 0;">
                            <img src="{{ $member->user->avatar ? asset('storage/' . $member->user->avatar) : asset('assets/ico/' . ($member->user->emblem_image ?? 'default-user.jpg')) }}" alt="Avatar" style="width: 56px; height: 56px; border-radius: 16px; object-fit: cover;">
                            @if($member->user->id === Auth::id())
                                <div style="position: absolute; bottom: -4px; right: -4px; background: #18181b; color: var(--text-primary); width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid var(--text-primary);">
                                    <i class='bx bx-user' style="font-size: 10px;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                                <h4 style="margin: 0; font-size: 15px; font-weight: 800; color: #18181b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding-right: 8px;">
                                    {{ $member->user->name }}
                                </h4>
                                <div>
                                    @if(strtolower($member->role) === 'leader')
                                        <span style="background: #18181b; color: var(--text-primary); padding: 3px 8px; border-radius: 100px; font-size: 9px; font-weight: 800; letter-spacing: 0.5px;">KETUA</span>
                                    @elseif(strtolower($member->role) === 'co_leader')
                                        <span style="background: rgba(0,0,0,0.06); color: #18181b; padding: 3px 8px; border-radius: 100px; font-size: 9px; font-weight: 800; letter-spacing: 0.5px;">WAKIL</span>
                                    @else
                                        <span style="color: #a1a1aa; font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">ANGGOTA</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div style="font-size: 12px; color: #71717a; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                                <span><i class='bx bxs-medal'></i> {{ $member->user->rank_name }}</span>
                                <span style="color: #e4e4e7;">•</span>
                                <span>{{ number_format($member->user->exp) }} EXP</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('click', function __clanDetailHandler(e) {
        var btn = e.target.closest('[data-action]');
        if (!btn) return;
        // Only handle actions within clan detail context
        if (!btn.closest('.tc-editorial-container')) return;

        var action = btn.getAttribute('data-action');
        var clanId = btn.getAttribute('data-clan-id');

        if (action === 'back') {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = '?page=clans';
            return;
        }

        if (action === 'invite' && clanId) {
            e.preventDefault();
            e.stopPropagation();
            var url = new URL(window.location.href);
            url.searchParams.set('page', 'clan-detail');
            url.searchParams.set('id', clanId);
            url.hash = '';
            var linkText = url.toString();

            // Try modern clipboard API first
            try {
                navigator.clipboard.writeText(linkText).then(function() {
                    Swal.fire({
                        title: 'Tersalin!',
                        text: 'Link undangan guild disalin ke clipboard. Kirimkan link ini ke temanmu!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }).catch(function() {
                    __fallbackCopy(linkText);
                });
            } catch(ex) {
                __fallbackCopy(linkText);
            }
            return;
        }

        if (action === 'leave' && clanId) {
            e.preventDefault();
            e.stopPropagation();
            Swal.fire({
                title: 'Keluar dari Guild?',
                text: 'Anda akan kehilangan akses ke fitur guild ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (!result.isConfirmed) return;
                fetch('{{ route("user.clan.leave") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ clan_id: parseInt(clanId) })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.success) {
                        Swal.fire({ title: 'Berhasil!', text: data.message, icon: 'success', timer: 2000, showConfirmButton: false });
                        setTimeout(function() { window.location.href = '?page=clans'; }, 1500);
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                })
                .catch(function() {
                    Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error');
                });
            });
            return;
        }
    });

    function __fallbackCopy(text) {
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
        Swal.fire({
            title: 'Tersalin!',
            text: 'Link undangan guild disalin ke clipboard. Kirimkan link ini ke temanmu!',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>

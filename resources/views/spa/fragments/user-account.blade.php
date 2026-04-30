{{-- ═══════════════════════════════════════════════════════════════
 ACCOUNT PAGE — Neo Bento Design (synced with Dashboard)
═══════════════════════════════════════════════════════════════ --}}
<div class="neo-dashboard rtd-dashboard">
<div class="neo-bento-container">

{{-- ── BACK TO DASHBOARD ────────────────────────────────────────── --}}
<a href="?page=dashboard" class="link-spa" data-page="dashboard" style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#888;text-decoration:none;margin-bottom:24px;transition:color 0.2s;" onmouseover="this.style.color='#121212'" onmouseout="this.style.color='#888'">
    <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali ke Dashboard
</a>

{{-- ── BENTO GRID: Profile + Stats ──────────────────────────────── --}}
<div class="neo-bento-grid">
    {{-- Left Column: Profile Card --}}
    <div class="neo-bento-col">
        <div class="neo-card neo-card-light acc-profile-card" style="height:100%;">
            <div class="neo-header">
                <h3 class="neo-title">Profil<br>Akun</h3>
                <span class="neo-arrow">&#x2197;</span>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;padding:24px 0;">
                <div class="acc-avatar-wrap {{ $user->isPenguasaSektor() ? 'sovereign-aura-lg' : ($user->isElite() ? 'elite-aura-lg' : '') }}" style="cursor:pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onclick="openImageViewer()">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="profile-cover-img" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid rgba(0,0,0,0.08);">
                    @else
                        <div style="width:120px;height:120px;border-radius:50%;background:#121212;display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:48px;font-weight:800;color:#fff;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <div style="text-align:center;">
                    <h4 id="display-name" class="{{ $user->isPenguasaSektor() ? 'sovereign-name-lg' : ($user->isElite() ? 'elite-name-lg' : '') }}" style="margin:0 0 4px;font-size:20px;font-weight:700;color:#121212;">{{ $user->name }}</h4>
                    <p id="display-email" style="margin:0;font-size:13px;color:#888;">{{ $user->email }}</p>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                    <span class="neo-pill" style="font-size:14px;background:rgba(0,0,0,0.05);">{{ number_format($user->exp ?? 0) }} EXP</span>
                    <span class="neo-pill" style="font-size:14px;background:#121212;color:#fff;border-color:#121212;">Rank: {{ $user->rank_name }}</span>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="neo-pill">{{ $daysActive }} hari aktif</span>
                    <span class="neo-pill" style="color:{{ $user->email_verified_at ? '#10b981' : '#f43f5e' }};border-color:{{ $user->email_verified_at ? '#10b981' : '#f43f5e' }};">{{ $user->email_verified_at ? '✓ Verified' : '✗ Unverified' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Stats Cards --}}
    <div class="neo-bento-right">
        <div class="neo-bento-top-row">
            {{-- Quiz Stats Card --}}
            <div class="neo-card neo-card-light" style="min-height:260px;justify-content:space-between;">
                <div class="neo-header">
                    <h3 class="neo-title">Kuis<br>Statistik</h3>
                    <span class="neo-arrow">&#x2197;</span>
                </div>
                <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:16px 0;">
                    <div style="text-align:center;">
                        <div style="font-size:56px;font-weight:800;color:#121212;line-height:1;">{{ $quizAvgScore }}</div>
                        <div style="font-size:13px;color:#888;font-weight:500;margin-top:4px;">Rata-rata Skor</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="neo-pill">{{ $totalQuizAttempts }} dicoba</span>
                    <span class="neo-pill" style="color:#10b981;border-color:#10b981;">{{ $quizPassedCount }} lulus</span>
                    <span class="neo-pill">Best: {{ $quizBestScore }}</span>
                </div>
            </div>

            {{-- Learning Progress Card --}}
            <div class="neo-card neo-card-light" style="min-height:260px;justify-content:space-between;">
                <div class="neo-header">
                    <h3 class="neo-title">Progres<br>Belajar</h3>
                    <span class="neo-arrow">&#x2197;</span>
                </div>
                <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:16px 0;">
                    <div style="position:relative;width:110px;height:110px;">
                        <svg viewBox="0 0 36 36" style="width:100%;height:100%;transform:rotate(-90deg);">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="rgba(0,0,0,0.08)" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#121212" stroke-width="3" stroke-dasharray="{{ $learningProgress }}, 100" stroke-linecap="round"/>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;color:#121212;">{{ $learningProgress }}%</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="neo-pill">{{ $completedSubMateris }}/{{ $totalSubMateris }} materi</span>
                    <span class="neo-pill">{{ $totalFavorites }} favorit</span>
                </div>
            </div>
        </div>

        {{-- Bottom Black Card: Activity Summary --}}
        <div style="flex:1;display:flex;">
            <div class="neo-card" style="flex:1;min-height:200px;background:#121212;color:#fff;padding:40px;display:flex;align-items:center;">
                <div style="width:100%;">
                    <div style="font-size:15px;font-weight:700;color:#fff;margin-bottom:16px;display:flex;align-items:center;">
                        <span>{{ $user->rank_name }}</span>
                        <span style="margin:0 10px;opacity:0.5;">&bull;</span>
                        <span>Bergabung {{ $user->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <h3 style="font-size:clamp(28px,3.5vw,40px);font-weight:800;line-height:1.15;letter-spacing:-0.02em;color:#fff;margin:0 0 32px;">
                        {{ $totalHistoryViews }} materi telah dibaca
                    </h3>
                    <div>
                        <button id="btn-open-edit-profile-2" style="display:inline-flex;align-items:center;gap:6px;font-size:15px;font-weight:700;color:#fff;background:none;border:none;cursor:pointer;padding:0;">
                            Edit Profile <i class='bx bx-right-arrow-alt' style="font-size:18px;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── ACHIEVEMENTS ──────────────────────────────────────────────── --}}
@if(!empty($achievements))
<div style="margin-top:48px;">
    <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Pencapaian</h3>
    <p style="font-size:16px;color:#555;margin:0 0 24px;">Lencana yang kamu dapatkan dari perjalanan belajar.</p>
    <div class="neo-card neo-card-light" style="padding:32px;">
        <div style="display:flex;flex-wrap:wrap;gap:24px;justify-content:center;">
            @foreach($achievements as $ach)
            <div class="acc-ach-item" title="{{ $ach['label'] }}: {{ $ach['desc'] }}">
                <img src="{{ asset('assets/ico/' . $ach['icon']) }}" alt="{{ $ach['label'] }}" style="width:64px;height:64px;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,0.1));transition:transform 0.2s;">
                <div style="text-align:center;margin-top:8px;">
                    <div style="font-size:12px;font-weight:700;color:#121212;">{{ $ach['label'] }}</div>
                    <div style="font-size:10px;color:#888;">{{ $ach['desc'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ── RECENT QUIZZES ────────────────────────────────────────────── --}}
@if($recentQuizzes->count() > 0)
<div style="margin-top:48px;">
    <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Riwayat Kuis</h3>
    <p style="font-size:16px;color:#555;margin:0 0 24px;">5 kuis terakhir yang kamu kerjakan.</p>
    <div class="neo-card neo-card-light" style="padding:24px;">
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($recentQuizzes as $q)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:16px;background:rgba(255,255,255,0.5);border-radius:16px;border:1px solid rgba(0,0,0,0.04);">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:12px;background:{{ $q->passed ? '#ecfdf5' : '#fef2f2' }};display:flex;align-items:center;justify-content:center;">
                        <i class='bx {{ $q->passed ? "bx-check" : "bx-x" }}' style="font-size:20px;color:{{ $q->passed ? '#10b981' : '#ef4444' }};"></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:600;color:#121212;">{{ $q->subMateri->title ?? 'Sub Materi' }}</div>
                        <div style="font-size:12px;color:#888;">{{ $q->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:18px;font-weight:800;color:#121212;">{{ $q->score }}%</div>
                    <div style="font-size:11px;color:{{ $q->passed ? '#10b981' : '#ef4444' }};font-weight:600;">{{ $q->passed ? 'LULUS' : 'GAGAL' }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ── FRIENDS SECTION (AJAX) ────────────────────────────────────── --}}
<div style="margin-top:48px;">
    <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:#121212;">Pertemanan</h3>
    <p style="font-size:16px;color:#555;margin:0 0 24px;">Kelola daftar teman dan permintaan masuk.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px;">
        {{-- Friend Requests --}}
        <div class="neo-card neo-card-light" style="padding:24px;">
            <h4 style="margin:0 0 16px;font-size:18px;font-weight:600;color:#121212;display:flex;justify-content:space-between;align-items:center;">
                Permintaan Masuk
                @if(isset($friendRequests) && $friendRequests->count() > 0)
                    <span id="friend-req-badge" style="background:#ef4444;color:white;font-size:12px;padding:2px 8px;border-radius:12px;">{{ $friendRequests->count() }}</span>
                @endif
            </h4>
            <div id="friend-requests-list" style="display:flex;flex-direction:column;gap:12px;">
                @if(isset($friendRequests) && $friendRequests->count() > 0)
                    @foreach($friendRequests as $req)
                    <div class="friend-req-item" data-sender-id="{{ $req->sender->id }}" style="display:flex;align-items:center;justify-content:space-between;padding:12px;background:rgba(255,255,255,0.5);border-radius:16px;border:1px solid rgba(0,0,0,0.04);transition:all 0.3s;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <img src="{{ $req->sender->avatar ? asset('storage/'.$req->sender->avatar) : asset('assets/ico/'.($req->sender->emblem_image ?? 'default-user.jpg')) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                            <div>
                                <div style="font-weight:600;font-size:14px;color:#121212;">{{ $req->sender->name }}</div>
                                <div style="font-size:12px;color:#888;">{{ $req->sender->rank_name }}</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <button class="btn-accept-friend" data-url="{{ route('user.friend.accept', $req->sender->id) }}" data-sender-name="{{ $req->sender->name }}" data-sender-avatar="{{ $req->sender->avatar ? asset('storage/'.$req->sender->avatar) : asset('assets/ico/'.($req->sender->emblem_image ?? 'default-user.jpg')) }}" data-sender-rank="{{ $req->sender->rank_name }}" data-sender-id="{{ $req->sender->id }}" style="padding:6px 10px;background:#121212;color:white;border:none;border-radius:10px;cursor:pointer;font-size:12px;font-weight:600;transition:all 0.2s;"><i class='bx bx-check'></i></button>
                            <button class="btn-reject-friend" data-url="{{ route('user.friend.reject', $req->sender->id) }}" style="padding:6px 10px;background:transparent;color:#888;border:1px solid rgba(0,0,0,0.15);border-radius:10px;cursor:pointer;font-size:12px;transition:all 0.2s;"><i class='bx bx-x'></i></button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="text-align:center;padding:24px;color:#888;font-size:14px;">Tidak ada permintaan masuk.</div>
                @endif
            </div>
        </div>

        {{-- Friends List --}}
        <div class="neo-card neo-card-light" style="padding:24px;">
            <h4 style="margin:0 0 16px;font-size:18px;font-weight:600;color:#121212;">Daftar Teman (<span id="friend-count">{{ isset($friends) ? $friends->count() : 0 }}</span>)</h4>
            <div id="friends-list" style="display:flex;flex-direction:column;gap:12px;">
                @if(isset($friends) && $friends->count() > 0)
                    @foreach($friends as $friend)
                    <div class="friend-item" data-friend-id="{{ $friend->id }}" style="display:flex;align-items:center;justify-content:space-between;padding:12px;background:rgba(255,255,255,0.5);border-radius:16px;border:1px solid rgba(0,0,0,0.04);transition:all 0.3s;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <a href="?page=profile&id={{ $friend->id }}" class="link-spa" data-page="profile&id={{ $friend->id }}" style="display:flex;align-items:center;gap:12px;text-decoration:none;color:inherit;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                <img src="{{ $friend->avatar ? asset('storage/'.$friend->avatar) : asset('assets/ico/'.($friend->emblem_image ?? 'default-user.jpg')) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                                <div>
                                    <div style="font-weight:600;font-size:14px;color:#121212;">{{ $friend->name }}</div>
                                    <div style="font-size:12px;color:#888;">{{ $friend->rank_name }}</div>
                                </div>
                            </a>
                        </div>
                        <button class="btn-remove-friend" data-url="{{ route('user.friend.remove', $friend->id) }}" style="padding:6px 10px;font-size:12px;background:transparent;border:1px solid rgba(0,0,0,0.1);color:#888;border-radius:10px;cursor:pointer;transition:all 0.2s;"><i class='bx bx-user-minus'></i> Hapus</button>
                    </div>
                    @endforeach
                @else
                    <div id="no-friends-msg" style="text-align:center;padding:24px;color:#888;font-size:14px;">Belum ada teman.</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── LOGOUT ────────────────────────────────────────────────────── --}}
<div style="margin-top:48px;margin-bottom:32px;">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" style="display:flex;align-items:center;gap:8px;padding:14px 28px;background:transparent;border:1px solid rgba(0,0,0,0.15);border-radius:16px;color:#888;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s;font-family:inherit;" onmouseover="this.style.borderColor='#ef4444';this.style.color='#ef4444';" onmouseout="this.style.borderColor='rgba(0,0,0,0.15)';this.style.color='#888';">
            <i class='bx bx-log-out' style="font-size:18px;"></i> Keluar dari akun
        </button>
    </form>
</div>

</div>
</div>

{{-- ── IMAGE VIEWER MODAL ────────────────────────────────────────── --}}
<div id="image-viewer-modal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 100000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(8px); opacity: 0; transition: opacity 0.3s ease;">
    <button onclick="closeImageViewer()" style="position: absolute; top: 24px; right: 24px; background: rgba(255,255,255,0.1); border: none; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: white; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.transform='scale(1)';">
        <i class='bx bx-x' style="font-size: 28px;"></i>
    </button>
    <img id="image-viewer-img" src="" alt="Profile Image" style="max-width: 90%; max-height: 90vh; border-radius: 4px; box-shadow: 0 24px 48px rgba(0,0,0,0.5); transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); object-fit: contain;">
</div>

<script>
    window.openImageViewer = function() {
        const imgModal = document.getElementById('image-viewer-modal');
        const imgViewer = document.getElementById('image-viewer-img');
        const coverImg = document.getElementById('profile-cover-img');
        if (coverImg && imgModal && imgViewer) {
            imgViewer.src = coverImg.src;
            imgModal.style.display = 'flex';
            // Trigger reflow
            void imgModal.offsetWidth;
            imgModal.style.opacity = '1';
            imgViewer.style.transform = 'scale(1)';
        }
    };

    window.closeImageViewer = function() {
        const imgModal = document.getElementById('image-viewer-modal');
        const imgViewer = document.getElementById('image-viewer-img');
        if (imgModal && imgViewer) {
            imgModal.style.opacity = '0';
            imgViewer.style.transform = 'scale(0.9)';
            setTimeout(() => {
                imgModal.style.display = 'none';
            }, 300);
        }
    };

    if (!window._imgViewerEventsBound) {
        document.addEventListener('click', function(e) {
            const imgModal = document.getElementById('image-viewer-modal');
            if (imgModal && e.target === imgModal) {
                window.closeImageViewer();
            }
        });

        document.addEventListener('keydown', function(e) {
            const imgModal = document.getElementById('image-viewer-modal');
            if (e.key === 'Escape' && imgModal && imgModal.style.display === 'flex') {
                window.closeImageViewer();
            }
        });
        window._imgViewerEventsBound = true;
    }
</script>

{{-- ═══════════════════════════════════════════════════════════════
 EDIT PROFILE MODAL
═══════════════════════════════════════════════════════════════ --}}
<div class="acc-modal-backdrop" id="ep-modal-backdrop"></div>
<div class="acc-modal" id="ep-modal">
    <div class="acc-modal-handle" id="ep-modal-handle"><span></span></div>
    <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 24px 16px;">
        <h4 style="color:#121212;font-size:18px;font-weight:700;margin:0;">Edit Profile</h4>
        <button id="ep-modal-close" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(0,0,0,0.1);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'"><i class='bx bx-x' style="font-size:20px;color:#888;"></i></button>
    </div>
    <div style="padding:20px 24px 40px;">
        {{-- Avatar --}}
        <div style="display:flex;align-items:center;gap:20px;">
            <div style="position:relative;width:80px;height:80px;flex-shrink:0;border-radius:50%;cursor:pointer;" id="ep-avatar-overlay">
                <div id="ep-avatar-preview" style="width:80px;height:80px;border-radius:50%;overflow:hidden;background:#e5e5e5;display:flex;align-items:center;justify-content:center;border:2px solid rgba(0,0,0,0.06);">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="ep-avatar-img" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div class="ep-avatar-placeholder"><i class='bx bx-user' style="color:#888;font-size:24px;"></i><span style="color:#121212;font-size:24px;font-weight:700;">{{ strtoupper(substr($user->name, 0, 1)) }}</span></div>
                    @endif
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <input type="file" id="ep-input-avatar" accept="image/jpeg,image/png,image/webp" hidden>
                <button type="button" id="ep-btn-upload" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:12px;border:1px solid rgba(0,0,0,0.1);background:#fff;color:#121212;font-size:13px;font-weight:500;cursor:pointer;"><i class='bx bx-upload' style="font-size:16px;color:#555;"></i> Ganti Foto</button>
                @if($user->avatar)
                <button type="button" class="ep-btn-remove" id="ep-btn-remove" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:12px;border:1px solid rgba(239,68,68,0.3);background:transparent;color:#ef4444;font-size:13px;font-weight:500;cursor:pointer;"><i class='bx bx-trash' style="font-size:16px;"></i> Hapus</button>
                @endif
                <p style="color:#888;font-size:11px;margin:0;">JPG, PNG, WEBP · Maks. 2MB</p>
            </div>
        </div>
        <div id="ep-avatar-toast"></div>
        <div style="height:1px;background:rgba(0,0,0,0.06);margin:20px 0;"></div>
        {{-- Form --}}
        <form id="ep-form-profile" style="display:flex;flex-direction:column;gap:16px;">
            <div><label style="color:#888;font-size:12px;font-weight:500;display:block;margin-bottom:6px;">Nama</label><div class="acc-input-wrap"><i class='bx bx-user'></i><input type="text" id="ep-input-name" name="name" value="{{ $user->name }}" required placeholder="Masukkan nama"></div></div>
            <div><label style="color:#888;font-size:12px;font-weight:500;display:block;margin-bottom:6px;">Email</label><div class="acc-input-wrap"><i class='bx bx-envelope'></i><input type="email" id="ep-input-email" name="email" value="{{ $user->email }}" required placeholder="Masukkan email"></div></div>
            <div style="display:flex;align-items:center;margin:4px 0;"><div style="flex:1;border-top:1px solid rgba(0,0,0,0.06);"></div><span style="padding:0 12px;color:#888;font-size:12px;">Ganti Password (Opsional)</span><div style="flex:1;border-top:1px solid rgba(0,0,0,0.06);"></div></div>
            <div><label style="color:#888;font-size:12px;font-weight:500;display:block;margin-bottom:6px;">Password Baru</label><div class="acc-input-wrap"><i class='bx bx-lock-alt'></i><input type="password" id="ep-input-password" name="password" placeholder="Kosongkan jika tidak ganti" minlength="8"><button type="button" class="ep-btn-toggle-pw" data-target="ep-input-password" style="background:none;border:none;cursor:pointer;padding:4px;"><i class='bx bx-hide' style="color:#888;font-size:18px;"></i></button></div></div>
            <div><label style="color:#888;font-size:12px;font-weight:500;display:block;margin-bottom:6px;">Konfirmasi Password</label><div class="acc-input-wrap"><i class='bx bx-lock-alt'></i><input type="password" id="ep-input-pw-confirm" name="password_confirmation" placeholder="Ulangi password baru" minlength="8"><button type="button" class="ep-btn-toggle-pw" data-target="ep-input-pw-confirm" style="background:none;border:none;cursor:pointer;padding:4px;"><i class='bx bx-hide' style="color:#888;font-size:18px;"></i></button></div></div>
            <div id="ep-form-message" style="display:none;padding:10px 14px;border-radius:12px;font-size:13px;"></div>
            <button type="submit" id="ep-btn-save" style="display:flex;align-items:center;justify-content:center;gap:8px;padding:14px 24px;border-radius:16px;border:none;background:#121212;color:#fff;font-size:15px;font-weight:600;cursor:pointer;transition:all 0.3s;margin-top:4px;font-family:inherit;"><i class='bx bx-check'></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

{{-- ═══ IMAGE CROP MODAL ═══ --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<div class="crop-modal-backdrop" id="crop-modal-backdrop"></div>
<div class="crop-modal" id="crop-modal">
    <div class="crop-modal-header">
        <h4><i class='bx bx-crop'></i> Sesuaikan Foto</h4>
        <button type="button" id="crop-modal-close" class="crop-modal-close"><i class='bx bx-x'></i></button>
    </div>
    <div class="crop-modal-body">
        <div class="crop-shape-toggle" style="display:flex; gap:8px; margin-bottom:16px; justify-content:center;">
            <button type="button" class="shape-btn active" data-shape="circle"><i class='bx bx-radio-circle' style="font-size:18px;"></i> Lingkaran</button>
            <button type="button" class="shape-btn" data-shape="square"><i class='bx bx-square' style="font-size:18px;"></i> Kotak</button>
        </div>
        <div class="crop-area-wrapper" style="width: 100%; aspect-ratio: 1; max-height: 400px; background: #1a1a1a; border-radius: 16px; overflow: hidden; position: relative; margin: 0 auto;">
            <img id="cropper-image" src="" style="max-width: 100%; display: block;">
        </div>
        <div class="crop-controls">
            <div class="crop-zoom-row" style="margin-top: 16px; display: flex; justify-content: center; gap: 16px;">
                <button type="button" id="crop-btn-zoom-out" class="crop-icon-btn" title="Zoom Out"><i class='bx bx-zoom-out'></i></button>
                <button type="button" id="crop-btn-zoom-in" class="crop-icon-btn" title="Zoom In"><i class='bx bx-zoom-in'></i></button>
                <button type="button" id="crop-btn-rotate-left" class="crop-icon-btn" title="Rotate Left"><i class='bx bx-rotate-left'></i></button>
                <button type="button" id="crop-btn-rotate-right" class="crop-icon-btn" title="Rotate Right"><i class='bx bx-rotate-right'></i></button>
                <button type="button" id="crop-btn-reset" class="crop-icon-btn" title="Reset"><i class='bx bx-reset'></i></button>
            </div>
        </div>
    </div>
    <div class="crop-modal-footer">
        <button type="button" id="crop-btn-cancel" class="crop-btn crop-btn-cancel"><i class='bx bx-x'></i> Batal</button>
        <button type="button" id="crop-btn-apply" class="crop-btn crop-btn-apply"><i class='bx bx-check'></i> Terapkan & Upload</button>
    </div>
</div>

{{-- Toast Container --}}
<div id="friend-toast-container" style="position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/css/user-account.css') }}">
@include('spa.fragments.partials.user-account-scripts')
{{-- ═══════════════════════════════════════════════════════════════
 PUBLIC PROFILE PAGE — Neo Bento Design
═══════════════════════════════════════════════════════════════ --}}
<div class="neo-dashboard rtd-dashboard">
<div class="neo-bento-container">

{{-- ── BACK TO PREVIOUS (Dashboard/Leaderboard) ─────────────────── --}}
<a href="#" onclick="history.back(); return false;" class="link-spa" style="display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#888;text-decoration:none;margin-bottom:24px;transition:color 0.2s;" onmouseover="this.style.color='var(--neo-text-dark, #121212)'" onmouseout="this.style.color='#888'">
    <i class='bx bx-arrow-back' style="font-size:18px;"></i> Kembali
</a>

{{-- ── BENTO GRID: Profile + Stats ──────────────────────────────── --}}
<div class="neo-bento-grid">
    {{-- Left Column: Profile Card --}}
    <div class="neo-bento-col">
        <div class="neo-card neo-card-light acc-profile-card" style="height:100%;">
            <div class="neo-header">
                <h3 class="neo-title">Profil<br>Publik</h3>
                <span class="neo-arrow">&#x2197;</span>
            </div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;padding:24px 0;">
                <div class="acc-avatar-wrap {{ $user->isPenguasaSektor() ? 'sovereign-aura-lg' : ($user->isElite() ? 'elite-aura-lg' : '') }}" style="cursor:pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onclick="openImageViewer()">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" id="profile-cover-img" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid rgba(0,0,0,0.08);">
                    @else
                        <div style="width:120px;height:120px;border-radius:50%;background:var(--neo-text-dark, #121212);display:flex;align-items:center;justify-content:center;">
                            <span style="font-size:48px;font-weight:800;color:var(--neo-text-light, #ffffff);">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <div style="text-align:center;">
                    <h4 id="display-name" class="{{ $user->isPenguasaSektor() ? 'sovereign-name-lg' : ($user->isElite() ? 'elite-name-lg' : '') }}" style="margin:0 0 4px;font-size:20px;font-weight:700;color:var(--neo-text-dark, #121212);">
                        @if($user->isPenguasaSektor())
                            <i class='bx bxs-crown' style="color:#fbbf24; margin-right:2px; font-size: 18px;"></i>
                        @endif
                        {{ $user->name }}
                    </h4>
                    <p id="display-email" style="margin:0;font-size:13px;color:#888;">{{ $user->masked_email }}</p>
                </div>
            </div>
            <div>
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px;">
                    <span class="neo-pill" style="font-size:14px;background:rgba(0,0,0,0.05);">{{ number_format($user->exp ?? 0) }} EXP</span>
                    <span class="neo-pill" style="font-size:14px;background:var(--neo-text-dark, #121212);color:var(--neo-text-light, #ffffff);border-color:var(--neo-text-dark, #121212);">Rank: {{ $user->rank_name }}</span>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="neo-pill">{{ $daysActive }} hari aktif</span>
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
                        <div style="font-size:56px;font-weight:800;color:var(--neo-text-dark, #121212);line-height:1;">{{ $quizAvgScore }}</div>
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
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--neo-text-dark, #121212)" stroke-width="3" stroke-dasharray="{{ $learningProgress }}, 100" stroke-linecap="round"/>
                        </svg>
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;color:var(--neo-text-dark, #121212);">{{ $learningProgress }}%</div>
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
            <div class="neo-card neo-card-black" style="flex:1;min-height:200px;background:var(--neo-card-black, #000000);color:var(--neo-text-light, #ffffff);padding:40px;display:flex;align-items:center;">
                <div style="width:100%;">
                    <div style="font-size:15px;font-weight:700;color:var(--neo-text-light, #ffffff);margin-bottom:16px;display:flex;align-items:center;">
                        <span>{{ $user->rank_name }}</span>
                        <span style="margin:0 10px;opacity:0.5;">&bull;</span>
                        <span>Bergabung {{ $user->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <h3 style="font-size:clamp(28px,3.5vw,40px);font-weight:800;line-height:1.15;letter-spacing:-0.02em;color:var(--neo-text-light, #ffffff);margin:0 0 32px;">
                        {{ $totalHistoryViews }} materi telah dibaca
                    </h3>
                    
                    @if ($user->id !== auth()->id() && isset($myFriendships))
                        @php
                            $friendship = $myFriendships->where('user_id', $user->id)->where('friend_id', auth()->id())->first()
                                        ?? $myFriendships->where('friend_id', $user->id)->where('user_id', auth()->id())->first();
                            $fStatus = $friendship ? $friendship->status : null;
                        @endphp
                        <div>
                            @if (!$friendship)
                                <button
                                    class="ldb-friend-btn neo-pill"
                                    data-url="{{ route('user.friend.add', $user->id) }}"
                                    style="padding: 10px 20px; font-size: 14px; background: var(--neo-text-light, #ffffff); border: none; color: var(--neo-card-black, #000000); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-weight: 700;">
                                    <i class='bx bx-user-plus'></i> Tambahkan Teman
                                </button>
                            @elseif ($fStatus === 'pending')
                                <button disabled
                                    class="neo-pill"
                                    style="padding: 10px 20px; font-size: 14px; background: var(--border-color); border: none; color: var(--neo-text-light, #ffffff); border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; cursor: not-allowed; font-weight: 700;">
                                    <i class='bx bx-time'></i> Menunggu Konfirmasi
                                </button>
                            @elseif ($fStatus === 'accepted')
                                <button disabled
                                    class="neo-pill"
                                    style="padding: 10px 20px; font-size: 14px; background: #10b981; border: none; color: var(--text-primary)fff; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; cursor: default; font-weight: 700;">
                                    <i class='bx bx-check'></i> Teman
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── ACHIEVEMENTS ──────────────────────────────────────────────── --}}
@if(!empty($achievements))
<div style="margin-top:48px;">
    <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:var(--neo-text-dark, #121212);">Pencapaian</h3>
    <p style="font-size:16px;color:#555;margin:0 0 24px;">Lencana yang dikumpulkan oleh {{ explode(' ', $user->name)[0] }}.</p>
    <div class="neo-card neo-card-light" style="padding:32px;">
        <div style="display:flex;flex-wrap:wrap;gap:24px;justify-content:center;">
            @foreach($achievements as $ach)
            <div class="acc-ach-item" title="{{ $ach['label'] }}: {{ $ach['desc'] }}">
                <img src="{{ asset('assets/ico/' . $ach['icon']) }}" alt="{{ $ach['label'] }}" style="width:64px;height:64px;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,0.1));transition:transform 0.2s;">
                <div style="text-align:center;margin-top:8px;">
                    <div style="font-size:12px;font-weight:700;color:var(--neo-text-dark, #121212);">{{ $ach['label'] }}</div>
                    <div style="font-size:10px;color:#888;">{{ $ach['desc'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
<div style="margin-top:48px;">
    <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:var(--neo-text-dark, #121212);">Pencapaian</h3>
    <div class="neo-card neo-card-light" style="text-align:center; padding: 40px 20px;">
        <i class='bx bx-medal' style="font-size: 48px; color: #aaa; margin-bottom: 12px;"></i>
        <h5 style="color: #666; font-size: 15px; font-weight: 500; margin: 0;">Belum memiliki lencana.</h5>
    </div>
</div>
@endif

{{-- ── SERTIFIKAT ──────────────────────────────────────────────── --}}
@if(isset($certificates) && $certificates->count() > 0)
<div style="margin-top:48px;">
    <h3 class="neo-title" style="font-size:28px;margin:0 0 8px;color:var(--neo-text-dark, #121212);">Sertifikasi</h3>
    <p style="font-size:16px;color:#555;margin:0 0 24px;">Sertifikat yang telah diraih oleh {{ explode(' ', $user->name)[0] }}.</p>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
        @foreach($certificates as $cert)
        <div class="neo-card neo-card-light" style="padding:20px;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                    <div style="width:40px;height:40px;background:linear-gradient(135deg,#06b6d4,#3b82f6);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;">
                        <i class='bx bx-check-shield'></i>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color: var(--text-primary)fff;line-height:1.2;">{{ $cert->materi->title ?? 'Materi' }}</div>
                        <div style="font-size:11px;color:#888;margin-top:4px;">{{ $cert->issued_at->translatedFormat('d M Y') }}</div>
                    </div>
                </div>
            </div>
            <a href="/certificate/{{ $cert->certificate_code }}" target="_blank" style="display:block;width:100%;text-align:center;padding:10px;background:rgba(0,0,0,0.05);color: var(--text-primary)fff;text-decoration:none;font-weight:600;font-size:13px;border-radius:8px;transition:all 0.2s;" onmouseover="this.style.background='#121212';this.style.color='#fff';" onmouseout="this.style.background='rgba(0,0,0,0.05)';this.style.color='#121212';">
                Lihat Kredensial
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

</div>
</div>

{{-- ── IMAGE VIEWER MODAL ────────────────────────────────────────── --}}
<div id="image-viewer-modal" style="position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 100000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(8px); opacity: 0; transition: opacity 0.3s ease;">
    <button onclick="closeImageViewer()" style="position: absolute; top: 24px; right: 24px; background: var(--border-color); border: none; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: white; transition: all 0.2s;" onmouseover="this.style.background='var(--border-color)'; this.style.transform='scale(1.1)';" onmouseout="this.style.background='var(--border-color)'; this.style.transform='scale(1)';">
        <i class='bx bx-x' style="font-size: 28px;"></i>
    </button>
    <img id="image-viewer-img" src="" alt="Profile Image" style="max-width: 90%; max-height: 90vh; border-radius: 16px; box-shadow: 0 24px 48px rgba(0,0,0,0.5); transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
</div>

<script>
(function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // ── Global toast helper ──────────────────────────────────────────
    if (typeof window.showFriendToast !== 'function') {
        window.showFriendToast = function (msg, type = 'success') {
            let container = document.getElementById('friend-toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'friend-toast-container';
                container.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;';
                document.body.appendChild(container);
            }
            const toast = document.createElement('div');
            toast.className = `friend-toast ${type}`;
            const icon = type === 'success' ? 'bx-check-circle' : 'bx-error-circle';
            toast.innerHTML = `<i class='bx ${icon}'></i> <span>${msg}</span>`;
            
            // basic styling if css not loaded
            toast.style.cssText = `display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:12px;font-size:13px;font-weight:500;color:#fff;box-shadow:0 8px 24px rgba(0,0,0,0.18);pointer-events:auto;min-width:220px;transition:opacity 0.4s;background:${type === 'success' ? '#10b981' : '#ef4444'};`;
            
            container.appendChild(toast);
            setTimeout(() => toast.style.opacity = '0', 3000);
            setTimeout(() => toast.remove(), 3500);
        };
    }

    // ── Add Friend (AJAX) ─────────────────────────────────────────────
    document.querySelectorAll('.ldb-friend-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            const url = this.dataset.url;
            if (!url) return;

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
                    this.innerHTML             = `<i class='bx bx-time'></i> Menunggu Konfirmasi`;
                    this.style.background      = 'var(--border-color)';
                    this.style.color           = '#ffffff';
                    this.style.cursor          = 'not-allowed';
                    this.disabled              = true;
                    window.showFriendToast(data.message, 'success');
                } else {
                    this.innerHTML        = `<i class='bx bx-user-plus'></i> Tambahkan Teman`;
                    this.style.background = '#ffffff';
                    this.style.color      = '#000000';
                    this.style.cursor     = 'pointer';
                    this.disabled         = false;
                    window.showFriendToast(data.message || 'Gagal mengirim permintaan.', 'error');
                }
            } catch (err) {
                this.innerHTML        = `<i class='bx bx-user-plus'></i> Tambahkan Teman`;
                this.style.background = '#ffffff';
                this.style.color      = '#000000';
                this.style.cursor     = 'pointer';
                this.disabled         = false;
                window.showFriendToast('Terjadi kesalahan koneksi. Coba lagi.', 'error');
            }
        });
    });

    // ── Image Viewer Logic ────────────────────────────────────────────
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
        // Close on background click
        document.addEventListener('click', function(e) {
            const imgModal = document.getElementById('image-viewer-modal');
            if (imgModal && e.target === imgModal) {
                window.closeImageViewer();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            const imgModal = document.getElementById('image-viewer-modal');
            if (e.key === 'Escape' && imgModal && imgModal.style.display === 'flex') {
                window.closeImageViewer();
            }
        });
        window._imgViewerEventsBound = true;
    }

})();
</script>

<link rel="stylesheet" href="{{ asset('assets/css/user-account.css') }}">

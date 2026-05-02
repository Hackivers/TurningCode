<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        <style>
            /* ═══ GUILD BENTO GRID ═══ */
            .guild-bento {
                display: grid;
                grid-template-columns: 1fr 1fr 1.1fr;
                grid-template-rows: auto auto;
                gap: 16px;
                margin-bottom: 48px;
            }

            /* ── Top-Left: Stats ── */
            .gb-stats {
                grid-column: 1;
                grid-row: 1;
                background: #f4f4f5;
                border-radius: 28px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .gb-stat-pill {
                background: #18181b;
                color: #fff;
                border-radius: 18px;
                padding: 14px 18px;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .gb-stat-pill .stat-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.08);
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .gb-stat-pill .stat-icon i {
                font-size: 18px;
                color: #a1a1aa;
            }

            .gb-stat-pill .stat-num {
                font-size: 22px;
                font-weight: 800;
                line-height: 1;
            }

            .gb-stat-pill .stat-label {
                font-size: 11px;
                color: #a1a1aa;
                font-weight: 500;
                margin-top: 2px;
            }

            .gb-stat-pill .stat-arrow {
                margin-left: auto;
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.08);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* ── Top-Middle: Watch Demo ── */
            .gb-demo {
                grid-column: 2;
                grid-row: 1;
                background: #fff;
                border-radius: 28px;
                padding: 22px;
                border: 1px solid rgba(0, 0, 0, 0.06);
                display: flex;
                flex-direction: column;
                gap: 14px;
            }

            .gb-demo-top {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
            }

            .gb-demo-badge {
                font-size: 11px;
                font-weight: 700;
                color: #52525b;
                border: 1px solid #e4e4e7;
                border-radius: 100px;
                padding: 4px 12px;
                display: inline-block;
            }

            .gb-demo-thumb {
                width: 56px;
                height: 56px;
                border-radius: 14px;
                object-fit: cover;
                border: 1px solid rgba(0, 0, 0, 0.04);
            }

            .gb-demo-bottom h4 {
                margin: 0 0 2px;
                font-size: 17px;
                font-weight: 800;
                color: #18181b;
            }

            .gb-demo-bottom p {
                margin: 0;
                font-size: 13px;
                color: #71717a;
                line-height: 1.4;
            }

            /* ── Right: Hero Image ── */
            .gb-hero {
                grid-column: 3;
                grid-row: 1 / span 2;
                border-radius: 28px;
                position: relative;
                overflow: hidden;
                min-height: 380px;
                display: flex;
                align-items: flex-end;
            }

            .gb-hero-img {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .gb-hero-overlay {
                position: relative;
                z-index: 2;
                width: calc(100% - 24px);
                margin: 12px;
                padding: 18px 20px;
                border-radius: 22px;
                background: rgba(255, 255, 255, 0.22);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.35);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .gb-hero-overlay .hero-text {
                font-size: 17px;
                font-weight: 700;
                color: #fff;
                line-height: 1.25;
                text-shadow: 0 1px 6px rgba(0, 0, 0, 0.25);
            }

            .gb-hero-overlay .hero-text span {
                display: block;
                font-size: 12px;
                font-weight: 500;
                opacity: .85;
                margin-top: 2px;
            }

            .gb-hero-btn {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: #18181b;
                color: #fff;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: transform .2s;
                flex-shrink: 0;
            }

            .gb-hero-btn:hover {
                transform: scale(1.08);
            }

            .gb-hero-btn i {
                font-size: 22px;
            }

            /* ── Bottom-Left: Big Typography ── */
            .gb-typo {
                grid-column: 1 / span 2;
                grid-row: 2;
                padding: 8px 0 0;
            }

            .gb-typo-heading {
                margin: 0;
                font-size: clamp(30px, 3.4vw, 46px);
                font-weight: 800;
                line-height: 1.06;
                letter-spacing: -1.5px;
                color: #18181b;
                max-width: 520px;
            }

            .gb-typo-row {
                display: flex;
                align-items: flex-end;
                gap: 14px;
                flex-wrap: wrap;
            }

            .gb-typo-cta {
                padding: 10px 22px;
                border-radius: 100px;
                background: #18181b;
                color: #fff;
                border: none;
                font-weight: 700;
                font-size: 13px;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: background .2s;
                margin-bottom: 6px;
            }

            .gb-typo-cta:hover {
                background: #27272a;
            }

            .gb-typo-cta i {
                font-size: 18px;
            }

            .gb-typo-avatars {
                display: flex;
                align-items: center;
                margin-bottom: 6px;
            }

            .gb-typo-avatars img {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                border: 2px solid #fff;
                object-fit: cover;
                margin-left: -8px;
            }

            .gb-typo-avatars img:first-child {
                margin-left: 0;
            }

            .gb-typo-desc {
                margin: 18px 0 0;
                font-size: 14px;
                color: #71717a;
                max-width: 520px;
                line-height: 1.65;
            }

            /* ── Tags Row ── */
            .gb-tags {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                margin-bottom: 40px;
            }

            .gb-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 18px;
                border-radius: 100px;
                border: 1px solid #e4e4e7;
                background: #fff;
                font-size: 12px;
                font-weight: 600;
                color: #3f3f46;
                white-space: nowrap;
            }

            .gb-tag i {
                font-size: 14px;
            }

            /* ── Responsive ── */
            @media (max-width: 1024px) {
                .guild-bento {
                    grid-template-columns: 1fr 1fr;
                }

                .gb-hero {
                    grid-column: 1 / span 2;
                    grid-row: auto;
                    min-height: 280px;
                }

                .gb-typo {
                    grid-column: 1 / span 2;
                }
            }

            @media (max-width: 640px) {
                .guild-bento {
                    grid-template-columns: 1fr;
                    gap: 12px;
                }

                .gb-stats,
                .gb-demo,
                .gb-hero,
                .gb-typo {
                    grid-column: 1;
                    grid-row: auto;
                }

                .gb-hero {
                    min-height: 240px;
                }

                .gb-typo-heading {
                    font-size: 28px;
                    letter-spacing: -1px;
                }
            }
        </style>

        <!-- ════════════════════════════════════════════
             BENTO HEADER
             ════════════════════════════════════════════ -->
        <div class="guild-bento">

            <!-- ▸ Top-Left · Stats -->
            <div class="gb-stats">
                <div class="gb-stat-pill">
                    <div class="stat-icon"><i class='bx bx-line-chart'></i></div>
                    <div>
                        <div class="stat-num">{{ $clans->count() }}+</div>
                        <div class="stat-label">Guild terdaftar</div>
                    </div>
                </div>
                <div class="gb-stat-pill">
                    <div class="stat-icon"><i class='bx bx-infinite'></i></div>
                    <div>
                        <div class="stat-num">18+</div>
                        <div class="stat-label">Fitur kolaborasi</div>
                    </div>
                    <div class="stat-arrow"><i class='bx bx-right-arrow-alt' style="color:#fff;font-size:16px"></i>
                    </div>
                </div>
            </div>

            <!-- ▸ Top-Middle · Demo / Info -->
            <div class="gb-demo">
                <div class="gb-demo-top">
                    <div>
                        <div class="gb-demo-badge">Panduan</div>
                    </div>
                    <img src="{{ asset('assets/img/guild-orbs.png') }}" class="gb-demo-thumb" alt="orbs">
                </div>
                <div class="gb-demo-bottom">
                    <h4>Pelajari Guild</h4>
                    <p>Cara kerja sistem guild & keuntungannya</p>
                </div>
            </div>

            <!-- ▸ Right · Hero Image -->
            <div class="gb-hero">
                <img src="{{ asset('assets/img/guild-hero.png') }}" class="gb-hero-img" alt="Guild Hero">
                <div class="gb-hero-overlay">
                    @if(Auth::user()->clans->count() < 2)
                        <div class="hero-text">buat guild <span>& mulai perjalananmu</span></div>
                        <button class="gb-hero-btn" onclick="openCreateClanModal()"><i class='bx bx-plus'></i></button>
                    @elseif(Auth::user()->clans->count() > 0)
                        <div class="hero-text">guild saya <span>& lihat statistik tim</span></div>
                        <button class="gb-hero-btn"
                            onclick="window.location.href='?page=clan-detail&id={{ Auth::user()->clans->first()->id }}'"><i
                                class='bx bx-right-arrow-alt'></i></button>
                    @endif
                </div>
            </div>

            <!-- ▸ Bottom-Left · Typography -->
            <div class="gb-typo">
                <div class="gb-typo-row">
                    <h1 class="gb-typo-heading">
                        Rasakan kekuatan belajar bersama tim
                    </h1>
                    <button class="gb-typo-cta"
                        onclick="document.getElementById('guild-list-section').scrollIntoView({behavior:'smooth'})">
                        Cari Guild <i class='bx bx-chevron-right'></i>
                    </button>
                </div>
                <p class="gb-typo-desc">
                    Temukan cara yang lebih seru untuk belajar. Dapatkan bonus poin,
                    selesaikan misi bersama, dan panjat papan peringkat global bersama
                    anggota timmu sekarang juga.
                </p>
            </div>

        </div>

        <!-- ═══ Tags ═══ -->
        <div class="gb-tags">
            <span class="gb-tag"><i class='bx bx-target-lock'></i> misi bersama</span>
            <span class="gb-tag"><i class='bx bx-broadcast'></i> kolaborasi</span>
            <span class="gb-tag"><i class='bx bx-shield-quarter'></i> sistem guild</span>
            <span class="gb-tag"><i class='bx bx-cloud'></i> cloud ranking</span>
            <span class="gb-tag"><i class='bx bx-bar-chart-alt-2'></i> data analytics</span>
        </div>

        <!-- ═══ My Guilds ═══ -->
        @if(isset($myClans) && $myClans->count() > 0)
            <div style="margin-bottom: 40px;">
                <h3 class="neo-title" style="font-size: 20px; margin: 0 0 20px;">Guild Saya</h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($myClans as $myClan)
                    @php $userMember = $myClan->members->where('user_id', Auth::id())->first(); @endphp
                    <div class="neo-card neo-card-light" onclick="window.location.href='?page=clan-detail&id={{ $myClan->id }}'"
                        style="padding: 28px; border-radius: 24px; border: 1px solid rgba(0,0,0,.06); background: #fff; cursor: pointer; transition: all .3s;"
                        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,.06)';"
                        onmouseout="this.style.transform=''; this.style.boxShadow='';">
                        <div
                            style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                            <div style="display: flex; align-items: center; gap: 18px;">
                                <div
                                    style="width: 64px; height: 64px; border-radius: 20px; background: #f4f4f5; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <img src="{{ asset('assets/ico/' . $myClan->emblem) }}"
                                        style="width: 44px; filter: drop-shadow(0 2px 6px rgba(0,0,0,.08));">
                                </div>
                                <div>
                                    <div
                                        style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 4px;">
                                        <h3 class="neo-title" style="margin: 0; font-size: 22px;">{{ $myClan->name }}</h3>
                                        <span class="neo-pill"
                                            style="padding: 3px 10px; background: rgba(245,158,11,.1); border-color: rgba(245,158,11,.2); color: #f59e0b; font-size: 11px; font-weight: 800;"><i
                                                class='bx bxs-star'></i> Lvl {{ $myClan->level }}</span>
                                    </div>
                                    <p style="margin: 0; font-size: 13px; color: #71717a;">
                                        {{ $myClan->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                            </div>
                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <div style="display: flex; gap: 8px; margin-right: 8px;">
                                    <span class="neo-pill"
                                        style="padding: 6px 12px; background: #f4f4f5; border: none; color: #52525b; font-size: 12px;"><i
                                            class='bx bxs-group'></i> {{ $myClan->members->count() }}/50</span>
                                    <span class="neo-pill"
                                        style="padding: 6px 12px; background: rgba(16,185,129,.08); border: none; color: #10b981; font-size: 12px;"><i
                                            class='bx bxs-bolt'></i> {{ number_format($myClan->exp) }} EXP</span>
                                </div>
                                <button onclick="event.stopPropagation(); copyInviteLink({{ $myClan->id }})"
                                    style="padding: 9px 18px; border-radius: 100px; background: #18181b; color: #fff; border: none; font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: background .2s;"
                                    onmouseover="this.style.background='#27272a'" onmouseout="this.style.background='#18181b'">
                                    <i class='bx bx-user-plus' style="font-size: 16px;"></i> Invite
                                </button>
                                @if($userMember && strtolower($userMember->role) !== 'leader')
                                    <button onclick="event.stopPropagation(); leaveClan({{ $myClan->id }})"
                                        style="padding: 9px 18px; border-radius: 100px; background: transparent; color: #ef4444; border: 1px solid rgba(239,68,68,.25); font-weight: 700; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all .2s;"
                                        onmouseover="this.style.background='#ef4444'; this.style.color='#fff'"
                                        onmouseout="this.style.background='transparent'; this.style.color='#ef4444'">
                                        <i class='bx bx-log-out' style="font-size: 16px;"></i> Keluar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        @endif

        <!-- ════════════════════════════════════════════
             GUILD LIST
             ════════════════════════════════════════════ -->
        <div id="guild-list-section"
            style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
            <h3 class="neo-title" style="font-size: 20px; margin: 0;">Daftar Guild Teratas</h3>
        </div>

        @if($clans->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($clans as $clan)
                    <div class="neo-card neo-card-light" onclick="window.location.href='?page=clan-detail&id={{ $clan->id }}'"
                        style="padding: 22px; border-radius: 22px; transition: all .3s cubic-bezier(.16,1,.3,1); cursor: pointer; border: 1px solid rgba(0,0,0,.05); background: #fff;"
                        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 16px 40px rgba(0,0,0,.06)'; this.style.borderColor='rgba(0,0,0,.1)'"
                        onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='rgba(0,0,0,.05)'">
                        <div class="neo-header" style="margin-bottom: 16px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                <img src="{{ asset('assets/ico/' . $clan->emblem) }}" alt="Emblem"
                                    style="width: 44px; height: 44px; object-fit: contain;">
                                <div>
                                    <h4 class="neo-title" style="margin: 0; font-size: 17px;">{{ $clan->name }}</h4>
                                </div>
                            </div>
                            <span class="neo-arrow" style="opacity: .4;">&#x2197;</span>
                        </div>

                        <p
                            style="font-size: 13px; color: #71717a; line-height: 1.55; margin: 0 0 20px 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 40px;">
                            {{ $clan->description ?? 'Tidak ada deskripsi.' }}
                        </p>

                        <div
                            style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid rgba(0,0,0,.05); padding-top: 16px;">
                            <div style="display: flex; gap: 8px;">
                                <span class="neo-pill"
                                    style="padding: 4px 10px; background: #fafafa; border-color: rgba(0,0,0,.05); color: #52525b; font-size: 11px;"><i
                                        class='bx bxs-group'></i> {{ $clan->members_count }}/50</span>
                                <span class="neo-pill"
                                    style="padding: 4px 10px; background: #fafafa; border-color: rgba(0,0,0,.05); color: #f59e0b; font-size: 11px;"><i
                                        class='bx bxs-star'></i> Lvl {{ $clan->level }}</span>
                            </div>
                            @if(!Auth::user()->clans->contains('id', $clan->id))
                                <button onclick="event.stopPropagation(); joinClan({{ $clan->id }}, this)"
                                    style="padding: 7px 16px; border-radius: 100px; background: transparent; color: #18181b; border: 1px solid rgba(0,0,0,.12); font-weight: 700; font-size: 12px; cursor: pointer; transition: all .2s;"
                                    onmouseover="this.style.background='#18181b'; this.style.color='#fff'; this.style.borderColor='#18181b'"
                                    onmouseout="this.style.background='transparent'; this.style.color='#18181b'; this.style.borderColor='rgba(0,0,0,.12)'">
                                    Gabung
                                </button>
                            @else
                                <span class="neo-pill"
                                    style="padding: 5px 14px; background: rgba(16,185,129,.1); border-color: rgba(16,185,129,.2); color: #10b981; font-size: 11px; font-weight: 700;"><i
                                        class='bx bx-check'></i> Bergabung</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="neo-card neo-card-light"
                style="text-align: center; padding: 60px 40px; border: 1px dashed rgba(0,0,0,.1); border-radius: 24px;">
                <div
                    style="width: 72px; height: 72px; background: #f4f4f5; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class='bx bx-shield-x' style="font-size: 36px; color: #a1a1aa;"></i>
                </div>
                <h4 class="neo-title" style="margin: 0 0 8px; font-size: 20px;">Belum ada Guild</h4>
                <p style="margin: 0; color: #a1a1aa; font-size: 14px;">Jadilah yang pertama membuat Guild di server ini!</p>
            </div>
        @endif

    </div>
</div>

<!-- ═══ Create Clan Modal ═══ -->
<div id="create-clan-modal"
    style="position: fixed; inset: 0; background: rgba(9, 9, 11, 0.65); z-index: 100000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); opacity: 0; transition: opacity .4s ease;">
    <div class="neo-card"
        style="width: 100%; max-width: 400px; padding: 40px; box-sizing: border-box; position: relative; transform: translateY(30px) scale(.95); transition: transform .5s cubic-bezier(.16,1,.3,1); border-radius: 28px; background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(255, 255, 255, 0.4); box-shadow: 0 24px 48px rgba(0,0,0,.15), inset 0 0 0 1px rgba(255,255,255,1);">
        
        <button type="button" onclick="closeCreateClanModal()"
            style="position: absolute; top: 20px; right: 20px; background: transparent; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #a1a1aa; transition: all .3s; z-index: 10;"
            onmouseover="this.style.color='#18181b'; this.style.transform='rotate(90deg) scale(1.1)'"
            onmouseout="this.style.color='#a1a1aa'; this.style.transform=''">
            <i class='bx bx-x' style="font-size: 26px;"></i>
        </button>
        
        <div style="margin-bottom: 32px; text-align: center;">
            <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #18181b 0%, #3f3f46 100%); border-radius: 22px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 12px 24px rgba(0,0,0,.2); transform: rotate(-6deg); transition: transform 0.3s ease;" onmouseover="this.style.transform='rotate(0deg)'" onmouseout="this.style.transform='rotate(-6deg)'">
                <i class='bx bxs-polygon' style="font-size: 32px; color: #fff; transform: rotate(6deg);" onmouseover="this.style.transform='rotate(0deg)'" onmouseout="this.style.transform='rotate(6deg)'"></i>
            </div>
            <h3 style="font-size: 24px; margin: 0 0 6px; font-weight: 800; letter-spacing: -0.5px; color: #18181b;">Initialize Guild</h3>
            <p style="margin: 0; color: #71717a; font-size: 14px; font-weight: 500;">Bentuk tim impianmu dan mulai penjelajahan.</p>
        </div>
        
        <form id="create-clan-form" onsubmit="submitCreateClan(event)">
            <div style="margin-bottom: 20px; position: relative;">
                <input type="text" name="name" required maxlength="50" placeholder="Nama Guild"
                    style="width: 100%; padding: 18px 22px; border-radius: 18px; border: 1px solid rgba(0,0,0,.05); background: rgba(244,244,245,.6); font-size: 15px; font-family: inherit; font-weight: 600; color: #18181b; box-sizing: border-box; outline: none; transition: all .3s; backdrop-filter: blur(10px);"
                    onfocus="this.style.borderColor='rgba(0,0,0,.15)'; this.style.background='#fff'; this.style.boxShadow='0 8px 24px rgba(0,0,0,.06)'"
                    onblur="this.style.borderColor='rgba(0,0,0,.05)'; this.style.background='rgba(244,244,245,.6)'; this.style.boxShadow='none'">
            </div>
            <div style="margin-bottom: 32px; position: relative;">
                <textarea name="description" rows="3" placeholder="Deskripsi singkat tentang guild ini..."
                    style="width: 100%; padding: 18px 22px; border-radius: 18px; border: 1px solid rgba(0,0,0,.05); background: rgba(244,244,245,.6); font-size: 14px; font-family: inherit; color: #3f3f46; box-sizing: border-box; outline: none; resize: none; transition: all .3s; backdrop-filter: blur(10px);"
                    onfocus="this.style.borderColor='rgba(0,0,0,.15)'; this.style.background='#fff'; this.style.boxShadow='0 8px 24px rgba(0,0,0,.06)'"
                    onblur="this.style.borderColor='rgba(0,0,0,.05)'; this.style.background='rgba(244,244,245,.6)'; this.style.boxShadow='none'"></textarea>
            </div>
            <button type="submit" id="btn-submit-clan"
                style="width: 100%; padding: 18px; border-radius: 18px; border: none; background: #18181b; color: #fff; font-size: 14px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all .3s; box-shadow: 0 10px 20px rgba(0,0,0,.1);"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 14px 28px rgba(0,0,0,.2)'; this.style.background='#27272a'" 
                onmouseout="this.style.transform='none'; this.style.boxShadow='0 10px 20px rgba(0,0,0,.1)'; this.style.background='#18181b'">
                CREATE MODULE <i class='bx bx-right-arrow-alt' style="vertical-align: middle; margin-left: 4px; font-size: 18px;"></i>
            </button>
        </form>
    </div>
</div>

<script>
    window.openCreateClanModal = function() {
        const modal = document.getElementById('create-clan-modal');
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.style.opacity = '1';
            modal.querySelector('.neo-card').style.transform = 'translateY(0) scale(1)';
        }, 10);
    };

    window.closeCreateClanModal = function() {
        const modal = document.getElementById('create-clan-modal');
        modal.style.opacity = '0';
        modal.querySelector('.neo-card').style.transform = 'translateY(20px) scale(.96)';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    };

    window.submitCreateClan = async function(e) {
        e.preventDefault();
        const form = e.target;
        const btn = document.getElementById('btn-submit-clan');
        const formData = new FormData(form);

        btn.disabled = true;
        btn.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i> Memproses...`;

        try {
            const res = await fetch('{{ route('user.clan.create') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(formData))
            });

            const data = await res.json();
            if (data.success) {
                closeCreateClanModal();
                if (window.showFriendToast) window.showFriendToast(data.message, 'success');
                setTimeout(() => {
                    window.location.href = '?page=clan-detail&id=' + data.clan_id;
                }, 1000);
            } else {
                if (window.showFriendToast) window.showFriendToast(data.message, 'error');
                btn.disabled = false;
                btn.innerHTML = `CREATE MODULE <i class='bx bx-right-arrow-alt' style="vertical-align: middle; margin-left: 4px; font-size: 18px;"></i>`;
            }
        } catch (err) {
            if (window.showFriendToast) window.showFriendToast('Terjadi kesalahan koneksi.', 'error');
            btn.disabled = false;
            btn.innerHTML = `CREATE MODULE <i class='bx bx-right-arrow-alt' style="vertical-align: middle; margin-left: 4px; font-size: 18px;"></i>`;
        }
    };

    window.joinClan = async function(clanId, btn) {
        btn.disabled = true;
        const originalText = btn.innerHTML;
        btn.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i>`;

        try {
            const res = await fetch(`{{ url('/app/api/clan/join') }}/${clanId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                if (window.showFriendToast) window.showFriendToast(data.message, 'success');
                setTimeout(() => {
                    window.location.href = '?page=clan-detail&id=' + clanId;
                }, 1000);
            } else {
                if (window.showFriendToast) window.showFriendToast(data.message, 'error');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } catch (err) {
            if (window.showFriendToast) window.showFriendToast('Terjadi kesalahan.', 'error');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    };

    window.leaveClan = async function(clanId = null) {
        const result = await Swal.fire({
            title: 'Keluar dari Guild?',
            text: 'Anda akan kehilangan akses ke fitur guild ini.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal'
        });
        if (!result.isConfirmed) return;

        const bodyData = clanId ? { clan_id: clanId } : {};

        try {
            const res = await fetch('{{ route('user.clan.leave') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(bodyData)
            });
            const data = await res.json();
            if (data.success) {
                Swal.fire({ title: 'Berhasil!', text: data.message, icon: 'success', timer: 2000, showConfirmButton: false });
                setTimeout(() => window.location.reload(), 1500);
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error');
        }
    };

    window.copyInviteLink = function(clanId) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', 'clan-detail');
        url.searchParams.set('id', clanId);
        url.hash = '';

        navigator.clipboard.writeText(url.toString()).then(() => {
            Swal.fire({
                title: 'Tersalin!',
                text: 'Link undangan guild berhasil disalin ke clipboard.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = url.toString();
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            Swal.fire({
                title: 'Tersalin!',
                text: 'Link undangan guild berhasil disalin ke clipboard.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        });
    };
</script>
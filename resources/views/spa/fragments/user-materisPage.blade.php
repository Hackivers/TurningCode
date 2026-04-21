<div class="container container-header headerbar">
    <header class="main-header-materi">
        <div class="tittle-header-materi">
            <div>
                <h4>{{ $firstMateri->title ?? '-' }}</h4>
                <h5>buat apa belajar materi ini...</h5>
            </div>
        </div>
        <div class="thumb-header-materi">
            <img src="{{ asset('assets/ico/img005.png') }}" alt="Thumbnail" />
        </div>
    </header>
</div>
<div class="tittle-submateri">
    <div>
        <h4>yok mulai dari fundamental dulu!!</h4>
        <h5>mulai lah yang paling dasar dulu yak</h5>
    </div>
</div>
@php
    $progressData = $progressData ?? [];
@endphp
<div class="container-submateri">
    <main class="main-submateri">
        <div class="wrapper-submateri">
            @foreach ($materis as $materi)
                <section
                    class="box-submateri {{ $progressData[$materi->id]['completed'] ?? false ? 'completed' : '' }}">
                    <div class="archive-submateri">
                        <i class="bx {{ in_array($materi->id, $arsipMateri ?? []) ? 'bxs-star active' : 'bx-star' }} archive-btn"
                            data-id="{{ $materi->id }}" data-type="materi">
                        </i>
                    </div>
                    <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa">
                        <div class="cover-submateri">
                            <div class="desc-submateri materi">
                                <h4>{{ $materi->title }}</h4>
                                <h5>gass belajar {{ $materi->title }}</h5>
                                <div class="on-progres-sub">
                                    <h6>
                                        {{ $progressData[$materi->id]['completed'] ?? false ? 'completed' : 'on progress' }}
                                    </h6>

                                    <h6>
                                        {{ $progressData[$materi->id]['done'] ?? 0 }}
                                        -
                                        {{ $progressData[$materi->id]['total'] ?? 0 }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="thumb-submateri">
                        <div class="thumb-cover-submateri"></div>
                        <img src="{{ asset('assets/img/img001non.jpg') }}" alt="">
                    </div>
                </section>
            @endforeach
        </div>
    </main>
</div>

<script>
    // ── Search Handler ────────────────────────────────────────────
    window.__currentSearchHandler = function(query) {
        document.querySelectorAll('.box-submateri').forEach(card => {
            const title = card.querySelector('.desc-submateri h4')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.desc-submateri h5')?.textContent.toLowerCase() || '';
            if (title.includes(query) || desc.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });

        if (query !== '') {
            const firstVisible = Array.from(document.querySelectorAll('.box-submateri')).find(c => c.style.display !== 'none');
            if (firstVisible) {
                setTimeout(() => {
                    firstVisible.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 50);
            }
        }
    };
</script>

<style>
/* ═══ ROTOOD DARK — MATERI PAGE ═══ */
.container-header.headerbar {
    background: #111 !important;
    border: 1px solid #1a1a1a !important;
    border-radius: 28px !important;
    margin: 1rem 24px !important;
}
.main-header-materi { background: transparent !important; }
.tittle-header-materi div h4 { color: #eee !important; }
.tittle-header-materi div h5 { color: #666 !important; }

.tittle-submateri { padding: 1rem 24px 0 !important; }
.tittle-submateri div h4 { color: #eee !important; font-size: 18px !important; font-weight: 700 !important; }
.tittle-submateri div h5 { color: #666 !important; }

.container-submateri { padding: 0 24px !important; }
.box-submateri {
    background: #111 !important;
    border: 1px solid #1a1a1a !important;
    border-radius: 28px !important;
}
.box-submateri:hover { border-color: #333 !important; }
.box-submateri.completed { border-color: #1a3a1a !important; }
.desc-submateri h4 { color: #eee !important; }
.desc-submateri h5 { color: #666 !important; }
.on-progres-sub h6 { color: #888 !important; }
.thumb-submateri { border-radius: 20px !important; overflow: hidden !important; }
.thumb-cover-submateri { background: linear-gradient(to right, #111, transparent) !important; }
.archive-submateri i { color: #555 !important; }
.archive-submateri i.active { color: #f59e0b !important; }
</style>













{{-- @if ($materis && count($materis))
    @php
        $firstMateri = $materis->first();
        $arsipSub = $arsipSub ?? [];
        $progressData = $progressData ?? [];
    @endphp
    <div class="container container-header headerbar">
        <header class="main-header-materi">
            <div class="tittle-header-materi">
                <div>
                    <h4>{{ $firstMateri->title ?? '-' }}</h4>
                    <h5>buat apa belajar materi ini...</h5>
                </div>
            </div>
            <div class="thumb-header-materi">
                <img src="{{ asset('assets/ico/img005.png') }}" alt="Thumbnail" />
            </div>
        </header>
    </div>
    <div class="container container-show-materi">
        <main class="main-show-materi">
            <div class="tittle-show-materi">
                <h4>about {{ $firstMateri->title ?? '-' }}</h4>
            </div>
            <div class="wrapper-show-materi">
                @foreach ($materis as $materi)
                    <div>
                        <a href="?page=submateri&materi_id={{ $materi->id }}" class="link-spa">
                            <figure
                                class="box-show-materi-thumb {{ $progressData[$materi->id]['completed'] ?? false ? 'completed' : '' }}">
                                <div class="dis-flex">
                                    <div class="subtittle-show-materi-thumb">
                                        <div class="subtittle-show-materi-thumb-img">
                                            <img class="wid-full" src="{{ asset('assets/ico/adminUser.jpg') }}"
                                                alt="" />
                                            <img class="wid-full" src="{{ asset('assets/ico/adminUser.jpg') }}"
                                                alt="" />
                                        </div>
                                        <div>
                                            <h5>
                                                ({{ $progressData[$materi->id]['done'] ?? 0 }}/{{ $progressData[$materi->id]['total'] ?? 0 }})
                                            </h5>
                                            <h3 class="bold-55 txt-cap">{{ $materi->title }}</h3>
                                        </div>
                                    </div>
                                    <div class="thum-show-materi-thumb dis-flex">
                                        <img class="wid-full" src="{{ asset('assets/ico/adminUser.jpg') }}"
                                            alt="" />
                                    </div>
                                </div>
                            </figure>
                        </a>
                        <div class="box-show-materi">
                            <div>
                                <div class="icon-show-materi">
                                    <i class='bx bx-code'></i>
                                </div>
                                <div class="desc-show-materi">
                                    <h6>
                                        <h6>{{ $materi->mainMateri->title }}</h6>
                                        <span>></span>
                                        <h6>{{ $materi->title }}</h6>
                                    </h6>
                                </div>
                                <div>
                                    <i class="bx {{ in_array($materi->id, $arsipMateri ?? []) ? 'bxs-star active' : 'bx-star' }} archive-btn"
                                        data-id="{{ $materi->id }}" data-type="materi">
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
@endif --}}

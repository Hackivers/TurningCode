<div class="container conatiner-detail-materi">
    <main class="main-detail-materi">
        <div class="wrapper-detail-materi">
            <div class="breadcrumb">
                <h6>
                    {{ $subMateri->materi->mainMateri->title ?? '-' }}
                    <i class='bx bx-chevron-right'></i>
                    {{ $subMateri->materi->title ?? '-' }}
                    <i class='bx bx-chevron-right'></i>
                    <span>{{ $subMateri->title }}</span>
                </h6>
            </div>
            <div class="back-button">
                <button class="btn-back">
                    <i class='bx bx-arrow-back'></i> Kembali
                </button>
            </div>
            <main class="box-detail-materi">
                <div>
                    <div class="meta">
                        <h5>{{ $subMateri->author ?? 'Unknown' }}</h5>
                    </div>
                    <div class="box-tittle-materi">
                        <h2>Materi kali ini akan belajar - {{ $subMateri->title }}</h2>
                    </div>
                    @if ($subMateri->thumbnail)
                        <div class="box-thumb-materi">
                            <img src="{{ asset('storage/' . $subMateri->thumbnail) }}">
                        </div>
                    @endif
                    <div class="box-content-materi">
                        @php
                            $sections = is_array($subMateri->sections)
                                ? $subMateri->sections
                                : json_decode($subMateri->sections, true);
                        @endphp
                        @if (!empty($sections))

                            @foreach ($sections as $index => $sec)
                                @if ($sec['type'] == 'heading')
                                    <h3 class="sec-heading">
                                        {{ $sec['value'] }}
                                    </h3>
                                @endif

                                @if ($sec['type'] == 'subheading')
                                    <h4 class="sec-subheading">
                                        {{ $sec['value'] }}
                                    </h4>
                                @endif

                                @if ($sec['type'] == 'content')
                                    <h5 class="sec-content">
                                        {!! $sec['value'] !!}
                                    </h5>
                                @endif
                            @endforeach
                        @else
                            <p>Tidak ada konten</p>
                        @endif
                    </div>
                    <div class="box-materi-navigation">
                        <hr>
                        <div>
                            @if (!empty($prev))
                                <a href="?page=detail&submateri_id={{ $prev->id }}" class="btn-prev link-spa">
                                    <i class='bx bx-left-arrow-alt'></i>
                                    Prev
                                </a>
                            @endif
                            <hr>
                            @if (!empty($next))
                                <a href="?page=detail&submateri_id={{ $next->id }}" class="btn-next link-spa">
                                    Next
                                    <i class='bx bx-right-arrow-alt'></i>
                                </a>
                            @else
                                <h5>end</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </main>
</div>
<script>
    document.addEventListener("click", function(e) {
        if (e.target.closest(".btn-back")) {

            // 🔥 cek kalau tidak ada history SPA
            if (!document.referrer || document.referrer === location.href) {
                loadPage("dashboard");
                return;
            }

            history.back();
        }
    });
</script>














{{-- <div class="container container-detail-materi">
    <section class="main-detail-materi">
        <div class="wrapper-detail-materi">

            <div class="breadcrumb">
                <h6>
                    {{ $subMateri->materi->mainMateri->title ?? '-' }}
                    <i class='bx bx-chevron-right'></i>
                    {{ $subMateri->materi->title ?? '-' }}
                    <i class='bx bx-chevron-right'></i>
                    <span>{{ $subMateri->title }}</span>
                </h6>
            </div>

            <div class="title-materi">
                <h2>{{ $subMateri->title }}</h2>
                @if ($subMateri->subtitle)
                    <p class="subtitle">{{ $subMateri->subtitle }}</p>
                @endif
            </div>

            <div class="meta">
                <span>✍️ {{ $subMateri->author ?? 'Unknown' }}</span>
            </div>

            @if ($subMateri->thumbnail)
                <div class="thumbnail">
                    <img src="{{ asset('storage/' . $subMateri->thumbnail) }}">
                </div>
            @endif

            <div class="content-materi">

                @php
                    $sections = is_array($subMateri->sections)
                        ? $subMateri->sections
                        : json_decode($subMateri->sections, true);
                @endphp

                @if (!empty($sections))

                    @foreach ($sections as $index => $sec)

                        @if ($sec['type'] == 'heading')
                            <h2 class="sec-heading">
                                {{ $sec['value'] }}
                            </h2>
                        @endif

                        @if ($sec['type'] == 'subheading')
                            <h4 class="sec-subheading">
                                {{ $sec['value'] }}
                            </h4>
                        @endif

                        @if ($sec['type'] == 'content')
                            <div class="sec-content">
                                {!! $sec['value'] !!}
                            </div>
                        @endif
                    @endforeach
                @else
                    <p>Tidak ada konten</p>
                @endif

            </div>

            <div class="materi-navigation">

                @if (!empty($prev))
                    <a href="?page=detail&submateri_id={{ $prev->id }}" class="btn-prev link-spa">
                        <i class='bx bx-left-arrow-alt'></i>
                        Prev
                    </a>
                @endif

                @if (!empty($next))
                    <a href="?page=detail&submateri_id={{ $next->id }}" class="btn-next link-spa">
                        Next
                        <i class='bx bx-right-arrow-alt'></i>
                    </a>
                @endif

            </div>

        </div>
    </section>
</div> --}}

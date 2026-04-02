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
        <h4>gass pelajari semuanya!!</h4>
        <h5>kayaknya seru nih</h5>
    </div>
</div>
@php
    $subMateris = $subMateris ?? [];
@endphp
<div class="container-submateri">
    <main class="main-submateri">
        <div class="wrapper-submateri">
            @foreach ($subMateris as $subMateri)
                <section class="box-submateri {{ in_array($subMateri->id, $completed ?? []) ? 'completed' : '' }}">
                    <div class="archive-submateri">
                        <i class="bx {{ in_array($subMateri->id, $arsipSub ?? []) ? 'bxs-star active' : 'bx-star' }} archive-btn"
                            data-id="{{ $subMateri->id }}" data-type="sub">
                        </i>
                    </div>
                    <a href="?page=detail&submateri_id={{ $subMateri->id }}" class="link-spa">
                        <div class="cover-submateri">
                            <div class="desc-submateri sub">
                                <h6>completed</h6>
                                <h4>{{ $subMateri->title }}</h4>
                                <h5>{{ $subMateri->content }}</h5>
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


{{--
@php
    $subMateris = $subMateris ?? [];
    $arsipSub = $arsipSub ?? [];
@endphp
<div class="page-submateri container container-header headerbar">
    <header class="main-header-materi">
        <div class="tittle-header-materi">
            <div>
                <h4>{{ $materi->title }}</h4>
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
            <h4>about {{ $materi->title }}</h4>
            <h5>{{ $materi->description }}</h5>
        </div>

        <div class="wrapper-show-materi">

            @foreach ($subMateris as $subMateri)
                <div>
                    <a href="?page=detail&submateri_id={{ $subMateri->id }}" class="link-spa">
                        <figure
                            class="box-show-materi-thumb {{ in_array($subMateri->id, $completed ?? []) ? 'completed' : '' }}">
                            <div class="dis-flex">
                                <div class="subtittle-show-materi-thumb">
                                    <div class="subtittle-show-materi-thumb-img">
                                        <img class="wid-full" src="{{ asset('assets/ico/adminUser.jpg') }}"
                                            alt="" />
                                        <img class="wid-full" src="{{ asset('assets/ico/adminUser.jpg') }}"
                                            alt="" />
                                    </div>
                                    <div>
                                        <h5>{{ $materi->title }}</h5>
                                        <h3 class="bold-55 txt-cap">{{ $subMateri->title }}</h3>
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
                                <h5>{{ Str::limit(strip_tags($subMateri->content), 80) }}</h5>
                            </div>
                            <div>
                                <i class="bx {{ in_array($subMateri->id, $arsipSub ?? []) ? 'bxs-star active' : 'bx-star' }} archive-btn"
                                    data-id="{{ $subMateri->id }}" data-type="sub">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </main>
</div> --}}

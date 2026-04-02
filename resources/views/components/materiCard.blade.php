<div class="tittle-materi">
    <div>
        <h4>Mau ngulik apa hari ini?</h4>
        <h5>Masih bingung arah? Web dev, app dev, game dev — gas aja dulu, nanti juga nemu jalan</h5>
    </div>
</div>
<div class="conatiner container-materi materibar">
    <main class="main-materi">
        <div class="wrapper-materi" id="scrollingMaterial">
            @foreach ($mainMateri as $materi)
                <section class="box-materi {{ $materi->is_completed ? 'completed' : '' }}">
                    <div class="wrapper-materi-cover">
                        <div class="main-cover-materi">
                            @if ($materi->is_coming_soon)
                                <div class="coming-soon-materi">
                                    <h4>Coming soon</h4>
                                </div>
                            @else
                            @endif
                            <div class="cover-materi">
                                <div class="txt-materi">
                                    <div>
                                        <div>
                                            <h4>{{ $materi->title }}</h4>
                                        </div>
                                        <div class="desc-materi">
                                            <h6>{{ $materi->description }}</h6>
                                        </div>
                                        <div class="subdesc-materi">
                                            <h6>{{ $materi->total_materi }}+ materi</h6>
                                            <h6>{{ $materi->total_submateri }}+ sub materi</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-materi">
                                <img src="{{ asset('assets/img/img00' . (($loop->iteration % 3) + 1) . 'non.jpg') }}"
                                    alt="">
                            </div>
                        </div>
                        @if ($materi->is_coming_soon)
                            <div class="materi-btn">
                                <button class="btn-disabled">tunggu yak</button>

                            </div>
                        @else
                            <a href="?page=materi&main_id={{ $materi->id }}" class="link-spa" data-page="materi"
                                data-id="{{ $materi->id }}">
                                <div class="materi-btn">
                                    <button>yok join room</button>
                                </div>
                            </a>
                        @endif
                    </div>
                </section>
            @endforeach
        </div>
    </main>
</div>

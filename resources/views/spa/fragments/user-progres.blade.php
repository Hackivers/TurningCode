<div class="tittle-progres">
    <div>
        <h4>progres mu sampai mana nih!!...</h4>
        <h5>waahh!, GG udah mulai berani melangkah</h5>
    </div>
</div>
<div class="container-progres">
    <main class="main-progres">
        <div class="wrapper-progres">
            @foreach ($mainMateri as $main)
                @if ($main->is_coming_soon)
                    @continue
                @endif
                <section class="box-progres">
                    <div class="persent-progres">
                        <h4>{{ $main->progress_percent }}%</h4>
                    </div>
                    <div class="cover-progres">
                        <div class="desc-progres">
                            <h4>{{ $main->title }}</h4>
                            <h5>terakhir kamu belajar : </h5>
                            @php
                                $totalBar = 7;
                                $activeBar = round(($main->progress_percent / 100) * $totalBar);
                            @endphp
                            <div class="wrapper-progresbar">
                                @for ($i = 0; $i < $totalBar; $i++)
                                    <span
                                        class="
                                        bar
                                        {{ $i < $activeBar ? 'active' : 'nonactive' }}

                                        {{-- ACTIVE --}}
                                        {{ $activeBar == 1 && $i == 0 ? 'single-active' : '' }}
                                        {{ $activeBar > 1 && $i == 0 ? 'first-active' : '' }}
                                        {{ $activeBar > 1 && $i == $activeBar - 1 ? 'last-active' : '' }}

                                        {{-- NONACTIVE --}}
                                        {{ $i == $activeBar ? 'first-nonactive' : '' }}
                                        {{ $i == $totalBar - 1 && $activeBar < $totalBar ? 'last-nonactive' : '' }}
                                    "
                                        style="animation-delay: {{ $i * 0.12 }}s"></span>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="thumb-progres">
                        <div class="thumb-cover-progres"></div>
                        <img src="{{ asset('assets/img/img00' . (($loop->iteration % 3) + 1) . 'non.jpg') }}"
                            alt="">
                    </div>
                </section>
            @endforeach
        </div>
    </main>
</div>

{{-- <div class="container container-progres">
    <main class="main-progres">

        <div class="tittle-progres">
            <h4>Progres</h4>
        </div>

        <div class="wrapper-progres">

            @foreach ($mainMateri as $main)
                <section class="box-progres">

                    <div class="progres-tittle-materi">
                        <h5>{{ $main->title }}</h5>
                        <h6>{{ $main->progress_percent }}%</h6>
                    </div>

                    <div class="wrapper-main-progres">

                        @foreach ($main->materis as $materi)
                            @php
                                $total = $materi->progress_total ?? 0;
                                $done = $materi->progress_done ?? 0;
                                $percent = $materi->progress_percent ?? 0;
                            @endphp

                            <div class="box-progresbar">

                                <div class="progres-tittle-submateri">
                                    <h6>{{ $materi->title }}</h6>
                                </div>

                                <div class="wrapper-progresbar">

                                    <div class="progresbar">

                                        @php
                                            $doneIndex = -1;

                                            foreach ($materi->submateris as $i => $s) {
                                                if (in_array($s->id, $arsipSub ?? [])) {
                                                    $doneIndex = $i;
                                                }
                                            }
                                        @endphp

                                        @foreach ($materi->submateris as $i => $sub)
                                            <span class="{{ $i <= $doneIndex ? 'active' : '' }}"></span>
                                        @endforeach

                                    </div>

                                    <div class="persent-progres">
                                        <h5>{{ $percent }}%</h5>
                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </section>
            @endforeach

        </div>

    </main>
</div> --}}

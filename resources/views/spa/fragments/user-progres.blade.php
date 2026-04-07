@php
    $hasProgress = $mainMateri->contains(fn($m) => $m->progress_percent > 0);
@endphp

@if ($hasProgress)
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
                @if ($main->is_coming_soon || $main->progress_percent <= 0)
                    @continue
                @endif
                <section class="box-progres">
                    <div class="persent-progres">
                        <h4>{{ $main->progress_percent }}%</h4>
                    </div>
                    <div class="cover-progres">
                        <div class="desc-progres">
                            <h4>{{ $main->title }}</h4>
                            <h5>
                                @if ($main->last_studied_title)
                                    terakhir belajar : {{ $main->last_studied_title }}
                                    @if ($main->last_studied_at)
                                        · {{ $main->last_studied_at->diffForHumans() }}
                                    @endif
                                @else
                                    belum mulai belajar nih, yok gas!
                                @endif
                            </h5>
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
@endif


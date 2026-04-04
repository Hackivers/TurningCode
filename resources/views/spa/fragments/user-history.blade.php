<div class="tittle-history">
    <div>
        <h4>riwayat belajar mu apa aja nih?</h4>
        <h5>mau belajar materi lama ada disini nih</h5>
    </div>
</div>

<div class="box-filter">
    <div>
        <div class="filter-btn active" data-filter="all">
            <h5>all</h5>
        </div>
        @foreach ($filters as $f)
            <div class="filter-btn" data-filter="{{ strtolower($f) }}">
                <h5>{{ strtolower($f) }}</h5>
            </div>
        @endforeach
    </div>
</div>

<div class="container-history">
    <main class="main-history">
        <div class="wrapper-history">
            @php
                $imgMap = [
                    1 => 'img002non.jpg',
                    2 => 'img003non.jpg',
                    3 => 'img001non.jpg',
                ];
            @endphp

            @if ($histories && count($histories))
                @foreach ($histories as $history)
                    @if ($history->submateri && $history->submateri->materi)
                        @php
                            $mainId = $history->submateri->materi->mainMateri->id ?? 1;
                            $img    = $imgMap[$mainId] ?? 'img001non.jpg';
                        @endphp
                        <a href="?page=detail&submateri_id={{ $history->submateri->id }}" class="link-spa history-item"
                            data-filter="{{ strtolower($history->submateri->materi->title) }}">
                            <section class="box-history">
                                <div class="persent-history">
                                    <h4>{{ $history->viewed_at->diffForHumans() }}</h4>
                                </div>
                                <div class="cover-history">
                                    <div class="desc-history">
                                        <h4>{{ $history->submateri->materi->mainMateri->title ?? '-' }}</h4>
                                        <h5>{{ $history->submateri->materi->title }} → {{ $history->submateri->title }}</h5>
                                    </div>
                                </div>
                                <div class="thumb-history">
                                    <div class="thumb-cover-history"></div>
                                    <img src="{{ asset('assets/img/' . $img) }}" alt="">
                                </div>
                            </section>
                        </a>
                    @endif
                @endforeach
            @else
                <div class="tittle-history-info">
                    <div>
                        <h4>yah kamu belum ada history nih!!</h4>
                        <h5>yok mulai belajar biar punya history</h5>
                    </div>
                </div>
            @endif
        </div>
    </main>
</div>

<script>
    // ── Filter history by materi ──────────────────────────────────────
    (function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items      = document.querySelectorAll('.history-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Toggle active class
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;

                items.forEach(item => {
                    if (filter === 'all' || item.dataset.filter === filter) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    })();
</script>

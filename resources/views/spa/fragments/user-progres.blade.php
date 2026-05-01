@php
    $hasProgress = $mainMateri->contains(fn($m) => $m->progress_percent > 0);
    $activeMateri = $mainMateri->filter(fn($m) => $m->progress_percent > 0 && !$m->is_coming_soon)->take(2);
@endphp

@if ($hasProgress && $activeMateri->count())
    @foreach ($activeMateri as $main)
        <a href="?page=materi&main_id={{ $main->id }}" class="neo-card neo-card-light progres-card-wrapper"
            style="min-height: 260px; display: flex; flex-direction: column; justify-content: space-between;">
            <div class="neo-header">
                <h3 class="neo-title" style="max-width: 80%;">{{ $main->title }}</h3>
                <span class="neo-arrow">&#x2197;</span>
            </div>

            <div class="progres-img-wrapper"
                style="display: flex; justify-content: center; align-items: center; padding: 20px 0; flex: 1;">
                <img src="{{ asset('assets/img/img00' . (($loop->iteration % 3) + 1) . 'non.jpg') }}" alt=""
                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; filter: grayscale(100%); mix-blend-mode: multiply; opacity: 0.8;">
            </div>

            <div>
                <p class="neo-desc progres-desc" style="margin-bottom: 16px; font-weight: 500;">
                    Melanjutkan ke tahap berikutnya.
                </p>
                <div class="progres-pill-container" style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <span class="neo-pill">{{ $main->progress_percent }}% Selesai</span>
                    @if ($main->last_studied_at)
                        <span class="neo-pill" title="Terakhir belajar">{{ $main->last_studied_at->diffForHumans() }}</span>
                    @endif
                </div>
            </div>
        </a>
    @endforeach

    @if($activeMateri->count() == 1)
        <!-- Fill the empty grid slot to maintain structural symmetry -->
        <div class="neo-card neo-card-light progres-empty-wrapper"
            style="justify-content: center; align-items: center; opacity: 0.4;">
            <i class='bx bx-book-bookmark' style="font-size: 64px; color: #a1a1aa; margin-bottom: 24px;"></i>
            <p style="font-size: 14px; font-weight: 500; color: #555; text-align: center;">Eksplor lebih banyak materi.</p>
        </div>
    @endif
@else
    <a href="?page=materi" class="neo-card neo-card-light progres-start-wrapper"
        style="min-height: 240px; grid-column: 1 / -1;">
        <div class="neo-header">
            <h3 class="neo-title">Mulai Perjalananmu</h3>
            <span class="neo-arrow">&#x2197;</span>
        </div>
        <div class="progres-img-wrapper"
            style="display: flex; justify-content: center; align-items: center; padding: 20px 0; flex: 1;">
            <i class='bx bx-rocket' style="font-size: 80px; color: #a1a1aa; opacity: 0.5;"></i>
        </div>
        <div>
            <p class="neo-desc progres-desc" style="font-weight: 500;">Pilih materi pertama yang ingin kamu pelajari hari
                ini di bawah.
            </p>
        </div>
    </a>
@endif

<style>
    /* ═══ MOBILE RESPONSIVENESS ═══ */
    @media (max-width: 768px) {
        .progres-card-wrapper {
            min-height: 140px !important;
            padding: 20px 16px !important;
        }

        .progres-img-wrapper {
            padding: 10px 0 !important;
        }

        .progres-img-wrapper img {
            width: 60px !important;
            height: 60px !important;
        }

        .progres-empty-wrapper {
            min-height: 140px !important;
            padding: 20px 16px !important;
        }

        .progres-empty-wrapper i {
            font-size: 40px !important;
            margin-bottom: 12px !important;
        }

        .progres-start-wrapper {
            min-height: 140px !important;
            padding: 20px 16px !important;
        }

        .progres-start-wrapper i {
            font-size: 48px !important;
        }

        .progres-pill-container {
            gap: 6px !important;
        }

        .progres-desc {
            margin-bottom: 8px !important;
            font-size: 13px !important;
        }
    }
</style>
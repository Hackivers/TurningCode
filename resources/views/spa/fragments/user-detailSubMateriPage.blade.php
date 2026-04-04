<div class="container conatiner-detail-materi">
    <main class="main-detail-materi">
        <div class="wrapper-detail-materi">

            {{-- Breadcrumb --}}
            <div class="breadcrumb">
                <h6>
                    <a href="?page=dashboard" class="link-spa breadcrumb-link">
                        {{ $subMateri->materi->mainMateri->title ?? '-' }}
                    </a>
                    <i class='bx bx-chevron-right'></i>
                    <a href="?page=materi&main_id={{ $subMateri->materi->mainMateri->id ?? '' }}" class="link-spa breadcrumb-link">
                        {{ $subMateri->materi->title ?? '-' }}
                    </a>
                    <i class='bx bx-chevron-right'></i>
                    <span>{{ $subMateri->title }}</span>
                </h6>
            </div>

            {{-- Back button --}}
            <div class="back-button">
                <button class="btn-back">
                    <i class='bx bx-arrow-back'></i> Kembali
                </button>
            </div>

            {{-- Detail Content --}}
            <main class="box-detail-materi">
                <div>
                    {{-- Meta --}}
                    @if ($subMateri->author)
                        <div class="meta">
                            <h5>✍️ {{ $subMateri->author }}</h5>
                        </div>
                    @endif

                    {{-- Title --}}
                    <div class="box-tittle-materi">
                        <h2>{{ $subMateri->title }}</h2>
                        @if ($subMateri->subtitle)
                            <p class="subtitle-detail">{{ $subMateri->subtitle }}</p>
                        @endif
                    </div>

                    {{-- Thumbnail --}}
                    @if ($subMateri->thumbnail)
                        <div class="box-thumb-materi">
                            <img src="{{ asset('storage/' . $subMateri->thumbnail) }}"
                                 alt="{{ $subMateri->title }}">
                        </div>
                    @endif

                    {{-- Sections --}}
                    <div class="box-content-materi">
                        @php
                            $sections = is_array($subMateri->sections)
                                ? $subMateri->sections
                                : json_decode($subMateri->sections, true);
                        @endphp

                        @if (!empty($sections))
                            @foreach ($sections as $sec)
                                @switch($sec['type'])

                                    @case('heading')
                                        <h3 class="sec-heading">{{ $sec['content'] ?? '' }}</h3>
                                        @break

                                    @case('subheading')
                                        <h4 class="sec-subheading">{{ $sec['content'] ?? '' }}</h4>
                                        @break

                                    @case('paragraph')
                                        <div class="sec-paragraph">{!! nl2br(e($sec['content'] ?? '')) !!}</div>
                                        @break

                                    @case('code')
                                        <div class="sec-code-block">
                                            @if (!empty($sec['language']))
                                                <span class="sec-code-lang">{{ $sec['language'] }}</span>
                                            @endif
                                            <pre><code>{{ $sec['content'] ?? '' }}</code></pre>
                                        </div>
                                        @break

                                    @case('image')
                                        <div class="sec-image">
                                            @if (!empty($sec['image_path']))
                                                <img src="{{ asset('storage/' . $sec['image_path']) }}"
                                                     alt="{{ $sec['content'] ?? '' }}">
                                            @endif
                                            @if (!empty($sec['content']))
                                                <p class="sec-image-caption">{{ $sec['content'] }}</p>
                                            @endif
                                        </div>
                                        @break

                                    @case('quote')
                                        <blockquote class="sec-quote">
                                            <p>{{ $sec['content'] ?? '' }}</p>
                                            @if (!empty($sec['source']))
                                                <cite>— {{ $sec['source'] }}</cite>
                                            @endif
                                        </blockquote>
                                        @break

                                    @case('list')
                                        @php
                                            $items = array_filter(
                                                explode("\n", $sec['content'] ?? ''),
                                                fn($line) => trim($line) !== ''
                                            );
                                            $tag = ($sec['list_type'] ?? 'unordered') === 'ordered' ? 'ol' : 'ul';
                                        @endphp
                                        <{{ $tag }} class="sec-list">
                                            @foreach ($items as $item)
                                                <li>{{ ltrim($item, '•-– ') }}</li>
                                            @endforeach
                                        </{{ $tag }}>
                                        @break

                                    @case('divider')
                                        <hr class="sec-divider">
                                        @break

                                    {{-- Fallback for legacy 'content' type --}}
                                    @case('content')
                                        <div class="sec-paragraph">{!! $sec['value'] ?? $sec['content'] ?? '' !!}</div>
                                        @break

                                @endswitch
                            @endforeach
                        @else
                            <div class="sec-empty">
                                <i class='bx bx-file-blank'></i>
                                <p>Belum ada konten untuk sub-materi ini</p>
                            </div>
                        @endif
                    </div>

                    {{-- Navigation prev/next --}}
                    <div class="box-materi-navigation">
                        <hr>
                        <div>
                            @if (!empty($prev))
                                <a href="?page=detail&submateri_id={{ $prev->id }}" class="btn-prev link-spa">
                                    <i class='bx bx-left-arrow-alt'></i>
                                    {{ $prev->title }}
                                </a>
                            @endif
                            <hr>
                            @if (!empty($next))
                                <a href="?page=detail&submateri_id={{ $next->id }}" class="btn-next link-spa">
                                    {{ $next->title }}
                                    <i class='bx bx-right-arrow-alt'></i>
                                </a>
                            @else
                                <a href="?page=submateri&materi_id={{ $subMateri->materi_id }}" class="btn-next link-spa">
                                    Selesai ✓
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </main>
</div>

{{-- Back button script --}}
<script>
    document.addEventListener("click", function(e) {
        if (e.target.closest(".btn-back")) {
            e.preventDefault();
            // Kembali ke halaman sub-materi list
            loadPage("submateri", { materi_id: "{{ $subMateri->materi_id }}" });
        }
    });
</script>

{{-- Detail page CSS --}}
<style>
    .conatiner-detail-materi {
        display: flex;
        justify-content: center;
        margin-top: 1em;
        padding-bottom: 6em;
    }
    .main-detail-materi {
        width: 100%;
        max-width: 79em;
        margin: 0 10px;
    }
    .wrapper-detail-materi {
        width: 100%;
    }

    /* Breadcrumb */
    .breadcrumb {
        margin-bottom: 12px;
    }
    .breadcrumb h6 {
        color: #8a898a;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
    }
    .breadcrumb i {
        font-size: 14px;
        color: #555;
    }
    .breadcrumb span {
        color: #E6E0E9;
    }
    .breadcrumb-link {
        color: #8a898a;
        text-decoration: none;
    }
    .breadcrumb-link:hover {
        color: #75bbed;
    }

    /* Back button */
    .back-button {
        margin-bottom: 20px;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        border: 1px solid #2a2c3a;
        background: #191825;
        color: #E6E0E9;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        background: #222430;
        border-color: #75bbed;
        color: #75bbed;
    }

    /* Detail box */
    .box-detail-materi {
        background: #191825;
        border-radius: 20px;
        border: 1px solid #1f1e2e;
        padding: 24px 16px;
    }

    /* Meta */
    .meta h5 {
        color: #8a898a;
        font-size: 12px;
        margin-bottom: 8px;
    }

    /* Title */
    .box-tittle-materi h2 {
        color: #E6E0E9;
        font-size: 20px;
        font-weight: 600;
        text-transform: capitalize;
        line-height: 1.4;
    }
    .subtitle-detail {
        color: #8a898a;
        font-size: 13px;
        margin-top: 6px;
    }

    /* Thumbnail */
    .box-thumb-materi {
        margin: 20px 0;
        border-radius: 16px;
        overflow: hidden;
    }
    .box-thumb-materi img {
        width: 100%;
        object-fit: cover;
        border-radius: 16px;
        max-height: 24em;
    }

    /* Content sections container */
    .box-content-materi {
        margin-top: 24px;
    }

    /* ── Section: heading ─────────────────────── */
    .sec-heading {
        color: #E6E0E9;
        font-size: 18px;
        font-weight: 600;
        margin: 28px 0 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #2a2c3a;
    }

    /* ── Section: subheading ──────────────────── */
    .sec-subheading {
        color: #c4c0cc;
        font-size: 15px;
        font-weight: 550;
        margin: 20px 0 8px;
    }

    /* ── Section: paragraph ───────────────────── */
    .sec-paragraph {
        color: #b8b6b9;
        font-size: 14px;
        line-height: 1.8;
        margin: 12px 0;
    }

    /* ── Section: code block ──────────────────── */
    .sec-code-block {
        position: relative;
        margin: 16px 0;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #2a2c3a;
    }
    .sec-code-lang {
        position: absolute;
        top: 8px;
        right: 12px;
        font-size: 11px;
        color: #75bbed;
        background: #13121c;
        padding: 2px 10px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .sec-code-block pre {
        background: #13121c;
        padding: 20px 16px;
        margin: 0;
        overflow-x: auto;
    }
    .sec-code-block code {
        font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
        font-size: 13px;
        color: #a6e3a1;
        line-height: 1.6;
        white-space: pre;
    }

    /* ── Section: image ───────────────────────── */
    .sec-image {
        margin: 20px 0;
        text-align: center;
    }
    .sec-image img {
        width: 100%;
        max-width: 100%;
        border-radius: 12px;
        border: 1px solid #2a2c3a;
    }
    .sec-image-caption {
        color: #8a898a;
        font-size: 12px;
        font-style: italic;
        margin-top: 8px;
    }

    /* ── Section: quote ───────────────────────── */
    .sec-quote {
        margin: 20px 0;
        padding: 16px 20px;
        border-left: 3px solid #75bbed;
        background: #13121c;
        border-radius: 0 12px 12px 0;
    }
    .sec-quote p {
        color: #c4c0cc;
        font-size: 14px;
        font-style: italic;
        line-height: 1.7;
        margin: 0;
    }
    .sec-quote cite {
        display: block;
        color: #8a898a;
        font-size: 12px;
        margin-top: 8px;
    }

    /* ── Section: list ────────────────────────── */
    .sec-list {
        margin: 16px 0;
        padding-left: 24px;
    }
    .sec-list li {
        color: #b8b6b9;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 4px;
    }
    ul.sec-list li::marker {
        color: #75bbed;
    }
    ol.sec-list li::marker {
        color: #75bbed;
        font-weight: 600;
    }

    /* ── Section: divider ─────────────────────── */
    .sec-divider {
        border: none;
        border-top: 1px solid #2a2c3a;
        margin: 24px 0;
    }

    /* ── Empty state ──────────────────────────── */
    .sec-empty {
        text-align: center;
        padding: 3em 1em;
        color: #8a898a;
    }
    .sec-empty i {
        font-size: 40px;
        margin-bottom: 12px;
        display: block;
    }

    /* Navigation prev/next */
    .box-materi-navigation {
        margin-top: 32px;
    }
    .box-materi-navigation > hr {
        border: none;
        border-top: 1px solid #2a2c3a;
        margin-bottom: 16px;
    }
    .box-materi-navigation > div {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    .box-materi-navigation > div > hr {
        flex: 1;
        border: none;
        border-top: 1px dashed #2a2c3a;
    }
    .btn-prev, .btn-next {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        border-radius: 20px;
        background: #222430;
        color: #E6E0E9;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        max-width: 40%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .btn-prev:hover, .btn-next:hover {
        background: #2a2c3a;
        color: #75bbed;
    }
    .btn-prev i, .btn-next i {
        font-size: 18px;
        flex-shrink: 0;
    }
</style>

{{-- ═══════════════════════════════════════════════════════════════
 DETAIL SUB MATERI — Editorial Article Design (synced with Dashboard)
═══════════════════════════════════════════════════════════════ --}}
<div class="neo-dashboard rtd-dashboard">
<div class="art-container">

    {{-- Breadcrumb --}}
    <div class="art-breadcrumb">
        <a href="?page=materi&main_id={{ $subMateri->materi->mainMateri->id ?? '' }}" class="link-spa">{{ $subMateri->materi->mainMateri->title ?? '-' }}</a>
        <span>/</span>
        <a href="?page=submateri&materi_id={{ $subMateri->materi_id }}" class="link-spa">{{ $subMateri->materi->title ?? '-' }}</a>
        <span>/</span>
        <span class="art-breadcrumb-current">{{ $subMateri->title }}</span>
    </div>

    {{-- Hero Section: Article Header --}}
    <header class="art-header">
        <div class="art-header-left">
            <h1 class="art-title">{{ $subMateri->title }}</h1>
            @if ($subMateri->subtitle)
                <p class="art-subtitle">{{ $subMateri->subtitle }}</p>
            @endif
            <div class="art-meta-row">
                @if ($subMateri->author)
                    <div class="art-author">
                        <div class="art-author-avatar">{{ strtoupper(substr($subMateri->author, 0, 1)) }}</div>
                        <div>
                            <div class="art-author-name">{{ $subMateri->author }}</div>
                            <div class="art-author-role">Penulis Materi</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="art-header-right">
            <div class="art-header-excerpt">
                @php
                    $sections = is_array($subMateri->sections) ? $subMateri->sections : json_decode($subMateri->sections, true);
                    $firstParagraph = '';
                    if (!empty($sections)) {
                        foreach ($sections as $s) {
                            if (($s['type'] ?? '') === 'paragraph' && !empty($s['content'])) {
                                $firstParagraph = Str::limit($s['content'], 200);
                                break;
                            }
                        }
                    }
                @endphp
                @if ($firstParagraph)
                    <p>{{ $firstParagraph }}</p>
                @endif
            </div>
            <div class="art-header-index">
                {{ $subMateri->materi->title ?? '' }}
            </div>
        </div>
    </header>

    {{-- Premium Thumbnail --}}
    @if ($subMateri->thumbnail)
        <div class="art-thumbnail-wrapper">
            <div class="art-thumbnail-glow" style="background-image: url('{{ asset('storage/' . $subMateri->thumbnail) }}');"></div>
            <div class="art-thumbnail">
                <img src="{{ asset('storage/' . $subMateri->thumbnail) }}" alt="{{ $subMateri->title }}">
            </div>
        </div>
    @endif

    {{-- Article Body --}}
    <article class="art-body">
        @if (!empty($sections))
            @foreach ($sections as $sec)
                @switch($sec['type'])
                    @case('heading')
                        <h2 class="art-sec-heading">{{ $sec['content'] ?? '' }}</h2>
                        @break
                    @case('subheading')
                        <h3 class="art-sec-subheading">{{ $sec['content'] ?? '' }}</h3>
                        @break
                    @case('paragraph')
                        <p class="art-sec-paragraph">{!! nl2br(e($sec['content'] ?? '')) !!}</p>
                        @break
                    @case('code')
                        <div class="art-sec-code">
                            @if (!empty($sec['language']))
                                <span class="art-code-lang">{{ $sec['language'] }}</span>
                            @endif
                            <pre><code>{{ $sec['content'] ?? '' }}</code></pre>
                        </div>
                        @break
                    @case('image')
                        <figure class="art-sec-image">
                            @if (!empty($sec['image_path']))
                                <img src="{{ asset('storage/' . $sec['image_path']) }}" alt="{{ $sec['content'] ?? '' }}">
                            @endif
                            @if (!empty($sec['content']))
                                <figcaption>{{ $sec['content'] }}</figcaption>
                            @endif
                        </figure>
                        @break
                    @case('quote')
                        <blockquote class="art-sec-quote">
                            <p>{{ $sec['content'] ?? '' }}</p>
                            @if (!empty($sec['source']))
                                <cite>— {{ $sec['source'] }}</cite>
                            @endif
                        </blockquote>
                        @break
                    @case('list')
                        @php
                            $items = array_filter(explode("\n", $sec['content'] ?? ''), fn($l) => trim($l) !== '');
                            $tag = ($sec['list_type'] ?? 'unordered') === 'ordered' ? 'ol' : 'ul';
                        @endphp
                        <{{ $tag }} class="art-sec-list">
                            @foreach ($items as $item)
                                <li>{{ ltrim($item, '•-– ') }}</li>
                            @endforeach
                        </{{ $tag }}>
                        @break
                    @case('divider')
                        <hr class="art-sec-divider">
                        @break
                    @case('content')
                        <div class="art-sec-paragraph">{!! $sec['value'] ?? $sec['content'] ?? '' !!}</div>
                        @break
                @endswitch
            @endforeach
        @else
            <div style="text-align:center;padding:60px 20px;">
                <i class='bx bx-file-blank' style="font-size:48px;color:#ccc;display:block;margin-bottom:12px;"></i>
                <p style="color:#888;font-size:14px;">Belum ada konten untuk sub-materi ini</p>
            </div>
        @endif
    </article>

    {{-- Navigation --}}
    <nav class="art-nav">
        @if (!empty($prev))
            <a href="?page=detail&submateri_id={{ $prev->id }}" class="link-spa art-nav-btn art-nav-prev">
                <i class='bx bx-left-arrow-alt'></i>
                <span>{{ $prev->title }}</span>
            </a>
        @else
            <div></div>
        @endif
        <a href="?page=quiz&submateri_id={{ $subMateri->id }}" class="link-spa art-nav-btn art-nav-quiz">
            <span>Uji Pemahaman</span>
            <i class='bx bx-right-arrow-alt'></i>
        </a>
    </nav>

</div>
</div>

<script>
    document.addEventListener("click", function(e) {
        if (e.target.closest(".btn-back")) {
            e.preventDefault();
            loadPage("submateri", { materi_id: "{{ $subMateri->materi_id }}" });
        }
    });
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

:root {
    --neo-bg: #ececec;
    --neo-text-dark: #121212;
    --art-max: 1200px;
    --art-body-max: 720px;
}

body { background-color: var(--neo-bg) !important; }

.neo-dashboard {
    background-color: var(--neo-bg);
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    width: 100%;
}
.art-container {
    max-width: var(--art-max);
    margin: 0 auto;
    padding: 32px 24px 80px;
}

/* ═══ BREADCRUMB ═══ */
.art-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #888;
    margin-bottom: 48px;
    flex-wrap: wrap;
}
.art-breadcrumb a {
    color: #888;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}
.art-breadcrumb a:hover { color: #121212; }
.art-breadcrumb span { color: #ccc; }
.art-breadcrumb-current { color: #121212; font-weight: 600; }

/* ═══ ARTICLE HEADER (Two-column editorial) ═══ */
.art-header {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    margin-bottom: 48px;
    align-items: start;
}

.art-title {
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -0.03em;
    color: var(--neo-text-dark);
    margin: 0 0 16px;
    text-transform: capitalize;
}
.art-subtitle {
    font-size: 16px;
    color: #666;
    line-height: 1.5;
    margin: 0 0 24px;
}

.art-meta-row {
    margin-top: 24px;
}
.art-author {
    display: flex;
    align-items: center;
    gap: 12px;
}
.art-author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #121212;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 16px;
}
.art-author-name { font-size: 14px; font-weight: 700; color: #121212; }
.art-author-role { font-size: 12px; color: #888; font-weight: 500; }

.art-header-right {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    padding-top: 8px;
}
.art-header-excerpt p {
    font-size: 14px;
    color: #555;
    line-height: 1.7;
    margin: 0;
}
.art-header-index {
    font-size: clamp(32px, 4vw, 48px);
    font-weight: 900;
    color: var(--neo-text-dark);
    text-align: right;
    letter-spacing: -0.02em;
    margin-top: 24px;
    opacity: 0.12;
}

/* ═══ PREMIUM THUMBNAIL ═══ */
.art-thumbnail-wrapper {
    position: relative;
    margin-bottom: 56px;
    border-radius: 32px;
    padding: 12px;
    background: rgba(255, 255, 255, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.6);
    box-shadow: 0 30px 60px rgba(0,0,0,0.05), inset 0 2px 8px rgba(255,255,255,0.8);
    backdrop-filter: blur(16px);
}
.art-thumbnail-glow {
    position: absolute;
    inset: 5%;
    z-index: 0;
    filter: blur(40px);
    opacity: 0.5;
    background-size: cover;
    background-position: center;
    border-radius: inherit;
}
.art-thumbnail {
    position: relative;
    z-index: 1;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.art-thumbnail img {
    width: 100%;
    max-height: 520px;
    object-fit: cover;
    display: block;
    transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}
.art-thumbnail-wrapper:hover .art-thumbnail img {
    transform: scale(1.03);
}

/* ═══ ARTICLE BODY ═══ */
.art-body {
    max-width: var(--art-body-max);
    margin: 0 auto;
    padding-bottom: 32px;
}

/* Heading */
.art-sec-heading {
    font-size: 24px;
    font-weight: 800;
    color: var(--neo-text-dark);
    margin: 48px 0 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid rgba(0,0,0,0.08);
    letter-spacing: -0.02em;
}

/* Subheading */
.art-sec-subheading {
    font-size: 18px;
    font-weight: 700;
    color: #333;
    margin: 32px 0 12px;
}

/* Paragraph */
.art-sec-paragraph {
    font-size: 16px;
    color: #444;
    line-height: 1.85;
    margin: 16px 0;
}

/* Code */
.art-sec-code {
    position: relative;
    margin: 24px 0;
    border-radius: 16px;
    overflow: hidden;
    background: #1a1a2e;
    border: 1px solid rgba(0,0,0,0.08);
}
.art-code-lang {
    position: absolute;
    top: 10px;
    right: 14px;
    font-size: 11px;
    color: #6366f1;
    background: rgba(99,102,241,0.1);
    padding: 3px 10px;
    border-radius: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
}
.art-sec-code pre {
    padding: 24px;
    margin: 0;
    overflow-x: auto;
}
.art-sec-code code {
    font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
    font-size: 13px;
    color: #a6e3a1;
    line-height: 1.7;
    white-space: pre;
}

/* Image */
.art-sec-image {
    margin: 32px 0;
    text-align: center;
}
.art-sec-image img {
    width: 100%;
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,0.06);
}
.art-sec-image figcaption {
    color: #888;
    font-size: 13px;
    font-style: italic;
    margin-top: 10px;
}

/* Quote */
.art-sec-quote {
    margin: 32px 0;
    padding: 24px 28px;
    border-left: 4px solid #121212;
    background: rgba(0,0,0,0.03);
    border-radius: 0 16px 16px 0;
}
.art-sec-quote p {
    color: #333;
    font-size: 16px;
    font-style: italic;
    line-height: 1.7;
    margin: 0;
}
.art-sec-quote cite {
    display: block;
    color: #888;
    font-size: 13px;
    margin-top: 12px;
    font-style: normal;
}

/* List */
.art-sec-list {
    margin: 20px 0;
    padding-left: 24px;
}
.art-sec-list li {
    color: #444;
    font-size: 16px;
    line-height: 1.85;
    margin-bottom: 6px;
}
ul.art-sec-list li::marker { color: #121212; }
ol.art-sec-list li::marker { color: #121212; font-weight: 700; }

/* Divider */
.art-sec-divider {
    border: none;
    border-top: 2px solid rgba(0,0,0,0.06);
    margin: 40px 0;
}

/* ═══ NAVIGATION ═══ */
.art-nav {
    max-width: var(--art-body-max);
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding-top: 32px;
    border-top: 2px solid rgba(0,0,0,0.06);
}
.art-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 100px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
    max-width: 45%;
    overflow: hidden;
    text-overflow: ellipsis;
}
.art-nav-btn i { font-size: 18px; flex-shrink: 0; }
.art-nav-prev {
    background: var(--neo-bg);
    color: #666;
    border: 1px solid rgba(0,0,0,0.12);
}
.art-nav-prev:hover {
    background: #121212;
    color: #fff;
    border-color: #121212;
}
.art-nav-quiz {
    background: #121212;
}
.art-nav-quiz span{
    color: #fff;
}
.art-nav-quiz i{
    color: #fff;
}
.art-nav-quiz:hover {
    opacity: 0.85;
    transform: translateY(-2px);
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 768px) {
    .art-container { padding: 24px 16px 60px; }
    .art-header {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .art-title { font-size: 32px; }
    .art-header-index { display: none; }
    .art-nav { flex-direction: column; }
    .art-nav-btn { max-width: 100%; width: 100%; justify-content: center; }
}
</style>

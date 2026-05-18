{{-- ═══════════════════════════════════════════════════════════════
 DETAIL SUB MATERI — Editorial Article Design (synced with Dashboard)
═══════════════════════════════════════════════════════════════ --}}
@php
    $rawSections = is_array($subMateri->sections) ? $subMateri->sections : json_decode($subMateri->sections, true);
    if (!is_array($rawSections)) $rawSections = [];

    $babs = [];
    $currentBab = ['id' => 'intro', 'title' => 'Pendahuluan', 'sections' => []];
    
    foreach($rawSections as $sec) {
        if (($sec['type'] ?? '') === 'bab') {
            if (!empty($currentBab['sections']) || $currentBab['id'] !== 'intro') {
                $babs[] = $currentBab;
            }
            $currentBab = [
                'id' => $sec['order'] ?? uniqid(),
                'title' => $sec['content'] ?? 'Bab',
                'sections' => [$sec]
            ];
        } else {
            $currentBab['sections'][] = $sec;
        }
    }
    if (!empty($currentBab['sections']) || $currentBab['id'] !== 'intro') {
        $babs[] = $currentBab;
    }

    $requestedBabId = request()->query('bab_id');
    $activeBabIndex = 0;
    
    // Server-side lock enforcement
    $history = \App\Models\UserHistory::firstOrCreate(
        ['user_id' => Auth::id(), 'sub_materi_id' => $subMateri->id],
        ['viewed_at' => now(), 'completed_babs' => []]
    );
    $completedBabs = is_array($history->completed_babs) ? $history->completed_babs : [];

    if ($requestedBabId !== null) {
        foreach($babs as $index => $b) {
            if ((string)$b['id'] === (string)$requestedBabId) {
                // Ensure previous bab is completed
                $isUnlocked = $index === 0;
                if ($index > 0) {
                    $prevBabId = $babs[$index - 1]['id'];
                    $isUnlocked = in_array($prevBabId, $completedBabs) || in_array($b['id'], $completedBabs);
                }
                
                if ($isUnlocked) {
                    $activeBabIndex = $index;
                }
                break;
            }
        }
    } else {
        if (count($babs) > 1 && empty($babs[0]['sections'])) {
            $activeBabIndex = 1;
        }
    }

    $sections = $babs[$activeBabIndex]['sections'] ?? [];
    
    $prevBab = $activeBabIndex > 0 ? $babs[$activeBabIndex - 1] : null;
    $nextBab = $activeBabIndex < count($babs) - 1 ? $babs[$activeBabIndex + 1] : null;
@endphp
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
                    $firstParagraph = '';
                    if (!empty($rawSections)) {
                        foreach ($rawSections as $s) {
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
                    @case('bab')
                        <div id="section-{{ $sec['order'] ?? '' }}" class="art-sec-bab">
                            <span class="art-bab-label">Bab Pembelajaran</span>
                            <h2 class="art-bab-title">{{ $sec['content'] ?? '' }}</h2>
                        </div>
                        @break
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
                        @php
                            $lang = strtolower($sec['language'] ?? '');
                            $isLive = in_array($lang, ['html', 'javascript', 'js', 'css']);
                        @endphp
                        <div class="art-sec-code {{ $isLive ? 'live-code-enabled' : '' }}" data-lang="{{ $lang }}">
                            <div class="code-header">
                                <span class="art-code-lang">{{ $sec['language'] ?? 'CODE' }}</span>
                                @if($isLive)
                                    <div style="display:flex;gap:6px;">
                                        <button class="btn-run-code"><i class='bx bx-play'></i> Run Code</button>
                                        <button class="btn-open-playground" onclick="openPlayground(this)"><i class='bx bx-expand'></i> PLAYGROUND</button>
                                    </div>
                                @endif
                            </div>
                            <div class="code-editor-wrap">
                                @if($isLive)
                                    <textarea class="code-input" spellcheck="false">{{ $sec['content'] ?? '' }}</textarea>
                                @else
                                    <pre><code>{{ $sec['content'] ?? '' }}</code></pre>
                                @endif
                            </div>
                            @if($isLive)
                            <div class="code-output-wrap" style="display:none;">
                                <div class="output-header">
                                    <span>LIVE OUTPUT</span>
                                    <button class="btn-close-output" title="Tutup Output"><i class='bx bx-x'></i></button>
                                </div>
                                <div class="output-body">
                                    <iframe class="output-frame"></iframe>
                                    <pre class="output-console" style="display:none;"></pre>
                                </div>
                            </div>
                            @endif
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
                    @case('table')
                        @php
                            $lines = array_filter(explode("\n", $sec['content'] ?? ''), fn($l) => trim($l) !== '');
                        @endphp
                        @if(count($lines) > 0)
                        <div class="art-sec-table-wrap">
                            <table class="art-sec-table">
                                @foreach($lines as $index => $line)
                                    @php $cells = explode("|", $line); @endphp
                                    @if($index === 0)
                                        <thead>
                                            <tr>
                                                @foreach($cells as $cell)
                                                    <th>{{ trim($cell) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @else
                                        <tr>
                                            @foreach($cells as $cell)
                                                <td>{{ trim($cell) }}</td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
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
        @if (!empty($prevBab))
            <a href="?page=detail&submateri_id={{ $subMateri->id }}&bab_id={{ $prevBab['id'] }}" class="link-spa art-nav-btn art-nav-prev">
                <i class='bx bx-left-arrow-alt'></i>
                <span>Bab Sebelumnya: {{ Str::limit($prevBab['title'], 25) }}</span>
            </a>
        @elseif (!empty($prev))
            <a href="?page=detail&submateri_id={{ $prev->id }}" class="link-spa art-nav-btn art-nav-prev">
                <i class='bx bx-left-arrow-alt'></i>
                <span>Materi Sebelumnya: {{ Str::limit($prev->title, 25) }}</span>
            </a>
        @else
            <div></div>
        @endif

        @if (!empty($nextBab))
            <a href="?page=detail&submateri_id={{ $subMateri->id }}&bab_id={{ $nextBab['id'] }}&complete_bab={{ $babs[$activeBabIndex]['id'] }}" class="link-spa art-nav-btn art-nav-quiz">
                <span>Bab Selanjutnya: {{ Str::limit($nextBab['title'], 25) }}</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
        @else
            <a href="?page=quiz&submateri_id={{ $subMateri->id }}&complete_bab={{ $babs[$activeBabIndex]['id'] ?? '' }}" class="link-spa art-nav-btn art-nav-quiz">
                <span>Uji Pemahaman Quiz</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
        @endif
    </nav>

    {{-- Discussion & Q&A Section --}}
    @include('spa.fragments.user-discussions')

</div>
</div>

<script>
    document.addEventListener("click", function(e) {
        if (e.target.closest(".btn-back")) {
            e.preventDefault();
            loadPage("submateri", { materi_id: "{{ $subMateri->materi_id }}" });
        }
        
        // Live Code Editor Logic
        const runBtn = e.target.closest(".btn-run-code");
        if (runBtn) {
            const container = runBtn.closest(".art-sec-code");
            const lang = container.dataset.lang;
            const input = container.querySelector(".code-input").value;
            const outputWrap = container.querySelector(".code-output-wrap");
            const frame = container.querySelector(".output-frame");
            const consoleEl = container.querySelector(".output-console");
            
            outputWrap.style.display = "block";
            
            if (lang === 'html' || lang === 'css') {
                frame.style.display = "block";
                consoleEl.style.display = "none";
                const darkBase = '<style>*{box-sizing:border-box}body{margin:0;padding:20px;background:#0a0a0a;color:#e0e0e0;font-family:Inter,sans-serif;}</style>';
                let htmlContent = input;
                if (lang === 'css') {
                    htmlContent = `<style>${input}</style><div style="padding:20px; font-family:sans-serif; text-align:center;">Element Preview Area</div>`;
                }
                frame.srcdoc = darkBase + htmlContent;
            } else if (lang === 'javascript' || lang === 'js') {
                frame.style.display = "none";
                consoleEl.style.display = "block";
                consoleEl.textContent = ""; 
                
                const originalLog = console.log;
                let logs = [];
                console.log = function(...args) {
                    logs.push(args.map(a => typeof a === 'object' ? JSON.stringify(a, null, 2) : a).join(' '));
                    originalLog.apply(console, args);
                };
                
                try {
                    const result = new Function(input)();
                    if (result !== undefined) {
                        logs.push(String(result));
                    }
                    if (logs.length === 0) logs.push("✓ Code executed successfully (no output).");
                    consoleEl.textContent = logs.join('\n');
                } catch (err) {
                    consoleEl.textContent = "Error: " + err.message;
                } finally {
                    console.log = originalLog;
                }
            }
        }
        
        const closeBtn = e.target.closest(".btn-close-output");
        if (closeBtn) {
            closeBtn.closest(".code-output-wrap").style.display = "none";
        }
    });
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700;800;900&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap');

:root {
    --neo-bg: transparent;
    --neo-text-dark: #ffffff;
    --art-max: 1400px;
    --art-body-max: 780px;
}

body { background-color: var(--bg-secondary) !important; }

.neo-dashboard {
    background-color: var(--bg-secondary);
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    width: 100%;
    color: #ffffff;
}
.art-container {
    max-width: var(--art-max);
    margin: 0 auto;
    padding: 32px 24px 80px;
    box-sizing: border-box;
    position: relative;
}

/* ═══ BREADCRUMB ═══ */
.art-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Outfit', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #a1a1aa;
    margin-bottom: 48px;
    flex-wrap: wrap;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.art-breadcrumb a {
    color: #a1a1aa;
    text-decoration: none;
    transition: color 0.2s;
    padding: 4px 10px;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 6px;
    background: rgba(255,255,255,0.02);
}
.art-breadcrumb a:hover { color: #ffffff; border-color: rgba(255,255,255,0.2); }
.art-breadcrumb span { color: rgba(255,255,255,0.2); }
.art-breadcrumb-current { color: #ffffff; font-weight: 700; }

/* ═══ ARTICLE HEADER (Two-column editorial) ═══ */
.art-header {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    margin-bottom: 48px;
    align-items: start;
}

.art-title {
    font-family: 'Inter', sans-serif;
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -0.03em;
    color: #ffffff;
    margin: 0 0 16px;
    text-transform: capitalize;
}
.art-subtitle {
    font-family: 'Outfit', sans-serif;
    font-size: 14px;
    color: #a1a1aa;
    line-height: 1.6;
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
    background: rgba(234,21,21,0.15);
    color: var(--accent-primary);
    border: 1px solid rgba(234,21,21,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 16px;
    font-family: 'Outfit', sans-serif;
}
.art-author-name { font-size: 14px; font-weight: 700; color: #ffffff; }
.art-author-role { font-size: 12px; color: #a1a1aa; font-weight: 500; font-family: 'Outfit', sans-serif; }

.art-header-right {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    padding-top: 8px;
}
.art-header-excerpt p {
    font-family: 'Outfit', sans-serif;
    font-size: 13px;
    color: #a1a1aa;
    line-height: 1.6;
    margin: 0;
}
.art-header-index {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(32px, 4vw, 48px);
    font-weight: 900;
    color: #ffffff;
    text-align: right;
    letter-spacing: -0.02em;
    margin-top: 24px;
    opacity: 0.1;
    text-transform: uppercase;
}

/* ═══ PREMIUM THUMBNAIL ═══ */
.art-thumbnail-wrapper {
    position: relative;
    margin-bottom: 56px;
    border-radius: 16px;
    padding: 4px;
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.08);
}
.art-thumbnail-glow {
    position: absolute;
    inset: 5%;
    z-index: 0;
    filter: blur(60px);
    opacity: 0.2;
    background-size: cover;
    background-position: center;
    border-radius: inherit;
}
.art-thumbnail {
    position: relative;
    z-index: 1;
    border-radius: 12px;
    overflow: hidden;
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

/* Bab Separator */
.art-sec-bab {
    margin: 64px 0 32px;
    padding: 32px;
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.08);
    color: #ffffff;
    border-radius: 16px;
    position: relative;
    overflow: hidden;
    scroll-margin-top: 100px;
}
.art-sec-bab::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 4px; height: 100%;
    background: var(--accent-primary);
}
.art-bab-label {
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--accent-primary);
    display: block;
    margin-bottom: 8px;
}
.art-bab-title {
    font-family: 'Inter', sans-serif;
    font-size: 28px;
    font-weight: 800;
    margin: 0;
    color: #ffffff;
    letter-spacing: -0.02em;
}

/* Heading */
.art-sec-heading {
    font-family: 'Inter', sans-serif;
    font-size: 24px;
    font-weight: 800;
    color: #ffffff;
    margin: 48px 0 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    letter-spacing: -0.02em;
}

/* Subheading */
.art-sec-subheading {
    font-family: 'Inter', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #eeeeee;
    margin: 32px 0 12px;
}

/* Paragraph */
.art-sec-paragraph {
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    color: #a1a1aa;
    line-height: 1.85;
    margin: 16px 0;
}

/* Code */
.art-sec-code {
    position: relative;
    margin: 24px 0;
    border-radius: 12px;
    overflow: hidden;
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.08);
}
.code-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 16px;
    background: rgba(255,255,255,0.03);
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.art-code-lang {
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    color: var(--accent-primary);
    background: rgba(234,21,21,0.1);
    border: 1px solid rgba(234,21,21,0.2);
    padding: 3px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
}
.btn-run-code {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: transparent;
    color: #a1a1aa;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 6px;
    padding: 4px 12px;
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-run-code:hover {
    background: rgba(255,255,255,0.1);
    color: #ffffff;
}
.code-editor-wrap {
    position: relative;
}
.code-editor-wrap code{
    color: #a6e3a1;
}
.code-editor-wrap pre, .code-editor-wrap textarea {
    width: 100%;
    margin: 0;
    padding: 20px;
    background: transparent;
    border: none;
    color: #a6e3a1;
    font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
    font-size: 13px;
    line-height: 1.7;
    box-sizing: border-box;
    resize: vertical;
    min-height: 25em;
}
.code-editor-wrap textarea:focus {
    outline: none;
}
.code-output-wrap {
    background: var(--bg-secondary);
    border-top: 1px solid rgba(255,255,255,0.08);
}
.output-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 16px;
    background: rgba(255,255,255,0.03);
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    font-weight: 700;
    color: #a1a1aa;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    letter-spacing: 0.5px;
}
.btn-close-output {
    background: transparent;
    border: none;
    color: #a1a1aa;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-close-output:hover { color: var(--accent-primary); }
.output-body { padding: 16px; }
.output-frame {
    width: 100%;
    height: 250px;
    border: 1px dashed rgba(255,255,255,0.1);
    border-radius: 8px;
    background: #0a0a0a;
}
.output-console {
    margin: 0;
    padding: 16px;
    background: rgba(255,255,255,0.02);
    color: #a6e3a1;
    font-family: 'Fira Code', monospace;
    font-size: 13px;
    border-radius: 8px;
    white-space: pre-wrap;
    min-height: 80px;
    border: 1px solid rgba(255,255,255,0.06);
}

/* Image */
.art-sec-image {
    margin: 32px 0;
    text-align: center;
}
.art-sec-image img {
    width: 100%;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
}
.art-sec-image figcaption {
    font-family: 'Outfit', sans-serif;
    color: #a1a1aa;
    font-size: 11px;
    margin-top: 10px;
}

/* Quote */
.art-sec-quote {
    margin: 32px 0;
    padding: 24px 28px;
    border-left: 3px solid var(--accent-primary);
    background: rgba(255,255,255,0.02);
    border-radius: 0 12px 12px 0;
}
.art-sec-quote p {
    color: #eeeeee;
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    font-style: italic;
    line-height: 1.7;
    margin: 0;
}
.art-sec-quote cite {
    display: block;
    font-family: 'Outfit', sans-serif;
    color: #a1a1aa;
    font-size: 12px;
    margin-top: 12px;
    font-style: normal;
}

/* List */
.art-sec-list {
    margin: 20px 0;
    padding-left: 24px;
}
.art-sec-list li {
    color: #a1a1aa;
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    line-height: 1.85;
    margin-bottom: 6px;
}
ul.art-sec-list li::marker { color: var(--accent-primary); }
ol.art-sec-list li::marker { color: var(--accent-primary); font-weight: 700; font-family: 'Outfit', sans-serif; }

/* Divider */
.art-sec-divider {
    border: none;
    border-top: 1px solid rgba(255,255,255,0.08);
    margin: 40px 0;
}

/* Table */
.art-sec-table-wrap {
    overflow-x: auto;
    margin: 32px 0;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
}
.art-sec-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    text-align: left;
    background: transparent;
    font-family: 'Inter', sans-serif;
}
.art-sec-table th {
    padding: 14px 16px;
    background: rgba(255,255,255,0.03);
    color: #ffffff;
    font-weight: 700;
    font-family: 'Outfit', sans-serif;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.art-sec-table td {
    padding: 14px 16px;
    color: #a1a1aa;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}
.art-sec-table tr:last-child td { border-bottom: none; }
.art-sec-table tbody tr:hover { background: rgba(255,255,255,0.02); }

/* ═══ NAVIGATION ═══ */
.art-nav {
    max-width: var(--art-body-max);
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding-top: 32px;
    border-top: 1px solid rgba(255,255,255,0.08);
}
.art-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 9999px;
    font-family: 'Outfit', sans-serif;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
    max-width: 45%;
    overflow: hidden;
    text-overflow: ellipsis;
}
.art-nav-btn i { font-size: 18px; flex-shrink: 0; }
.art-nav-prev {
    background: transparent;
    color: #a1a1aa;
    border: 1px solid rgba(255,255,255,0.08);
}
.art-nav-prev:hover {
    background: rgba(255,255,255,0.05);
    color: #ffffff;
    border-color: rgba(255,255,255,0.2);
}
.art-nav-quiz {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
}
.art-nav-quiz span { color: #ffffff; }
.art-nav-quiz i { color: #ffffff; }
.art-nav-quiz:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.2);
    transform: translateY(-2px);
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 768px) {
    .neo-dashboard { overflow-x: hidden; }
    .art-container { padding: 16px 16px 48px; max-width: 100vw; }
    .art-breadcrumb { 
        font-size: 11px; 
        margin-bottom: 24px; 
        gap: 4px;
    }
    .art-header {
        grid-template-columns: 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }
    .art-title { font-size: 26px !important; margin-bottom: 8px; }
    .art-subtitle { font-size: 14px; margin-bottom: 16px; }
    .art-meta-row { margin-top: 16px; }
    .art-author-avatar { width: 32px; height: 32px; font-size: 14px; }
    .art-author-name { font-size: 13px; }
    .art-author-role { font-size: 11px; }
    .art-header-right { padding-top: 0; }
    .art-header-excerpt p { font-size: 13px; }
    .art-header-index { display: none; }
    
    /* Thumbnail */
    .art-thumbnail-wrapper { 
        margin-bottom: 32px; 
        border-radius: 20px; 
        padding: 8px; 
    }
    .art-thumbnail { border-radius: 14px; }
    .art-thumbnail img { max-height: 280px; }
    
    /* Body */
    .art-sec-bab { margin: 40px 0 24px; padding: 24px; border-radius: 16px; scroll-margin-top: 80px; }
    .art-bab-label { font-size: 10px; margin-bottom: 6px; }
    .art-bab-title { font-size: 22px; }
    .art-sec-heading { font-size: 20px; margin: 32px 0 12px; padding-bottom: 8px; }
    .art-sec-subheading { font-size: 16px; margin: 24px 0 8px; }
    .art-sec-paragraph { font-size: 14px; line-height: 1.75; margin: 12px 0; }
    .art-sec-code { margin: 16px 0; border-radius: 12px; }
    .art-sec-code pre { padding: 16px; }
    .art-sec-code code { font-size: 12px; }
    .art-sec-quote { padding: 16px 20px; margin: 20px 0; border-radius: 0 12px 12px 0; }
    .art-sec-quote p { font-size: 14px; }
    .art-sec-list li { font-size: 14px; }
    .art-sec-image { margin: 20px 0; }
    .art-sec-image img { border-radius: 12px; }
    .art-sec-divider { margin: 28px 0; }
    .art-sec-table { font-size: 13px; }
    .art-sec-table th, .art-sec-table td { padding: 10px 12px; }
    
    /* Nav */
    .art-nav { 
        flex-direction: column; 
        gap: 10px; 
        padding-top: 24px;
        margin: 0 16px;
    }
    .art-nav-btn { 
        max-width: 100%; 
        width: 100%; 
        justify-content: center; 
        padding: 10px 16px; 
        font-size: 13px; 
    }
}

/* Playground Button */
.btn-open-playground {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: transparent;
    color: var(--accent-primary);
    border: 1px solid rgba(234,21,21,0.2);
    border-radius: 6px;
    padding: 4px 12px;
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.btn-open-playground:hover {
    background: rgba(234,21,21,0.1);
    border-color: rgba(234,21,21,0.4);
    color: #ff3333;
}

/* ═══ PLAYGROUND OVERLAY ═══ */
.nw-pg-overlay {
    position: fixed;
    inset: 0;
    z-index: 200;
    background: var(--bg-secondary);
    display: none;
    flex-direction: column;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.3s, transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.nw-pg-overlay.active {
    display: flex;
    opacity: 1;
    transform: translateY(0);
}
.nw-pg-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.02);
    flex-shrink: 0;
}
.nw-pg-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.nw-pg-title {
    font-family: 'Outfit', sans-serif;
    font-size: 13px;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 1px;
    text-transform: uppercase;
}
.nw-pg-lang-badge {
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    font-weight: 700;
    color: var(--accent-primary);
    background: rgba(234,21,21,0.1);
    border: 1px solid rgba(234,21,21,0.2);
    padding: 3px 10px;
    border-radius: 6px;
    text-transform: uppercase;
}
.nw-pg-header-right {
    display: flex;
    align-items: center;
    gap: 8px;
}
.nw-pg-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 16px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: #ffffff;
    border-radius: 8px;
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.nw-pg-btn:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.2);
}
.nw-pg-btn-run {
    background: rgba(234,21,21,0.1);
    border-color: rgba(234,21,21,0.25);
    color: var(--accent-primary);
}
.nw-pg-btn-run:hover {
    background: rgba(234,21,21,0.2);
    border-color: rgba(234,21,21,0.4);
}
.nw-pg-btn-close {
    width: 36px;
    height: 36px;
    padding: 0;
    justify-content: center;
    font-size: 20px;
    border-radius: 50%;
}
.nw-pg-body {
    display: flex;
    flex: 1;
    overflow: hidden;
}
.nw-pg-editor-pane, .nw-pg-output-pane {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.nw-pg-editor-pane {
    border-right: 1px solid rgba(255,255,255,0.08);
}
.nw-pg-pane-label {
    font-family: 'Outfit', sans-serif;
    font-size: 10px;
    font-weight: 700;
    color: #a1a1aa;
    padding: 10px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    text-transform: uppercase;
    letter-spacing: 1px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}
.nw-pg-pane-label i { font-size: 14px; }
.nw-pg-editor {
    flex: 1;
    width: 100%;
    padding: 20px;
    background: transparent;
    border: none;
    outline: none;
    color: #a6e3a1;
    font-family: 'Fira Code', 'Consolas', 'Monaco', monospace;
    font-size: 14px;
    line-height: 1.7;
    resize: none;
    box-sizing: border-box;
    tab-size: 2;
}
.nw-pg-editor::placeholder {
    color: #333;
    font-family: 'Outfit', sans-serif;
}
.nw-pg-output-frame {
    flex: 1;
    width: 100%;
    border: none;
    background: #0a0a0a;
}
.nw-pg-output-console {
    flex: 1;
    width: 100%;
    padding: 20px;
    background: transparent;
    border: none;
    color: #a6e3a1;
    font-family: 'Fira Code', monospace;
    font-size: 13px;
    white-space: pre-wrap;
    overflow-y: auto;
    margin: 0;
    box-sizing: border-box;
}
.nw-pg-shortcut {
    font-family: 'Outfit', sans-serif;
    font-size: 9px;
    color: #555;
    padding: 12px 20px;
    border-top: 1px solid rgba(255,255,255,0.06);
    flex-shrink: 0;
    display: flex;
    gap: 20px;
}
.nw-pg-shortcut kbd {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    padding: 1px 6px;
    border-radius: 4px;
    font-size: 9px;
    color: #a1a1aa;
}

@media (max-width: 768px) {
    .nw-pg-body { flex-direction: column; }
    .nw-pg-editor-pane { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.08); flex: 1; }
    .nw-pg-output-pane { flex: 1; }
    .nw-pg-header { padding: 10px 14px; }
    .nw-pg-title { font-size: 11px; }
    .nw-pg-shortcut { display: none; }
}
</style>

{{-- ── FULL-PAGE PLAYGROUND OVERLAY ── --}}
<div id="nw-playground" class="nw-pg-overlay">
    <div class="nw-pg-header">
        <div class="nw-pg-header-left">
            <span class="nw-pg-title">⟨/⟩ Playground</span>
            <span id="nw-pg-lang" class="nw-pg-lang-badge">HTML</span>
        </div>
        <div class="nw-pg-header-right">
            <button class="nw-pg-btn" onclick="resetPlayground()"><i class='bx bx-reset'></i> Reset</button>
            <button class="nw-pg-btn nw-pg-btn-run" onclick="runPlayground()"><i class='bx bx-play'></i> Run</button>
            <button class="nw-pg-btn nw-pg-btn-close" onclick="closePlayground()"><i class='bx bx-x'></i></button>
        </div>
    </div>
    <div class="nw-pg-body">
        <div class="nw-pg-editor-pane">
            <div class="nw-pg-pane-label"><i class='bx bx-code-alt'></i> EDITOR</div>
            <textarea id="nw-pg-editor" class="nw-pg-editor" spellcheck="false" placeholder="// mulai menulis kode..."></textarea>
            <div class="nw-pg-shortcut">
                <span><kbd>Ctrl</kbd>+<kbd>Enter</kbd> Run</span>
                <span><kbd>Esc</kbd> Close</span>
            </div>
        </div>
        <div class="nw-pg-output-pane">
            <div class="nw-pg-pane-label"><i class='bx bx-terminal'></i> OUTPUT</div>
            <iframe id="nw-pg-frame" class="nw-pg-output-frame"></iframe>
            <pre id="nw-pg-console" class="nw-pg-output-console" style="display:none;"></pre>
        </div>
    </div>
</div>

<script>
(function() {
    let pgOriginalCode = '';
    let pgLang = 'html';

    window.openPlayground = function(btn) {
        const container = btn.closest('.art-sec-code');
        if (!container) return;
        pgLang = (container.dataset.lang || 'html').toLowerCase();
        const input = container.querySelector('.code-input');
        const codeEl = container.querySelector('code');
        const code = input ? input.value : (codeEl ? codeEl.textContent : '');
        pgOriginalCode = code;

        const overlay = document.getElementById('nw-playground');
        const editor = document.getElementById('nw-pg-editor');
        const langBadge = document.getElementById('nw-pg-lang');
        const frame = document.getElementById('nw-pg-frame');
        const consoleEl = document.getElementById('nw-pg-console');

        editor.value = code;
        langBadge.textContent = pgLang.toUpperCase();
        frame.style.display = 'none';
        consoleEl.style.display = 'none';
        consoleEl.textContent = '';

        overlay.style.display = 'flex';
        requestAnimationFrame(() => {
            overlay.classList.add('active');
            editor.focus();
        });
        document.body.style.overflow = 'hidden';
    };

    window.runPlayground = function() {
        const editor = document.getElementById('nw-pg-editor');
        const frame = document.getElementById('nw-pg-frame');
        const consoleEl = document.getElementById('nw-pg-console');
        const code = editor.value;

        if (pgLang === 'html' || pgLang === 'css') {
            frame.style.display = 'block';
            consoleEl.style.display = 'none';
            const darkBase = '<style>*{box-sizing:border-box}body{margin:0;padding:20px;background:#0a0a0a;color:#e0e0e0;font-family:Inter,sans-serif;}</style>';
            let htmlContent = code;
            if (pgLang === 'css') {
                htmlContent = `<style>${code}</style><div style="padding:20px; font-family:sans-serif; text-align:center;">Element Preview Area</div>`;
            }
            frame.srcdoc = darkBase + htmlContent;
        } else if (pgLang === 'javascript' || pgLang === 'js') {
            frame.style.display = 'none';
            consoleEl.style.display = 'block';
            consoleEl.textContent = '';

            const origLog = console.log;
            let logs = [];
            console.log = function(...args) {
                logs.push(args.map(a => typeof a === 'object' ? JSON.stringify(a, null, 2) : a).join(' '));
                origLog.apply(console, args);
            };
            try {
                const result = new Function(code)();
                if (result !== undefined) logs.push(String(result));
                if (logs.length === 0) logs.push('✓ Code executed successfully (no output).');
                consoleEl.textContent = logs.join('\n');
            } catch (err) {
                consoleEl.textContent = 'Error: ' + err.message;
            } finally {
                console.log = origLog;
            }
        }
    };

    window.resetPlayground = function() {
        document.getElementById('nw-pg-editor').value = pgOriginalCode;
        document.getElementById('nw-pg-frame').style.display = 'none';
        document.getElementById('nw-pg-console').style.display = 'none';
        document.getElementById('nw-pg-console').textContent = '';
    };

    window.closePlayground = function() {
        const overlay = document.getElementById('nw-playground');
        overlay.classList.remove('active');
        setTimeout(() => {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    };

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        const overlay = document.getElementById('nw-playground');
        if (!overlay || !overlay.classList.contains('active')) return;

        if (e.key === 'Escape') {
            e.preventDefault();
            closePlayground();
        }
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            runPlayground();
        }
    });
})();
</script>

{{-- ── FLOATING NOTES PANEL ── --}}
<button id="btn-toggle-notes" style="position: fixed; bottom: 112px; right: 28px; width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,0.05); color: #ffffff; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 24px rgba(0,0,0,0.4); cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 99; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='rgba(255,255,255,0.2)';" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='rgba(255,255,255,0.1)';">
    <i class='bx bx-edit-alt' style="font-size: 24px; color: #ffffff;"></i>
</button>

<div id="notes-panel" style="position: fixed; top: 0; right: -400px; width: 400px; max-width: 100vw; height: 100vh; background: #0a0a0a; border-left: 1px solid rgba(255,255,255,0.08); box-shadow: -10px 0 30px rgba(0,0,0,0.5); z-index: 100; display: flex; flex-direction: column; transition: right 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
    <div style="padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class='bx bx-notepad' style="font-size: 20px; color: var(--accent-primary);"></i>
            <h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #ffffff; font-family: 'Outfit', sans-serif; text-transform: uppercase; letter-spacing: 0.5px;">Catatan</h3>
        </div>
        <button id="btn-close-notes" style="background: none; border: none; cursor: pointer; font-size: 24px; color: #a1a1aa; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.color='#ffffff';" onmouseout="this.style.background='none'; this.style.color='#a1a1aa';">
            <i class='bx bx-x'></i>
        </button>
    </div>
    
    <div style="padding: 16px 24px; font-size: 11px; color: #a1a1aa; display: flex; justify-content: space-between; align-items: center; font-family: 'Outfit', sans-serif;">
        <span>Markdown didukung (**, *, `, dll)</span>
        <span id="notes-status-indicator" style="display: flex; align-items: center; gap: 4px; font-weight: 700; color: #a6e3a1;">
            <i class='bx bx-check-circle'></i> Tersimpan
        </span>
    </div>

    <div style="flex: 1; padding: 0 24px 24px;">
        <textarea id="personal-notes-input" placeholder="Tulis catatan pentingmu di sini..." style="width: 100%; height: 100%; resize: none; border: none; outline: none; font-family: 'Inter', sans-serif; font-size: 14px; line-height: 1.6; color: #eeeeee; background: transparent;"></textarea>
    </div>
</div>
<div id="notes-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 98; display: none; backdrop-filter: blur(4px);"></div>

<script>
(function() {
    const btnToggle = document.getElementById('btn-toggle-notes');
    const btnClose = document.getElementById('btn-close-notes');
    const panel = document.getElementById('notes-panel');
    const overlay = document.getElementById('notes-overlay');
    const textarea = document.getElementById('personal-notes-input');
    const statusInd = document.getElementById('notes-status-indicator');
    const subMateriId = '{{ $subMateri->id }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    
    let saveTimeout = null;

    if (!btnToggle || !panel) return;

    // Toggle Panel
    function openNotes() {
        panel.style.right = '0';
        overlay.style.display = 'block';
        setTimeout(() => overlay.style.opacity = '1', 10);
        textarea.focus();
        fetchNote();
    }

    function closeNotes() {
        panel.style.right = '-400px';
        overlay.style.opacity = '0';
        setTimeout(() => overlay.style.display = 'none', 300);
    }

    btnToggle.addEventListener('click', openNotes);
    btnClose.addEventListener('click', closeNotes);
    overlay.addEventListener('click', closeNotes);

    // Fetch Note
    async function fetchNote() {
        try {
            const res = await fetch(`/app/api/notes/${subMateriId}`);
            const data = await res.json();
            if (data.success) {
                textarea.value = data.content;
            }
        } catch (e) {
            console.error('Failed to fetch notes:', e);
        }
    }

    // Auto Save
    async function saveNote() {
        statusInd.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Menyimpan...";
        statusInd.style.color = "#f59e0b";
        
        try {
            const res = await fetch('/app/api/notes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    sub_materi_id: subMateriId,
                    content: textarea.value
                })
            });
            const data = await res.json();
            
            if (data.success) {
                statusInd.innerHTML = "<i class='bx bx-check-circle'></i> Tersimpan";
                statusInd.style.color = "#10b981";
            } else {
                throw new Error('Save failed');
            }
        } catch (e) {
            statusInd.innerHTML = "<i class='bx bx-error'></i> Gagal simpan";
            statusInd.style.color = "#ef4444";
        }
    }

    textarea.addEventListener('input', function() {
        statusInd.innerHTML = "Mengetik...";
        statusInd.style.color = "#888";
        
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(saveNote, 1000); // 1s auto-save
    });
})();
</script>

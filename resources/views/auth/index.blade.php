<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="TurningCode — Platform pembelajaran interaktif. Akses materi, kerjakan tugas, dan pantau progresmu dalam satu tempat.">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @vite(['resources/css/global.css', 'resources/css/welcome.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <title>{{ config('app.name') }} — Platform Belajar Interaktif</title>
</head>

<body>
    <div class="wlc-page">
        {{-- ═══ TOP HEADER BAR ═══ --}}
        <header class="wlc-header">
            <div class="wlc-header-inner">
                <a href="{{ route('home') }}" class="wlc-header-brand">
                    <i class='bx bx-code-alt'></i>
                    <span>TurningCode</span>
                </a>

                <nav class="wlc-header-nav">
                    <a href="#" class="wlc-header-link" onclick="event.preventDefault(); showInfoPopup(event, 'Materi Terstruktur', 'Jelajahi berbagai modul pembelajaran yang disusun rapi dari tingkat dasar hingga mahir. Kami mencakup HTML, CSS, JavaScript modern, hingga arsitektur Backend.', 'bx-book-open')">Materi <i class='bx bx-chevron-down'></i></a>
                    <a href="#" class="wlc-header-link" onclick="event.preventDefault(); showInfoPopup(event, 'Fitur Unggulan', 'Platform kami dilengkapi dengan Live Code Editor, sistem Gamifikasi (EXP & Rank), pemantauan progres visual, serta asisten AI TurnBot yang siap membantumu.', 'bx-star')">Fitur <i class='bx bx-chevron-down'></i></a>
                    <a href="#" class="wlc-header-link" onclick="event.preventDefault(); showInfoPopup(event, 'Integrasi Sistem', 'TurningCode terintegrasi penuh dengan lingkungan eksekusi waktu nyata. Tulis kodemu dan jalankan secara langsung di browser dengan Live DOM dan JS Runtime Console.', 'bx-plug')">Integrasi <i class='bx bx-chevron-down'></i></a>
                    <a href="#" class="wlc-header-link" onclick="event.preventDefault(); showInfoPopup(event, 'Komunitas & Ekstra', 'Temukan berbagai kejutan menarik di dalam platform! Mulai dari leaderboard peringkat siswa, easter eggs tersembunyi, hingga mini-games interaktif bersama TurnBot.', 'bx-category')">Lainnya <i class='bx bx-chevron-down'></i></a>
                </nav>

                <div class="wlc-header-actions">
                    <a href="{{ route('login') }}" class="wlc-header-login">Log in</a>
                    <a href="{{ route('register') }}" class="wlc-header-cta">Daftar Sekarang</a>
                </div>

                {{-- Mobile hamburger --}}
                <button class="wlc-header-burger"
                    onclick="document.querySelector('.wlc-header').classList.toggle('open')">
                    <i class='bx bx-menu'></i>
                </button>
            </div>

            {{-- Mobile dropdown --}}
            <div class="wlc-header-mobile">
                <a href="#" class="wlc-mobile-link" onclick="event.preventDefault(); showInfoPopup(event, 'Materi Terstruktur', 'Jelajahi berbagai modul pembelajaran yang disusun rapi dari tingkat dasar hingga mahir. Kami mencakup HTML, CSS, JavaScript modern, hingga arsitektur Backend.', 'bx-book-open')">Materi</a>
                <a href="#" class="wlc-mobile-link" onclick="event.preventDefault(); showInfoPopup(event, 'Fitur Unggulan', 'Platform kami dilengkapi dengan Live Code Editor, sistem Gamifikasi (EXP & Rank), pemantauan progres visual, serta asisten AI TurnBot yang siap membantumu.', 'bx-star')">Fitur</a>
                <a href="#" class="wlc-mobile-link" onclick="event.preventDefault(); showInfoPopup(event, 'Integrasi Sistem', 'TurningCode terintegrasi penuh dengan lingkungan eksekusi waktu nyata. Tulis kodemu dan jalankan secara langsung di browser dengan Live DOM dan JS Runtime Console.', 'bx-plug')">Integrasi</a>
                <a href="#" class="wlc-mobile-link" onclick="event.preventDefault(); showInfoPopup(event, 'Komunitas & Ekstra', 'Temukan berbagai kejutan menarik di dalam platform! Mulai dari leaderboard peringkat siswa, easter eggs tersembunyi, hingga mini-games interaktif bersama TurnBot.', 'bx-category')">Lainnya</a>
                <div class="wlc-mobile-actions">
                    <a href="{{ route('login') }}" class="wlc-header-login">Log in</a>
                    <a href="{{ route('register') }}" class="wlc-header-cta">Daftar Sekarang</a>
                </div>
            </div>
        </header>

        {{-- ═══ HERO SECTION — Split Layout ═══ --}}
        <section class="wlc-hero">
            {{-- Vertical lines background --}}
            <div class="wlc-lines" aria-hidden="true">
                <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
            </div>

            {{-- Floating Icons --}}
            <div class="wlc-float-icons">
                <div class="wlc-float-icon"><i class='bx bx-book-open'></i></div>
                <div class="wlc-float-icon"><i class='bx bx-bulb'></i></div>
                <div class="wlc-float-icon"><i class='bx bx-target-lock'></i></div>
                <div class="wlc-float-icon"><i class='bx bx-bar-chart'></i></div>
            </div>

            <div class="wlc-hero-grid">
                {{-- LEFT COLUMN — Text --}}
                <div class="wlc-hero-left">
                    <div class="wlc-sparkle">✦</div>

                    <h1 class="wlc-hero-title">
                        <span class="serif">Complete</span>
                        Platform Belajar
                        Interaktif
                    </h1>

                    <p class="wlc-hero-desc">
                        Akses materi pelajaran, kerjakan tugas, dan <strong>pantau progresmu</strong> dalam
                        satu tempat. Platform yang dirancang untuk membantu kamu belajar lebih <strong>efektif</strong>.
                    </p>

                    <a href="{{ route('login') }}" class="wlc-hero-cta">Masuk Sekarang</a>
                </div>

                {{-- RIGHT COLUMN — Browser Mockup --}}
                <div class="wlc-hero-right">
                    <div class="wlc-mockup">
                        <div class="wlc-mockup-inner">
                            {{-- Chrome Bar --}}
                            <div class="wlc-mockup-bar">
                                <div class="wlc-mockup-dots">
                                    <span></span><span></span><span></span>
                                </div>
                                <div class="wlc-mockup-url">
                                    <i class='bx bx-lock-alt' style="margin-right: 6px; font-size: 11px;"></i>
                                    turningcode.app
                                </div>
                                <div class="wlc-mockup-actions">
                                    <i class='bx bx-chevron-left'></i>
                                    <i class='bx bx-chevron-right'></i>
                                    <i class='bx bx-refresh'></i>
                                </div>
                            </div>

                            {{-- Mockup Content — Sidebar + Main --}}
                            <div class="wlc-mockup-body">
                                <div class="wlc-mockup-sidebar">
                                    <div class="wlc-mock-logo"><i class='bx bx-code-alt'></i></div>
                                    <div class="wlc-mock-sidebar-item active">
                                        <i class='bx bx-home'></i> Dashboard
                                    </div>
                                    <div class="wlc-mock-sidebar-item">
                                        <i class='bx bx-book-open'></i> Materi
                                    </div>
                                    <div class="wlc-mock-sidebar-item">
                                        <i class='bx bx-task'></i> Tugas
                                    </div>
                                    <div class="wlc-mock-sidebar-item">
                                        <i class='bx bx-bar-chart-alt-2'></i> Progres
                                    </div>
                                    <div class="wlc-mock-sidebar-item">
                                        <i class='bx bx-cog'></i> Pengaturan
                                    </div>
                                </div>
                                <div class="wlc-mockup-main">
                                    <div class="wlc-mock-main-header">
                                        <div class="wlc-mock-greeting">
                                            <i class='bx bx-sun'></i>
                                            <span>Selamat Pagi!</span>
                                        </div>
                                        <div class="wlc-mock-title-text">Apa yang ingin kamu pelajari?</div>
                                    </div>
                                    <div class="wlc-mock-cards">
                                        <div class="wlc-mock-card">
                                            <div class="wlc-mock-card-line w80"></div>
                                            <div class="wlc-mock-card-line w50"></div>
                                        </div>
                                        <div class="wlc-mock-card">
                                            <div class="wlc-mock-card-line w60"></div>
                                            <div class="wlc-mock-card-line w70"></div>
                                        </div>
                                    </div>
                                    <div class="wlc-mock-chat-bar">
                                        <div class="wlc-mock-chat-icon"><i class='bx bx-bot'></i></div>
                                        <div class="wlc-mock-chat-msg">Hai! Mau mulai belajar apa hari ini?</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ DOWNLOAD SECTION ═══ --}}
        <section class="wlc-download">
            <div class="wlc-dl-card">
                <h2 class="wlc-dl-title">Mulai perjalanan karirmu</h2>
                <p class="wlc-dl-desc">
                    TurningCode adalah platform pembelajaran interaktif untuk membangun pondasi programming yang kuat.
                </p>

                <div class="wlc-dl-buttons">
                    <div class="wlc-dl-btn" style="opacity: 0.6; cursor: default;">
                        <i class='bx bxl-apple dl-icon'></i>
                        <div class="dl-text">
                            <span>Segera Hadir di</span>
                            <strong>App Store</strong>
                        </div>
                    </div>
                    <div class="wlc-dl-btn" style="opacity: 0.6; cursor: default;">
                        <i class='bx bxl-play-store dl-icon'></i>
                        <div class="dl-text">
                            <span>Segera Hadir di</span>
                            <strong>Google Play</strong>
                        </div>
                    </div>
                    <div class="wlc-dl-btn qr">
                        <i class='bx bx-grid-small dl-icon'></i>
                        <div class="dl-text">
                            <span>Scan</span>
                            <strong>Browser</strong>
                        </div>
                    </div>
                </div>

                <div class="wlc-dl-footer">
                    <span><i class='bx bxs-star' style='color:#666'></i> 4.9 Rating Siswa</span>
                    <span class="dot">•</span>
                    <span>10k+ Pengguna Aktif</span>
                    <span class="dot">•</span>
                    <span><i class='bx bx-trophy' style='color:#666'></i> Platform Terbaik</span>
                </div>
            </div>
        </section>

        {{-- ═══ FEATURE SECTION ═══ --}}
        <section class="wlc-feature">
            <div class="wlc-feat-card">
                {{-- Left Content --}}
                <div class="wlc-feat-left">
                    <span class="feat-badge">Interactive Coding</span>
                    <h2 class="feat-title">
                        Belajar coding lebih cepat <span class="light">dengan Live Code Editor</span>
                    </h2>
                    <p class="feat-desc">
                        TurningCode menyediakan environment belajar yang terintegrasi. Tidak perlu instalasi — cukup
                        buka materi, tulis kodemu, dan langsung jalankan.
                    </p>

                    <div class="feat-quote">
                        <i class='bx bxs-quote-alt-left quote-icon'></i>
                        <p class="quote-text">
                            Dengan fitur live coding, pemahaman konsep menjadi jauh lebih cepat. Saya bisa langsung
                            mempraktikkan teori yang baru saja dibaca tanpa pindah aplikasi.
                        </p>
                        <div class="quote-author">
                            <strong>Budi Santoso</strong>
                            <span>Siswa TurningCode</span>
                        </div>
                    </div>
                </div>

                {{-- Right Content — Code Editor Mockup --}}
                <div class="wlc-feat-right">
                    <div class="wlc-editor">
                        <div class="wlc-editor-header">
                            <div class="editor-tab active" data-tab="js" style="cursor:pointer;"><i
                                    class='bx bxl-javascript' style="color:#fbbf24"></i> script.js</div>
                            <div class="editor-tab" data-tab="html" style="cursor:pointer;"><i class='bx bxl-html5'
                                    style="color:#e34f26"></i> index.html</div>
                        </div>
                        <div class="wlc-editor-body">
                            <pre id="wlc-tab-js" class="wlc-code-tab" contenteditable="true" spellcheck="false"
                                style="outline:none; display:block;"><code><span class="kwd">function</span> <span class="func">greet</span>(<span class="arg">name</span>) {
  <span class="kwd">return</span> <span class="str">`Halo, <span class="var">${name}</span>! Selamat datang di TurningCode.`</span>;
}

<span class="cmt">// Coba jalankan kode ini</span>
<span class="kwd">const</span> <span class="var">message</span> = <span class="func">greet</span>(<span class="str">"Programmer"</span>);
<span class="func">console</span>.<span class="func">log</span>(<span class="var">message</span>);</code></pre>
                            <pre id="wlc-tab-html" class="wlc-code-tab" contenteditable="true" spellcheck="false"
                                style="outline:none; display:none;"><code>&lt;<span class="kwd">h3</span> <span class="arg">style</span>=<span class="str">"color: #fbbf24; margin: 0 0 10px;"</span>&gt;Halo Dunia!&lt;/<span class="kwd">h3</span>&gt;
&lt;<span class="kwd">p</span> <span class="arg">style</span>=<span class="str">"color: #a6e3a1; font-family: sans-serif; margin: 0;"</span>&gt;Coba ubah teks HTML ini dan klik Run.&lt;/<span class="kwd">p</span>&gt;</code></pre>
                        </div>
                        <div class="wlc-editor-footer">
                            <div class="editor-status"><i class='bx bxs-check-circle'></i> Output Ready</div>
                            <button class="editor-btn run-wlc-code">Run Code <i
                                    class='bx bx-right-arrow-alt'></i></button>
                        </div>
                        <div class="wlc-editor-output"
                            style="display:none; border-top:1px solid rgba(255,255,255,0.05); padding:16px; background:#121212;">
                            <div class="wlc-output-header"
                                style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                                <span
                                    style="font-size:11px; font-weight:700; color:#888; text-transform:uppercase; letter-spacing:0.5px;">Live
                                    Output</span>
                                <button class="wlc-close-output"
                                    style="background:none; border:none; color:#888; cursor:pointer;"><i
                                        class='bx bx-x'></i></button>
                            </div>
                            <pre class="wlc-output-console"
                                style="display:none; color:#a6e3a1; font-family:monospace; margin:0; font-size:13px; white-space:pre-wrap;"></pre>
                            <iframe class="wlc-output-frame"
                                style="display:none; width:100%; height:120px; border:1px dashed rgba(255,255,255,0.2); border-radius:8px; background:transparent;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ ROADMAP SECTION ═══ --}}
        <section class="wlc-roadmap">
            <div class="wlc-rm-header">
                <h2 class="rm-title">Roadmap Belajar</h2>
                <p class="rm-desc">Langkah demi langkah terstruktur untuk menguasai pemrograman dari nol hingga mahir.
                </p>

                {{-- Category Buttons --}}
                <div class="rm-tabs">
                    @php
                        $mainMateris = \App\Models\MainMateri::with('materis')->where('status', '!=', 'draft')->orderBy('id')->get();
                    @endphp
                    @foreach($mainMateris as $index => $main)
                        <button class="rm-tab-btn {{ $index == 0 ? 'active' : '' }}"
                            data-target="rm-canvas-{{ $main->id }}">
                            {{ $main->title }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="rm-canvases-container">
                @foreach($mainMateris as $mainIndex => $main)
                    <div class="wlc-rm-canvas {{ $mainIndex == 0 ? 'active' : '' }}" id="rm-canvas-{{ $main->id }}">
                        <ul class="h-tree">
                            <li>
                                {{-- Root Node: MainMateri --}}
                                <div class="rm-node">
                                    <div class="rm-node-header">
                                        <i class='bx bx-book-open'></i>
                                        <strong>{{ $main->title }}</strong>
                                        <i class='bx bx-dots-horizontal-rounded dots'></i>
                                    </div>
                                    <div class="rm-node-body">
                                        <div class="rm-row bg">
                                            <span class="rm-key"><i class='bx bx-folder'></i> Total</span>
                                            <span class="rm-val">{{ $main->materis->count() }} Materi</span>
                                        </div>
                                    </div>
                                    <div class="rm-port-out"></div>
                                </div>

                                @if($main->materis->isNotEmpty())
                                    <ul>
                                        @foreach($main->materis->take(4) as $materi)
                                            <li>
                                                {{-- Level 1 Node: Materi --}}
                                                <div class="rm-node">
                                                    <div class="rm-node-header">
                                                        <i class='bx bx-file'></i>
                                                        <strong>{{ $materi->title }}</strong>
                                                    </div>
                                                    <div class="rm-node-body">
                                                        <div class="rm-row bg">
                                                            <span class="rm-key"><i class='bx bx-time'></i> Modul</span>
                                                            <span
                                                                class="rm-val">{{ \App\Models\SubMateri::where('materi_id', $materi->id)->count() }}
                                                                Topik</span>
                                                        </div>
                                                        <div class="rm-row" style="display:block; padding: 12px 16px;">
                                                            <div class="rm-val"
                                                                style="font-size: 11px; font-weight: normal; line-height: 1.5; color: #666; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; white-space: normal;">
                                                                {{ $materi->description ?? 'Pelajari lebih lanjut tentang topik ini.' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="rm-port-out"></div>
                                                </div>

                                                @if($materi->subMateris->isNotEmpty())
                                                    <ul>
                                                        @foreach($materi->subMateris->take(3) as $sub)
                                                            <li>
                                                                {{-- Level 2 Node: SubMateri (Leaf) --}}
                                                                <div class="rm-node compact">
                                                                    <div class="rm-node-header">
                                                                        <i class='bx bx-check-circle' style="color:#10b981;"></i>
                                                                        <strong>{{ $sub->title }}</strong>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Roadmap Logic
                    const tabs = document.querySelectorAll('.rm-tab-btn');
                    const canvases = document.querySelectorAll('.wlc-rm-canvas');

                    tabs.forEach(tab => {
                        tab.addEventListener('click', () => {
                            tabs.forEach(t => t.classList.remove('active'));
                            canvases.forEach(c => c.classList.remove('active'));

                            tab.classList.add('active');
                            const targetId = tab.getAttribute('data-target');
                            const targetCanvas = document.getElementById(targetId);
                            if (targetCanvas) {
                                targetCanvas.classList.add('active');
                            }
                        });
                    });

                    // Live Code Logic
                    const wlcTabs = document.querySelectorAll(".wlc-editor-header .editor-tab");
                    const wlcCodeTabs = document.querySelectorAll(".wlc-editor-body .wlc-code-tab");
                    const runWlcBtn = document.querySelector(".run-wlc-code");
                    const wlcOutputWrap = document.querySelector(".wlc-editor-output");
                    const wlcOutputConsole = document.querySelector(".wlc-output-console");
                    const wlcOutputFrame = document.querySelector(".wlc-output-frame");
                    const wlcCloseBtn = document.querySelector(".wlc-close-output");

                    let currentWlcLang = 'js';

                    wlcTabs.forEach(tab => {
                        tab.addEventListener("click", () => {
                            wlcTabs.forEach(t => t.classList.remove("active"));
                            wlcCodeTabs.forEach(c => c.style.display = "none");

                            tab.classList.add("active");
                            currentWlcLang = tab.getAttribute("data-tab");
                            const targetEl = document.getElementById("wlc-tab-" + currentWlcLang);
                            if (targetEl) targetEl.style.display = "block";
                        });
                    });

                    runWlcBtn.addEventListener("click", () => {
                        wlcOutputWrap.style.display = "block";
                        const activeCodeEl = document.getElementById("wlc-tab-" + currentWlcLang);
                        const codeText = activeCodeEl.innerText || activeCodeEl.textContent;

                        if (currentWlcLang === 'html') {
                            wlcOutputConsole.style.display = "none";
                            wlcOutputFrame.style.display = "block";
                            wlcOutputFrame.srcdoc = `<style>body{color:#fff; font-family:sans-serif; margin:10px;}</style>` + codeText;
                        } else if (currentWlcLang === 'js') {
                            wlcOutputFrame.style.display = "none";
                            wlcOutputConsole.style.display = "block";
                            wlcOutputConsole.textContent = "";

                            const originalLog = console.log;
                            let logs = [];
                            console.log = function (...args) {
                                logs.push(args.map(a => typeof a === 'object' ? JSON.stringify(a) : a).join(' '));
                                originalLog.apply(console, args);
                            };

                            try {
                                const result = new Function(codeText)();
                                if (result !== undefined) logs.push(String(result));
                                if (logs.length === 0) logs.push("✓ Code executed successfully.");
                                wlcOutputConsole.textContent = logs.join('\n');
                            } catch (e) {
                                wlcOutputConsole.textContent = "Error: " + e.message;
                            } finally {
                                console.log = originalLog;
                            }
                        }
                    });

                    wlcCloseBtn.addEventListener("click", () => {
                        wlcOutputWrap.style.display = "none";
                    });
                });

                // Navbar Info Popover Component
                let currentNavPopover = null;

                function showInfoPopup(e, title, desc, icon) {
                    if (currentNavPopover) {
                        currentNavPopover.remove();
                        currentNavPopover = null;
                    }

                    const target = e.currentTarget;
                    const rect = target.getBoundingClientRect();

                    let leftPos = rect.left + (rect.width / 2);
                    let transformX = '-50%';
                    let arrowLeft = '50%';

                    if (window.innerWidth < 400) {
                        leftPos = window.innerWidth / 2;
                        transformX = '-50%';
                        // Arrow pointing exactly at the center of the clicked element
                        arrowLeft = (rect.left + (rect.width / 2)) - (window.innerWidth / 2 - 170) + 'px';
                    } else if (leftPos < 170) {
                        leftPos = rect.left;
                        transformX = '0';
                        arrowLeft = (rect.width / 2) + 'px';
                    } else if (leftPos + 170 > window.innerWidth) {
                        leftPos = rect.right;
                        transformX = '-100%';
                        arrowLeft = 'calc(100% - ' + (rect.width / 2) + 'px)';
                    }

                    const popup = document.createElement('div');
                    popup.style.cssText = `
                        position: fixed;
                        top: ${rect.bottom + 16}px;
                        left: ${leftPos}px;
                        transform: translateX(${transformX}) translateY(10px);
                        width: 340px;
                        max-width: calc(100vw - 32px);
                        background: #18181c;
                        border: 1px solid rgba(255, 255, 255, 0.08);
                        border-radius: 16px;
                        padding: 20px;
                        box-shadow: 0 20px 40px rgba(0,0,0,0.6);
                        z-index: 10000;
                        opacity: 0;
                        visibility: hidden;
                        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
                        display: flex;
                        gap: 16px;
                    `;

                    const arrow = document.createElement('div');
                    arrow.style.cssText = `
                        position: absolute;
                        top: -7px;
                        left: ${arrowLeft};
                        transform: translateX(-50%) rotate(45deg);
                        width: 14px;
                        height: 14px;
                        background: #18181c;
                        border-left: 1px solid rgba(255, 255, 255, 0.08);
                        border-top: 1px solid rgba(255, 255, 255, 0.08);
                        z-index: -1;
                    `;
                    popup.appendChild(arrow);

                    popup.innerHTML += `
                        <div style="
                            flex-shrink: 0;
                            width: 48px; height: 48px;
                            background: rgba(255, 255, 255, 0.03);
                            color: #e2e8f0;
                            border: 1px solid rgba(255, 255, 255, 0.08);
                            border-radius: 12px;
                            display: flex; align-items: center; justify-content: center;
                            font-size: 24px;
                        "><i class='bx ${icon}'></i></div>
                        <div>
                            <h4 style="
                                color: #fff; font-family: 'Inter', sans-serif;
                                font-size: 15px; font-weight: 600; margin: 0 0 6px;
                                letter-spacing: -0.2px;
                            ">${title}</h4>
                            <p style="
                                color: #a0a0b0; font-family: 'Inter', sans-serif;
                                font-size: 13px; line-height: 1.5; margin: 0;
                            ">${desc}</p>
                        </div>
                    `;

                    document.body.appendChild(popup);
                    currentNavPopover = popup;

                    void popup.offsetWidth;
                    popup.style.visibility = 'visible';
                    popup.style.opacity = '1';
                    popup.style.transform = `translateX(${transformX}) translateY(0)`;

                    setTimeout(() => {
                        const closeHandler = (ev) => {
                            if (!popup.contains(ev.target)) {
                                popup.style.opacity = '0';
                                popup.style.transform = `translateX(${transformX}) translateY(10px)`;
                                setTimeout(() => popup.remove(), 250);
                                document.removeEventListener('click', closeHandler);
                                currentNavPopover = null;
                            }
                        };
                        document.addEventListener('click', closeHandler);
                        
                        setTimeout(() => {
                            if(currentNavPopover === popup) {
                                popup.style.opacity = '0';
                                popup.style.transform = `translateX(${transformX}) translateY(10px)`;
                                setTimeout(() => popup.remove(), 250);
                                document.removeEventListener('click', closeHandler);
                                currentNavPopover = null;
                            }
                        }, 5000);
                    }, 10);
                }
            </script>
        </section>

        {{-- ═══ TIER SYSTEM SECTION ═══ --}}
        <section class="wlc-tiers">
            <div class="wlc-tiers-inner">
                <div class="wlc-tiers-header">
                    <h2 class="tier-title">Sistem Gamifikasi & Tier</h2>
                    <p class="tier-desc">TurningCode mengadaptasi sistem gamifikasi ala game RPG. Setiap kali kamu
                        menyelesaikan materi atau tugas, kamu akan mendapatkan EXP untuk naik Rank/Tier. Berikut adalah
                        3 Tier paling elit yang bisa kamu capai:</p>
                </div>

                <div class="wlc-tiers-grid">
                    <div class="tier-card elite">
                        <div class="tier-glow"></div>
                        <img src="{{ asset('assets/ico/emblem011Trans.png') }}" alt="Penguasa Sektor" class="tier-img">
                        <h3 class="tier-name">Penguasa Sektor</h3>
                        <p class="tier-exp">1,000,000+ EXP</p>
                        <span class="tier-badge">Peringkat 1</span>
                    </div>
                    <div class="tier-card">
                        <img src="{{ asset('assets/ico/emblem010Trans.png') }}" alt="Venerable" class="tier-img">
                        <h3 class="tier-name">Venerable</h3>
                        <p class="tier-exp">500,000+ EXP</p>
                        <span class="tier-badge">Peringkat 2</span>
                    </div>
                    <div class="tier-card">
                        <img src="{{ asset('assets/ico/emblem009Trans.png') }}" alt="Immortal" class="tier-img">
                        <h3 class="tier-name">Immortal</h3>
                        <p class="tier-exp">250,000+ EXP</p>
                        <span class="tier-badge">Peringkat 3</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══ TURNBOT SECTION ═══ --}}
        <section class="wlc-bot">
            <div class="wlc-bot-inner">
                <div class="wlc-bot-content">
                    <h2 class="bot-title">Kenalan dengan TurnBot!</h2>
                    <p class="bot-desc">Asisten virtual cerdas yang siap menemani perjalanan belajarmu. TurnBot tidak
                        hanya membantu menjawab pertanyaan seputar materi, tapi juga bisa menemanimu bermain mini-games,
                        melacak mood belajarmu, dan memastikan kamu tetap termotivasi setiap hari!</p>
                    <ul class="bot-features">
                        <li>
                            <div class="feat-icon"><i class='bx bx-message-rounded-dots'></i></div>
                            <span>Teman diskusi belajar interaktif</span>
                        </li>
                        <li>
                            <div class="feat-icon"><i class='bx bx-joystick'></i></div>
                            <span>Mini games & easter eggs tersembunyi</span>
                        </li>
                        <li>
                            <div class="feat-icon"><i class='bx bx-smile'></i></div>
                            <span>Pemantau mood & streak harian</span>
                        </li>
                    </ul>
                </div>
                <div class="wlc-bot-image">
                    <div class="bot-img-wrapper">
                        <div class="bot-glow"></div>
                        <img src="{{ asset('assets/img/maskot-turncode.gif') }}" alt="TurnBot Mascot">
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
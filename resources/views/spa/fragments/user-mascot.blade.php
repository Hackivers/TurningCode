{{-- ═══ RTD MASCOT COMPANION v2 — Interactive Chat ═══ --}}
@php $userName = Auth::user()->name ?? 'Kamu'; @endphp
<div id="rtd-mascot-wrapper" class="rtd-mascot-wrapper" data-user="{{ $userName }}">
    <div id="rtd-mascot-bubble" class="rtd-mascot-bubble rtd-mascot-bubble--hidden">
        <div class="rtd-bubble-header">
            <div class="rtd-bubble-header-left">
                <img src="{{ asset('assets/img/maskot-turncode.gif') }}" class="rtd-header-avatar" alt="RTD">
                <div>
                    <span class="rtd-bubble-name">TurnBot</span>
                    <span class="rtd-bubble-status"><span class="rtd-bubble-dot"></span> Online</span>
                </div>
            </div>
            <button type="button" class="rtd-bubble-close" onclick="window.__mascotClose()"><i class='bx bx-x'></i></button>
        </div>
        <div class="rtd-bubble-body" id="rtd-bubble-body"></div>
        <div class="rtd-bubble-chips" id="rtd-bubble-chips">
            <button class="rtd-chip" onclick="window.__mascotAsk('motivation')"><i class='bx bx-bulb'></i> Motivasi</button>
            <button class="rtd-chip" onclick="window.__mascotAsk('tip')"><i class='bx bx-code-alt'></i> Tips</button>
            <button class="rtd-chip" onclick="window.__mascotAsk('guide')"><i class='bx bx-map'></i> Panduan</button>
            <button class="rtd-chip" onclick="window.__mascotAsk('funfact')"><i class='bx bx-planet'></i> Fun Fact</button>
            <button class="rtd-chip" onclick="window.__mascotAsk('quiz')"><i class='bx bx-brain'></i> Quiz</button>
            <button class="rtd-chip" onclick="window.__mascotAsk('joke')"><i class='bx bx-happy-heart-eyes'></i> Joke</button>
            <button class="rtd-chip" onclick="window.__mascotAsk('tebak')"><i class='bx bx-target-lock'></i> Tebak Angka</button>
            <button class="rtd-chip" onclick="window.__mascotAsk('scramble')"><i class='bx bx-text'></i> Scramble</button>
        </div>
        <div class="rtd-bubble-input-wrap">
            <input type="text" id="rtd-chat-input" class="rtd-chat-input" placeholder="Ketik pesan..." autocomplete="off" maxlength="200">
            <button type="button" id="rtd-chat-send" class="rtd-chat-send" onclick="window.__mascotSendInput()"><i class='bx bx-send'></i></button>
        </div>
    </div>
    {{-- Floating speech bubble (outside chat) --}}
    <div id="rtd-float-bubble" class="rtd-float-bubble rtd-float-bubble--hidden">
        <div class="rtd-float-bubble-inner">
            <div class="rtd-float-avatar">
                <img src="{{ asset('assets/img/maskot-turncode.gif') }}" alt="RTD">
            </div>
            <div class="rtd-float-text" id="rtd-float-text"></div>
            <button class="rtd-float-close" onclick="window.__mascotDismissFloat()"><i class='bx bx-x'></i></button>
        </div>
        <div class="rtd-float-tail"></div>
    </div>
    <button type="button" id="rtd-mascot-btn" class="rtd-mascot-btn" onclick="window.__mascotToggle()" title="TurnBot">
        <div class="rtd-mascot-glow"></div>
        <img src="{{ asset('assets/img/maskot-turncode.gif') }}" alt="TurnBot" class="rtd-mascot-img" draggable="false">
        <div class="rtd-mascot-badge" id="rtd-mascot-badge"><i class='bx bx-message-dots'></i></div>
    </button>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/user-mascot.css') }}">

<script src="{{ asset('src/js/user-mascot.js') }}"></script>
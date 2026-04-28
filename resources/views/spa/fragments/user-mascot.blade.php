{{-- ═══ RTD MASCOT COMPANION v2 — Interactive Chat ═══ --}}
@php $userName = Auth::user()->name ?? 'Kamu'; @endphp
<div id="rtd-mascot-wrapper" class="rtd-mascot-wrapper">
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

<style>
.rtd-mascot-wrapper{position:fixed;bottom:24px;right:24px;z-index:99990;pointer-events:none}
.rtd-mascot-wrapper>*{pointer-events:auto}
.rtd-mascot-btn{position:relative;width:64px;height:64px;border-radius:50%;border:none;background:#0a0a0a;cursor:pointer;padding:0;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 32px rgba(0,0,0,.4),0 0 0 3px rgba(99,102,241,.15);transition:transform .3s cubic-bezier(.34,1.56,.64,1),box-shadow .3s;animation:mascotFloat 3s ease-in-out infinite;overflow:visible}
.rtd-mascot-btn:hover{transform:scale(1.1);box-shadow:0 12px 40px rgba(0,0,0,.5),0 0 0 4px rgba(99,102,241,.3)}
.rtd-mascot-btn:active{transform:scale(.95)}
.rtd-mascot-img{width:48px;height:48px;border-radius:50%;object-fit:cover;pointer-events:none}
.rtd-mascot-glow{position:absolute;inset:-6px;border-radius:50%;background:conic-gradient(from 0deg,#6366f1,#06b6d4,#8b5cf6,#6366f1);opacity:.25;filter:blur(10px);animation:mascotGlowSpin 4s linear infinite;pointer-events:none}
.rtd-mascot-badge{position:absolute;top:-4px;right:-4px;width:22px;height:22px;border-radius:50%;background:#6366f1;color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;box-shadow:0 2px 8px rgba(99,102,241,.5);animation:mascotBadgePulse 2s ease-in-out infinite;pointer-events:none}
.rtd-mascot-badge.hidden{display:none}
.rtd-mascot-bubble{position:absolute;bottom:76px;right:0;width:360px;max-width:calc(100vw - 48px);background:#111;border:1px solid #1e1e1e;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,.6);overflow:hidden;transform-origin:bottom right;transition:opacity .3s,visibility .3s,transform .3s cubic-bezier(.34,1.56,.64,1);display:flex;flex-direction:column}
.rtd-mascot-bubble--hidden{opacity:0;visibility:hidden;transform:scale(.8) translateY(10px);pointer-events:none!important}
.rtd-mascot-bubble--visible{opacity:1;visibility:visible;transform:scale(1) translateY(0)}
.rtd-bubble-header{display:flex;align-items:center;justify-content:space-between;padding:12px 14px;border-bottom:1px solid #1e1e1e;background:rgba(99,102,241,.04)}
.rtd-bubble-header-left{display:flex;align-items:center;gap:10px}
.rtd-header-avatar{width:32px;height:32px;border-radius:50%;object-fit:cover;border:2px solid #222}
.rtd-bubble-name{font-size:13px;font-weight:700;color:#e5e5e5;display:block;line-height:1.2}
.rtd-bubble-status{font-size:10px;color:#888;display:flex;align-items:center;gap:4px}
.rtd-bubble-dot{width:6px;height:6px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px rgba(34,197,94,.5);animation:mascotDotPulse 2s ease-in-out infinite}
.rtd-bubble-close{background:rgba(255,255,255,.06);border:none;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#888;cursor:pointer;transition:all .2s;font-size:18px}
.rtd-bubble-close:hover{background:rgba(255,255,255,.12);color:#fff}
.rtd-bubble-body{padding:14px;min-height:100px;max-height:300px;overflow-y:auto;display:flex;flex-direction:column;gap:10px;scroll-behavior:smooth}
.rtd-msg{max-width:85%;padding:10px 14px;border-radius:16px;font-size:13px;line-height:1.55;font-family:'Inter',sans-serif;animation:msgIn .3s ease-out}
.rtd-msg-bot{background:#1a1a2e;color:#ccc;border-bottom-left-radius:4px;align-self:flex-start}
.rtd-msg-user{background:#6366f1;color:#fff;border-bottom-right-radius:4px;align-self:flex-end}
.rtd-msg-bot .rtd-msg-label{font-size:10px;font-weight:700;color:#6366f1;margin-bottom:4px;text-transform:uppercase;letter-spacing:.04em}
.rtd-typing-indicator{display:inline-flex;gap:4px;padding:6px 0;align-items:center}
.rtd-typing-indicator span{width:6px;height:6px;border-radius:50%;background:#6366f1;animation:typingDot 1.4s ease-in-out infinite}
.rtd-typing-indicator span:nth-child(2){animation-delay:.2s}
.rtd-typing-indicator span:nth-child(3){animation-delay:.4s}
.rtd-bubble-chips{display:flex;flex-wrap:wrap;gap:6px;padding:0 14px 10px;border-top:1px solid #1a1a1a;padding-top:10px}
.rtd-chip{display:inline-flex;align-items:center;gap:4px;padding:6px 11px;font-size:10.5px;font-weight:600;color:#999;background:rgba(255,255,255,.03);border:1px solid #222;border-radius:20px;cursor:pointer;transition:all .2s;font-family:'Inter',sans-serif;white-space:nowrap}
.rtd-chip:hover{background:rgba(99,102,241,.1);border-color:rgba(99,102,241,.3);color:#c7d2fe;transform:translateY(-1px)}
.rtd-chip i{font-size:12px}
.rtd-bubble-input-wrap{display:flex;align-items:center;gap:8px;padding:10px 14px;border-top:1px solid #1a1a1a;background:rgba(0,0,0,.2)}
.rtd-chat-input{flex:1;background:#1a1a1a;border:1px solid #252525;border-radius:20px;padding:9px 14px;font-size:13px;color:#ddd;outline:none;font-family:'Inter',sans-serif;transition:border-color .2s}
.rtd-chat-input:focus{border-color:#6366f1}
.rtd-chat-input::placeholder{color:#555}
.rtd-chat-send{width:34px;height:34px;border-radius:50%;border:none;background:#6366f1;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;transition:all .2s;flex-shrink:0}
.rtd-chat-send:hover{background:#4f46e5;transform:scale(1.05)}
/* Mini quiz */
.rtd-quiz-options{display:flex;flex-direction:column;gap:6px;margin-top:8px}
.rtd-quiz-opt{text-align:left;background:rgba(255,255,255,.04);border:1px solid #2a2a2a;border-radius:12px;padding:8px 12px;font-size:12px;color:#bbb;cursor:pointer;transition:all .2s;font-family:'Inter',sans-serif}
.rtd-quiz-opt:hover{background:rgba(99,102,241,.1);border-color:#6366f1;color:#e5e5e5}
.rtd-quiz-opt.correct{background:rgba(34,197,94,.15)!important;border-color:#22c55e!important;color:#4ade80!important}
.rtd-quiz-opt.wrong{background:rgba(239,68,68,.15)!important;border-color:#ef4444!important;color:#f87171!important}
.rtd-quiz-opt:disabled{cursor:default;opacity:.7}
@keyframes mascotFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}
@keyframes mascotGlowSpin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
@keyframes mascotBadgePulse{0%,100%{transform:scale(1)}50%{transform:scale(1.15)}}
@keyframes mascotDotPulse{0%,100%{opacity:1}50%{opacity:.5}}
@keyframes typingDot{0%,60%,100%{transform:translateY(0);opacity:.4}30%{transform:translateY(-6px);opacity:1}}
@keyframes msgIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
@media(max-width:768px){.rtd-mascot-wrapper{bottom:80px;right:16px}.rtd-mascot-btn{width:56px;height:56px}.rtd-mascot-img{width:40px;height:40px}.rtd-mascot-bubble{width:300px;bottom:68px}.rtd-float-bubble{max-width:260px;bottom:68px}}
/* --- Floating Speech Bubble (Outside Chat) --- */
.rtd-float-bubble{position:absolute;bottom:76px;right:0;width:max-width;max-width:320px;pointer-events:auto;transition:opacity .35s cubic-bezier(.16,1,.3,1),transform .35s cubic-bezier(.34,1.56,.64,1),visibility .35s;transform-origin:bottom right; width: max-content;}
.rtd-float-bubble--hidden{opacity:0;visibility:hidden;transform:scale(.85) translateY(8px);pointer-events:none!important}
.rtd-float-bubble--visible{opacity:1;visibility:visible;transform:scale(1) translateY(0)}
.rtd-float-bubble-inner{background:#111;border:1px solid #1e1e1e;border-radius:16px;padding:12px 14px;display:flex;align-items:flex-start;gap:10px;box-shadow:0 12px 40px rgba(0,0,0,.5),0 0 0 1px rgba(99,102,241,.08);position:relative}
.rtd-float-avatar{flex-shrink:0}
.rtd-float-avatar img{width:28px;height:28px;border-radius:50%;object-fit:cover;border:2px solid #222}
.rtd-float-text{flex:1;font-size:12.5px;line-height:1.55;color:#ccc;font-family:'Inter',sans-serif;padding-right:20px;min-width:180px;}
.rtd-float-close{position:absolute;top:6px;right:6px;width:20px;height:20px;border-radius:50%;border:none;background:rgba(255,255,255,.06);color:#666;display:flex;align-items:center;justify-content:center;font-size:13px;cursor:pointer;transition:all .2s;padding:0}
.rtd-float-close:hover{background:rgba(255,255,255,.15);color:#fff}
.rtd-float-tail{position:absolute;bottom:-6px;right:28px;width:12px;height:12px;background:#111;border-right:1px solid #1e1e1e;border-bottom:1px solid #1e1e1e;transform:rotate(45deg);z-index:-1}
@keyframes floatBubbleIn{from{opacity:0;transform:scale(.8) translateY(12px)}to{opacity:1;transform:scale(1) translateY(0)}}
/* --- New Easter Egg Animations --- */
.rtd-dance { animation: rtdDance 1s ease-in-out infinite; }
@keyframes rtdDance {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25% { transform: translateY(-10px) rotate(-15deg); }
    50% { transform: translateY(0) rotate(0deg); }
    75% { transform: translateY(-10px) rotate(15deg); }
}
.rtd-shake { animation: rtdShake 0.4s ease-in-out; }
@keyframes rtdShake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px) rotate(-5deg); }
    50% { transform: translateX(5px) rotate(5deg); }
    75% { transform: translateX(-5px) rotate(-5deg); }
}
.rtd-rps-options { display: flex; gap: 8px; margin-top: 8px; justify-content: center; }
.rtd-rps-opt { background: rgba(255,255,255,0.05); border: 1px solid #333; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 20px; cursor: pointer; transition: all 0.2s; }
.rtd-rps-opt:hover { background: #6366f1; border-color: #6366f1; transform: scale(1.1); }
.rtd-rps-opt:disabled { cursor: default; opacity: 0.5; transform: none; background: rgba(255,255,255,0.05); border-color: #333; }
.rtd-guess-input { width: 60px; background: #1a1a2e; border: 1px solid #6366f1; border-radius: 8px; padding: 6px 10px; color: #fff; font-size: 14px; text-align: center; outline: none; margin: 0 6px; }
.rtd-guess-btn, .rtd-scramble-btn { background: #6366f1; border: none; border-radius: 8px; padding: 6px 14px; color: #fff; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.rtd-guess-btn:hover, .rtd-scramble-btn:hover { background: #4f46e5; transform: scale(1.05); }
.rtd-mood-row { display: flex; gap: 6px; margin-top: 8px; flex-wrap: wrap; }
.rtd-mood-btn { background: rgba(255,255,255,0.04); border: 1px solid #2a2a2a; border-radius: 10px; padding: 6px 12px; font-size: 18px; cursor: pointer; transition: all 0.2s; }
.rtd-mood-btn:hover { background: rgba(99,102,241,0.15); border-color: #6366f1; transform: scale(1.1); }
.rtd-streak-bar { display: flex; align-items: center; gap: 6px; margin-top: 6px; padding: 8px 12px; background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(139,92,246,0.1)); border-radius: 10px; border: 1px solid rgba(99,102,241,0.2); }
.rtd-streak-fire { font-size: 16px; }
.rtd-streak-text { font-size: 11px; color: #a5b4fc; font-weight: 600; }
.rtd-flip { animation: rtdFlip 0.6s ease-in-out; }
@keyframes rtdFlip { 0% { transform: rotateY(0); } 50% { transform: rotateY(180deg); } 100% { transform: rotateY(360deg); } }
.rtd-tada { animation: rtdTada 0.8s ease-in-out; }
@keyframes rtdTada { 0%,100% { transform: scale(1) rotate(0); } 10%,20% { transform: scale(0.9) rotate(-3deg); } 30%,50%,70% { transform: scale(1.1) rotate(3deg); } 40%,60% { transform: scale(1.1) rotate(-3deg); } 80% { transform: scale(1) rotate(0); } }
</style>

<script>
(function(){
    const USER = @json($userName);
    const body = document.getElementById('rtd-bubble-body');
    const bubble = document.getElementById('rtd-mascot-bubble');
    const badge = document.getElementById('rtd-mascot-badge');
    const btn = document.getElementById('rtd-mascot-btn');
    const input = document.getElementById('rtd-chat-input');
    const mascotImg = document.querySelector('.rtd-mascot-img');
    const headerAvatar = document.querySelector('.rtd-header-avatar');
    const floatBubble = document.getElementById('rtd-float-bubble');
    const floatText = document.getElementById('rtd-float-text');
    let open = false;
    let floatTimer = null;
    let floatQueue = [];

    // ── Float bubble helpers (outside chat) ──
    function showFloat(text){
        if(open) return; // chat is open, don't show float
        floatQueue.push(text);
        if(floatQueue.length === 1) processFloatQueue();
    }
    function processFloatQueue(){
        if(floatQueue.length === 0) return;
        const text = floatQueue[0];
        floatText.innerHTML = text;
        floatBubble.classList.remove('rtd-float-bubble--hidden');
        floatBubble.classList.add('rtd-float-bubble--visible');
        badge.classList.remove('hidden');
        clearTimeout(floatTimer);
        floatTimer = setTimeout(()=>{
            hideFloat();
            floatQueue.shift();
            if(floatQueue.length > 0) setTimeout(processFloatQueue, 600);
        }, 6000);
    }
    function hideFloat(){
        floatBubble.classList.remove('rtd-float-bubble--visible');
        floatBubble.classList.add('rtd-float-bubble--hidden');
    }
    window.__mascotDismissFloat = function(){
        hideFloat();
        clearTimeout(floatTimer);
        floatQueue = [];
    };

    // ── Data ──
    const D = {
        motivation:[
            "Setiap baris kode adalah investasi untuk masa depanmu! 🚀",
            "Programmer hebat bukan yg tidak pernah error, tapi yg tidak pernah berhenti debugging! 💪",
            "Konsistensi mengalahkan intensitas. 30 menit/hari > 5 jam sekali seminggu! ⏱️",
            "Error bukan musuh, error adalah guru terbaik! 🧠",
            "Semua expert dulunya pemula. Terus belajar! 🌟",
            "Coding itu seperti puzzle — makin sering, makin jago! 🧩",
            `${USER}, kamu sudah hebat sampai di sini. Jangan menyerah! 🔥`,
            "Satu langkah kecil hari ini bisa jadi lompatan besar besok! 🎯",
        ],
        tip:[
            "💡 console.log() untuk debug, tapi hapus sebelum deploy!",
            "💡 Beri nama variabel deskriptif: `userData` > `x`",
            "💡 Pecah kode jadi fungsi kecil — mudah dibaca & di-debug!",
            "💡 Validasi input di frontend DAN backend!",
            "💡 DRY — Don't Repeat Yourself. Copy-paste 3x? Buat fungsi!",
            "💡 Commit sering ke Git dengan pesan jelas!",
            "💡 Baca dokumentasi resmi sebelum googling!",
            "💡 Pakai shortcut keyboard IDE, hemat banyak waktu!",
        ],
        guide:[
            "📌 Dashboard → lihat progress belajar keseluruhan.",
            "📌 Favorit (⭐) → bookmark materi penting.",
            "📌 Jadwal → atur waktu belajar rutin.",
            "📌 Setelah baca materi, kerjakan Kuis!",
            "📌 Riwayat → lihat materi yang sudah dipelajari.",
            "📌 Kumpulkan EXP → naik rank & buka Secret Lab! 🔓",
        ],
        funfact:[
            "🌍 JavaScript dibuat hanya dalam 10 hari oleh Brendan Eich (1995)!",
            "🐛 Bug pertama di dunia adalah ngengat nyata yang tersangkut di relay komputer Harvard Mark II (1947)!",
            "📧 Email pertama dikirim oleh Ray Tomlinson tahun 1971, dia sendiri lupa isinya apa!",
            "🎮 Game pertama yang dibuat adalah 'Tennis for Two' (1958)!",
            "🔢 Ada sekitar 700+ bahasa pemrograman di dunia!",
            "💻 90% kode di dunia ditulis dalam 10 bahasa pemrograman saja!",
            "🐍 Python dinamai dari acara TV 'Monty Python', bukan ular!",
            "☕ Java dinamai dari kopi Java, bukan pulau!",
        ],
        joke:[
            "Kenapa programmer suka gelap? Karena light menarik bugs! 🐛😂",
            "Knock knock. — Who's there? — !function() — !function() who? — Exactly. 😄",
            "Kenapa programmer tidak suka alam? Terlalu banyak bugs dan tidak ada Ctrl+Z! 🌿",
            "Ada 10 jenis orang: yang mengerti binary dan yang tidak. 🤓",
            "Programmer diminta beli 1 roti. Kalau ada telur, beli 12. Pulang bawa 12 roti. 🍞",
            "How do you comfort a JavaScript bug? You console it! 😂",
            "Kenapa frontend developer suka bau? Karena CSS-nya inline! 🤣",
        ],
        magic8ball: [
            "Tentu saja! 🎱", "Mungkin saja... 🤔", "Sepertinya tidak. 🙅‍♂️", 
            "Yakin 100%! 💯", "Jangan tanya aku, tanya error log-nya! 🐛", 
            "Coba jalankan kodenya lagi, siapa tau berubah pikiran. 🔄",
            "Sangat meragukan... 🤨", "Tanya lagi setelah minum kopi! ☕"
        ]
    };
    const QUIZ = [
        {q:"Apa kepanjangan HTML?",opts:["Hyper Text Markup Language","High Tech Modern Language","Hyper Transfer Markup Language","Home Tool Markup Language"],ans:0},
        {q:"Bahasa apa yang digunakan untuk styling website?",opts:["JavaScript","CSS","Python","Java"],ans:1},
        {q:"Apa simbol komentar single-line di JavaScript?",opts:["/* */","#","//","--"],ans:2},
        {q:"Framework PHP populer yang dibuat Taylor Otwell?",opts:["Django","Spring","Laravel","Rails"],ans:2},
        {q:"Apa fungsi `console.log()` di JavaScript?",opts:["Menampilkan alert","Mencetak output ke console","Membuat file log","Menghapus data"],ans:1},
        {q:"Bahasa apa yang disebut 'bahasa ular'?",opts:["Cobra","Anaconda","Python","Viper"],ans:2},
        {q:"Git digunakan untuk apa?",opts:["Desain grafis","Version control","Database","Hosting"],ans:1},
        {q:"Siapa pencipta Linux?",opts:["Bill Gates","Steve Jobs","Linus Torvalds","Mark Zuckerberg"],ans:2},
    ];
    const CHAT_RESPONSES = [
        {keywords:["halo","hai","hey","hi","hello"],reply:"Hai juga, {name}! 👋 Ada yang bisa kubantu hari ini?"},
        {keywords:["siapa kamu","siapa lo","kamu siapa","lo siapa","who are you"],reply:"Aku TurnBot! 🤖 Asisten virtual di TurningCode. Aku bisa kasih tips coding, motivasi, fun fact, mini quiz, bahkan main suit (ketik 'suit' atau 'batu gunting kertas')!"},
        {keywords:["terima kasih","makasih","thanks","thx","thank"],reply:"Sama-sama, {name}! 😊 Senang bisa membantu!"},
        {keywords:["bosan","boring","gabut","bosen"],reply:"Jangan bosan! Coba kerjakan Mini Quiz, baca Fun Fact, atau mari main Suit Gunting Batu Kertas! Ketik 'suit' ya 🎮"},
        {keywords:["susah","sulit","susyah","gak ngerti","bingung","ga paham"],reply:"Tenang {name}, semua orang pernah bingung! Coba baca ulang materinya pelan-pelan, atau tanya teman. Kamu pasti bisa! 💪"},
        {keywords:["semangat","mantap","keren","bagus","hebat"],reply:"Yes! Semangat terus {name}! Kamu luar biasa! 🔥🎉"},
        {keywords:["capek","tired","lelah","ngantuk","cape"],reply:"Istirahat dulu ya, {name}. Coding tanpa istirahat malah bikin error makin banyak! 😴☕"},
        {keywords:["help","bantuan","bantu","tolong"],reply:"Tentu! Aku bisa bantu dengan:\n• 💡 Tips & Motivasi\n• 🧠 Mini Quiz\n• ✊ Suit (Batu Gunting Kertas)\n• 🎯 Tebak Angka\n• 🔤 Word Scramble\n• 🧮 Kalkulator (ketik: hitung 5+5)\n• 🎱 Magic 8-Ball (awali: Apakah...)\n• 🪙 Coin Flip (ketik: /flip)\n• 😊 Mood Tracker (ketik: /mood)\n• 🕺 Easter Egg: /dance, /clear, /time, /streak\nKetik perintahnya atau klik chip!"},
        {keywords:["sedih","nangis","kecewa","bad mood","galau"],reply:"Jangan sedih, {name}! Ini ada pelukan virtual untukmu 🫂. Semuanya akan baik-baik saja!"},
        {keywords:["lapar","laper","makan"],reply:"Wah, kalau lapar jangan dipaksa ngoding! Perut keroncongan bikin otak nge-blank. Makan dulu sana! 🍔🍕"},
        {keywords:["cinta","love","sayang"],reply:"Aku hanyalah sekumpulan kode, tapi aku sangat menghargaimu, {name}! 🤖❤️"},
    ];

    function pick(arr){return arr[Math.floor(Math.random()*arr.length)]}
    function esc(s){const d=document.createElement('div');d.textContent=s;return d.innerHTML}

    function addMsg(text,type,html){
        const d=document.createElement('div');
        d.className='rtd-msg '+(type==='bot'?'rtd-msg-bot':'rtd-msg-user');
        if(type==='bot') d.innerHTML='<div class="rtd-msg-label">TurnBot</div>'+(html?text:esc(text).replace(/\n/g,'<br>'));
        else d.textContent=text;
        body.appendChild(d);
        body.scrollTop=body.scrollHeight;
    }

    function botReply(text,html,delay){
        const typing=document.createElement('div');
        typing.className='rtd-msg rtd-msg-bot';
        typing.innerHTML='<div class="rtd-msg-label">TurnBot</div><div class="rtd-typing-indicator"><span></span><span></span><span></span></div>';
        body.appendChild(typing);
        body.scrollTop=body.scrollHeight;
        setTimeout(()=>{
            typing.remove();
            addMsg(text,'bot',html);
            // Tambahkan animasi bounce ringan setiap kali membalas
            if (headerAvatar) {
                headerAvatar.style.transform = 'scale(1.1)';
                setTimeout(() => headerAvatar.style.transform = 'scale(1)', 200);
            }
        },delay||600+Math.random()*500);
    }

    function getGreeting(){
        const h=new Date().getHours();
        if(h>=5&&h<11) return `Selamat pagi, ${USER}! ☀️ Siap belajar hari ini?`;
        if(h>=11&&h<15) return `Selamat siang, ${USER}! 🌤️ Sudah makan belum? Jangan lupa istirahat!`;
        if(h>=15&&h<18) return `Sore, ${USER}! 🌅 Sore yang sempurna untuk ngoding!`;
        if(h>=18&&h<24) return `Malam, ${USER}! 🌙 Night owl coder ya?`;
        return `Masih terjaga, ${USER}? 🦉 Jangan lupa istirahat ya!`;
    }

    // --- GAME: MINI QUIZ ---
    function startQuiz(){
        const q=pick(QUIZ);
        let html=`<strong>${esc(q.q)}</strong><div class="rtd-quiz-options">`;
        q.opts.forEach((o,i)=>{html+=`<button class="rtd-quiz-opt" data-ans="${i}" data-correct="${q.ans}" onclick="window.__mascotQuizAnswer(this)">${esc(o)}</button>`});
        html+='</div>';
        botReply(html,true);
    }

    window.__mascotQuizAnswer=function(el){
        const correct=parseInt(el.dataset.correct);
        const chosen=parseInt(el.dataset.ans);
        const allBtns=el.parentElement.querySelectorAll('.rtd-quiz-opt');
        allBtns.forEach(b=>{b.disabled=true;if(parseInt(b.dataset.ans)===correct)b.classList.add('correct')});
        if(chosen!==correct) {
            el.classList.add('wrong');
            bubble.classList.add('rtd-shake');
            setTimeout(()=>bubble.classList.remove('rtd-shake'), 400);
        }
        setTimeout(()=>{
            if(chosen===correct) botReply(`Benar! 🎉 Kamu memang jago, ${USER}!`);
            else botReply(`Belum tepat! 😅 Jawaban yang benar sudah ditandai hijau. Coba lagi nanti ya!`);
        },800);
    };

    // --- GAME: ROCK PAPER SCISSORS ---
    function startRPS(){
        let html=`Ayo main Batu Gunting Kertas! Pilih senjatamu: <br><div class="rtd-rps-options">`;
        html+=`<button class="rtd-rps-opt" onclick="window.__mascotRPS('batu', this)">✊</button>`;
        html+=`<button class="rtd-rps-opt" onclick="window.__mascotRPS('kertas', this)">✋</button>`;
        html+=`<button class="rtd-rps-opt" onclick="window.__mascotRPS('gunting', this)">✌️</button>`;
        html+='</div>';
        botReply(html, true);
    }

    window.__mascotRPS=function(userChoice, btn){
        const allBtns = btn.parentElement.querySelectorAll('.rtd-rps-opt');
        allBtns.forEach(b => b.disabled = true);
        btn.style.background = '#6366f1';
        
        const choices = ['batu', 'kertas', 'gunting'];
        const emojis = {'batu': '✊', 'kertas': '✋', 'gunting': '✌️'};
        const botChoice = choices[Math.floor(Math.random() * 3)];
        
        let result = "";
        if (userChoice === botChoice) result = "Seri! Kita sehati 🤝";
        else if (
            (userChoice === 'batu' && botChoice === 'gunting') ||
            (userChoice === 'kertas' && botChoice === 'batu') ||
            (userChoice === 'gunting' && botChoice === 'kertas')
        ) {
            result = "Kamu Menang! 🎉 Hebat!";
        } else {
            result = "Aku Menang! 🤖 Wahaha!";
        }
        
        setTimeout(() => {
            botReply(`Aku pilih ${emojis[botChoice]} (${botChoice}).<br><br><strong>${result}</strong>`, true);
        }, 1000);
    }

    // --- GAME: NUMBER GUESSING ---
    let guessTarget = 0, guessAttempts = 0;
    function startGuessGame(){
        guessTarget = Math.floor(Math.random()*50)+1;
        guessAttempts = 0;
        let html = `🎯 Aku sudah pilih angka 1-50. Coba tebak!<br><div style="margin-top:8px;display:flex;align-items:center"><input type="number" class="rtd-guess-input" id="rtd-guess-val" min="1" max="50" placeholder="?"><button class="rtd-guess-btn" onclick="window.__mascotGuess()">Tebak!</button></div>`;
        botReply(html, true);
    }
    window.__mascotGuess = function(){
        const inp = document.getElementById('rtd-guess-val');
        if(!inp) return;
        const val = parseInt(inp.value);
        if(isNaN(val)||val<1||val>50){ botReply('Masukkan angka 1-50 ya! 🔢'); return; }
        guessAttempts++;
        if(val === guessTarget){
            mascotImg.classList.add('rtd-tada');
            setTimeout(()=>mascotImg.classList.remove('rtd-tada'),800);
            botReply(`🎉 BENAR! Angkanya ${guessTarget}! Kamu berhasil dalam ${guessAttempts} percobaan!`);
            addStreak();
        } else if(val < guessTarget){
            botReply(`⬆️ Lebih besar dari ${val}! (Percobaan ke-${guessAttempts})`);
        } else {
            botReply(`⬇️ Lebih kecil dari ${val}! (Percobaan ke-${guessAttempts})`);
        }
    };

    // --- GAME: WORD SCRAMBLE ---
    const WORDS = [
        {w:'javascript',h:'Bahasa web populer'},{w:'laravel',h:'Framework PHP'},{w:'python',h:'Bahasa ular 🐍'},
        {w:'database',h:'Tempat menyimpan data'},{w:'function',h:'Blok kode yang bisa dipanggil'},
        {w:'variable',h:'Wadah penyimpan nilai'},{w:'frontend',h:'Sisi tampilan website'},
        {w:'backend',h:'Sisi server website'},{w:'github',h:'Platform version control'},
        {w:'array',h:'Kumpulan data berurutan'},{w:'boolean',h:'True atau false'},
    ];
    let scrambleAnswer = '';
    function startScramble(){
        const item = pick(WORDS);
        scrambleAnswer = item.w;
        const shuffled = item.w.split('').sort(()=>Math.random()-0.5).join('').toUpperCase();
        let html = `🔤 Susun huruf ini menjadi kata yang benar!<br><br>`;
        html += `<div style="font-size:20px;font-weight:800;letter-spacing:6px;color:#a5b4fc;text-align:center;margin:8px 0">${shuffled}</div>`;
        html += `<div style="font-size:11px;color:#666;margin:4px 0">💡 Hint: ${item.h}</div>`;
        html += `<div style="margin-top:8px;font-size:11px;color:#888">Ketik jawabanmu di chat!</div>`;
        botReply(html, true);
    }

    // --- MOOD TRACKER ---
    function showMoodPicker(){
        let html = `Bagaimana perasaanmu sekarang, ${USER}?<div class="rtd-mood-row">`;
        const moods = [{e:'😊',l:'Senang'},{e:'😐',l:'Biasa'},{e:'😤',l:'Kesal'},{e:'😢',l:'Sedih'},{e:'🤯',l:'Pusing'},{e:'😴',l:'Ngantuk'},{e:'🔥',l:'Semangat'}];
        moods.forEach(m => { html += `<button class="rtd-mood-btn" onclick="window.__mascotMood('${m.l}','${m.e}')" title="${m.l}">${m.e}</button>`; });
        html += '</div>';
        botReply(html, true);
    }
    window.__mascotMood = function(label, emoji){
        const responses = {
            'Senang': `Senang dengarnya ${emoji}! Mood bagus = produktivitas naik! Keep going, ${USER}! 🚀`,
            'Biasa': `Kadang hari biasa aja itu juga oke ${emoji}. Mau aku hibur? Ketik 'joke' atau 'suit'! 🎮`,
            'Kesal': `Kalau kesal, tarik nafas... lalu ketik kodenya pelan-pelan ${emoji}. Atau mau main suit untuk tenangkan pikiran? ✊`,
            'Sedih': `Jangan sedih, ${USER} ${emoji}. Setiap bug yang kamu fix membuat kamu lebih kuat! 🫂`,
            'Pusing': `Pusing ${emoji}? Istirahat 15 menit, minum air, lalu balik lagi! Otak perlu reset kadang-kadang 💧`,
            'Ngantuk': `Ngantuk ${emoji}? Power nap 20 menit bisa bantu! Atau mau ngobrol dulu biar melek? ☕`,
            'Semangat': `YEAAH! ${emoji} Semangat membara! Ayo tuntaskan materi hari ini! ${USER} pasti bisa! 💪🔥`,
        };
        botReply(responses[label] || `${emoji} Noted! Aku di sini kapan pun kamu butuh, ${USER}!`);
    };

    // --- COIN FLIP ---
    function coinFlip(){
        mascotImg.classList.add('rtd-flip');
        setTimeout(()=>mascotImg.classList.remove('rtd-flip'),600);
        const result = Math.random() < 0.5 ? '🪙 HEADS (Kepala)' : '🪙 TAILS (Ekor)';
        return `Melempar koin...<br><br><strong>${result}</strong>`;
    }

    // --- STREAK SYSTEM ---
    function getStreak(){ return parseInt(localStorage.getItem('rtd_streak')||'0'); }
    function addStreak(){
        const s = getStreak()+1;
        localStorage.setItem('rtd_streak', s);
        const html = `<div class="rtd-streak-bar"><span class="rtd-streak-fire">🔥</span><span class="rtd-streak-text">Streak: ${s} game berturut-turut!</span></div>`;
        setTimeout(()=>botReply(html, true), 1200);
    }

    function matchChat(text){
        const lower=text.toLowerCase().trim();
        
        // Easter Eggs / Commands
        if(lower === '/clear'){ body.innerHTML = ''; botReply('Chat telah dibersihkan! 🧹'); return null; }
        if(lower === '/dance'){
            mascotImg?.classList.add('rtd-dance');
            setTimeout(()=>mascotImg?.classList.remove('rtd-dance'),5000);
            return "Wooohooo! 🕺💃 (Lihat aku menari!)";
        }
        if(lower === '/flip'){ return coinFlip(); }
        if(lower === '/streak'){
            const s = getStreak();
            return s > 0 ? `🔥 Streak kamu: ${s} game! Terus bermain untuk menambah streak!` : `Kamu belum punya streak. Ayo main game dulu! 🎮`;
        }
        if(lower === '/mood'){ showMoodPicker(); return null; }
        if(lower === '/time'){
            const now = new Date();
            return `🕐 Sekarang jam ${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')} — ${now.toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'})}`;
        }
        
        // Word Scramble answer check
        if(scrambleAnswer && lower === scrambleAnswer){
            const ans = scrambleAnswer;
            scrambleAnswer = '';
            mascotImg?.classList.add('rtd-tada');
            setTimeout(()=>mascotImg?.classList.remove('rtd-tada'),800);
            addStreak();
            return `✅ BENAR! Jawabannya memang "${ans.toUpperCase()}"! Kamu pintar, ${USER}! 🧠🎉`;
        } else if(scrambleAnswer && lower.length === scrambleAnswer.length){
            return `❌ Bukan "${lower}". Coba lagi! Hint-nya ada di atas 👆`;
        }
        
        // Math Calculator
        const mathMatch = lower.match(/^(hitung|berapa|kalkulator)\s+([\d\s\+\-\*\/\(\)\.]+)$/i);
        if(mathMatch){
            try{
                const expr = mathMatch[2].replace(/[^\d\+\-\*\/\(\)\.]/g,'');
                if(expr){ const r = new Function('return '+expr)(); return `Biar aku hitung... 🧮<br>Hasil: <strong>${expr} = ${r}</strong>`; }
            }catch(e){ return "Hmm, format salah. Coba: hitung 5+5 🤔"; }
        }

        // Magic 8-Ball
        if(lower.startsWith('apakah ')||lower.startsWith('apa ')){ return pick(D.magic8ball); }

        // Games triggers
        if(lower.includes('suit')||lower.includes('batu gunting kertas')){ startRPS(); return null; }
        if(lower.includes('quiz')||lower.includes('kuis')){ startQuiz(); return null; }
        if(lower.includes('tebak')||lower.includes('guess')){ startGuessGame(); return null; }
        if(lower.includes('scramble')||lower.includes('acak kata')){ startScramble(); return null; }
        if(lower.includes('mood')||lower.includes('perasaan')){ showMoodPicker(); return null; }
        if(lower.includes('coin')||lower.includes('koin')||lower.includes('flip')){ return coinFlip(); }
        
        // Keyword responses
        for(const r of CHAT_RESPONSES){
            if(r.keywords.some(k=>lower.includes(k))) return r.reply.replace(/\{name\}/g,USER);
        }
        
        // Categories
        if(lower.includes('motivasi')){return pick(D.motivation)}
        if(lower.includes('tip')||lower.includes('saran')){return pick(D.tip)}
        if(lower.includes('fact')||lower.includes('fakta')){return pick(D.funfact)}
        if(lower.includes('joke')||lower.includes('lucu')||lower.includes('humor')){return pick(D.joke)}
        if(lower.includes('panduan')||lower.includes('guide')||lower.includes('cara')){return pick(D.guide)}
        
        const fallbacks=[
            `Hmm, coba ketik "help" untuk lihat semua fitur! 😊`,
            `Aku belum paham, ${USER}. Coba "/dance", "suit", "tebak", atau "scramble"! 🤖`,
            `Ketik "apakah aku jago coding?" untuk Magic 8-Ball 🎱 atau "/mood" untuk mood tracker!`,
        ];
        return pick(fallbacks);
    }

    window.__mascotAsk=function(cat){
        if(cat==='quiz'){addMsg('Mini Quiz!','user');startQuiz();return}
        if(cat==='tebak'){addMsg('Tebak Angka!','user');startGuessGame();return}
        if(cat==='scramble'){addMsg('Word Scramble!','user');startScramble();return}
        const labels={motivation:'Motivasi',tip:'Tips Coding',guide:'Panduan',funfact:'Fun Fact',joke:'Joke'};
        addMsg(labels[cat]||cat,'user');
        botReply(pick(D[cat]||D.tip));
    };

    window.__mascotSendInput=function(){
        const val=input.value.trim();
        if(!val)return;
        addMsg(val,'user');
        input.value='';
        const reply=matchChat(val);
        if(reply)botReply(reply, reply.includes('<br>') || reply.includes('<strong>'));
    };

    input.addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();window.__mascotSendInput()}});

    // ── Toggle ──
    window.__mascotToggle=function(){open?window.__mascotClose():window.__mascotOpen()};
    window.__mascotOpen=function(){
        open=true;
        // Hide float bubble when chat opens
        hideFloat();
        clearTimeout(floatTimer);
        floatQueue = [];
        bubble.classList.remove('rtd-mascot-bubble--hidden');
        bubble.classList.add('rtd-mascot-bubble--visible');
        badge.classList.add('hidden');
        btn.style.animation='none';
        input.focus();
    };
    window.__mascotClose=function(){
        open=false;
        bubble.classList.remove('rtd-mascot-bubble--visible');
        bubble.classList.add('rtd-mascot-bubble--hidden');
        btn.style.animation='';
    };

    // ── Init greeting ──
    addMsg(getGreeting(),'bot');
    setTimeout(()=>addMsg('Klik chip di atas atau ketik langsung. Kamu juga bisa ketik "help" atau main "suit"! 🎮💬','bot'),1200);

    // ── Show greeting as float bubble (outside chat) ──
    const gk='rtd_greet2_'+new Date().toDateString();
    if(!sessionStorage.getItem(gk)){
        sessionStorage.setItem(gk,'1');
        setTimeout(()=>{
            if(!open) showFloat(getGreeting());
        },2500);
    } else {
        // Returning user — show a shorter float
        setTimeout(()=>{
            if(!open) showFloat(`Hai lagi, ${USER}! 👋 Ada yang bisa kubantu?`);
        },5000);
    }

    // ── Context-aware: react to page changes ──
    let lastPage='';
    setInterval(()=>{
        const params=new URLSearchParams(window.location.search);
        const page=params.get('page')||'dashboard';
        if(page===lastPage)return;
        lastPage=page;
        const pageMsg={
            'dashboard':`Kamu di Dashboard! Lihat progress belajarmu 📊`,
            'schedule':`Halaman Jadwal! ⏰ Atur jadwal belajar rutin ya!`,
            'favorites':`Koleksi Favoritmu! ⭐ Bookmark ada di sini.`,
            'history':`Riwayat Belajar! 📜 Kamu sudah belajar banyak!`,
            'materi':`Yuk pilih materi yang mau dipelajari! 📚`,
            'submateri':`Sub-materi menunggu! Baca pelan-pelan ya 🧐`,
            'detail':`Lagi baca materi? Fokus ya, ${USER}! 🎧`,
            'quiz':`Kuis time! 🧠 Baca soalnya baik-baik!`,
            'account':`Profil kamu! ✨ Pastikan data up-to-date.`,
            'secret-lab':`Wow, Secret Lab! 🔬 Area elite coder!`,
        };
        if(pageMsg[page]){
            if(open){
                // Inside chat
                botReply(pageMsg[page]);
            } else {
                // Outside chat — show float bubble
                showFloat(pageMsg[page]);
            }
        }
    },2000);

    // ── Auto-show badge ──
    setTimeout(()=>{if(!open)badge.classList.remove('hidden')},6000);

    // ── Periodic tips (outside chat) ──
    setInterval(()=>{
        if(!open){
            const tipTexts = [
                `💡 Tip: ${pick(D.tip)}`,
                `🌍 ${pick(D.funfact)}`,
                `🔥 ${pick(D.motivation)}`,
            ];
            showFloat(pick(tipTexts));
        }
    }, 120000); // Every 2 minutes
})();
</script>
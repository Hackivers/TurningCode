(function(){
    const USER = document.getElementById('rtd-mascot-wrapper').dataset.user;
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
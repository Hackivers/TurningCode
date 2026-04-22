{{-- QUIZ PAGE — Neo Bento + Per-Page Questions --}}
<div class="neo-dashboard rtd-dashboard">
<div class="qz-container">

    {{-- Breadcrumb --}}
    <div class="qz-breadcrumb">
        <a href="?page=materi&main_id={{ $subMateri->materi->mainMateri->id ?? '' }}" class="link-spa">{{ $subMateri->materi->mainMateri->title ?? '-' }}</a>
        <span>/</span>
        <a href="?page=submateri&materi_id={{ $subMateri->materi_id }}" class="link-spa">{{ $subMateri->materi->title ?? '-' }}</a>
        <span>/</span>
        <a href="?page=detail&submateri_id={{ $subMateri->id }}" class="link-spa">{{ $subMateri->title }}</a>
        <span>/</span>
        <span class="qz-bc-current">Kuis</span>
    </div>

    @if(isset($questions) && $questions->count() > 0)
        @php $totalQ = $questions->count(); @endphp

        {{-- Progress Bar --}}
        <div class="qz-progress-wrap">
            <div class="qz-progress-bar"><div class="qz-progress-fill" id="qz-progress-fill"></div></div>
            <span class="qz-progress-text" id="qz-progress-text">1 / {{ $totalQ }}</span>
        </div>

        {{-- Already Passed Banner --}}
        @if(isset($quizAttempt) && $quizAttempt && $quizAttempt->passed)
            <div class="qz-passed-banner" id="qz-passed-banner">
                <i class='bx bx-check-circle'></i>
                <div><strong>Kuis Sudah Lulus!</strong><br><span>Skor terbaik: {{ $quizAttempt->score }}%</span></div>
                <button class="qz-btn-retake" id="qz-btn-retake">Ulang Kuis</button>
            </div>
        @endif

        {{-- Question Cards (one per page) --}}
        <form id="qz-form" class="{{ isset($quizAttempt) && $quizAttempt && $quizAttempt->passed ? 'qz-hidden' : '' }}">
            @foreach($questions as $i => $q)
                <div class="qz-card {{ $i === 0 ? 'qz-active' : '' }}" data-idx="{{ $i }}" data-qid="{{ $q->id }}">
                    <div class="qz-card-head">
                        <span class="qz-card-num">Soal {{ $i + 1 }}</span>
                        <span class="qz-card-total">dari {{ $totalQ }}</span>
                    </div>
                    <h3 class="qz-question">{{ $q->question }}</h3>

                    @if($q->code_snippet)
                        <div class="qz-code">
                            @if($q->code_language)<span class="qz-code-lang">{{ $q->code_language }}</span>@endif
                            <pre><code>{{ $q->code_snippet }}</code></pre>
                        </div>
                    @endif

                    <div class="qz-options">
                        @foreach($q->options as $oi => $opt)
                            <label class="qz-opt" data-oi="{{ $oi }}">
                                <input type="radio" name="q_{{ $q->id }}" value="{{ $oi }}">
                                <span class="qz-opt-letter">{{ chr(65 + $oi) }}</span>
                                <span class="qz-opt-text">{{ $opt }}</span>
                                <i class='bx bx-check qz-ico-ok'></i>
                                <i class='bx bx-x qz-ico-no'></i>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Nav Buttons --}}
            <div class="qz-nav-row">
                <button type="button" class="qz-btn qz-btn-prev" id="qz-prev" style="display:none;">
                    <i class='bx bx-left-arrow-alt'></i> Sebelumnya
                </button>
                <div style="flex:1;"></div>
                <button type="button" class="qz-btn qz-btn-next" id="qz-next">
                    Selanjutnya <i class='bx bx-right-arrow-alt'></i>
                </button>
                <button type="submit" class="qz-btn qz-btn-submit" id="qz-submit" style="display:none;">
                    <i class='bx bx-send'></i> Kirim Jawaban
                </button>
            </div>
        </form>

        {{-- Result Screen --}}
        <div class="qz-result-screen" id="qz-result-screen" style="display:none;">
            <div class="qz-result-circle" id="qz-result-circle">
                <svg viewBox="0 0 120 120"><circle class="qz-rc-bg" cx="60" cy="60" r="52"/><circle class="qz-rc-fill" id="qz-rc-fill" cx="60" cy="60" r="52"/></svg>
                <span class="qz-rc-pct" id="qz-rc-pct">0%</span>
            </div>
            <h2 class="qz-result-title" id="qz-result-title"></h2>
            <p class="qz-result-sub" id="qz-result-sub"></p>
            <div class="qz-result-exp" id="qz-result-exp" style="display:none;"><i class='bx bx-bolt-circle'></i> <span id="qz-exp-val"></span></div>
            <div class="qz-result-actions">
                <button class="qz-btn qz-btn-retry" id="qz-retry" style="display:none;" onclick="loadPage('quiz',{submateri_id:{{ $subMateri->id }}})">
                    <i class='bx bx-refresh'></i> Coba Lagi
                </button>
                @if (!empty($next))
                    <a href="?page=detail&submateri_id={{ $next->id }}" class="link-spa qz-btn qz-btn-next-materi">
                        Materi Selanjutnya <i class='bx bx-right-arrow-alt'></i>
                    </a>
                @else
                    <a href="?page=submateri&materi_id={{ $subMateri->materi_id }}" class="link-spa qz-btn qz-btn-next-materi">
                        Selesai <i class='bx bx-check'></i>
                    </a>
                @endif
            </div>
        </div>

    @else
        <div style="text-align:center;padding:80px 20px;">
            <i class='bx bx-x-circle' style="font-size:48px;color:#ccc;display:block;margin-bottom:12px;"></i>
            <p style="color:#888;font-size:15px;">Belum ada soal kuis untuk materi ini.</p>
        </div>
    @endif

</div>
</div>

<script>
(function(){
    const form = document.getElementById('qz-form');
    if (!form) return;
    const cards = Array.from(form.querySelectorAll('.qz-card'));
    const total = cards.length;
    const btnPrev = document.getElementById('qz-prev');
    const btnNext = document.getElementById('qz-next');
    const btnSubmit = document.getElementById('qz-submit');
    const progFill = document.getElementById('qz-progress-fill');
    const progText = document.getElementById('qz-progress-text');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    let cur = 0;

    function show(idx) {
        cards.forEach((c,i) => c.classList.toggle('qz-active', i === idx));
        btnPrev.style.display = idx === 0 ? 'none' : '';
        btnNext.style.display = idx === total - 1 ? 'none' : '';
        btnSubmit.style.display = idx === total - 1 ? '' : 'none';
        progFill.style.width = ((idx + 1) / total * 100) + '%';
        progText.textContent = (idx + 1) + ' / ' + total;
        cur = idx;
    }

    btnPrev.onclick = () => { if (cur > 0) show(cur - 1); };
    btnNext.onclick = () => { if (cur < total - 1) show(cur + 1); };

    // Retake
    const retakeBtn = document.getElementById('qz-btn-retake');
    if (retakeBtn) {
        retakeBtn.onclick = () => {
            document.getElementById('qz-passed-banner').style.display = 'none';
            form.classList.remove('qz-hidden');
            form.querySelectorAll('input[type=radio]').forEach(r => r.checked = false);
            form.querySelectorAll('.qz-opt').forEach(o => o.className = 'qz-opt');
            show(0);
        };
    }

    // Submit
    form.onsubmit = async (e) => {
        e.preventDefault();
        const answers = {};
        let unanswered = 0;
        cards.forEach(c => {
            const sel = c.querySelector('input:checked');
            if (sel) answers[c.dataset.qid] = parseInt(sel.value);
            else unanswered++;
        });
        if (unanswered > 0 && !confirm('Masih ada ' + unanswered + ' soal belum dijawab. Kirim?')) return;

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengirim...';

        try {
            const res = await fetch('{{ route("user.quiz.submit") }}', {
                method: 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' },
                body: JSON.stringify({ sub_materi_id: {{ $subMateri->id }}, answers }),
                credentials: 'same-origin',
            });
            const data = await res.json();
            if (data.success) {
                // Highlight answers
                Object.entries(data.results).forEach(([qId, r]) => {
                    const card = form.querySelector('[data-qid="'+qId+'"]');
                    if (!card) return;
                    card.querySelectorAll('.qz-opt').forEach(o => {
                        const idx = parseInt(o.dataset.oi);
                        o.classList.add('qz-locked');
                        if (idx === r.correct_option) o.classList.add('qz-correct');
                        if (idx === r.selected && !r.is_correct) o.classList.add('qz-wrong');
                    });
                });

                // Show result
                form.style.display = 'none';
                document.querySelector('.qz-progress-wrap').style.display = 'none';
                const screen = document.getElementById('qz-result-screen');
                screen.style.display = '';

                const pct = data.score;
                const circ = document.getElementById('qz-rc-fill');
                const circumference = 2 * Math.PI * 52;
                circ.style.strokeDasharray = circumference;
                circ.style.strokeDashoffset = circumference;
                setTimeout(() => { circ.style.strokeDashoffset = circumference - (pct / 100) * circumference; }, 100);

                // Animate percentage number
                let counter = 0;
                const pctEl = document.getElementById('qz-rc-pct');
                const interval = setInterval(() => {
                    counter += 1;
                    if (counter >= pct) { counter = pct; clearInterval(interval); }
                    pctEl.textContent = counter + '%';
                }, 20);

                document.getElementById('qz-result-title').textContent = data.passed ? '🎉 Selamat, Kuis Lulus!' : 'Belum Lulus';
                document.getElementById('qz-result-sub').textContent = data.correct + ' dari ' + data.total + ' soal benar';
                circ.style.stroke = data.passed ? '#10b981' : '#ef4444';

                if (data.exp_awarded) {
                    const expDiv = document.getElementById('qz-result-exp');
                    expDiv.style.display = '';
                    document.getElementById('qz-exp-val').textContent = '+' + data.exp_gained + ' EXP';
                }
                if (!data.passed) document.getElementById('qz-retry').style.display = '';

                screen.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } catch {
            alert('Gagal mengirim jawaban.');
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bx bx-send"></i> Kirim Jawaban';
        }
    };
})();
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
:root { --neo-bg:#ececec; --neo-card:#e5e5e5; --neo-r:32px; --neo-t:#121212; }
body { background: var(--neo-bg) !important; }
.neo-dashboard { background:var(--neo-bg); font-family:'Inter',sans-serif; min-height:100vh; width:100%; }
.qz-container { max-width:720px; margin:0 auto; padding:32px 24px 80px; }

/* Breadcrumb */
.qz-breadcrumb { display:flex; align-items:center; gap:8px; font-size:13px; color:#888; margin-bottom:32px; flex-wrap:wrap; }
.qz-breadcrumb a { color:#888; text-decoration:none; font-weight:500; transition:color 0.2s; }
.qz-breadcrumb a:hover { color:#121212; }
.qz-breadcrumb span { color:#ccc; }
.qz-bc-current { color:#121212; font-weight:600; }

/* Progress */
.qz-progress-wrap { display:flex; align-items:center; gap:16px; margin-bottom:32px; }
.qz-progress-bar { flex:1; height:6px; background:rgba(0,0,0,0.08); border-radius:100px; overflow:hidden; }
.qz-progress-fill { height:100%; background:#121212; border-radius:100px; transition:width 0.4s cubic-bezier(0.16,1,0.3,1); width:0; }
.qz-progress-text { font-size:13px; font-weight:700; color:#121212; white-space:nowrap; }

/* Passed Banner */
.qz-passed-banner { display:flex; align-items:center; gap:12px; padding:16px 20px; background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.2); border-radius:20px; margin-bottom:24px; }
.qz-passed-banner > i { font-size:28px; color:#10b981; }
.qz-passed-banner strong { color:#121212; font-size:15px; }
.qz-passed-banner span { color:#666; font-size:13px; }
.qz-btn-retake { margin-left:auto; padding:8px 16px; border-radius:100px; border:1px solid rgba(0,0,0,0.1); background:transparent; color:#121212; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; }
.qz-btn-retake:hover { background:#121212; color:#fff; }

/* Card */
.qz-card { display:none; animation:qzSlideIn 0.3s ease; }
.qz-card.qz-active { display:block; }
.qz-card-head { display:flex; justify-content:space-between; margin-bottom:20px; }
.qz-card-num { font-size:13px; font-weight:800; color:#121212; text-transform:uppercase; letter-spacing:1px; }
.qz-card-total { font-size:13px; color:#888; font-weight:500; }
.qz-question { font-size:20px; font-weight:800; color:#121212; line-height:1.4; margin:0 0 24px; letter-spacing:-0.02em; }

/* Code */
.qz-code { margin-bottom:24px; border-radius:16px; overflow:hidden; background:#1a1a2e; border:1px solid rgba(0,0,0,0.06); position:relative; }
.qz-code-lang { position:absolute; top:10px; right:14px; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#6366f1; background:rgba(99,102,241,0.1); padding:3px 10px; border-radius:8px; }
.qz-code pre { padding:20px; margin:0; overflow-x:auto; }
.qz-code code { font-family:'Fira Code','Consolas',monospace; font-size:13px; color:#a6e3a1; line-height:1.7; white-space:pre; }

/* Options */
.qz-options { display:flex; flex-direction:column; gap:10px; }
.qz-opt { display:flex; align-items:center; gap:12px; padding:16px 18px; border-radius:16px; background:var(--neo-card); border:2px solid transparent; cursor:pointer; transition:all 0.2s; }
.qz-opt input { display:none; }
.qz-opt-letter { width:32px; height:32px; border-radius:10px; background:rgba(0,0,0,0.06); color:#888; font-size:13px; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all 0.2s; }
.qz-opt-text { flex:1; font-size:15px; color:#444; line-height:1.4; }
.qz-ico-ok, .qz-ico-no { display:none; font-size:20px; flex-shrink:0; }

.qz-opt:hover { border-color:rgba(0,0,0,0.1); }
.qz-opt:has(input:checked) { border-color:#121212; background:#fff; }
.qz-opt:has(input:checked) .qz-opt-letter { background:#121212; color:#fff; }
.qz-opt:has(input:checked) .qz-opt-text { color:#121212; font-weight:600; }

/* After submit */
.qz-opt.qz-locked { pointer-events:none; }
.qz-opt.qz-correct { border-color:#10b981 !important; background:rgba(16,185,129,0.06) !important; }
.qz-opt.qz-correct .qz-opt-letter { background:#10b981 !important; color:#fff !important; }
.qz-opt.qz-correct .qz-opt-text { color:#065f46 !important; }
.qz-opt.qz-correct .qz-ico-ok { display:block; color:#10b981; }
.qz-opt.qz-wrong { border-color:#ef4444 !important; background:rgba(239,68,68,0.06) !important; }
.qz-opt.qz-wrong .qz-opt-letter { background:#ef4444 !important; color:#fff !important; }
.qz-opt.qz-wrong .qz-opt-text { color:#991b1b !important; }
.qz-opt.qz-wrong .qz-ico-no { display:block; color:#ef4444; }

/* Nav Buttons */
.qz-nav-row { display:flex; align-items:center; gap:12px; margin-top:32px; }
.qz-btn { display:inline-flex; align-items:center; gap:8px; padding:14px 24px; border-radius:100px; font-size:14px; font-weight:700; cursor:pointer; transition:all 0.2s; border:none; text-decoration:none; }
.qz-btn i { font-size:18px; }
.qz-btn-prev { background:transparent; color:#666; border:1px solid rgba(0,0,0,0.12); }
.qz-btn-prev:hover { background:#121212; color:#fff; border-color:#121212; }
.qz-btn-next { background:#121212; color:#fff; }
.qz-btn-next:hover { opacity:0.85; }
.qz-btn-submit { background:#121212; color:#fff; }
.qz-btn-submit:hover { opacity:0.85; }
.qz-btn-submit:disabled { opacity:0.5; cursor:not-allowed; }

/* Result Screen */
.qz-result-screen { text-align:center; padding:40px 20px; animation:qzSlideIn 0.5s ease; }
.qz-result-circle { position:relative; width:160px; height:160px; margin:0 auto 24px; }
.qz-result-circle svg { width:100%; height:100%; transform:rotate(-90deg); }
.qz-rc-bg { fill:none; stroke:rgba(0,0,0,0.06); stroke-width:8; }
.qz-rc-fill { fill:none; stroke:#10b981; stroke-width:8; stroke-linecap:round; transition:stroke-dashoffset 1.5s cubic-bezier(0.16,1,0.3,1); }
.qz-rc-pct { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:36px; font-weight:900; color:#121212; letter-spacing:-0.02em; }
.qz-result-title { font-size:24px; font-weight:800; color:#121212; margin:0 0 8px; }
.qz-result-sub { font-size:15px; color:#666; margin:0 0 20px; }
.qz-result-exp { display:inline-flex; align-items:center; gap:6px; padding:8px 18px; border-radius:100px; background:rgba(99,102,241,0.08); color:#6366f1; font-size:14px; font-weight:700; margin-bottom:24px; }
.qz-result-exp i { font-size:18px; color:#f59e0b; }
.qz-result-actions { display:flex; justify-content:center; gap:12px; flex-wrap:wrap; }
.qz-btn-retry { background:transparent; color:#121212; border:1px solid rgba(0,0,0,0.12); }
.qz-btn-retry:hover { background:#121212; color:#fff; }
.qz-btn-next-materi { background:#121212; color:#fff; }
.qz-btn-next-materi:hover { opacity:0.85; }

.qz-hidden { display:none !important; }

@keyframes qzSlideIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }

@media (max-width:768px) {
    .qz-container { padding:24px 16px 60px; }
    .qz-question { font-size:18px; }
    .qz-result-actions { flex-direction:column; }
    .qz-btn { width:100%; justify-content:center; }
}
</style>
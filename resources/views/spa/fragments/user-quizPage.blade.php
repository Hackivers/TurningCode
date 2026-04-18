<div class="container conatiner-quiz-materi">
    <main class="main-quiz-materi">
        <div class="wrapper-quiz-materi">

            {{-- Breadcrumb --}}
            <div class="breadcrumb">
                <h6>
                    <a href="?page=dashboard" class="link-spa breadcrumb-link">
                        {{ $subMateri->materi->mainMateri->title ?? '-' }}
                    </a>
                    <i class='bx bx-chevron-right'></i>
                    <a href="?page=materi&main_id={{ $subMateri->materi->mainMateri->id ?? '' }}"
                        class="link-spa breadcrumb-link">
                        {{ $subMateri->materi->title ?? '-' }}
                    </a>
                    <i class='bx bx-chevron-right'></i>
                    <a href="?page=detail&submateri_id={{ $subMateri->id }}" class="link-spa breadcrumb-link">
                        {{ $subMateri->title }}
                    </a>
                    <i class='bx bx-chevron-right'></i>
                    <span>Kuis</span>
                </h6>
            </div>

            {{-- Back button --}}
            <div class="back-button">
                <button class="btn-back">
                    <i class='bx bx-arrow-back'></i> Kembali ke Materi
                </button>
            </div>

            {{-- Quiz Content --}}
            <main class="box-quiz-materi">
                <div>
                    {{-- Title --}}
                    <div class="box-tittle-materi">
                        <h2>Kuis: {{ $subMateri->title }}</h2>
                    </div>

                    @if(isset($questions) && $questions->count() > 0)
                        <div class="quiz-section" id="quiz-section">
                            <div class="quiz-header">
                                <div class="quiz-header-icon">
                                    <i class='bx bx-brain'></i>
                                </div>
                                <div>
                                    <h3>Uji Pemahamanmu</h3>
                                    <p>{{ $questions->count() }} soal · Skor minimal 80% untuk lulus</p>
                                </div>
                            </div>

                            @if(isset($quizAttempt) && $quizAttempt && $quizAttempt->passed)
                                <div class="quiz-passed-badge" id="quiz-passed-badge">
                                    <i class='bx bx-check-circle'></i>
                                    <div>
                                        <h4>Kuis Sudah Lulus! ✓</h4>
                                        <p>Skor terbaik: {{ $quizAttempt->score }}% · EXP sudah diterima</p>
                                    </div>
                                    <button class="btn-retake" id="btn-retake">
                                        <i class='bx bx-revision'></i> Ulang
                                    </button>
                                </div>
                            @endif

                            <form id="quiz-form"
                                class="quiz-form {{ isset($quizAttempt) && $quizAttempt && $quizAttempt->passed ? 'hidden-quiz' : '' }}">
                                @foreach($questions as $i => $q)
                                    <div class="quiz-card" data-question-id="{{ $q->id }}">
                                        <div class="quiz-card-number">{{ $i + 1 }}</div>
                                        <h4 class="quiz-card-question">{{ $q->question }}</h4>

                                        @if($q->code_snippet)
                                            <div class="quiz-code-block">
                                                @if($q->code_language)
                                                    <div class="quiz-code-header">
                                                        <span class="quiz-code-lang">{{ $q->code_language }}</span>
                                                    </div>
                                                @endif
                                                <pre class="quiz-code-pre"><code>{{ $q->code_snippet }}</code></pre>
                                            </div>
                                        @endif

                                        <div class="quiz-options">
                                            @foreach($q->options as $optIdx => $option)
                                                <label class="quiz-option" data-option-idx="{{ $optIdx }}">
                                                    <input type="radio" name="q_{{ $q->id }}" value="{{ $optIdx }}">
                                                    <span class="quiz-option-indicator">{{ chr(65 + $optIdx) }}</span>
                                                    <span class="quiz-option-text">{{ $option }}</span>
                                                    <i class='bx bx-check quiz-icon-correct'></i>
                                                    <i class='bx bx-x quiz-icon-wrong'></i>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <div id="quiz-result" class="quiz-result" style="display:none;"></div>

                                <button type="submit" class="quiz-btn-submit" id="quiz-btn-submit">
                                    <i class='bx bx-send'></i> Kirim Jawaban
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="sec-empty">
                            <i class='bx bx-x-circle'></i>
                            <p>Belum ada soal kuis untuk materi ini.</p>
                        </div>
                    @endif

                    {{-- Navigation prev/next --}}
                    <div class="box-materi-navigation">
                        <hr>
                        <div id="quiz-nav-container" style="gap: 12px;">
                            @if (!empty($next))
                                <a href="?page=detail&submateri_id={{ $next->id }}" class="btn-next link-spa">
                                    Materi Selanjutnya: {{ $next->title }}
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
    document.addEventListener("click", function (e) {
        if (e.target.closest(".btn-back")) {
            e.preventDefault();
            loadPage("detail", { submateri_id: "{{ $subMateri->id }}" }); // Back to reading
        }
    });
</script>

{{-- Quiz Script --}}
<script>
    (function () {
        const quizForm = document.getElementById('quiz-form');
        const btnSubmit = document.getElementById('quiz-btn-submit');
        const resultBox = document.getElementById('quiz-result');
        const passedBadge = document.getElementById('quiz-passed-badge');
        const btnRetake = document.getElementById('btn-retake');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const subMateriId = {{ $subMateri->id }};

        if (btnRetake) {
            btnRetake.addEventListener('click', () => {
                passedBadge.style.display = 'none';
                quizForm.classList.remove('hidden-quiz');
                // Reset all selections
                quizForm.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
                quizForm.querySelectorAll('.quiz-option').forEach(o => {
                    o.classList.remove('correct', 'wrong', 'disabled');
                });
                quizForm.querySelectorAll('.quiz-card').forEach(c => {
                    c.classList.remove('answered');
                });
                resultBox.style.display = 'none';
                btnSubmit.style.display = '';
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="bx bx-send"></i> Kirim Jawaban';
            });
        }

        if (!quizForm) return;

        quizForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Collect answers
            const answers = {};
            let unanswered = 0;
            quizForm.querySelectorAll('.quiz-card').forEach(card => {
                const qId = card.dataset.questionId;
                const selected = card.querySelector('input[type="radio"]:checked');
                if (selected) {
                    answers[qId] = parseInt(selected.value);
                } else {
                    unanswered++;
                }
            });

            if (unanswered > 0) {
                if (!confirm(`Masih ada ${unanswered} soal yang belum dijawab. Kirim sekarang?`)) return;
            }

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Mengirim...';

            try {
                const res = await fetch('{{ route("user.quiz.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ sub_materi_id: subMateriId, answers }),
                    credentials: 'same-origin',
                });

                const data = await res.json();

                if (data.success) {
                    // Highlight correct/wrong
                    Object.entries(data.results).forEach(([qId, r]) => {
                        const card = quizForm.querySelector(`.quiz-card[data-question-id="${qId}"]`);
                        if (!card) return;
                        card.classList.add('answered');

                        card.querySelectorAll('.quiz-option').forEach(opt => {
                            const idx = parseInt(opt.dataset.optionIdx);
                            opt.classList.add('disabled');
                            if (idx === r.correct_option) {
                                opt.classList.add('correct');
                            }
                            if (idx === r.selected && !r.is_correct) {
                                opt.classList.add('wrong');
                            }
                        });
                    });

                    // Tambahkan tombol Coba Lagi jika tidak lulus di sebelah Selesai/Next
                    if (!data.passed) {
                        const navContainer = document.getElementById('quiz-nav-container');
                        if (navContainer && !document.getElementById('btn-coba-lagi')) {
                            navContainer.insertAdjacentHTML('afterbegin', `
                            <button id="btn-coba-lagi" class="btn-prev" onclick="loadPage('quiz', { submateri_id: ${subMateriId} })" style="background: rgba(220, 38, 38, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); cursor: pointer; padding: 10px 18px; border-radius: 20px; font-weight: 500; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                                <i class='bx bx-refresh'></i> Coba Lagi
                            </button>
                        `);
                        }
                    }

                    // Show result
                    const icon = data.passed ? 'bx-trophy' : 'bx-error';
                    const cls = data.passed ? 'success' : 'failed';
                    let expHtml = '';
                    if (data.exp_awarded) {
                        expHtml = `<div class="quiz-exp-reward"><i class='bx bx-bolt-circle'></i> +${data.exp_gained} EXP</div>`;
                    }

                    resultBox.innerHTML = `
                    <div class="quiz-result-card ${cls}">
                        <i class='bx ${icon}'></i>
                        <h4>${data.message}</h4>
                        <p>${data.correct} dari ${data.total} soal benar</p>
                        <div class="quiz-score-bar">
                            <div class="quiz-score-fill" style="width: ${data.score}%"></div>
                        </div>
                        <span class="quiz-score-text">${data.score}%</span>
                        ${expHtml}
                    </div>
                `;
                    resultBox.style.display = 'block';
                    btnSubmit.style.display = 'none';

                    // Scroll to result
                    setTimeout(() => {
                        resultBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 200);
                }
            } catch (err) {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="bx bx-send"></i> Kirim Jawaban';
                alert('Gagal mengirim jawaban. Coba lagi.');
            }
        });
    })();
</script>

<style>
    .conatiner-quiz-materi {
        display: flex;
        justify-content: center;
        margin-top: 1em;
        padding-bottom: 6em;
    }

    .main-quiz-materi {
        width: 100%;
        max-width: 79em;
        margin: 0 10px;
    }

    .wrapper-quiz-materi {
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
    .box-quiz-materi {
        background: #191825;
        border-radius: 20px;
        border: 1px solid #1f1e2e;
        padding: 24px 16px;
    }

    .box-tittle-materi h2 {
        color: #E6E0E9;
        font-size: 20px;
        font-weight: 600;
        text-transform: capitalize;
        line-height: 1.4;
        margin-bottom: 20px;
    }

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

    /* ═══════════════════════════════════════════════════════════
       QUIZ STYLES
       ═══════════════════════════════════════════════════════════ */
    .quiz-section {
        padding-top: 10px;
    }

    .quiz-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }

    .quiz-header-icon {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.15));
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .quiz-header-icon i {
        font-size: 24px;
        color: #8b5cf6;
    }

    .quiz-header h3 {
        color: #E6E0E9;
        font-size: 17px;
        font-weight: 600;
        margin: 0;
    }

    .quiz-header p {
        color: #8a898a;
        font-size: 12px;
        margin: 4px 0 0;
    }

    /* ── Passed Badge ─────────────────────────── */
    .quiz-passed-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        background: rgba(13, 40, 24, 0.5);
        border: 1px solid rgba(22, 101, 52, 0.5);
        border-radius: 16px;
        margin-bottom: 16px;
        animation: quizFadeIn 0.4s ease;
    }

    .quiz-passed-badge>i {
        font-size: 28px;
        color: #4ade80;
        flex-shrink: 0;
    }

    .quiz-passed-badge h4 {
        color: #4ade80;
        font-size: 15px;
        font-weight: 600;
        margin: 0;
    }

    .quiz-passed-badge p {
        color: #86efac;
        font-size: 12px;
        margin: 2px 0 0;
    }

    .btn-retake {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid rgba(22, 101, 52, 0.5);
        background: transparent;
        color: #86efac;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .btn-retake:hover {
        background: rgba(22, 101, 52, 0.2);
    }

    /* ── Quiz Form ────────────────────────────── */
    .quiz-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .quiz-form.hidden-quiz {
        display: none;
    }

    /* ── Quiz Card ────────────────────────────── */
    .quiz-card {
        position: relative;
        background: rgba(19, 18, 28, 0.6);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.04);
        padding: 20px;
        transition: all 0.3s ease;
    }

    .quiz-card:hover {
        border-color: rgba(139, 92, 246, 0.15);
    }

    .quiz-card-number {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quiz-card-question {
        color: #E6E0E9;
        font-size: 14px;
        font-weight: 550;
        line-height: 1.6;
        margin: 0 0 14px;
        padding-right: 36px;
    }

    /* ── Quiz Options ─────────────────────────── */
    .quiz-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .quiz-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.06);
        background: rgba(25, 24, 37, 0.6);
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }

    .quiz-option input[type="radio"] {
        display: none;
    }

    .quiz-option-indicator {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.04);
        color: #8a898a;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .quiz-option-text {
        color: #b8b6b9;
        font-size: 13px;
        flex: 1;
        line-height: 1.4;
    }

    .quiz-icon-correct,
    .quiz-icon-wrong {
        display: none;
        font-size: 18px;
        flex-shrink: 0;
    }

    .quiz-option:hover {
        border-color: rgba(139, 92, 246, 0.3);
        background: rgba(139, 92, 246, 0.05);
    }

    .quiz-option:has(input:checked) {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.08);
    }

    .quiz-option:has(input:checked) .quiz-option-indicator {
        background: #6366f1;
        color: #fff;
    }

    .quiz-option:has(input:checked) .quiz-option-text {
        color: #E6E0E9;
    }

    /* After submit states */
    .quiz-option.disabled {
        pointer-events: none;
        opacity: 0.7;
    }

    .quiz-option.correct {
        border-color: #166534 !important;
        background: rgba(13, 40, 24, 0.4) !important;
        opacity: 1 !important;
    }

    .quiz-option.correct .quiz-option-indicator {
        background: #16a34a !important;
        color: #fff !important;
    }

    .quiz-option.correct .quiz-option-text {
        color: #4ade80 !important;
    }

    .quiz-option.correct .quiz-icon-correct {
        display: block;
        color: #4ade80;
    }

    .quiz-option.wrong {
        border-color: #991b1b !important;
        background: rgba(45, 18, 21, 0.4) !important;
        opacity: 1 !important;
    }

    .quiz-option.wrong .quiz-option-indicator {
        background: #dc2626 !important;
        color: #fff !important;
    }

    .quiz-option.wrong .quiz-option-text {
        color: #f87171 !important;
    }

    .quiz-option.wrong .quiz-icon-wrong {
        display: block;
        color: #f87171;
    }

    /* ── Submit Button ────────────────────────── */
    .quiz-btn-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        border-radius: 16px;
        border: none;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25);
        margin-top: 4px;
    }

    .quiz-btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(99, 102, 241, 0.4);
    }

    .quiz-btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* ── Result ───────────────────────────────── */
    .quiz-result-card {
        text-align: center;
        padding: 28px 20px;
        border-radius: 20px;
        animation: quizFadeIn 0.5s ease;
    }

    .quiz-result-card.success {
        background: rgba(13, 40, 24, 0.4);
        border: 1px solid rgba(22, 101, 52, 0.5);
    }

    .quiz-result-card.failed {
        background: rgba(45, 18, 21, 0.3);
        border: 1px solid rgba(153, 27, 27, 0.5);
    }

    .quiz-result-card>i {
        font-size: 40px;
        margin-bottom: 8px;
    }

    .quiz-result-card.success>i {
        color: #4ade80;
    }

    .quiz-result-card.failed>i {
        color: #f87171;
    }

    .quiz-result-card h4 {
        color: #E6E0E9;
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 4px;
    }

    .quiz-result-card p {
        color: #8a898a;
        font-size: 13px;
        margin: 0 0 16px;
    }

    .quiz-score-bar {
        width: 100%;
        max-width: 300px;
        height: 8px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 8px;
        margin: 0 auto 8px;
        overflow: hidden;
    }

    .quiz-score-fill {
        height: 100%;
        border-radius: 8px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .quiz-result-card.failed .quiz-score-fill {
        background: linear-gradient(90deg, #ef4444, #f87171);
    }

    .quiz-score-text {
        color: #E6E0E9;
        font-size: 24px;
        font-weight: 700;
    }

    .quiz-exp-reward {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        padding: 8px 16px;
        border-radius: 20px;
        background: rgba(99, 102, 241, 0.15);
        color: #a78bfa;
        font-size: 14px;
        font-weight: 600;
        animation: quizPulse 0.6s ease;
    }

    .quiz-exp-reward i {
        font-size: 18px;
        color: #facc15;
    }

    @keyframes quizFadeIn {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes quizPulse {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Navigation prev/next */
    .box-materi-navigation {
        margin-top: 32px;
    }

    .box-materi-navigation>hr {
        border: none;
        border-top: 1px solid #2a2c3a;
        margin-bottom: 16px;
    }

    .box-materi-navigation>div {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .btn-next {
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
        max-width: 60%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .btn-next:hover {
        background: #2a2c3a;
        color: #75bbed;
    }

    .btn-next i {
        font-size: 18px;
        flex-shrink: 0;
    }

    /* ── Code Snippet Block ──────────────────── */
    .quiz-code-block {
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.06);
        background: #0d0c14;
    }

    .quiz-code-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .quiz-code-lang {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #8b5cf6;
        background: rgba(139, 92, 246, 0.1);
        padding: 2px 8px;
        border-radius: 6px;
    }

    .quiz-code-pre {
        margin: 0;
        padding: 16px;
        overflow-x: auto;
        font-family: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', 'Consolas', monospace;
        font-size: 13px;
        line-height: 1.7;
        color: #a5f3c4;
        white-space: pre;
        tab-size: 4;
    }

    .quiz-code-pre code {
        font-family: inherit;
        color: inherit;
    }

    .quiz-code-pre::-webkit-scrollbar {
        height: 4px;
    }

    .quiz-code-pre::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.3);
        border-radius: 2px;
    }

    .quiz-code-pre::-webkit-scrollbar-track {
        background: transparent;
    }
</style>
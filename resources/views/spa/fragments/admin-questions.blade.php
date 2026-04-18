<div class="spa-fragment max-w-4xl mx-auto space-y-8" id="question-app"
    data-api-materis="{{ url('/admin/api/main') }}"
    data-api-sub-materis="{{ url('/admin/api/materi') }}"
    data-old-main="{{ old('main_materi_id') }}"
    data-old-materi="{{ old('materi_id') }}"
    data-old-sub-materi="{{ old('sub_materi_id') }}">

    {{-- ── Header ── --}}
    <div>
        <h1 class="text-xl font-semibold text-zinc-900">❓ Kelola Soal Quiz</h1>
        <p class="mt-1 text-sm text-zinc-600">
            Pilih Main Materi → Materi → Sub Materi, lalu tambahkan soal pilihan ganda (A-D).
            Soal bisa menyertakan potongan kode (code snippet).
        </p>
    </div>

    <form method="post" action="{{ route('admin.question.store') }}" class="space-y-6">
        @csrf

        {{-- ── Cascading selects: Main Materi → Materi → Sub Materi ── --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-4">
            <h2 class="text-sm font-semibold text-zinc-800">📋 Pilih Target Sub-Materi</h2>

            <div class="grid gap-4 sm:grid-cols-3">
                {{-- Main Materi --}}
                <div>
                    <label class="block text-xs font-medium text-zinc-600">Main Materi</label>
                    <select id="q-main-select" required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">— pilih —</option>
                        @foreach ($mainMateris as $main)
                            <option value="{{ $main->id }}" {{ old('main_materi_id') == $main->id ? 'selected' : '' }}>
                                {{ $main->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Materi --}}
                <div id="q-materi-wrap" @class(['hidden' => !old('main_materi_id')])>
                    <label class="block text-xs font-medium text-zinc-600">Materi</label>
                    <select id="q-materi-select"
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">— pilih main dulu —</option>
                    </select>
                </div>

                {{-- Sub Materi --}}
                <div id="q-submateri-wrap" @class(['hidden' => !old('materi_id')])>
                    <label class="block text-xs font-medium text-zinc-600">Sub Materi</label>
                    <select name="sub_materi_id" id="q-submateri-select" required
                        class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option value="">— pilih materi dulu —</option>
                    </select>
                </div>
            </div>

            {{-- Info existing questions --}}
            <div id="q-info-bar" class="hidden rounded-lg border border-indigo-100 bg-indigo-50 px-4 py-3 text-sm text-indigo-800">
                <span id="q-info-text"></span>
            </div>
        </div>

        {{-- ── Questions form area ── --}}
        <div id="q-form-wrap" class="space-y-6 @if (!$errors->any() && !old('sub_materi_id')) hidden @endif">

            {{-- Toolbar --}}
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-zinc-800">📝 Soal Pertanyaan</h2>
                <button type="button" id="btn-add-question"
                    class="inline-flex items-center gap-1.5 rounded-md border border-indigo-300 bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-100 transition-colors">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Soal
                </button>
            </div>

            {{-- Question rows --}}
            <div id="q-rows" class="space-y-4">
                {{-- Render old input rows if any --}}
                @if(old('questions'))
                    @foreach(old('questions') as $idx => $q)
                        <div class="q-block rounded-xl border border-zinc-200 bg-zinc-50/50 p-5 transition-all" data-q-row>
                            <div class="flex items-center justify-between mb-4">
                                <span class="q-num inline-flex items-center gap-2 text-sm font-semibold text-zinc-700">
                                    <span class="q-badge flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-500 text-xs font-bold text-white">{{ $idx + 1 }}</span>
                                    Soal #<span class="q-label-num">{{ $idx + 1 }}</span>
                                </span>
                                <button type="button" class="btn-remove-q rounded-md border border-red-200 px-2 py-1 text-xs text-red-500 hover:bg-red-50 transition-colors">✕ Hapus</button>
                            </div>
                            <div class="space-y-3">
                                {{-- Question text --}}
                                <div>
                                    <label class="text-xs text-zinc-600">Pertanyaan</label>
                                    <textarea name="questions[{{ $idx }}][question]" rows="3" required
                                        class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                        placeholder="Tuliskan pertanyaan...">{{ $q['question'] ?? '' }}</textarea>
                                </div>

                                {{-- Code snippet toggle --}}
                                <div class="q-code-section">
                                    <button type="button" class="btn-toggle-code inline-flex items-center gap-1.5 rounded-md border px-3 py-1.5 text-xs font-medium transition-colors {{ !empty($q['code_snippet']) ? 'border-emerald-300 bg-emerald-50 text-emerald-700' : 'border-zinc-300 bg-white text-zinc-600 hover:bg-zinc-50' }}">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                        {{ !empty($q['code_snippet']) ? '✓ Kode aktif' : '+ Tambah Kode' }}
                                    </button>
                                    <div class="q-code-fields mt-3 space-y-2 {{ empty($q['code_snippet']) ? 'hidden' : '' }}">
                                        <div class="flex gap-3">
                                            <div class="w-40">
                                                <label class="text-xs text-zinc-600">Bahasa</label>
                                                <input type="text" name="questions[{{ $idx }}][code_language]" value="{{ $q['code_language'] ?? '' }}"
                                                    class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="php, js, python...">
                                            </div>
                                            <div class="flex-1">
                                                <label class="text-xs text-zinc-600">Preview bahasa</label>
                                                <p class="mt-0.5 px-3 py-2 text-xs text-zinc-400 italic">Bahasa ditampilkan di kiri atas blok kode</p>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-xs text-zinc-600">Kode</label>
                                            <textarea name="questions[{{ $idx }}][code_snippet]" rows="6"
                                                class="mt-0.5 w-full rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-3 text-sm font-mono text-emerald-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                                placeholder="Tuliskan potongan kode di sini..."
                                                spellcheck="false">{{ $q['code_snippet'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- Options --}}
                                <div class="grid gap-3 sm:grid-cols-2">
                                    <div class="relative">
                                        <label class="text-xs text-zinc-600">
                                            <input type="radio" name="questions[{{ $idx }}][correct_option]" value="0" {{ ($q['correct_option'] ?? '') == '0' ? 'checked' : '' }} class="mr-1">
                                            Opsi A <span class="text-emerald-500 text-[10px]">(klik = jawaban benar)</span>
                                        </label>
                                        <input type="text" name="questions[{{ $idx }}][option_a]" value="{{ $q['option_a'] ?? '' }}" required
                                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Opsi A">
                                    </div>
                                    <div class="relative">
                                        <label class="text-xs text-zinc-600">
                                            <input type="radio" name="questions[{{ $idx }}][correct_option]" value="1" {{ ($q['correct_option'] ?? '') == '1' ? 'checked' : '' }} class="mr-1">
                                            Opsi B
                                        </label>
                                        <input type="text" name="questions[{{ $idx }}][option_b]" value="{{ $q['option_b'] ?? '' }}" required
                                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Opsi B">
                                    </div>
                                    <div class="relative">
                                        <label class="text-xs text-zinc-600">
                                            <input type="radio" name="questions[{{ $idx }}][correct_option]" value="2" {{ ($q['correct_option'] ?? '') == '2' ? 'checked' : '' }} class="mr-1">
                                            Opsi C
                                        </label>
                                        <input type="text" name="questions[{{ $idx }}][option_c]" value="{{ $q['option_c'] ?? '' }}" required
                                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Opsi C">
                                    </div>
                                    <div class="relative">
                                        <label class="text-xs text-zinc-600">
                                            <input type="radio" name="questions[{{ $idx }}][correct_option]" value="3" {{ ($q['correct_option'] ?? '') == '3' ? 'checked' : '' }} class="mr-1">
                                            Opsi D
                                        </label>
                                        <input type="text" name="questions[{{ $idx }}][option_d]" value="{{ $q['option_d'] ?? '' }}" required
                                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Opsi D">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Empty state --}}
            <div id="q-empty-state" class="@if(old('questions')) hidden @endif">
                <p class="text-sm text-zinc-400 text-center py-8 border-2 border-dashed border-zinc-200 rounded-xl">
                    ⬆️ Klik "Tambah Soal" untuk mulai menambahkan pertanyaan
                </p>
            </div>

            @if ($errors->any())
                <ul class="list-inside list-disc text-sm text-red-600 rounded-lg border border-red-200 bg-red-50 p-4">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif

            <button type="submit" id="btn-submit-questions"
                class="rounded-md bg-zinc-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-zinc-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                💾 Simpan Semua Soal
            </button>
        </div>
    </form>

    {{-- ── Existing questions preview ── --}}
    @if ($recentQuestions->isNotEmpty())
        <section class="border-t border-zinc-200 pt-8" data-csrf="{{ csrf_token() }}">
            <h2 class="text-sm font-semibold text-zinc-800 mb-4">📖 Soal Terbaru</h2>
            <div class="space-y-3">
                @foreach ($recentQuestions as $q)
                    <div class="rounded-lg border border-zinc-200 bg-white p-4 text-sm" data-crud-item="question" data-id="{{ $q->id }}">
                        <div class="crud-display flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs text-zinc-500">
                                        {{ $q->subMateri?->materi?->mainMateri?->title ?? '—' }}
                                        <span class="text-zinc-300">→</span>
                                        {{ $q->subMateri?->materi?->title ?? '—' }}
                                        <span class="text-zinc-300">→</span>
                                        {{ $q->subMateri?->title ?? '—' }}
                                    </p>
                                    <span class="shrink-0 text-xs text-zinc-400">#{{ $q->id }}</span>
                                </div>
                                <p class="font-medium text-zinc-800">{{ $q->question }}</p>

                                @if($q->code_snippet)
                                    <div class="mt-2 rounded-lg border border-zinc-700 bg-zinc-900 overflow-hidden">
                                        @if($q->code_language)
                                            <div class="flex items-center justify-between px-4 py-1.5 border-b border-zinc-700/50 bg-zinc-800/50">
                                                <span class="text-[10px] font-semibold uppercase tracking-wider text-zinc-400">{{ $q->code_language }}</span>
                                                <span class="text-[10px] text-zinc-500">snippet</span>
                                            </div>
                                        @endif
                                        <pre class="px-4 py-3 text-xs text-emerald-400 font-mono overflow-x-auto whitespace-pre"><code>{{ $q->code_snippet }}</code></pre>
                                    </div>
                                @endif

                                <div class="mt-2 grid gap-1 sm:grid-cols-2">
                                    @foreach ($q->options as $i => $opt)
                                        <span class="text-xs px-2 py-1 rounded {{ $i === $q->correct_option ? 'bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200' : 'bg-zinc-50 text-zinc-600 border border-zinc-100' }}">
                                            {{ chr(65 + $i) }}. {{ $opt }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex shrink-0 flex-col gap-1">
                                <button type="button" class="btn-crud-edit rounded border border-zinc-200 px-2 py-1 text-xs text-zinc-600 hover:bg-zinc-50 transition-colors">✏️ Edit</button>
                                <button type="button" class="btn-crud-delete rounded border border-red-200 px-2 py-1 text-xs text-red-500 hover:bg-red-50 transition-colors">🗑️ Hapus</button>
                            </div>
                        </div>

                        {{-- Edit mode --}}
                        <div class="crud-edit hidden mt-3 space-y-3 rounded-lg border border-indigo-200 bg-indigo-50/30 p-4">
                            <div>
                                <label class="text-xs text-zinc-600">Pertanyaan</label>
                                <textarea class="edit-question mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" rows="2">{{ $q->question }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs text-zinc-600">Bahasa Snippet</label>
                                    <input type="text" class="edit-code-lang mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" value="{{ $q->code_language }}">
                                </div>
                                <div class="col-span-2">
                                    <label class="text-xs text-zinc-600">Code Snippet</label>
                                    <textarea class="edit-code-snippet mt-0.5 w-full rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-3 text-sm font-mono text-emerald-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500" rows="4">{{ $q->code_snippet }}</textarea>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach ($q->options as $i => $opt)
                                    <div>
                                        <label class="text-xs text-zinc-600">
                                            <input type="radio" name="edit_correct_{{ $q->id }}" value="{{ $i }}" {{ $i === $q->correct_option ? 'checked' : '' }}>
                                            Opsi {{ chr(65 + $i) }}
                                        </label>
                                        <input type="text" class="edit-opt-{{ $i }} mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" value="{{ $opt }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex gap-2 mt-4">
                                <button type="button" class="btn-crud-save rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700 transition-colors">💾 Simpan</button>
                                <button type="button" class="btn-crud-cancel rounded-md border border-zinc-300 px-3 py-1.5 text-xs text-zinc-600 hover:bg-zinc-50 transition-colors">Batal</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

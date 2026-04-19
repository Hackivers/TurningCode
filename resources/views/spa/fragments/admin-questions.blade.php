<div class="spa-fragment max-w-5xl mx-auto space-y-8" id="question-app"
    data-api-materis="{{ url('/admin/api/main') }}"
    data-api-sub-materis="{{ url('/admin/api/materi') }}"
    data-old-main="{{ old('main_materi_id') }}"
    data-old-materi="{{ old('materi_id') }}"
    data-old-sub-materi="{{ old('sub_materi_id') }}">

    {{-- Header Section --}}
    <div class="relative overflow-hidden rounded-3xl bg-zinc-900 p-8 text-white shadow-2xl">
        <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-sky-500/20 blur-3xl"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-emerald-300 backdrop-blur-md ring-1 ring-white/20">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Evaluation System
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Bank Soal Quiz</h1>
                <p class="text-sm font-medium text-zinc-400">Bangun sistem evaluasi materi melalui soal pilihan ganda dinamis dengan dukungan snippet code.</p>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('admin.question.store') }}" class="space-y-6">
        @csrf

        {{-- ── Cascading selects: Main Materi → Materi → Sub Materi ── --}}
        <section class="rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
            <div class="mb-5 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 shadow-inner">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800">Target Mapping</h2>
            </div>
            
            <div class="grid gap-6 sm:grid-cols-3">
                {{-- Main Materi --}}
                <div class="space-y-1.5 group">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-emerald-600">Main Materi</label>
                    <select id="q-main-select" required
                        class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 appearance-none">
                        <option value="">— pilih node induk —</option>
                        @foreach ($mainMateris as $main)
                            <option value="{{ $main->id }}" {{ old('main_materi_id') == $main->id ? 'selected' : '' }}>
                                {{ $main->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Materi --}}
                <div id="q-materi-wrap" @class(['space-y-1.5 group', 'hidden' => !old('main_materi_id')])>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-emerald-600">Materi</label>
                    <select id="q-materi-select"
                        class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 appearance-none">
                        <option value="">— await induk —</option>
                    </select>
                </div>

                {{-- Sub Materi --}}
                <div id="q-submateri-wrap" @class(['space-y-1.5 group', 'hidden' => !old('materi_id')])>
                    <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-emerald-600">Sub Materi</label>
                    <select name="sub_materi_id" id="q-submateri-select" required
                        class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 appearance-none">
                        <option value="">— await sub-level —</option>
                    </select>
                </div>
            </div>

            {{-- Info existing questions --}}
            <div id="q-info-bar" class="hidden mt-6 rounded-xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-xs font-bold text-emerald-800 flex items-center gap-3">
                <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span id="q-info-text"></span>
            </div>
        </section>

        {{-- ── Questions form area ── --}}
        <section id="q-form-wrap" class="rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl @if (!$errors->any() && !old('sub_materi_id')) hidden @endif">

            {{-- Toolbar --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800 flex items-center gap-2">
                    <svg class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Builder Form Soal
                </h2>
                <button type="button" id="btn-add-question"
                    class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-sky-300">
                    <svg class="h-3.5 w-3.5 text-zinc-400 group-hover:text-sky-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-sky-600 transition-colors">Tambah Blok Soal</span>
                </button>
            </div>

            {{-- Question rows --}}
            <div id="q-rows" class="space-y-6">
                {{-- Render old input rows if any --}}
                @if(old('questions'))
                    @foreach(old('questions') as $idx => $q)
                        <div class="q-block relative overflow-hidden rounded-2xl border border-zinc-200/80 bg-zinc-50/50 p-6 transition-colors focus-within:border-sky-300 focus-within:bg-sky-50/30 group" data-q-row>
                            
                            <div class="absolute top-0 right-0 rounded-bl-xl bg-zinc-200/50 px-3 py-1 text-[9px] font-black tracking-widest text-zinc-500 uppercase transition-colors group-focus-within:bg-sky-200 group-focus-within:text-sky-700">
                                BLOCK SOAL
                            </div>

                            <div class="flex items-center gap-3 mb-5">
                                <span class="flex items-center justify-center h-8 w-8 rounded-lg bg-sky-500 text-white font-black shadow-md border border-sky-600 q-num">
                                    <span class="q-badge hidden">{{ $idx + 1 }}</span>
                                    <span class="q-label-num text-[10px]">{{ $idx + 1 }}</span>
                                </span>
                                <button type="button" class="btn-remove-q ml-auto flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-red-500 hover:bg-red-50 hover:text-red-600 shadow-sm transition-colors opacity-0 group-hover:opacity-100 mr-20">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Hapus
                                </button>
                            </div>

                            <div class="space-y-5">
                                {{-- Question text --}}
                                <div class="space-y-1.5 group/inner focus-within:text-sky-600">
                                    <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors">Pertanyaan</label>
                                    <textarea name="questions[{{ $idx }}][question]" rows="3" required
                                        class="w-full resize-none rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500"
                                        placeholder="Tuliskan pertanyaan..."></textarea>
                                </div>

                                {{-- Code snippet toggle --}}
                                <div class="q-code-section rounded-xl border border-zinc-200 bg-white p-4">
                                    <button type="button" class="btn-toggle-code inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider transition-colors {{ !empty($q['code_snippet']) ? 'border-emerald-300 bg-emerald-50 text-emerald-700' : 'border-zinc-300 bg-zinc-50 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900' }}">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                        {{ !empty($q['code_snippet']) ? '✓ Kode Payload Aktif' : '+ Injeksi Kode (opsional)' }}
                                    </button>
                                    
                                    <div class="q-code-fields mt-4 space-y-4 {{ empty($q['code_snippet']) ? 'hidden' : '' }}">
                                        <div class="flex gap-4">
                                            <div class="w-1/3 space-y-1.5 focus-within:text-sky-600">
                                                <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Bahasa</label>
                                                <input type="text" name="questions[{{ $idx }}][code_language]" value="{{ $q['code_language'] ?? '' }}"
                                                    class="w-full rounded-xl border-0 bg-zinc-50 px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="e.g. php, python...">
                                            </div>
                                            <div class="flex-1 flex flex-col justify-center">
                                                <div class="rounded bg-sky-50 px-3 py-2 text-[10px] font-mono text-sky-600 ring-1 ring-sky-200">ℹ️ Bahasa akan muncul di pojok kiri atas saat di-render.</div>
                                            </div>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Source Code</label>
                                            <textarea name="questions[{{ $idx }}][code_snippet]" rows="6"
                                                class="w-full resize-none rounded-xl border border-zinc-700 bg-[#0f0f11] px-4 py-4 text-[11px] font-mono leading-relaxed text-emerald-400 shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)] transition-all placeholder:text-zinc-600 focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 scrollbar-thin scrollbar-thumb-zinc-700 scrollbar-track-transparent"
                                                placeholder="Tuliskan snippet..."
                                                spellcheck="false">{{ $q['code_snippet'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- Options --}}
                                <div class="grid gap-4 sm:grid-cols-2 pt-2 border-t border-zinc-200/50">
                                    @php $opts = ['a', 'b', 'c', 'd']; @endphp
                                    @foreach($opts as $i => $opt)
                                        <div class="relative space-y-1.5 focus-within:text-sky-600 group/opt">
                                            <div class="flex items-center justify-between">
                                                <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 flex items-center gap-2 cursor-pointer transition-colors group-focus-within/opt:text-sky-600">
                                                    <div class="relative flex items-center">
                                                        <input type="radio" name="questions[{{ $idx }}][correct_option]" value="{{ $i }}" {{ ($q['correct_option'] ?? '') == (string)$i ? 'checked' : '' }}
                                                            class="peer h-4 w-4 cursor-pointer appearance-none rounded-full border-2 border-zinc-300 bg-white transition-all checked:border-emerald-500 checked:bg-emerald-500 hover:shadow-md">
                                                    </div>
                                                    Opsi {{ strtoupper($opt) }}
                                                </label>
                                                <span class="text-[9px] font-bold text-emerald-500 opacity-0 transition-opacity peer-checked:opacity-100 group-focus-within/opt:peer-checked:opacity-100">JAWABAN BENAR</span>
                                            </div>
                                            <input type="text" name="questions[{{ $idx }}][option_{{ $opt }}]" value="{{ $q['option_'.$opt] ?? '' }}" required
                                                class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="Pilihan {{ strtoupper($opt) }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Empty state --}}
            <div id="q-empty-state" class="@if(old('questions')) hidden @endif mt-8 mb-4">
                <div class="flex flex-col items-center justify-center p-10 border-2 border-dashed border-zinc-200/80 rounded-2xl bg-zinc-50/50">
                    <svg class="h-10 w-10 text-zinc-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Builder Block Kosong</p>
                    <p class="mt-1 text-[10px] text-zinc-500">Klik "Tambah Blok Soal" di sudut kanan atas untuk injeksi payload baru</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="rounded-xl bg-red-50 p-4 border border-red-100 mt-6">
                    <ul class="list-inside list-disc text-xs font-medium text-red-600 space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-8">
                <button type="submit" id="btn-submit-questions"
                    class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-zinc-900 px-4 py-4 text-sm font-bold text-white transition-all hover:bg-emerald-500 hover:shadow-[0_0_30px_rgba(16,185,129,0.5)] hover:-translate-y-0.5 active:scale-[0.98] disabled:opacity-50 disabled:hover:translate-y-0 disabled:hover:shadow-none disabled:hover:bg-zinc-900">
                    <span class="relative z-10 tracking-widest uppercase">Deploy Bank Soal</span>
                    <svg class="relative z-10 h-4 w-4 transition-transform group-hover:translate-x-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </section>
    </form>

    {{-- ── Existing questions preview ── --}}
    {{-- ── Existing questions preview ── --}}
    @if ($recentQuestions->isNotEmpty())
        <section class="mt-8 rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl" data-csrf="{{ csrf_token() }}">
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-50 text-sky-600 shadow-inner">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800">Database Soal Terbaru</h2>
            </div>
            
            <div class="space-y-4">
                @foreach ($recentQuestions as $q)
                    <div class="group relative overflow-hidden rounded-2xl border border-zinc-200/80 bg-white p-5 transition-all hover:shadow-md hover:shadow-zinc-200/50 hover:ring-1 hover:ring-emerald-500/20" data-crud-item="question" data-id="{{ $q->id }}">
                        
                        <div class="crud-display flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-zinc-50 text-zinc-400 ring-1 ring-zinc-100 transition-colors group-hover:bg-emerald-50 group-hover:text-emerald-500 group-hover:ring-emerald-100">
                                <span class="font-black text-sm">Q{{ $q->id }}</span>
                            </div>

                            <div class="flex-1 min-w-0 pt-0.5">
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 flex items-center gap-1.5 truncate">
                                        {{ $q->subMateri?->materi?->mainMateri?->title ?? '—' }}
                                        <svg class="h-3 w-3 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        {{ $q->subMateri?->materi?->title ?? '—' }}
                                        <svg class="h-3 w-3 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        {{ $q->subMateri?->title ?? '—' }}
                                    </p>
                                    <div class="flex shrink-0 items-center gap-1.5 opacity-0 transition-opacity group-hover:opacity-100">
                                        <button type="button" class="btn-crud-edit flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-50 text-zinc-500 transition-colors hover:bg-emerald-50 hover:text-emerald-600" title="Edit Soal">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button type="button" class="btn-crud-delete flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-50 text-zinc-500 transition-colors hover:bg-red-50 hover:text-red-600" title="Hapus Soal">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <p class="font-medium text-zinc-800 text-sm mb-3">{{ $q->question }}</p>

                                @if($q->code_snippet)
                                    <div class="mb-3 rounded-xl border border-zinc-700 bg-zinc-900 overflow-hidden shadow-inner">
                                        @if($q->code_language)
                                            <div class="flex items-center justify-between px-4 py-2 border-b border-zinc-700/80 bg-zinc-800/80">
                                                <span class="text-[9px] font-black uppercase tracking-widest text-zinc-300">{{ $q->code_language }}</span>
                                            </div>
                                        @endif
                                        <pre class="px-4 py-3 text-[11px] font-mono leading-relaxed text-emerald-400 overflow-x-auto whitespace-pre scrollbar-thin scrollbar-thumb-zinc-700 scrollbar-track-transparent"><code>{{ $q->code_snippet }}</code></pre>
                                    </div>
                                @endif

                                <div class="grid gap-2 sm:grid-cols-2">
                                    @foreach ($q->options as $i => $opt)
                                        <div class="flex items-center gap-2 rounded-lg px-3 py-2 text-xs border {{ $i === $q->correct_option ? 'border-emerald-200 bg-emerald-50 text-emerald-700 font-bold shadow-sm' : 'border-zinc-100 bg-zinc-50/50 text-zinc-600' }}">
                                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-md {{ $i === $q->correct_option ? 'bg-emerald-500 text-white' : 'bg-zinc-200 text-zinc-500' }} text-[9px] font-black">{{ chr(65 + $i) }}</span>
                                            <span class="truncate">{{ $opt }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Edit mode --}}
                        <div class="crud-edit hidden mt-4 rounded-xl border border-sky-100 bg-sky-50/50 p-5 shadow-inner">
                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold uppercase tracking-wider text-sky-600">Edit Pertanyaan</label>
                                    <textarea class="edit-question w-full rounded-xl border-0 bg-white px-4 py-3 text-sm shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-500" rows="2">{{ $q->question }}</textarea>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-12">
                                    <div class="sm:col-span-4 space-y-1.5">
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-sky-600">Language</label>
                                        <input type="text" class="edit-code-lang w-full rounded-xl border-0 bg-white px-4 py-3 text-sm shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-500" value="{{ $q->code_language }}">
                                    </div>
                                    <div class="sm:col-span-8 space-y-1.5">
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-sky-600">Code Snippet (KOSONGKAN JIKA TIDAK ADA)</label>
                                        <textarea class="edit-code-snippet w-full rounded-xl border border-zinc-700 bg-[#0f0f11] px-4 py-3 text-[11px] font-mono text-emerald-400 focus:outline-none focus:ring-2 focus:ring-sky-500 shadow-inner" rows="4">{{ $q->code_snippet }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="grid gap-4 sm:grid-cols-2 pt-2 border-t border-sky-200/50">
                                    @foreach ($q->options as $i => $opt)
                                        <div class="relative space-y-1.5 group/editopt focus-within:text-sky-600">
                                            <label class="flex items-center gap-2 cursor-pointer text-[10px] font-bold uppercase tracking-wider text-sky-600">
                                                <input type="radio" name="edit_correct_{{ $q->id }}" value="{{ $i }}" {{ $i === $q->correct_option ? 'checked' : '' }} class="peer h-4 w-4 appearance-none rounded-full border-2 border-zinc-300 bg-white checked:border-emerald-500 checked:bg-emerald-500">
                                                Opsi {{ chr(65 + $i) }}
                                                <span class="text-[9px] font-bold text-emerald-500 opacity-0 transition-opacity peer-checked:opacity-100 uppercase ml-auto">Kunci Jawaban</span>
                                            </label>
                                            <input type="text" class="edit-opt-{{ $i }} w-full rounded-xl border-0 bg-white px-4 py-3 text-sm shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-500" value="{{ $opt }}">
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="flex items-center justify-end gap-3 pt-4 mt-2 border-t border-sky-100/50">
                                    <button type="button" class="btn-crud-cancel group flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors hover:bg-red-50 hover:text-red-600">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Batal
                                    </button>
                                    <button type="button" class="btn-crud-save group relative flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-zinc-900 px-6 py-2.5 text-[10px] font-bold uppercase tracking-widest text-white transition-all hover:bg-sky-500 hover:shadow-[0_0_20px_rgba(14,165,233,0.4)] hover:-translate-y-0.5 active:scale-[0.98]">
                                        <span class="relative z-10">Konfirmasi Update Soal</span>
                                        <svg class="relative z-10 h-3 w-3 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

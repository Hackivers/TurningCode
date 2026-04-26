<div class="spa-fragment max-w-5xl mx-auto space-y-8" data-csrf="{{ csrf_token() }}">
    {{-- Header Section --}}
    <div class="relative overflow-hidden rounded-3xl bg-zinc-900 p-8 text-white shadow-2xl">
        <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-cyan-500/20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-violet-500/20 blur-3xl"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-cyan-300 backdrop-blur-md ring-1 ring-white/20">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Sub-Level Navigation
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Materi</h1>
                <p class="text-sm font-medium text-zinc-400">Pecah Main Materi (Kategori Master) menjadi sub-kategori spesifik (contoh: HTML, CSS).</p>
            </div>

            {{-- Import Excel Buttons --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.materi.template') }}" class="group inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-2 text-xs font-bold text-white/80 backdrop-blur-md ring-1 ring-white/20 transition-all hover:bg-white/20 hover:text-white hover:-translate-y-0.5 hover:shadow-lg" title="Download Template Excel">
                    <svg class="h-3.5 w-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span class="hidden sm:inline uppercase tracking-widest">Template</span>
                </a>
                <button type="button" onclick="window.triggerMateriExcelImport()" class="group inline-flex items-center gap-2 rounded-xl bg-emerald-500/20 px-3 py-2 text-xs font-bold text-emerald-300 backdrop-blur-md ring-1 ring-emerald-400/30 transition-all hover:bg-emerald-500/30 hover:text-emerald-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/20" title="Import dari Excel">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="uppercase tracking-widest">Import Excel</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden form for Excel import --}}
    <form id="form-import-materi-excel" method="post" action="{{ route('admin.materi.import') }}" enctype="multipart/form-data" class="hidden">
        @csrf
        <input type="file" name="excel_file" id="import_materi_excel_file" accept=".xlsx" onchange="window.submitMateriImportExcel()">
    </form>

    @if ($mainMateris->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-6 py-4 text-sm text-amber-900 shadow-sm flex items-center gap-3">
            <svg class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Belum ada Main Materi. Buat fondasi terlebih dahulu di menu <strong>Main Materi</strong>.
        </div>
    @else
        <div class="space-y-8">
            {{-- Form Section --}}
            <section class="rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600 shadow-inner">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800">Deploy Data</h2>
                        </div>
                    </div>

                    <form method="post" action="{{ route('admin.materi.store') }}" id="form-materi-batch" class="space-y-6">
                        @csrf
                        <div class="space-y-1.5 group">
                            <label for="main_materi_id" class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-cyan-600">Pilih Node Kategori Utama</label>
                            <select id="main_materi_id" name="main_materi_id" required
                                class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500 appearance-none">
                                <option value="">— pilih —</option>
                                @foreach ($mainMateris as $mm)
                                    <option value="{{ $mm->id }}" @selected(old('main_materi_id') == $mm->id)>{{ $mm->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-2 border-t border-zinc-200/50">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-xs font-bold text-zinc-700 uppercase tracking-wider">Node Payload</h3>
                                <button type="button" id="btn-add-materi-row"
                                    class="flex items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-2 py-1 text-[10px] font-bold uppercase tracking-widest text-zinc-600 transition-colors hover:bg-cyan-50 hover:text-cyan-600 hover:border-cyan-200">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Node
                                </button>
                            </div>
                            
                            @php
                                $itemRows = old('items', [
                                    ['title' => '', 'description' => ''],
                                    ['title' => '', 'description' => ''],
                                    ['title' => '', 'description' => ''],
                                ]);
                            @endphp
                            
                            <div id="materi-rows" class="space-y-3">
                                @foreach ($itemRows as $idx => $item)
                                    <div class="materi-row relative overflow-hidden rounded-2xl border border-zinc-200/80 bg-zinc-50/50 p-4 transition-colors focus-within:border-cyan-300 focus-within:bg-cyan-50/30 group" data-row="">
                                        <div class="absolute top-0 right-0 rounded-bl-xl bg-zinc-200/50 px-2 py-0.5 text-[8px] font-black tracking-widest text-zinc-500 transition-colors group-focus-within:bg-cyan-200 group-focus-within:text-cyan-700">NODE #<span class="row-num">{{ $idx + 1 }}</span></div>
                                        <div class="space-y-3 mt-1">
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold uppercase tracking-wider text-zinc-500">Subject</label>
                                                <input type="text" name="items[{{ $idx }}][title]" value="{{ $item['title'] ?? '' }}" maxlength="255"
                                                    class="w-full rounded-lg border-0 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                                    placeholder="Contoh: HTML">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold uppercase tracking-wider text-zinc-500">Brief</label>
                                                <textarea name="items[{{ $idx }}][description]" rows="1"
                                                    class="w-full resize-none rounded-lg border-0 bg-white px-3 py-2 text-sm text-zinc-900 shadow-sm ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                                    placeholder="Deskripsi singkat">{{ $item['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="rounded-xl bg-red-50 p-4 border border-red-100">
                                <ul class="list-inside list-disc text-xs font-medium text-red-600 space-y-1">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit"
                            class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-zinc-900 px-4 py-4 text-sm font-bold text-white transition-all hover:bg-zinc-700 hover:shadow-lg hover:shadow-zinc-500/20 active:scale-[0.98]">
                            <span class="relative z-10 tracking-wide uppercase">Deploy Materi Batch</span>
                            <svg class="relative z-10 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </section>

            {{-- List Section --}}
            <section class="rounded-3xl border border-zinc-200/60 bg-white/60 p-2 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
                    @if (isset($materis) && $materis->isNotEmpty())
                        <ul class="space-y-2">
                            @foreach ($materis as $m)
                                <li class="group relative overflow-hidden rounded-2xl bg-white p-5 transition-all hover:shadow-md hover:shadow-zinc-200/50 hover:ring-1 hover:ring-cyan-500/20" data-crud-item="materi" data-id="{{ $m->id }}">
                                    
                                    {{-- Display mode --}}
                                    <div class="crud-display flex items-start gap-4">
                                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-zinc-50 text-zinc-400 ring-1 ring-zinc-100 transition-colors group-hover:bg-cyan-50 group-hover:text-cyan-500 group-hover:ring-cyan-100">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>

                                        <div class="flex-1 min-w-0 pt-0.5">
                                            <div class="flex items-center justify-between gap-4">
                                                <div class="flex items-center gap-3">
                                                    <h3 class="font-bold text-zinc-900 truncate">{{ $m->title }}</h3>
                                                    <span class="inline-flex items-center rounded bg-zinc-100 px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest text-zinc-500">Id: {{ $m->id }}</span>
                                                </div>
                                                <div class="flex shrink-0 items-center gap-1.5 opacity-0 transition-opacity group-hover:opacity-100">
                                                    <button type="button" class="btn-crud-edit flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-50 text-zinc-500 transition-colors hover:bg-cyan-50 hover:text-cyan-600" title="Edit Data">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    </button>
                                                    <button type="button" class="btn-crud-delete flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-50 text-zinc-500 transition-colors hover:bg-red-50 hover:text-red-600" title="Hapus Data">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </div>
                                            </div>

                                            @if ($m->description)
                                                <p class="mt-1 text-sm text-zinc-500 line-clamp-2 leading-relaxed">{{ $m->description }}</p>
                                            @endif

                                            <div class="mt-3 flex items-center gap-2">
                                                <span class="inline-flex items-center gap-1.5 rounded-md bg-zinc-900 px-2.5 py-1 text-[9px] font-mono font-bold uppercase tracking-widest text-zinc-300">
                                                    <svg class="h-3 w-3 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                    {{ $m->mainMateri?->title ?? '—' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Edit mode (hidden by default) --}}
                                    <div class="crud-edit hidden mt-4 rounded-xl border border-cyan-100 bg-cyan-50/50 p-4 shadow-inner">
                                        <div class="space-y-4">
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-bold uppercase tracking-wider text-cyan-600">Edit Judul Materi</label>
                                                <input type="text" class="edit-title w-full rounded-lg border-0 bg-white px-3 py-2 text-sm shadow-sm ring-1 ring-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500" value="{{ $m->title }}">
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-bold uppercase tracking-wider text-cyan-600">Edit Deskripsi</label>
                                                <textarea class="edit-description w-full rounded-lg border-0 bg-white px-3 py-2 text-sm shadow-sm ring-1 ring-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500" rows="3">{{ $m->description }}</textarea>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-bold uppercase tracking-wider text-cyan-600">Re-assign Main Materi</label>
                                                <select class="edit-main-materi-id w-full rounded-lg border-0 bg-white px-3 py-2 text-sm shadow-sm ring-1 ring-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                                                    @foreach ($mainMateris as $mm)
                                                        <option value="{{ $mm->id }}" {{ $m->main_materi_id == $mm->id ? 'selected' : '' }}>{{ $mm->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-cyan-100/50">
                                                <button type="button" class="btn-crud-cancel group flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors hover:bg-red-50 hover:text-red-600">
                                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    Batal
                                                </button>
                                                <button type="button" class="btn-crud-save group relative flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-zinc-900 px-6 py-2.5 text-[10px] font-bold uppercase tracking-widest text-white transition-all hover:bg-cyan-500 hover:shadow-[0_0_20px_rgba(6,182,212,0.4)] hover:-translate-y-0.5 active:scale-[0.98]">
                                                    <span class="relative z-10">Konfirmasi Update</span>
                                                    <svg class="relative z-10 h-3 w-3 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center justify-center px-12 py-20 text-center">
                            <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-zinc-50 text-zinc-300 ring-1 ring-zinc-200/50">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-zinc-900">Belum ada Materi Sub-Level</h3>
                            <p class="mt-2 text-xs text-zinc-500 leading-relaxed">Pilih Kategori Utama dan isi node di form di atas.</p>
                        </div>
                    @endif
            </section>
        </div>
    @endif
</div>

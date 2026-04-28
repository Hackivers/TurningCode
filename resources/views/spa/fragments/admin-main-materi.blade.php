<div class="spa-fragment max-w-5xl mx-auto space-y-8" data-csrf="{{ csrf_token() }}">
    {{-- Header Section --}}
    <div class="relative overflow-hidden rounded-3xl bg-zinc-900 p-8 text-white shadow-2xl">
        <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-indigo-300 backdrop-blur-md ring-1 ring-white/20">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Master Navigation
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Main Materi</h1>
                <p class="text-sm font-medium text-zinc-400">Pondasi utama direktori pembelajaran (Kategori Induk).</p>
            </div>

            {{-- Import Excel Buttons --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.main-materi.template') }}" class="group inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-2 text-xs font-bold text-white/80 backdrop-blur-md ring-1 ring-white/20 transition-all hover:bg-white/20 hover:text-white hover:-translate-y-0.5 hover:shadow-lg" title="Download Template Excel">
                    <svg class="h-3.5 w-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span class="hidden sm:inline uppercase tracking-widest">Template</span>
                </a>
                <button type="button" onclick="window.triggerMainMateriExcelImport()" class="group inline-flex items-center gap-2 rounded-xl bg-emerald-500/20 px-3 py-2 text-xs font-bold text-emerald-300 backdrop-blur-md ring-1 ring-emerald-400/30 transition-all hover:bg-emerald-500/30 hover:text-emerald-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/20" title="Import dari Excel">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="uppercase tracking-widest">Import Excel</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Hidden form for Excel import --}}
    <form id="form-import-main-materi-excel" method="post" action="{{ route('admin.main-materi.import') }}" enctype="multipart/form-data" class="hidden">
        @csrf
        <input type="file" name="excel_file" id="import_main_materi_excel_file" accept=".xlsx" onchange="window.submitMainMateriImportExcel()">
    </form>

    <div class="space-y-8">
        {{-- Form Section --}}
        <section class="rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
                <div class="mb-6 flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-inner">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800">Tambah Data</h2>
                </div>

                <form method="post" action="{{ route('admin.main-materi.store') }}" class="space-y-5">
                    @csrf
                    <div class="space-y-1.5 group">
                        <label for="mm-title" class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-indigo-600">Judul Kategori</label>
                        <input id="mm-title" type="text" name="title" value="{{ old('title') }}" required maxlength="255"
                            class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="e.g., Web Development">
                    </div>

                    <div class="space-y-1.5 group">
                        <label for="mm-desc" class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-indigo-600">Deskripsi</label>
                        <textarea id="mm-desc" name="description" rows="4"
                            class="w-full resize-none rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Ringkasan atau detail kategori...">{{ old('description') }}</textarea>
                    </div>

                    <div class="space-y-1.5 group">
                        <label for="mm-status" class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-indigo-600">Status</label>
                        <select id="mm-status" name="status" class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="draft" @selected(old('status') == 'draft')>Draft</option>
                            <option value="publish" @selected(old('status') == 'publish')>Publish</option>
                            <option value="coming_soon" @selected(old('status') == 'coming_soon')>Coming Soon</option>
                        </select>
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
                        <span class="relative z-10 tracking-wide uppercase">Deploy Kategori</span>
                        <svg class="relative z-10 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </section>

        {{-- List Section --}}
        <section class="rounded-3xl border border-zinc-200/60 bg-white/60 p-2 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
                @if ($mainMateris->isNotEmpty())
                    <ul class="space-y-2">
                        @foreach ($mainMateris as $mm)
                            <li class="group relative overflow-hidden rounded-2xl bg-white p-5 transition-all hover:shadow-md hover:shadow-zinc-200/50 hover:ring-1 hover:ring-indigo-500/20" data-crud-item="main-materi" data-id="{{ $mm->id }}">
                                
                                {{-- Display mode --}}
                                <div class="crud-display flex items-start gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-zinc-50 text-zinc-400 ring-1 ring-zinc-100 transition-colors group-hover:bg-indigo-50 group-hover:text-indigo-500 group-hover:ring-indigo-100">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>

                                    <div class="flex-1 min-w-0 pt-0.5">
                                        <div class="flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-bold text-zinc-900 truncate">{{ $mm->title }}</h3>
                                                @if($mm->status === 'publish')
                                                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Publish</span>
                                                @elseif($mm->status === 'coming_soon')
                                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Coming Soon</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-md bg-zinc-100 px-2 py-1 text-xs font-medium text-zinc-600 ring-1 ring-inset ring-zinc-500/10">Draft</span>
                                                @endif
                                            </div>
                                            <div class="flex shrink-0 items-center gap-1.5 opacity-0 transition-opacity group-hover:opacity-100">
                                                <button type="button" class="btn-crud-edit flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-50 text-zinc-500 transition-colors hover:bg-indigo-50 hover:text-indigo-600" title="Edit Data">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <button type="button" class="btn-crud-delete flex h-8 w-8 items-center justify-center rounded-lg bg-zinc-50 text-zinc-500 transition-colors hover:bg-red-50 hover:text-red-600" title="Hapus Data">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>

                                        @if ($mm->description)
                                            <p class="mt-1 text-sm text-zinc-500 line-clamp-2 leading-relaxed">{{ $mm->description }}</p>
                                        @endif

                                        <div class="mt-3 flex items-center gap-3">
                                            <span class="inline-flex items-center gap-1.5 rounded-md bg-zinc-50 px-2 py-1 text-[10px] font-mono font-bold uppercase tracking-widest text-zinc-500 ring-1 ring-inset ring-zinc-200/50">
                                                <span class="h-1.5 w-1.5 rounded-full bg-zinc-400"></span>
                                                {{ $mm->materis_count }} Node Materi
                                            </span>
                                            <span class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider">ID: {{ $mm->id }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit mode (hidden by default) --}}
                                <div class="crud-edit hidden mt-4 rounded-xl border border-indigo-100 bg-indigo-50/50 p-4 shadow-inner">
                                    <div class="space-y-4">
                                        <div class="space-y-1.5">
                                            <label class="text-[10px] font-bold uppercase tracking-wider text-indigo-600">Edit Judul</label>
                                            <input type="text" class="edit-title w-full rounded-lg border-0 bg-white px-3 py-2 text-sm shadow-sm ring-1 ring-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ $mm->title }}">
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="text-[10px] font-bold uppercase tracking-wider text-indigo-600">Edit Deskripsi</label>
                                            <textarea class="edit-description w-full rounded-lg border-0 bg-white px-3 py-2 text-sm shadow-sm ring-1 ring-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="3">{{ $mm->description }}</textarea>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="text-[10px] font-bold uppercase tracking-wider text-indigo-600">Status</label>
                                            <select class="edit-status w-full rounded-lg border-0 bg-white px-3 py-2 text-sm shadow-sm ring-1 ring-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                <option value="draft" @selected($mm->status == 'draft')>Draft</option>
                                                <option value="publish" @selected($mm->status == 'publish')>Publish</option>
                                                <option value="coming_soon" @selected($mm->status == 'coming_soon')>Coming Soon</option>
                                            </select>
                                        </div>
                                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-indigo-100/50">
                                            <button type="button" class="btn-crud-cancel group flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors hover:bg-red-50 hover:text-red-600">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Batal
                                            </button>
                                            <button type="button" class="btn-crud-save group relative flex items-center justify-center gap-2 overflow-hidden rounded-xl bg-zinc-900 px-6 py-2.5 text-[10px] font-bold uppercase tracking-widest text-white transition-all hover:bg-indigo-600 hover:shadow-[0_0_20px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 active:scale-[0.98]">
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
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-sm font-bold text-zinc-900">Belum ada Kategori</h3>
                        <p class="mt-2 text-xs text-zinc-500 leading-relaxed">Mulai bangun fondasi materi dengan menambahkan data pertama di atas.</p>
                    </div>
                @endif
            </section>
    </div>
</div>

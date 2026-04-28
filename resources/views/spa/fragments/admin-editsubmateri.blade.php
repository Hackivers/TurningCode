@php
    // Ambil data sub-materi beserta relasinya
    $mainMateriId = old('main_materi_id', $sub->materi?->main_materi_id);
    $materiId = old('materi_id', $sub->materi_id);

    // Gabungkan fallback (jika ada validation error, ambil old('sections'), jika tidak ambil dari database)
    $sectionRows = old('sections', $sub->sections ?? []);
@endphp

<div class="spa-fragment max-w-5xl mx-auto space-y-8" id="submateri-app" data-api-base="{{ url('/admin/api/main') }}"
    data-old-main="{{ $mainMateriId }}" data-old-materi="{{ $materiId }}">

    {{-- Header Section --}}
    <div class="relative overflow-hidden rounded-3xl bg-zinc-900 p-8 text-white shadow-2xl">
        <div class="absolute -top-24 -right-24 h-64 w-64 rounded-full bg-amber-500/20 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-violet-500/20 blur-3xl"></div>

        <div class="relative z-10 flex items-start justify-between">
            <div class="space-y-2">
                <div
                    class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-amber-300 backdrop-blur-md ring-1 ring-white/20">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                    Edit Mode Payload
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Edit Sub Materi</h1>
                <p class="text-sm font-medium text-zinc-400">Node ID: <code
                        class="px-2 py-0.5 bg-zinc-800 rounded text-amber-400">#{{ $sub->id }}</code> — Modifikasi
                    konten JSON secara penuh.</p>
            </div>

            <button type="button" data-spa-page="addsubmateri"
                class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white/10 px-4 py-2 border border-white/20 shadow-sm transition-all hover:bg-white hover:text-zinc-900 hover:shadow-md">
                <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-xs font-bold uppercase tracking-widest group-hover:text-zinc-900">Kembali</span>
            </button>
        </div>
    </div>

    <form method="post" action="{{ route('admin.sub-materi.updateFull', $sub->id) }}" enctype="multipart/form-data"
        class="space-y-8">
        @csrf

        <input type="hidden" name="main_materi_id" id="remember-main-id" value="{{ $mainMateriId }}">

        {{-- ── Pilih Main Materi → Materi ── --}}
        <section
            class="rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
            <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800 mb-5 flex items-center gap-2">
                <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                Node Relasi
            </h2>
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-1.5 group">
                    <label
                        class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-emerald-600">Main
                        materi</label>
                    <select id="subm-main-select" required
                        class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 appearance-none">
                        <option value="">— pilih node induk —</option>
                        @foreach ($mainMateris as $main)
                            <option value="{{ $main->id }}" {{ $mainMateriId == $main->id ? 'selected' : '' }}>
                                {{ $main->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="subm-materi-wrap" class="space-y-1.5 group">
                    <label
                        class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-emerald-600">Materi
                        Sub-level</label>
                    <select name="materi_id" id="subm-materi-select" required
                        class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 appearance-none">
                        <option value="">— await induk —</option>
                        @if($sub->materi)
                            <option value="{{ $sub->materi->id }}" selected>{{ $sub->materi->title }}</option>
                        @endif
                    </select>
                </div>
            </div>
        </section>

        {{-- ── Metadata + Sections ── --}}
        <div id="subm-form-wrap" class="space-y-8">

            {{-- Metadata --}}
            <section
                class="rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
                <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800 mb-5 flex items-center gap-2">
                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    Metadata Sub-Materi
                </h2>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="space-y-1.5 group">
                        <label
                            class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-violet-600">Judul
                            Utama</label>
                        <input type="text" name="title" value="{{ old('title', $sub->title) }}"
                            class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-violet-500"
                            placeholder="Judul utama sub-materi" required>
                    </div>
                    <div class="space-y-1.5 group">
                        <label
                            class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-violet-600">Sub
                            Judul</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $sub->subtitle) }}"
                            class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-violet-500"
                            placeholder="Sub judul (opsional)">
                    </div>
                    <div class="space-y-1.5 group">
                        <label
                            class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-violet-600">Author</label>
                        <input type="text" name="author" value="{{ old('author', $sub->author) }}"
                            class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-violet-500"
                            placeholder="Nama penulis">
                    </div>
                    <div class="space-y-1.5 group">
                        <label
                            class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors focus-within:text-violet-600">Ganti
                            Thumbnail Cover</label>
                        <input type="file" name="thumbnail" accept="image/*" onchange="window.previewImage(this)"
                            class="block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-violet-50 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-violet-700 file:-ml-4 file:-my-3 hover:file:bg-violet-100 bg-white border-0 ring-1 ring-zinc-200/50 rounded-xl px-4 py-3 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] cursor-pointer">
                        @if($sub->thumbnail)
                            <p
                                class="text-[10px] text-violet-500 mt-2 font-mono break-all inline-block px-2 py-1 bg-violet-50 rounded">
                                File Tersimpan: {{ $sub->thumbnail }}</p>
                        @endif
                    </div>
                    <div class="space-y-1.5 group">
                        <label
                            class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-violet-600">Meta
                            Title (SEO)</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $sub->meta_title) }}"
                            class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-violet-500"
                            placeholder="Meta title (SEO)">
                    </div>
                    <div class="space-y-1.5 group">
                        <label
                            class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors group-focus-within:text-violet-600">Meta
                            Description (SEO)</label>
                        <textarea name="meta_description" rows="1"
                            class="w-full resize-none rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-violet-500"
                            placeholder="Meta description (SEO)">{{ old('meta_description', $sub->meta_description) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center p-4 bg-zinc-50 rounded-xl border border-zinc-200/50">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $sub->is_published) ? 'checked' : '' }}
                                class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border-2 border-zinc-300 bg-white transition-all checked:border-violet-500 checked:bg-violet-500 hover:shadow-md">
                            <svg class="pointer-events-none absolute left-1/2 top-1/2 h-3.5 w-3.5 -translate-x-1/2 -translate-y-1/2 stroke-white stroke-[3] opacity-0 transition-all peer-checked:opacity-100"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-zinc-800">Publish Node</span>
                            <span class="text-[10px] text-zinc-500 font-mono tracking-wide">Aktifkan data agar terlihat
                                oleh publik</span>
                        </div>
                    </label>
                </div>
            </section>

            {{-- Section toolbar --}}
            <section
                class="rounded-3xl border border-zinc-200/60 bg-white/60 p-6 shadow-xl shadow-zinc-200/40 backdrop-blur-xl">
                <h2 class="text-sm font-black uppercase tracking-widest text-zinc-800 mb-5 flex items-center gap-2">
                    <svg class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Block Builder Layout
                </h2>
                <div id="subm-section-toolbar" class="flex flex-wrap gap-2.5 mb-6">
                    <button type="button" data-add-type="heading"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-indigo-300">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-indigo-600">Heading</span>
                    </button>
                    <button type="button" data-add-type="subheading"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-violet-300">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-violet-600">Subheading</span>
                    </button>
                    <button type="button" data-add-type="paragraph"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-blue-300">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-blue-600">Text</span>
                    </button>
                    <button type="button" data-add-type="code"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-emerald-300">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-emerald-600">Code</span>
                    </button>
                    <button type="button" data-add-type="image"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-amber-300">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-amber-600">Media</span>
                    </button>
                    <button type="button" data-add-type="quote"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-pink-300">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-pink-600">Quote</span>
                    </button>
                    <button type="button" data-add-type="list"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-teal-300">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-teal-600">List</span>
                    </button>
                    <button type="button" data-add-type="table"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-orange-400">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-orange-600">Table</span>
                    </button>
                    <button type="button" data-add-type="divider"
                        class="group relative inline-flex items-center gap-2 overflow-hidden rounded-xl bg-white px-4 py-2 border border-zinc-200 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-zinc-400">
                        <span
                            class="text-xs font-bold uppercase tracking-widest text-zinc-700 group-hover:text-zinc-900">Break</span>
                    </button>
                </div>

                {{-- Section rows --}}
                <div id="subm-section-rows" class="space-y-4">
                    @foreach ($sectionRows as $idx => $sec)
                        @php $type = $sec['type'] ?? 'paragraph'; @endphp
                        <div class="subm-section-block relative overflow-hidden rounded-2xl border border-zinc-200/80 bg-zinc-50/50 p-5 transition-colors focus-within:border-pink-300 focus-within:bg-pink-50/30 group"
                            data-section-row data-section-type="{{ $type }}">
                            <input type="hidden" name="sections[{{ $idx }}][type]" value="{{ $type }}">
                            <input type="hidden" name="sections[{{ $idx }}][order]" value="{{ $idx }}">

                            {{-- Preserved image info --}}
                            @if(isset($sec['image_path']))
                                <input type="hidden" name="sections[{{ $idx }}][image_path]" value="{{ $sec['image_path'] }}">
                            @endif

                            <div
                                class="absolute top-0 right-0 rounded-bl-xl bg-zinc-200/50 px-3 py-1 text-[9px] font-black tracking-widest text-zinc-500 uppercase transition-colors group-focus-within:bg-pink-200 group-focus-within:text-pink-700">
                                {{ $type }}
                            </div>

                            <div class="flex items-center gap-3 mb-4">
                                <span
                                    class="flex items-center justify-center h-8 w-8 rounded-lg bg-white border border-zinc-200 section-num text-[10px] font-black text-zinc-500 shadow-sm">{{ $idx + 1 }}</span>
                                <div
                                    class="flex gap-1.5 ml-auto opacity-0 transition-opacity group-hover:opacity-100 mr-20">
                                    <button type="button"
                                        class="btn-move-section-up flex h-7 w-7 items-center justify-center rounded-md bg-white border border-zinc-200 text-zinc-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-colors shadow-sm"
                                        title="Move Up"><svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7"></path>
                                        </svg></button>
                                    <button type="button"
                                        class="btn-move-section-down flex h-7 w-7 items-center justify-center rounded-md bg-white border border-zinc-200 text-zinc-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-colors shadow-sm"
                                        title="Move Down"><svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg></button>
                                    <button type="button"
                                        class="btn-remove-section flex h-7 w-7 items-center justify-center rounded-md bg-white border border-red-200 text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors shadow-sm"
                                        title="Remove Block"><svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg></button>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @if ($type === 'code')
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Bahasa
                                            Source Code</label>
                                        <input type="text" name="sections[{{ $idx }}][language]"
                                            value="{{ $sec['language'] ?? '' }}"
                                            class="w-full xl:w-1/3 rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500"
                                            placeholder="e.g. php, python, js...">
                                    </div>
                                @endif

                                @if ($type !== 'image')
                                    <div class="space-y-1.5 focus-within:text-pink-600">
                                        <label
                                            class="text-[10px] font-bold uppercase tracking-wider text-zinc-500 transition-colors">Data
                                            Payload</label>
                                        <textarea name="sections[{{ $idx }}][content]"
                                            rows="{{ in_array($type, ['heading', 'subheading']) ? 1 : 5 }}"
                                            class="w-full resize-none rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500"
                                            placeholder="Input source content di sini...">{{ $sec['content'] ?? '' }}</textarea>
                                    </div>
                                @endif

                                @if ($type === 'image')
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Ubah Media
                                            Asset</label>
                                        <input type="file" name="sections[{{ $idx }}][file]" accept="image/*"
                                            onchange="window.previewImage(this)"
                                            class="block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-50 file:px-4 file:py-2.5 file:text-xs file:font-semibold file:text-amber-700 file:-ml-4 file:-my-3 hover:file:bg-amber-100 bg-white border-0 ring-1 ring-zinc-200/50 rounded-xl px-4 py-3 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] cursor-pointer">
                                        @if(isset($sec['image_path']))
                                            <p
                                                class="text-[10px] text-amber-500 mt-2 font-mono break-all inline-block px-2 py-1 bg-amber-50/50 rounded ring-1 ring-amber-200">
                                                File Tersimpan: {{ $sec['image_path'] }}</p>
                                        @endif
                                    </div>
                                @endif

                                @if ($type === 'quote')
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Reference
                                            URL/Name</label>
                                        <input type="text" name="sections[{{ $idx }}][source]"
                                            value="{{ $sec['source'] ?? '' }}"
                                            class="w-full rounded-xl border-0 bg-white px-4 py-3 text-sm text-zinc-900 shadow-[inset_0_2px_5px_rgba(0,0,0,0.02)] ring-1 ring-zinc-200/50 transition-all placeholder:text-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500"
                                            placeholder="Kutipan...">
                                    </div>
                                @endif

                                @if ($type === 'list')
                                    <div class="flex gap-6 mt-2">
                                        <label class="relative flex cursor-pointer items-center gap-2">
                                            <input type="radio" name="sections[{{ $idx }}][list_type]" value="unordered" {{ ($sec['list_type'] ?? 'unordered') === 'unordered' ? 'checked' : '' }}
                                                class="peer sr-only">
                                            <div
                                                class="h-4 w-4 rounded border-2 border-zinc-300 peer-checked:border-pink-500 peer-checked:bg-pink-500">
                                            </div>
                                            <span class="text-xs font-bold text-zinc-700 uppercase tracking-widest">BULLET
                                                LIST</span>
                                        </label>
                                        <label class="relative flex cursor-pointer items-center gap-2">
                                            <input type="radio" name="sections[{{ $idx }}][list_type]" value="ordered" {{ ($sec['list_type'] ?? '') === 'ordered' ? 'checked' : '' }} class="peer sr-only">
                                            <div
                                                class="h-4 w-4 rounded border-2 border-zinc-300 peer-checked:border-pink-500 peer-checked:bg-pink-500">
                                            </div>
                                            <span class="text-xs font-bold text-zinc-700 uppercase tracking-widest">NUMBERED
                                                LIST</span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (count($sectionRows) === 0)
                    <div
                        class="flex flex-col items-center justify-center p-10 border-2 border-dashed border-zinc-200 rounded-2xl bg-zinc-50/50">
                        <svg class="h-10 w-10 text-zinc-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Node Konten Kosong</p>
                        <p class="mt-1 text-[10px] text-zinc-500">Pilih builder block di atas untuk menginjeksi data
                            kontainer</p>
                    </div>
                @endif

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
                    class="group relative mt-4 flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-zinc-900 px-4 py-4 text-sm font-bold text-white transition-all hover:bg-zinc-700 hover:shadow-lg hover:shadow-zinc-500/20 active:scale-[0.98]">
                    <span class="relative z-10 tracking-widest uppercase">Konfirmasi Modifikasi Payload</span>
                    <svg class="relative z-10 h-4 w-4 transition-transform group-hover:translate-x-1.5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </section>
        </div>
    </form>
</div>
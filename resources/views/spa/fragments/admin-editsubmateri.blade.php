@php
    // Ambil data sub-materi beserta relasinya
    $mainMateriId = old('main_materi_id', $sub->materi?->main_materi_id);
    $materiId = old('materi_id', $sub->materi_id);
    
    // Gabungkan fallback (jika ada validation error, ambil old('sections'), jika tidak ambil dari database)
    $sectionRows = old('sections', $sub->sections ?? []);
@endphp

<div class="spa-fragment max-w-4xl mx-auto space-y-8" id="submateri-app" data-api-base="{{ url('/admin/api/main') }}"
    data-old-main="{{ $mainMateriId }}" data-old-materi="{{ $materiId }}">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-semibold text-zinc-900">Edit Sub Materi</h1>
            <p class="mt-1 text-sm text-zinc-600">ID: #{{ $sub->id }} — Modifikasi konten JSON secara penuh.</p>
        </div>
        <button type="button" data-spa-page="addsubmateri" class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50">
            ← Kembali
        </button>
    </div>

    <form method="post" action="{{ route('admin.sub-materi.updateFull', $sub->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <input type="hidden" name="main_materi_id" id="remember-main-id" value="{{ $mainMateriId }}">

        {{-- ── Pilih Main Materi → Materi ── --}}
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-zinc-700">Main materi</label>
                <select id="subm-main-select" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">— pilih —</option>
                    @foreach ($mainMateris as $main)
                        <option value="{{ $main->id }}" {{ $mainMateriId == $main->id ? 'selected' : '' }}>{{ $main->title }}</option>
                    @endforeach
                </select>
            </div>
            <div id="subm-materi-wrap">
                <label class="block text-sm font-medium text-zinc-700">Materi</label>
                <select name="materi_id" id="subm-materi-select" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">— pilih main dulu —</option>
                    @if($sub->materi)
                        <option value="{{ $sub->materi->id }}" selected>{{ $sub->materi->title }}</option>
                    @endif
                </select>
            </div>
        </div>

        {{-- ── Metadata + Sections ── --}}
        <div id="subm-form-wrap" class="space-y-6">

            {{-- Metadata --}}
            <div class="rounded-xl border border-zinc-200 bg-white p-5 space-y-4">
                <h2 class="text-sm font-semibold text-zinc-800">📋 Metadata Sub-Materi</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-xs text-zinc-600">Judul Utama</label>
                        <input type="text" name="title" value="{{ old('title', $sub->title) }}"
                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                            placeholder="Judul utama sub-materi" required>
                    </div>
                    <div>
                        <label class="text-xs text-zinc-600">Sub Judul</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $sub->subtitle) }}"
                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                            placeholder="Sub judul (opsional)">
                    </div>
                    <div>
                        <label class="text-xs text-zinc-600">Author</label>
                        <input type="text" name="author" value="{{ old('author', $sub->author) }}"
                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                            placeholder="Nama penulis">
                    </div>
                    <div>
                        <label class="text-xs text-zinc-600">Ganti Thumbnail (opsional)</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="mt-0.5 block w-full text-sm text-zinc-600 file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm">
                        @if($sub->thumbnail)
                            <p class="text-[10px] text-zinc-400 mt-1">Saat ini: {{ $sub->thumbnail }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="text-xs text-zinc-600">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $sub->meta_title) }}"
                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                            placeholder="Meta title (SEO)">
                    </div>
                    <div>
                        <label class="text-xs text-zinc-600">Meta Description</label>
                        <textarea name="meta_description" rows="2"
                            class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                            placeholder="Meta description (SEO)">{{ old('meta_description', $sub->meta_description) }}</textarea>
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm text-zinc-700">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $sub->is_published) ? 'checked' : '' }}
                        class="rounded border-zinc-300">
                    Publish
                </label>
            </div>

            {{-- Section toolbar --}}
            <div>
                <h2 class="text-sm font-semibold text-zinc-800 mb-3">📝 Section Konten</h2>
                <div id="subm-section-toolbar" class="flex flex-wrap gap-2 mb-4">
                    <button type="button" data-add-type="heading"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-indigo-50 hover:border-indigo-300">
                        + Judul</button>
                    <button type="button" data-add-type="subheading"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-violet-50 hover:border-violet-300">
                        + Subjudul</button>
                    <button type="button" data-add-type="paragraph"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-blue-50 hover:border-blue-300">
                        + Paragraf</button>
                    <button type="button" data-add-type="code"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-emerald-50 hover:border-emerald-300">
                        + Kode</button>
                    <button type="button" data-add-type="image"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-amber-50 hover:border-amber-300">
                        + Gambar</button>
                    <button type="button" data-add-type="quote"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-pink-50 hover:border-pink-300">
                        + Kutipan</button>
                    <button type="button" data-add-type="list"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-teal-50 hover:border-teal-300">
                        + Daftar</button>
                    <button type="button" data-add-type="divider"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-zinc-100">
                        + Pemisah</button>
                </div>
            </div>

            {{-- Section rows --}}
            <div id="subm-section-rows" class="space-y-4">
                @foreach ($sectionRows as $idx => $sec)
                    @php $type = $sec['type'] ?? 'paragraph'; @endphp
                    <div class="subm-section-block rounded-xl border border-zinc-200 bg-zinc-50/50 p-4" data-section-row data-section-type="{{ $type }}">
                        <input type="hidden" name="sections[{{ $idx }}][type]" value="{{ $type }}">
                        <input type="hidden" name="sections[{{ $idx }}][order]" value="{{ $idx }}">
                        
                        {{-- Preserved image info --}}
                        @if(isset($sec['image_path']))
                            <input type="hidden" name="sections[{{ $idx }}][image_path]" value="{{ $sec['image_path'] }}">
                        @endif

                        <div class="flex items-center gap-2 mb-3">
                            <span class="section-num text-xs font-semibold text-zinc-500">#{{ $idx + 1 }} — {{ ucfirst($type) }}</span>
                            <button type="button" class="btn-move-section-up ml-auto rounded border border-zinc-300 px-1.5 py-0.5 text-xs hover:bg-zinc-100">▲</button>
                            <button type="button" class="btn-move-section-down rounded border border-zinc-300 px-1.5 py-0.5 text-xs hover:bg-zinc-100">▼</button>
                            <button type="button" class="btn-remove-section rounded border border-red-200 px-1.5 py-0.5 text-xs text-red-500 hover:bg-red-50">✕</button>
                        </div>
                        <div class="space-y-3">
                            @if ($type === 'code')
                                <div>
                                    <label class="text-xs text-zinc-600">Bahasa</label>
                                    <input type="text" name="sections[{{ $idx }}][language]" value="{{ $sec['language'] ?? '' }}"
                                        class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="php, js, python...">
                                </div>
                            @endif
                            
                            @if ($type !== 'image')
                                <div>
                                    <label class="text-xs text-zinc-600">Konten</label>
                                    <textarea name="sections[{{ $idx }}][content]" rows="{{ in_array($type, ['heading','subheading']) ? 1 : 5 }}"
                                        class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                        placeholder="Isi konten...">{{ $sec['content'] ?? '' }}</textarea>
                                </div>
                            @endif
                            
                            @if ($type === 'image')
                                <div>
                                    <label class="text-xs text-zinc-600">Ubah gambar (opsional)</label>
                                    <input type="file" name="sections[{{ $idx }}][file]" accept="image/*"
                                        class="mt-0.5 block w-full text-sm text-zinc-600 file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm">
                                    @if(isset($sec['image_path']))
                                        <p class="text-[10px] text-zinc-400 mt-1">Saat ini: {{ $sec['image_path'] }}</p>
                                    @endif
                                </div>
                            @endif

                            @if ($type === 'quote')
                                <div>
                                    <label class="text-xs text-zinc-600">Sumber</label>
                                    <input type="text" name="sections[{{ $idx }}][source]" value="{{ $sec['source'] ?? '' }}"
                                        class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" placeholder="Sumber kutipan (opsional)">
                                </div>
                            @endif
                            @if ($type === 'list')
                                <div class="flex gap-4 text-xs text-zinc-600">
                                    <label><input type="radio" name="sections[{{ $idx }}][list_type]" value="unordered" {{ ($sec['list_type'] ?? 'unordered') === 'unordered' ? 'checked' : '' }}> • Bullet</label>
                                    <label><input type="radio" name="sections[{{ $idx }}][list_type]" value="ordered" {{ ($sec['list_type'] ?? '') === 'ordered' ? 'checked' : '' }}> 1. Numbered</label>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if (count($sectionRows) === 0)
                <p class="text-sm text-zinc-400 text-center py-6 border-2 border-dashed border-zinc-200 rounded-xl">
                    ⬇️ Klik tombol di atas untuk menambah section konten
                </p>
            @endif

            @if ($errors->any())
                <ul class="list-inside list-disc text-sm text-red-600">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif

            <button type="submit" class="rounded-md bg-indigo-600 hover:bg-indigo-700 px-4 py-2 text-sm font-medium text-white transition-colors">
                💾 Update Full Sub Materi
            </button>
        </div>
    </form>
</div>

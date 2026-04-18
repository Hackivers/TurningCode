<div class="spa-fragment max-w-3xl mx-auto space-y-6" data-csrf="{{ csrf_token() }}">
    <div>
        <h1 class="text-xl font-semibold text-zinc-900">Materi</h1>
        <p class="mt-1 text-sm text-zinc-600">Pilih main materi, lalu tambah satu atau lebih materi (mis. HTML, CSS, JS di bawah
            &ldquo;Web Dev&rdquo;).</p>
    </div>

    @if ($mainMateris->isEmpty())
        <p class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            Belum ada main materi. Buat dulu di menu <strong>Main materi</strong>.
        </p>
    @else
        <form method="post" action="{{ route('admin.materi.store') }}" id="form-materi-batch" class="space-y-6">
            @csrf
            <div>
                <label for="main_materi_id" class="block text-sm font-medium text-zinc-700">Main materi</label>
                <select id="main_materi_id" name="main_materi_id" required
                    class="mt-1 w-full max-w-md rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">— pilih —</option>
                    @foreach ($mainMateris as $mm)
                        <option value="{{ $mm->id }}" @selected(old('main_materi_id') == $mm->id)>{{ $mm->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-sm font-semibold text-zinc-800">Daftar materi (boleh banyak)</h2>
                    <button type="button" id="btn-add-materi-row"
                        class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-zinc-50">
                        + Tambah baris
                    </button>
                </div>
                <p class="mt-1 text-xs text-zinc-500">Baris dengan judul kosong akan diabaikan.</p>

                @php
                    $itemRows = old('items', [
                        ['title' => '', 'description' => ''],
                        ['title' => '', 'description' => ''],
                        ['title' => '', 'description' => ''],
                    ]);
                @endphp
                <div id="materi-rows" class="mt-4 space-y-4">
                    @foreach ($itemRows as $idx => $item)
                        <div class="materi-row rounded-lg border border-zinc-200 bg-zinc-50/50 p-4" data-row="">
                            <p class="text-xs font-medium text-zinc-500">Materi #<span class="row-num">{{ $idx + 1 }}</span>
                            </p>
                            <div class="mt-2 grid gap-3 sm:grid-cols-1">
                                <div>
                                    <label class="block text-xs text-zinc-600">Judul</label>
                                    <input type="text" name="items[{{ $idx }}][title]" value="{{ $item['title'] ?? '' }}"
                                        maxlength="255"
                                        class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                        placeholder="Contoh: HTML, CSS, JavaScript">
                                </div>
                                <div>
                                    <label class="block text-xs text-zinc-600">Deskripsi</label>
                                    <textarea name="items[{{ $idx }}][description]" rows="2"
                                        class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                        placeholder="Deskripsi singkat">{{ $item['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($errors->any())
                <ul class="list-inside list-disc text-sm text-red-600">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif

            <button type="submit" class="rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                Simpan semua materi
            </button>
        </form>
    @endif

    {{-- ── Existing materis list ── --}}
    @if (isset($materis) && $materis->isNotEmpty())
        <section class="border-t border-zinc-200 pt-6">
            <h2 class="text-sm font-semibold text-zinc-800 mb-3">Daftar materi yang ada</h2>
            <ul class="divide-y divide-zinc-200 rounded-xl border border-zinc-200 bg-white">
                @foreach ($materis as $m)
                    <li class="px-4 py-3" data-crud-item="materi" data-id="{{ $m->id }}">
                        <div class="crud-display flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-zinc-900">{{ $m->title }}</p>
                                @if ($m->description)
                                    <p class="mt-0.5 text-sm text-zinc-600 line-clamp-2">{{ $m->description }}</p>
                                @endif
                                <p class="mt-1 text-xs text-zinc-400">Main: {{ $m->mainMateri?->title ?? '—' }}</p>
                            </div>
                            <div class="flex shrink-0 gap-1">
                                <button type="button" class="btn-crud-edit rounded border border-zinc-200 px-2 py-1 text-xs text-zinc-600 hover:bg-zinc-50 transition-colors">✏️ Edit</button>
                                <button type="button" class="btn-crud-delete rounded border border-red-200 px-2 py-1 text-xs text-red-500 hover:bg-red-50 transition-colors">🗑️ Hapus</button>
                            </div>
                        </div>
                        <div class="crud-edit hidden mt-3 space-y-3 rounded-lg border border-indigo-200 bg-indigo-50/30 p-4">
                            <div>
                                <label class="text-xs text-zinc-600">Judul</label>
                                <input type="text" class="edit-title mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" value="{{ $m->title }}">
                            </div>
                            <div>
                                <label class="text-xs text-zinc-600">Deskripsi</label>
                                <textarea class="edit-description mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm" rows="2">{{ $m->description }}</textarea>
                            </div>
                            <div>
                                <label class="text-xs text-zinc-600">Main Materi</label>
                                <select class="edit-main-materi-id mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm">
                                    @foreach ($mainMateris as $mm)
                                        <option value="{{ $mm->id }}" {{ $m->main_materi_id == $mm->id ? 'selected' : '' }}>{{ $mm->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" class="btn-crud-save rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700 transition-colors">💾 Simpan</button>
                                <button type="button" class="btn-crud-cancel rounded-md border border-zinc-300 px-3 py-1.5 text-xs text-zinc-600 hover:bg-zinc-50 transition-colors">Batal</button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
</div>

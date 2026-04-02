@php
    $sectionRows = old(
        'sections',
        [
            [
                'judul' => '',
                'subjudul' => '',
                'meta' => '',
                'meta_desc' => '',
                'artikel' => '',
            ],
        ],
    );
@endphp

<div class="spa-fragment max-w-4xl space-y-8" id="submateri-app" data-api-base="{{ url('/admin/api/main') }}"
    data-old-main="{{ old('main_materi_id') }}" data-old-materi="{{ old('materi_id') }}">
    <div>
        <h1 class="text-xl font-semibold text-zinc-900">Sub materi</h1>
        <p class="mt-1 text-sm text-zinc-600">Pilih main → materi, lalu tambah satu atau lebih <strong>section</strong> (judul,
            subjudul, meta, meta desc, artikel, thumbnail). Data disimpan sebagai array JSON di database + salinan string.</p>
    </div>

    <form method="post" action="{{ route('admin.sub-materi.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="main_materi_id" id="remember-main-id" value="{{ old('main_materi_id') }}">

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-zinc-700">Main materi</label>
                <select id="subm-main-select" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">— pilih —</option>
                    @foreach ($mainMateris as $main)
                        <option value="{{ $main->id }}">{{ $main->title }}</option>
                    @endforeach
                </select>
            </div>
            <div id="subm-materi-wrap" @class(['hidden' => !old('main_materi_id')])>
                <label class="block text-sm font-medium text-zinc-700">Materi</label>
                <select name="materi_id" id="subm-materi-select" required
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500">
                    <option value="">— pilih main dulu —</option>
                </select>
            </div>
        </div>

        <div id="subm-form-wrap" class="space-y-6 @if (!$errors->any() && !old('materi_id')) hidden @endif">
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-sm font-semibold text-zinc-800">Section konten</h2>
                <button type="button" id="btn-add-subm-section"
                    class="rounded-md border border-zinc-300 bg-white px-3 py-1.5 text-xs font-medium text-zinc-800 hover:bg-zinc-50">
                    + Tambah section
                </button>
            </div>

            <div id="subm-section-rows" class="space-y-6">
                @foreach ($sectionRows as $idx => $sec)
                    <div class="subm-section-block rounded-xl border border-zinc-200 bg-zinc-50/50 p-4" data-section-row>
                        <p class="mb-3 text-xs font-semibold text-zinc-500">Section <span
                                class="section-num">{{ $idx + 1 }}</span></p>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="text-xs text-zinc-600">Judul</label>
                                <input type="text" name="sections[{{ $idx }}][judul]"
                                    value="{{ $sec['judul'] ?? '' }}"
                                    class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                    placeholder="Judul">
                            </div>
                            <div>
                                <label class="text-xs text-zinc-600">Subjudul</label>
                                <input type="text" name="sections[{{ $idx }}][subjudul]"
                                    value="{{ $sec['subjudul'] ?? '' }}"
                                    class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                    placeholder="Subjudul">
                            </div>
                            <div>
                                <label class="text-xs text-zinc-600">Meta</label>
                                <input type="text" name="sections[{{ $idx }}][meta]" value="{{ $sec['meta'] ?? '' }}"
                                    class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                    placeholder="Meta title / tag">
                            </div>
                            <div>
                                <label class="text-xs text-zinc-600">Meta description</label>
                                <textarea name="sections[{{ $idx }}][meta_desc]" rows="2"
                                    class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                    placeholder="Meta description">{{ $sec['meta_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="text-xs text-zinc-600">Artikel</label>
                            <textarea name="sections[{{ $idx }}][artikel]" rows="5"
                                class="mt-0.5 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm"
                                placeholder="Isi artikel">{{ $sec['artikel'] ?? '' }}</textarea>
                        </div>
                        <div class="mt-3">
                            <label class="text-xs text-zinc-600">Thumbnail</label>
                            <input type="file" name="sections[{{ $idx }}][thumbnail]" accept="image/*"
                                class="mt-0.5 block w-full text-sm text-zinc-600 file:mr-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-3 file:py-1.5 file:text-sm">
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($errors->any())
                <ul class="list-inside list-disc text-sm text-red-600">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif

            <button type="submit" class="rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                Simpan sub materi
            </button>
        </div>
    </form>

    @if ($recentSubMateris->isNotEmpty())
        <section class="border-t border-zinc-200 pt-8">
            <h2 class="text-sm font-semibold text-zinc-800">Terbaru (preview string JSON)</h2>
            <ul class="mt-4 space-y-4">
                @foreach ($recentSubMateris as $sub)
                    <li class="rounded-lg border border-zinc-200 bg-white p-4 text-sm">
                        <p class="font-medium text-zinc-900">
                            {{ $sub->materi?->mainMateri?->title ?? '—' }}
                            <span class="text-zinc-400">→</span>
                            {{ $sub->materi?->title ?? '—' }}
                            <span class="text-xs font-normal text-zinc-500">#{{ $sub->id }}</span>
                        </p>
                        <pre class="mt-2 max-h-48 overflow-auto rounded bg-zinc-900 p-3 text-xs text-zinc-100 whitespace-pre-wrap">{{ $sub->sections_json }}</pre>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
</div>

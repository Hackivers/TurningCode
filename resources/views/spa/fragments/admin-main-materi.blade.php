<div class="spa-fragment max-w-3xl space-y-8">
    <div>
        <h1 class="text-xl font-semibold text-zinc-900">Main materi</h1>
        <p class="mt-1 text-sm text-zinc-600">Kategori besar (contoh: Web Dev). Isi judul dan deskripsi.</p>
    </div>

    <section class="rounded-xl border border-zinc-200 bg-zinc-50/50 p-5">
        <h2 class="text-sm font-semibold text-zinc-800">Tambah main materi</h2>
        <form method="post" action="{{ route('admin.main-materi.store') }}" class="mt-4 space-y-4">
            @csrf
            <div>
                <label for="mm-title" class="block text-sm font-medium text-zinc-700">Judul</label>
                <input id="mm-title" type="text" name="title" value="{{ old('title') }}" required maxlength="255"
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500"
                    placeholder="Contoh: Web Development">
            </div>
            <div>
                <label for="mm-desc" class="block text-sm font-medium text-zinc-700">Deskripsi</label>
                <textarea id="mm-desc" name="description" rows="4"
                    class="mt-1 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500"
                    placeholder="Ringkasan tentang main materi ini">{{ old('description') }}</textarea>
            </div>
            @if ($errors->any())
                <ul class="list-inside list-disc text-sm text-red-600">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif
            <button type="submit"
                class="rounded-md bg-zinc-900 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                Simpan main materi
            </button>
        </form>
    </section>

    @if ($mainMateris->isNotEmpty())
        <section>
            <h2 class="text-sm font-semibold text-zinc-800">Daftar main materi</h2>
            <ul class="mt-3 divide-y divide-zinc-200 rounded-xl border border-zinc-200 bg-white">
                @foreach ($mainMateris as $mm)
                    <li class="px-4 py-3">
                        <p class="font-medium text-zinc-900">{{ $mm->title }}</p>
                        @if ($mm->description)
                            <p class="mt-1 text-sm text-zinc-600 line-clamp-2">{{ $mm->description }}</p>
                        @endif
                        <p class="mt-1 text-xs text-zinc-400">{{ $mm->materis_count }} materi</p>
                    </li>
                @endforeach
            </ul>
        </section>
    @else
        <p class="text-sm text-zinc-500">Belum ada main materi. Tambahkan di atas.</p>
    @endif
</div>

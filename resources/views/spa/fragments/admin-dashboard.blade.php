<div class="spa-fragment space-y-8">

    {{-- ── Header ── --}}
    <div>
        <h1 class="text-2xl font-bold text-zinc-900">📊 Dashboard</h1>
        <p class="mt-1 text-sm text-zinc-500">Ringkasan data dan analisis platform TurningCode</p>
    </div>

    {{-- ═══════════════════════════════════════════════════
         STAT CARDS — Row 1 : Utama
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Users --}}
        <div class="group relative overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-indigo-100/60 transition-transform group-hover:scale-125"></div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500 text-lg text-white shadow-sm">👤</span>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-indigo-400">Users</p>
                        <p class="text-2xl font-bold text-indigo-900">{{ number_format($totalUsers) }}</p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-zinc-500">pengguna terdaftar</p>
            </div>
        </div>

        {{-- Admins --}}
        <div class="group relative overflow-hidden rounded-2xl border border-violet-100 bg-gradient-to-br from-violet-50 to-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-violet-100/60 transition-transform group-hover:scale-125"></div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500 text-lg text-white shadow-sm">🛡️</span>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-violet-400">Admins</p>
                        <p class="text-2xl font-bold text-violet-900">{{ number_format($totalAdmins) }}</p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-zinc-500">administrator aktif</p>
            </div>
        </div>

        {{-- Main Materi --}}
        <div class="group relative overflow-hidden rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-emerald-100/60 transition-transform group-hover:scale-125"></div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-lg text-white shadow-sm">📚</span>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-emerald-400">Main Materi</p>
                        <p class="text-2xl font-bold text-emerald-900">{{ number_format($totalMainMateris) }}</p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-zinc-500">kategori utama</p>
            </div>
        </div>

        {{-- Materi --}}
        <div class="group relative overflow-hidden rounded-2xl border border-amber-100 bg-gradient-to-br from-amber-50 to-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-amber-100/60 transition-transform group-hover:scale-125"></div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-lg text-white shadow-sm">📖</span>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-amber-400">Materi</p>
                        <p class="text-2xl font-bold text-amber-900">{{ number_format($totalMateris) }}</p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-zinc-500">total materi</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         STAT CARDS — Row 2 : Sub-Materi breakdown
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-4 sm:grid-cols-3">

        {{-- Total Sub-Materi --}}
        <div class="group relative overflow-hidden rounded-2xl border border-sky-100 bg-gradient-to-br from-sky-50 to-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-sky-100/60 transition-transform group-hover:scale-125"></div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500 text-lg text-white shadow-sm">📝</span>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-sky-400">Sub Materi</p>
                        <p class="text-2xl font-bold text-sky-900">{{ number_format($totalSubMateris) }}</p>
                    </div>
                </div>
                <p class="mt-2 text-xs text-zinc-500">total sub-materi</p>
            </div>
        </div>

        {{-- Published --}}
        <div class="group relative overflow-hidden rounded-2xl border border-green-100 bg-gradient-to-br from-green-50 to-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-green-100/60 transition-transform group-hover:scale-125"></div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500 text-lg text-white shadow-sm">✅</span>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-green-400">Published</p>
                        <p class="text-2xl font-bold text-green-900">{{ number_format($publishedSubMateris) }}</p>
                    </div>
                </div>
                <div class="mt-2">
                    @if($totalSubMateris > 0)
                        <div class="h-1.5 w-full rounded-full bg-green-100">
                            <div class="h-1.5 rounded-full bg-green-500 transition-all" style="width: {{ round($publishedSubMateris / $totalSubMateris * 100) }}%"></div>
                        </div>
                        <p class="mt-1 text-xs text-zinc-500">{{ round($publishedSubMateris / $totalSubMateris * 100) }}% dari total</p>
                    @else
                        <p class="text-xs text-zinc-500">belum ada data</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Draft --}}
        <div class="group relative overflow-hidden rounded-2xl border border-orange-100 bg-gradient-to-br from-orange-50 to-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
            <div class="absolute -right-3 -top-3 h-16 w-16 rounded-full bg-orange-100/60 transition-transform group-hover:scale-125"></div>
            <div class="relative">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500 text-lg text-white shadow-sm">📋</span>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-orange-400">Draft</p>
                        <p class="text-2xl font-bold text-orange-900">{{ number_format($draftSubMateris) }}</p>
                    </div>
                </div>
                <div class="mt-2">
                    @if($totalSubMateris > 0)
                        <div class="h-1.5 w-full rounded-full bg-orange-100">
                            <div class="h-1.5 rounded-full bg-orange-500 transition-all" style="width: {{ round($draftSubMateris / $totalSubMateris * 100) }}%"></div>
                        </div>
                        <p class="mt-1 text-xs text-zinc-500">{{ round($draftSubMateris / $totalSubMateris * 100) }}% dari total</p>
                    @else
                        <p class="text-xs text-zinc-500">belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         Bottom section : Top Materi + Recent Sub-Materi
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Top Materi by sub-materi count --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
            <h2 class="flex items-center gap-2 text-sm font-semibold text-zinc-800">
                <span class="flex h-6 w-6 items-center justify-center rounded-md bg-indigo-100 text-xs">🏆</span>
                Top Materi
            </h2>
            <p class="mb-4 text-xs text-zinc-500">Materi dengan sub-materi terbanyak</p>

            @if($topMateris->isNotEmpty())
                <div class="space-y-3">
                    @foreach($topMateris as $index => $materi)
                        <div class="flex items-center gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-xs font-bold
                                @if($index === 0) bg-amber-100 text-amber-700
                                @elseif($index === 1) bg-zinc-100 text-zinc-600
                                @elseif($index === 2) bg-orange-100 text-orange-700
                                @else bg-zinc-50 text-zinc-500
                                @endif
                            ">{{ $index + 1 }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-zinc-800">{{ $materi->title }}</p>
                                <p class="text-xs text-zinc-500">{{ $materi->mainMateri?->title ?? '—' }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-indigo-600">
                                {{ $materi->sub_materis_count }} sub
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="py-8 text-center text-sm text-zinc-400">Belum ada materi</p>
            @endif
        </div>

        {{-- Recent Sub-Materi --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
            <h2 class="flex items-center gap-2 text-sm font-semibold text-zinc-800">
                <span class="flex h-6 w-6 items-center justify-center rounded-md bg-emerald-100 text-xs">🕐</span>
                Sub-Materi Terbaru
            </h2>
            <p class="mb-4 text-xs text-zinc-500">5 sub-materi terakhir ditambahkan</p>

            @if($recentSubMateris->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentSubMateris as $sub)
                        <div class="flex items-start gap-3 rounded-lg border border-zinc-100 bg-zinc-50/50 p-3 transition-colors hover:bg-zinc-50">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-zinc-800">{{ $sub->title }}</p>
                                <p class="mt-0.5 text-xs text-zinc-500">
                                    {{ $sub->materi?->mainMateri?->title ?? '—' }}
                                    <span class="text-zinc-300">→</span>
                                    {{ $sub->materi?->title ?? '—' }}
                                </p>
                                @if($sub->author)
                                    <p class="mt-0.5 text-xs text-zinc-400">oleh {{ $sub->author }}</p>
                                @endif
                            </div>
                            <div class="flex shrink-0 flex-col items-end gap-1">
                                @if($sub->is_published)
                                    <span class="rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-600">Published</span>
                                @else
                                    <span class="rounded-full bg-orange-50 px-2 py-0.5 text-xs font-medium text-orange-600">Draft</span>
                                @endif
                                <span class="text-xs text-zinc-400">{{ $sub->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="py-8 text-center text-sm text-zinc-400">Belum ada sub-materi</p>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         Summary bar
    ═══════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-zinc-200 bg-gradient-to-r from-zinc-900 to-zinc-800 p-5 text-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-semibold">📈 Ringkasan Konten</h3>
                <p class="mt-1 text-xs text-zinc-400">Total keseluruhan konten di platform</p>
            </div>
            <div class="flex flex-wrap gap-6 text-center">
                <div>
                    <p class="text-2xl font-bold">{{ number_format($totalMainMateris + $totalMateris + $totalSubMateris) }}</p>
                    <p class="text-xs text-zinc-400">Total Konten</p>
                </div>
                <div class="h-10 w-px bg-zinc-700"></div>
                <div>
                    <p class="text-2xl font-bold">{{ number_format($totalUsers + $totalAdmins) }}</p>
                    <p class="text-xs text-zinc-400">Total Akun</p>
                </div>
                <div class="h-10 w-px bg-zinc-700"></div>
                <div>
                    @php
                        $avgSubPerMateri = $totalMateris > 0 ? round($totalSubMateris / $totalMateris, 1) : 0;
                    @endphp
                    <p class="text-2xl font-bold">{{ $avgSubPerMateri }}</p>
                    <p class="text-xs text-zinc-400">Rata-rata Sub/Materi</p>
                </div>
            </div>
        </div>
    </div>

</div>

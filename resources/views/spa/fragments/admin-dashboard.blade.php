<div class="spa-fragment space-y-12">



    {{-- ═══════════════════════════════════════════════════
         STAT CARDS — Row 1 : Utama
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Users --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-indigo-200 hover:shadow-[0_8px_25px_-5px_rgba(99,102,241,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-indigo-50 transition-all group-hover:bg-indigo-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-indigo-500/30 transition-all group-hover:w-1.5 group-hover:bg-indigo-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-indigo-500 transition-colors">Users Status</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-50 text-indigo-500 text-sm ring-1 ring-indigo-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalUsers) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span> active_accounts
                    </div>
                </div>
            </div>
        </div>

        {{-- Admins --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-violet-200 hover:shadow-[0_8px_25px_-5px_rgba(139,92,246,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-violet-50 transition-all group-hover:bg-violet-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-violet-500/30 transition-all group-hover:w-1.5 group-hover:bg-violet-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-violet-500 transition-colors">Managers</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-violet-50 text-violet-500 text-sm ring-1 ring-violet-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalAdmins) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-violet-400"></span> auth_level_0
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Materi --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-emerald-200 hover:shadow-[0_8px_25px_-5px_rgba(16,185,129,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-emerald-50 transition-all group-hover:bg-emerald-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-emerald-500/30 transition-all group-hover:w-1.5 group-hover:bg-emerald-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-emerald-500 transition-colors">Core Modules</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 text-sm ring-1 ring-emerald-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalMainMateris) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> structure_base
                    </div>
                </div>
            </div>
        </div>

        {{-- Materi --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-amber-200 hover:shadow-[0_8px_25px_-5px_rgba(245,158,11,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-amber-50 transition-all group-hover:bg-amber-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-amber-500/30 transition-all group-hover:w-1.5 group-hover:bg-amber-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-amber-500 transition-colors">Chapters</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-amber-50 text-amber-500 text-sm ring-1 ring-amber-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalMateris) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span> sub_directories
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ═══════════════════════════════════════════════════
         Row 2 : Sub-Materi breakdown (Light HUD Style)
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-6 sm:grid-cols-3">
        
        <div class="sm:col-span-1 rounded-3xl bg-grid-pattern-box relative border border-zinc-200 p-8 flex flex-col justify-center shadow-sm" data-dm-card>
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 mb-3 relative z-10">Content Depth</p>
            <h2 class="text-5xl font-black tracking-tighter text-zinc-800 relative z-10">{{ number_format($totalSubMateris) }}</h2>
            <div class="mt-5 flex items-center gap-3 relative z-10">
                <div class="h-2.5 w-2.5 rounded-sm border border-sky-300 animate-pulse bg-sky-400"></div>
                <p class="text-xs font-medium text-zinc-500 uppercase tracking-wide">Total Sub-Materi nodes</p>
            </div>
        </div>

        <div class="sm:col-span-2 rounded-3xl border border-zinc-200 p-8 relative overflow-hidden flex flex-col justify-between shadow-inner" data-dm-panel>
            <!-- Grid Background Overlay -->
            <div class="absolute inset-0" data-dm-grid></div>
            
            <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 mb-6 relative z-10 inline-block px-2 rounded backdrop-blur max-w-max" data-dm-label>State Distribution</p>
            
            <div class="flex items-center gap-10 relative z-10 w-full">
                <!-- Published Metric -->
                <div class="flex-1 space-y-4">
                    <div class="flex justify-between items-end">
                        <div class="flex items-center gap-3">
                            <span class="text-lg text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                            <div>
                                <span class="text-2xl font-bold text-green-600 block leading-none">{{ number_format($publishedSubMateris) }}</span>
                                <span class="text-[9px] font-bold tracking-widest uppercase text-green-500/70">Published Nodes</span>
                            </div>
                        </div>
                        @if($totalSubMateris > 0)
                            <span class="text-xs font-black text-green-600 tracking-tighter">{{ round($publishedSubMateris / $totalSubMateris * 100) }}%</span>
                        @endif
                    </div>
                    <!-- Light HUD Segmented Bar -->
                    <div class="h-2 w-full bg-zinc-200/50 flex overflow-hidden rounded-sm">
                        @if($totalSubMateris > 0)
                            @for($i = 0; $i < 20; $i++)
                                <div class="flex-1 border-r border-zinc-100/50 h-full {{ $i < ($publishedSubMateris / $totalSubMateris * 20) ? 'bg-green-400' : 'bg-transparent' }}"></div>
                            @endfor
                        @endif
                    </div>
                </div>

                <div class="w-px h-16 bg-zinc-300"></div>

                <!-- Drafts Metric -->
                <div class="flex-1 space-y-4">
                    <div class="flex justify-between items-end">
                        <div class="flex items-center gap-3">
                            <span class="text-lg text-orange-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9.75a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/></svg></span>
                            <div>
                                <span class="text-2xl font-bold text-orange-500 block leading-none">{{ number_format($draftSubMateris) }}</span>
                                <span class="text-[9px] font-bold tracking-widest uppercase text-orange-500/70">WIP Drafts</span>
                            </div>
                        </div>
                        @if($totalSubMateris > 0)
                            <span class="text-xs font-black text-orange-500 tracking-tighter">{{ round($draftSubMateris / $totalSubMateris * 100) }}%</span>
                        @endif
                    </div>
                    <!-- Light HUD Segmented Bar -->
                    <div class="h-2 w-full bg-zinc-200/50 flex overflow-hidden rounded-sm">
                        @if($totalSubMateris > 0)
                            @for($i = 0; $i < 20; $i++)
                                <div class="flex-1 border-r border-zinc-100/50 h-full {{ $i < ($draftSubMateris / $totalSubMateris * 20) ? 'bg-orange-400' : 'bg-transparent' }}"></div>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         System Status & Additional Metrics
    ═══════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Pendaftar Baru --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm relative overflow-hidden flex items-center justify-between group transition-all hover:shadow-md" data-dm-card>
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors" data-dm-glow-emerald></div>
            <div class="relative z-10">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1">Pendaftar Baru</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-zinc-800 tracking-tighter">{{ number_format($newUsersThisWeek) }}</h3>
                    <span class="text-xs font-semibold text-zinc-400">Minggu Ini</span>
                </div>
            </div>
            <div class="relative z-10 w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform" data-dm-icon-emerald>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
            </div>
        </div>

        {{-- Siswa Lulus Kuis --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm relative overflow-hidden flex items-center justify-between group transition-all hover:shadow-md" data-dm-card>
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-50 rounded-full blur-2xl group-hover:bg-violet-100 transition-colors" data-dm-glow-violet></div>
            <div class="relative z-10">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1">Total Lulus Kuis</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-zinc-800 tracking-tighter">{{ number_format($quizPassedCount) }}</h3>
                    <span class="text-xs font-semibold text-zinc-400">Passed</span>
                </div>
            </div>
            <div class="relative z-10 w-12 h-12 rounded-2xl bg-violet-50 border border-violet-100 flex items-center justify-center text-violet-500 group-hover:scale-110 transition-transform" data-dm-icon-violet>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 0014.476 0l-.426-3.834A2.031 2.031 0 0016.273 4.5h-8.546a2.03 2.03 0 00-2.037 1.813l-.43 3.834zM12 18.75v-10.5m0 0L9.75 10.5m2.25-2.25L14.25 10.5M4.5 12h15m-15 0a3.375 3.375 0 00-3.375 3.375v1.5c0 1.864 1.512 3.375 3.375 3.375h15a3.375 3.375 0 003.375-3.375v-1.5a3.375 3.375 0 00-3.375-3.375H4.5z" /></svg>
            </div>
        </div>
        
        {{-- Laporan Masalah --}}
        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm relative overflow-hidden flex items-center justify-between group transition-all hover:shadow-md" data-dm-card>
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full blur-2xl group-hover:bg-rose-100 transition-colors" data-dm-glow-rose></div>
            <div class="relative z-10">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1">Total Laporan</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black text-zinc-800 tracking-tighter">{{ number_format($totalReports) }}</h3>
                    <span class="text-xs font-semibold text-zinc-400">Issues</span>
                </div>
            </div>
            <div class="relative z-10 w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-500 group-hover:scale-110 transition-transform" data-dm-icon-rose>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a14.267 14.267 0 014.62 0l2.67.668a12.024 12.024 0 003.96 0L21 14.25v-9.58A14.27 14.27 0 0016.38 4L13.71 3.332a12.024 12.024 0 01-3.96 0L6.98 4.025a14.27 14.27 0 00-3.98.65V4.5M3 15V4.5z" /></svg>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         Bottom section : Top Lists Terminal Light Build
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-8 lg:grid-cols-3">

        {{-- Top Materi List --}}
        <div class="rounded-3xl border border-zinc-200 bg-grid-pattern-box shadow-sm overflow-hidden flex flex-col" data-dm-card>
            <div class="border-b border-zinc-100 backdrop-blur-sm px-6 py-4" data-dm-header>
                <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-600 flex items-center gap-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-indigo-50 text-indigo-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></span>
                    Heavy Workloads (Top Modules)
                </h2>
            </div>
            
            <div class="p-6 flex-1 relative">
                @if($topMateris->isNotEmpty())
                    <ul class="space-y-4">
                        @foreach($topMateris as $index => $materi)
                            <li class="group flex items-center gap-4 py-1">
                                <span class="font-mono text-xs font-bold text-zinc-300 transition-colors group-hover:text-indigo-400 bg-zinc-50 w-6 h-6 flex items-center justify-center rounded ring-1 ring-zinc-200/50">0{{ $index + 1 }}</span>
                                <div class="min-w-0 flex-1 border-b border-zinc-100 pb-1 border-dashed">
                                    <p class="truncate text-sm font-semibold text-zinc-700 transition-colors group-hover:text-indigo-600">{{ $materi->title }}</p>
                                    <p class="text-[10px] uppercase font-mono tracking-wider text-zinc-400">{{ $materi->mainMateri?->title ?? '—' }}</p>
                                </div>
                                <div class="shrink-0 flex flex-col items-end">
                                    <span class="text-sm font-bold text-zinc-700">{{ $materi->sub_materis_count }}</span>
                                    <span class="text-[9px] uppercase font-mono text-zinc-400">Nodes</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-zinc-400 space-y-2">
                        <svg class="h-8 w-8 text-zinc-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-xs font-mono">// No heavy workloads</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Activity Log --}}
        <div class="rounded-3xl border border-zinc-200 bg-grid-pattern-box shadow-sm overflow-hidden flex flex-col" data-dm-card>
            <div class="border-b border-zinc-100 backdrop-blur-sm px-6 py-4 flex justify-between items-center" data-dm-header>
                <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-600 flex items-center gap-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-emerald-50 text-emerald-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                    Activity Log
                </h2>
                <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">Time: {{ date('H:i') }}</span>
            </div>
            
            <div class="p-6 flex-1">
                @if($recentSubMateris->isNotEmpty())
                    <ul class="space-y-4">
                        @foreach($recentSubMateris as $sub)
                            <li class="relative border-l-2 {{ $sub->is_published ? 'border-emerald-400' : 'border-orange-400' }} pl-4 py-1 hover:bg-zinc-50 transition-colors group">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            @if($sub->is_published)
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                                            @else
                                                <span class="h-1.5 w-1.5 rounded-full bg-orange-400 shrink-0"></span>
                                            @endif
                                            <p class="truncate text-sm font-semibold text-zinc-700 transition-colors group-hover:text-zinc-900">{{ $sub->title }}</p>
                                        </div>
                                        <p class="mt-1 text-[10px] font-mono text-zinc-400 uppercase tracking-widest truncate">
                                            {{ $sub->materi?->mainMateri?->title ?? 'sys' }} <span class="text-zinc-300 mx-1">/</span> {{ $sub->materi?->title ?? 'null' }}
                                        </p>
                                    </div>
                                    <div class="shrink-0 flex flex-col items-end gap-1">
                                        <span class="text-[10px] font-medium text-zinc-500 bg-zinc-100 px-2 py-0.5 rounded">
                                            {{ $sub->created_at->format('M d') }}
                                        </span>
                                        <span class="text-[9px] font-mono text-zinc-400">
                                            {{ $sub->created_at->diffForHumans(['short' => true]) }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-zinc-400 space-y-2">
                        <svg class="h-8 w-8 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <p class="text-xs font-mono">await content_insert_event</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Issue Reports --}}
        <div class="rounded-3xl border border-zinc-200 bg-grid-pattern-box shadow-sm overflow-hidden flex flex-col" data-dm-card>
            <div class="border-b border-zinc-100 backdrop-blur-sm px-6 py-4 flex justify-between items-center" data-dm-header>
                <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-600 flex items-center gap-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-rose-50 text-rose-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></span>
                    Issue Reports
                </h2>
                <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest">{{ $pendingReports }} Pending</span>
            </div>
            
            <div class="p-6 flex-1">
                @if($recentReports && $recentReports->isNotEmpty())
                    <ul class="space-y-4">
                        @foreach($recentReports as $report)
                            <li onclick="openReportDetailModal({{ json_encode($report) }})" class="relative border-l-2 {{ $report->status === 'pending' ? 'border-rose-400' : 'border-emerald-400' }} pl-4 py-1 hover:bg-zinc-50 transition-colors group cursor-pointer">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            @if($report->status === 'pending')
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-400 shrink-0 animate-pulse"></span>
                                            @else
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 shrink-0"></span>
                                            @endif
                                            <p class="truncate text-sm font-semibold text-zinc-700 transition-colors group-hover:text-zinc-900">{{ $report->name }}</p>
                                        </div>
                                        <p class="mt-1 text-[10px] font-mono text-zinc-400 uppercase tracking-widest truncate" title="{{ $report->description }}">
                                            {{ $report->user?->name ?? 'Anonim' }} <span class="text-zinc-300 mx-1">/</span> {{ \Illuminate\Support\Str::limit($report->description, 35) }}
                                        </p>
                                    </div>
                                    <div class="shrink-0 flex flex-col items-end gap-1">
                                        @if($report->status === 'pending')
                                            <button onclick="event.stopPropagation(); resolveIssueReport({{ $report->id }}, this)" class="group/btn relative overflow-hidden text-[10px] font-bold text-rose-600 bg-rose-50 hover:bg-emerald-50 hover:text-emerald-600 px-2 py-0.5 rounded transition-all duration-300 min-w-[60px] text-center">
                                                <span class="inline-block transition-opacity duration-300 group-hover/btn:opacity-0">PENDING</span>
                                                <span class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover/btn:opacity-100 tracking-wider">ACCEPT</span>
                                            </button>
                                        @else
                                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded min-w-[60px] text-center">
                                                RESOLVED
                                            </span>
                                        @endif
                                        <span class="text-[9px] font-mono text-zinc-400" title="{{ $report->created_at->format('d M Y H:i:s') }}">
                                            {{ $report->created_at->diffForHumans(['short' => true]) }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-zinc-400 space-y-2">
                        <svg class="h-8 w-8 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs font-mono">no_issues_detected</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         Row 3 : Quiz & Engagement Quick Stats
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Questions Bank --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-cyan-200 hover:shadow-[0_8px_25px_-5px_rgba(6,182,212,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-cyan-50 transition-all group-hover:bg-cyan-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-cyan-500/30 transition-all group-hover:w-1.5 group-hover:bg-cyan-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-cyan-500 transition-colors">Question Bank</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-cyan-50 text-cyan-500 text-sm ring-1 ring-cyan-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalQuestions) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-cyan-400"></span> quiz_questions
                    </div>
                </div>
            </div>
        </div>

        {{-- Quiz Attempts --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-rose-200 hover:shadow-[0_8px_25px_-5px_rgba(244,63,94,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-rose-50 transition-all group-hover:bg-rose-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-rose-500/30 transition-all group-hover:w-1.5 group-hover:bg-rose-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-rose-500 transition-colors">Quiz Attempts</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-rose-50 text-rose-500 text-sm ring-1 ring-rose-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalQuizAttempts) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span> total_submissions
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Views --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-sky-200 hover:shadow-[0_8px_25px_-5px_rgba(14,165,233,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-sky-50 transition-all group-hover:bg-sky-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-sky-500/30 transition-all group-hover:w-1.5 group-hover:bg-sky-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-sky-500 transition-colors">Page Views</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-sky-50 text-sky-500 text-sm ring-1 ring-sky-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalViews) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span> content_impressions
                    </div>
                </div>
            </div>
        </div>

        {{-- Favorites --}}
        <div class="group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:border-pink-200 hover:shadow-[0_8px_25px_-5px_rgba(236,72,153,0.1)] hover:-translate-y-1">
            <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full bg-pink-50 transition-all group-hover:bg-pink-100/60"></div>
            <div class="absolute inset-y-0 left-0 w-1 bg-pink-500/30 transition-all group-hover:w-1.5 group-hover:bg-pink-500"></div>
            <div class="relative z-10 flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400 group-hover:text-pink-500 transition-colors">Bookmarks</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-pink-50 text-pink-500 text-sm ring-1 ring-pink-200/50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg></span>
                </div>
                <div>
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-800">{{ number_format($totalFavorites) }}</h2>
                    <div class="mt-2 text-[10px] font-mono text-zinc-500 flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-pink-400"></span> saved_items
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         Row 4 : Quiz Performance + Top Users
    ═══════════════════════════════════════════════════ --}}
    <div class="grid gap-8 lg:grid-cols-2">

        {{-- Quiz Performance Gauge --}}
        <div class="rounded-3xl border border-zinc-200 shadow-sm overflow-hidden flex flex-col" data-dm-card>
            <div class="border-b border-zinc-100 px-6 py-4" data-dm-header>
                <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-600 flex items-center gap-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-rose-50 text-rose-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg></span>
                    Quiz Performance Overview
                </h2>
            </div>

            <div class="p-6 flex-1">
                @if($totalQuizAttempts > 0)
                    @php
                        $passRate = round($quizPassedCount / $totalQuizAttempts * 100);
                        $failCount = $totalQuizAttempts - $quizPassedCount;
                    @endphp
                    <div class="flex flex-col sm:flex-row items-center gap-6 w-full">
                        {{-- Circular Gauge Container --}}
                        <div class="relative shrink-0 flex flex-col items-center justify-center p-6 rounded-2xl border border-zinc-100/80 w-full sm:w-auto" data-dm-gauge>
                            <div class="relative">
                                <svg class="w-28 h-28 -rotate-90 drop-shadow-sm" viewBox="0 0 120 120">
                                    <circle cx="60" cy="60" r="52" fill="none" stroke="#f4f4f5" stroke-width="12"/>
                                    <circle cx="60" cy="60" r="52" fill="none" stroke="{{ $passRate >= 70 ? '#10b981' : ($passRate >= 40 ? '#f59e0b' : '#ef4444') }}" stroke-width="12" stroke-linecap="round"
                                        stroke-dasharray="{{ $passRate * 3.267 }} {{ 326.7 - $passRate * 3.267 }}"/>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center mt-1">
                                    <span class="text-3xl font-black text-zinc-800 tracking-tighter">{{ $passRate }}<span class="text-lg text-zinc-400 font-bold">%</span></span>
                                </div>
                            </div>
                            <span class="mt-6 text-[10px] font-bold uppercase tracking-widest text-zinc-400 px-4 py-1.5 rounded-full border border-zinc-200 shadow-sm" data-dm-pill>Pass Rate</span>
                        </div>

                        {{-- Stats Breakdown --}}
                        <div class="flex-1 w-full flex flex-col gap-3">
                            <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50/50 border border-emerald-100/50 hover:bg-emerald-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                    <div>
                                        <span class="block text-sm font-bold text-zinc-700">Lulus</span>
                                        <span class="block text-[9px] uppercase font-mono text-zinc-400">Total Passed</span>
                                    </div>
                                </div>
                                <span class="text-lg font-black text-emerald-600">{{ number_format($quizPassedCount) }}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-xl bg-red-50/50 border border-red-100/50 hover:bg-red-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </span>
                                    <div>
                                        <span class="block text-sm font-bold text-zinc-700">Gagal</span>
                                        <span class="block text-[9px] uppercase font-mono text-zinc-400">Total Failed</span>
                                    </div>
                                </div>
                                <span class="text-lg font-black text-red-500">{{ number_format($failCount) }}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-xl bg-zinc-50 border border-zinc-100 hover:bg-zinc-100 transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-200 text-zinc-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></span>
                                    <div>
                                        <span class="block text-sm font-bold text-zinc-700">Skor Rata-rata</span>
                                        <span class="block text-[9px] uppercase font-mono text-zinc-400">Mean Score</span>
                                    </div>
                                </div>
                                <span class="text-lg font-black text-zinc-800">{{ $quizAvgScore }}<span class="text-[10px] text-zinc-400 ml-1">pts</span></span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-zinc-400 space-y-2">
                        <svg class="h-8 w-8 text-zinc-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"></path></svg>
                        <p class="text-xs font-mono">// no quiz attempts yet</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Top Active Users Leaderboard --}}
        <div class="rounded-3xl border border-zinc-200 shadow-sm overflow-hidden flex flex-col" data-dm-card>
            <div class="border-b border-zinc-100 px-6 py-4 flex justify-between items-center" data-dm-header>
                <h2 class="text-xs font-bold uppercase tracking-widest text-zinc-600 flex items-center gap-3">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-amber-50 text-amber-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0016.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.003 6.003 0 01-3.77 1.523m3.77-1.523V14.25M14.52 9.728a6.003 6.003 0 01-3.77-1.523m0 0V14.25"/></svg></span>
                    Top Active Users
                </h2>
                <span class="text-[9px] font-mono text-zinc-400 uppercase tracking-widest bg-amber-50 text-amber-600 px-2 py-0.5 rounded">EXP Rank</span>
            </div>

            <div class="p-6 flex-1">
                @if($topActiveUsers->isNotEmpty())
                    <ul class="space-y-3">
                        @foreach($topActiveUsers as $index => $activeUser)
                            @php
                                $medals = ['🥇', '🥈', '🥉'];
                                $rankColors = ['text-amber-500', 'text-zinc-400', 'text-orange-400'];
                            @endphp
                            <li class="group flex items-center gap-4 py-2 px-3 rounded-xl hover:bg-zinc-50 transition-colors">
                                {{-- Rank --}}
                                <span class="shrink-0 w-7 text-center text-lg leading-none">
                                    @if($index < 3)
                                        {{ $medals[$index] }}
                                    @else
                                        <span class="font-mono text-xs font-bold text-zinc-300">#{{ $index + 1 }}</span>
                                    @endif
                                </span>

                                {{-- Avatar --}}
                                <div class="shrink-0 w-9 h-9 rounded-full overflow-hidden ring-2 {{ $index === 0 ? 'ring-amber-300' : 'ring-zinc-200' }}">
                                    <img src="{{ $activeUser->avatar ? asset('storage/' . $activeUser->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($activeUser->name) . '&background=1C1C1E&color=ffffff&size=80' }}"
                                         alt="{{ $activeUser->name }}" class="w-full h-full object-cover">
                                </div>

                                {{-- Name + Emblem --}}
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-1.5">
                                        <p class="truncate text-sm font-semibold text-zinc-700 group-hover:text-zinc-900 transition-colors">{{ $activeUser->name }}</p>
                                        <img src="{{ asset('assets/ico/' . $activeUser->emblem_image) }}" alt="{{ $activeUser->rank_name }}" class="w-5 h-5 object-contain shrink-0" title="{{ $activeUser->rank_name }}">
                                    </div>
                                    <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">{{ $activeUser->rank_name }}</p>
                                    @if(isset($achievements[$activeUser->id]))
                                        <div class="flex items-center gap-1 mt-1 flex-wrap">
                                            @foreach($achievements[$activeUser->id] as $ach)
                                                <span class="inline-flex items-center gap-0.5 bg-amber-50 border border-amber-100 rounded-full px-1.5 py-0.5 text-[9px] font-bold text-amber-700">
                                                    <img src="{{ asset('assets/ico/' . $ach['icon']) }}" alt="{{ $ach['label'] }}" class="w-3 h-3 object-contain">
                                                    {{ $ach['label'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- EXP --}}
                                <div class="shrink-0 text-right">
                                    <span class="text-sm font-black text-zinc-700">{{ number_format($activeUser->exp) }}</span>
                                    <span class="block text-[9px] uppercase font-mono text-zinc-400">EXP</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="flex flex-col items-center justify-center h-full text-zinc-400 space-y-2">
                        <svg class="h-8 w-8 text-zinc-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path></svg>
                        <p class="text-xs font-mono">// no active participants yet</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════
         Bottom / Footer Metric Bar
    ═══════════════════════════════════════════════════ --}}
    <div class="rounded-2xl border border-zinc-200 bg-grid-pattern-box p-6 shadow-sm overflow-hidden relative" data-dm-card>
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-50/50 via-white to-zinc-50/50 opacity-90 blur-xl"></div>
        <div class="relative z-10 flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-100 border border-zinc-200 text-zinc-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-800">Platform Overview</h3>
                    <p class="mt-0.5 text-[10px] font-mono text-zinc-500">Total cumulative platform size</p>
                </div>
            </div>
            
            <div class="flex gap-8">
                <div class="text-right">
                    <p class="text-[10px] font-bold text-zinc-400 mb-1 uppercase tracking-widest">Total Records</p>
                    <p class="text-2xl font-black text-zinc-800 leading-none">{{ number_format($totalMainMateris + $totalMateris + $totalSubMateris) }} <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest align-top">Rows</span></p>
                </div>
                <div class="w-px bg-zinc-150 border-l border-zinc-200/50 border-dashed"></div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-zinc-400 mb-1 uppercase tracking-widest">Depth Ratio</p>
                    @php $avgSubPerMateri = $totalMateris > 0 ? round($totalSubMateris / $totalMateris, 1) : 0; @endphp
                    <p class="text-2xl font-black text-zinc-800 leading-none">{{ $avgSubPerMateri }} <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest align-top">Avg</span></p>
                </div>
                <div class="w-px bg-zinc-150 border-l border-zinc-200/50 border-dashed"></div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-zinc-400 mb-1 uppercase tracking-widest">New Users (7d)</p>
                    <p class="text-2xl font-black text-zinc-800 leading-none">{{ number_format($newUsersThisWeek) }} <span class="text-[10px] font-bold {{ $newUsersThisWeek > 0 ? 'text-emerald-500' : 'text-zinc-400' }} uppercase tracking-widest align-top">{{ $newUsersThisWeek > 0 ? '↑' : '—' }}</span></p>
                </div>
                <div class="w-px bg-zinc-150 border-l border-zinc-200/50 border-dashed"></div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-zinc-400 mb-1 uppercase tracking-widest">Issue Reports</p>
                    <p class="text-2xl font-black text-zinc-800 leading-none">{{ number_format($totalReports ?? 0) }} <span class="text-[10px] font-bold {{ ($pendingReports ?? 0) > 0 ? 'text-red-500' : 'text-zinc-400' }} uppercase tracking-widest align-top">{{ ($pendingReports ?? 0) > 0 ? ($pendingReports . ' Pending') : 'All Cleared' }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Detail Modal -->
    <div id="report-detail-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeReportDetailModal()"></div>
        <div class="relative bg-white border border-zinc-200 shadow-2xl rounded-3xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300 p-6 flex flex-col gap-4 m-4 max-h-[90vh] overflow-y-auto">
            <!-- Close button -->
            <button onclick="closeReportDetailModal()" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-700 bg-zinc-100 hover:bg-zinc-200 rounded-full p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <div class="flex items-center gap-3 border-b border-zinc-100 pb-4 pr-8">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-zinc-100 shrink-0">
                    <img id="rd-avatar" src="" alt="Avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 id="rd-user-name" class="font-bold text-zinc-800 leading-tight"></h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span id="rd-user-role" class="text-[9px] uppercase tracking-widest font-bold px-2 py-0.5 rounded bg-zinc-100 text-zinc-500"></span>
                        <span id="rd-user-email" class="text-[10px] font-mono text-zinc-500"></span>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1">Issue Title</p>
                <h4 id="rd-issue-title" class="font-semibold text-zinc-800 text-lg"></h4>
            </div>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1">Description</p>
                <p id="rd-issue-desc" class="text-sm text-zinc-600 leading-relaxed whitespace-pre-wrap bg-zinc-50 p-4 rounded-xl border border-zinc-100"></p>
            </div>

            <div id="rd-image-container" class="hidden mt-2">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-2">Attachment</p>
                <a id="rd-image-link" href="#" target="_blank" class="block rounded-xl overflow-hidden border border-zinc-200 hover:border-indigo-300 transition-colors bg-zinc-50 flex items-center justify-center min-h-[100px]">
                    <img id="rd-image" src="" alt="Report Attachment" class="w-full object-cover max-h-64">
                </a>
            </div>
        </div>
    </div></div>



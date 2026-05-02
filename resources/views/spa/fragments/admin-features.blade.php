<div class="spa-fragment" id="fragment-admin-features">
    {{-- Glassmorphic Header --}}
    <div class="mb-8 rounded-[32px] border border-zinc-200/80 bg-white/60 dark:border-zinc-800/80 dark:bg-zinc-900/60 p-8 backdrop-blur-2xl shadow-sm relative overflow-hidden transition-all duration-300">
        {{-- Decorative glowing orbs --}}
        <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-gradient-to-br from-indigo-500/20 to-purple-500/20 blur-3xl dark:from-indigo-500/10 dark:to-purple-500/10"></div>
        <div class="absolute -left-20 -bottom-20 h-72 w-72 rounded-full bg-gradient-to-tr from-emerald-500/20 to-teal-500/20 blur-3xl dark:from-emerald-500/10 dark:to-teal-500/10"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white shadow-[0_8px_20px_rgba(99,102,241,0.3)] shrink-0">
                    <i class="bx bx-slider-alt text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-zinc-900 dark:text-white">Manajemen Fitur</h1>
                    <p class="mt-1.5 text-[13px] font-medium text-zinc-500 dark:text-zinc-400 max-w-xl leading-relaxed">
                        Pusat kendali akses modul pengguna. Aktifkan atau nonaktifkan menu secara real-time tanpa perlu deployment ulang.
                    </p>
                </div>
            </div>
            <div class="shrink-0 flex items-center gap-3">
                <button type="button" onclick="loadPage('features')" class="flex items-center gap-2 h-11 px-5 rounded-xl bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 shadow-sm ring-1 ring-zinc-200/80 dark:ring-zinc-700/80 transition-all hover:bg-zinc-50 hover:text-indigo-600 dark:hover:bg-zinc-700 dark:hover:text-indigo-400 font-semibold text-[13px]">
                    <i class="bx bx-refresh text-lg"></i>
                    <span>Refresh Data</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Main Content area --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $features = [
                'menu_schedule' => ['icon' => 'bx-calendar', 'color' => 'blue', 'title' => 'Jadwal Belajar', 'desc' => 'Modul untuk melihat dan mengatur jadwal materi mingguan.'],
                'menu_favorites' => ['icon' => 'bx-star', 'color' => 'yellow', 'title' => 'Materi Favorit', 'desc' => 'Fitur bookmark agar user dapat menyimpan materi favorit.'],
                'menu_history' => ['icon' => 'bx-history', 'color' => 'orange', 'title' => 'Riwayat', 'desc' => 'Pencatatan rekam jejak akses materi dan aktivitas terbaru.'],
                'menu_notes' => ['icon' => 'bx-notepad', 'color' => 'teal', 'title' => 'Catatan Pribadi', 'desc' => 'Buku catatan digital yang terintegrasi dengan modul belajar.'],
                'menu_missions' => ['icon' => 'bx-target-lock', 'color' => 'red', 'title' => 'Misi Harian', 'desc' => 'Sistem quest, achievement, dan hadiah klaim harian.'],
                'menu_achievements' => ['icon' => 'bx-trophy', 'color' => 'amber', 'title' => 'Pencapaian', 'desc' => 'Lencana penghargaan dan sistem trofi koleksi pengguna.'],
                'menu_leaderboard' => ['icon' => 'bx-bar-chart', 'color' => 'emerald', 'title' => 'Leaderboard', 'desc' => 'Papan peringkat kompetitif global berdasarkan perolehan EXP.'],
                'menu_clans' => ['icon' => 'bx-shield-quarter', 'color' => 'indigo', 'title' => 'Sistem Guild', 'desc' => 'Modul klan dan guild komunitas untuk interaksi sosial.'],
                'menu_shop' => ['icon' => 'bx-store', 'color' => 'purple', 'title' => 'Reward Shop', 'desc' => 'Toko penukaran koin dengan item virtual (Avatar, Banner).'],
                'menu_analytics' => ['icon' => 'bx-bar-chart-alt-2', 'color' => 'sky', 'title' => 'Analitik Belajar', 'desc' => 'Grafik dan statistik performa progres pembelajaran personal.'],
                'menu_secret_lab' => ['icon' => 'bxs-flask', 'color' => 'rose', 'title' => 'Secret Lab', 'desc' => 'Area fitur eksperimental khusus untuk user Elite / Sovereign.'],
            ];
            
            // Map colors to tailwind classes (supporting dark mode)
            $colorMap = [
                'blue' => 'text-blue-500 bg-blue-50 dark:bg-blue-500/10 dark:text-blue-400',
                'yellow' => 'text-yellow-600 bg-yellow-50 dark:bg-yellow-500/10 dark:text-yellow-400',
                'orange' => 'text-orange-500 bg-orange-50 dark:bg-orange-500/10 dark:text-orange-400',
                'teal' => 'text-teal-500 bg-teal-50 dark:bg-teal-500/10 dark:text-teal-400',
                'red' => 'text-red-500 bg-red-50 dark:bg-red-500/10 dark:text-red-400',
                'amber' => 'text-amber-500 bg-amber-50 dark:bg-amber-500/10 dark:text-amber-400',
                'emerald' => 'text-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 dark:text-emerald-400',
                'indigo' => 'text-indigo-500 bg-indigo-50 dark:bg-indigo-500/10 dark:text-indigo-400',
                'purple' => 'text-purple-500 bg-purple-50 dark:bg-purple-500/10 dark:text-purple-400',
                'sky' => 'text-sky-500 bg-sky-50 dark:bg-sky-500/10 dark:text-sky-400',
                'rose' => 'text-rose-500 bg-rose-50 dark:bg-rose-500/10 dark:text-rose-400',
            ];
        @endphp

        @foreach($features as $key => $data)
            @php 
                $isActive = \App\Models\FeatureToggle::isActive($key);
                $colorClasses = $colorMap[$data['color']];
            @endphp
            <div class="rounded-[24px] border border-zinc-200/80 bg-white dark:border-zinc-800/80 dark:bg-zinc-900 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-zinc-200/50 dark:hover:shadow-none dark:hover:border-zinc-700 relative overflow-hidden group">
                
                {{-- Decorative background gradient on hover --}}
                <div class="absolute inset-0 bg-gradient-to-br from-zinc-50 to-transparent dark:from-zinc-800/50 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                <div class="relative flex items-start justify-between mb-5">
                    <div class="flex h-14 w-14 items-center justify-center rounded-[16px] {{ $colorClasses }} transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3 shadow-inner">
                        <i class="bx {{ $data['icon'] }} text-2xl"></i>
                    </div>
                    
                    {{-- Premium iOS-like Toggle Switch --}}
                    <label class="relative inline-flex items-center cursor-pointer mt-1">
                        <input type="checkbox" class="sr-only peer feature-toggle-input" data-feature="{{ $key }}" {{ $isActive ? 'checked' : '' }}>
                        <div class="w-[46px] h-[26px] bg-zinc-200 dark:bg-zinc-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-[20px] peer-checked:after:border-white after:content-[''] after:absolute after:top-[3px] after:left-[3px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-[20px] after:w-[20px] after:transition-all duration-300 peer-checked:bg-emerald-500 shadow-inner"></div>
                    </label>
                </div>
                
                <div class="relative">
                    <h3 class="text-[16px] font-bold text-zinc-900 dark:text-white mb-2">{{ $data['title'] }}</h3>
                    <p class="text-[13px] font-medium text-zinc-500 dark:text-zinc-400 leading-relaxed min-h-[40px]">{{ $data['desc'] }}</p>
                    
                    {{-- Status Badge --}}
                    <div class="mt-5 flex items-center gap-2.5">
                        <div class="relative flex h-2.5 w-2.5 items-center justify-center">
                            <span class="absolute inline-flex h-full w-full rounded-full {{ $isActive ? 'bg-emerald-400 animate-ping opacity-75' : 'bg-transparent' }} status-ping-{{ $key }}"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 {{ $isActive ? 'bg-emerald-500' : 'bg-zinc-300 dark:bg-zinc-600' }} status-indicator-{{ $key }} transition-colors duration-300"></span>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-widest {{ $isActive ? 'text-emerald-600 dark:text-emerald-400' : 'text-zinc-400 dark:text-zinc-500' }} status-text-{{ $key }} transition-colors duration-300">
                            {{ $isActive ? 'Sistem Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>



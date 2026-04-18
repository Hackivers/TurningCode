<div class="space-y-6 animate-fade-in relative" id="db-schema-root">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 tracking-tight">Struktur Database</h2>
            <p class="text-sm text-zinc-500 mt-1">
                {{ count($schema) }} tabel ditemukan &mdash; klik untuk melihat detail kolom dan relasi.
            </p>
        </div>
        
        <div class="flex items-center gap-3">
            {{-- Search --}}
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                <input type="text" id="db-search" placeholder="Cari tabel..." class="w-full md:w-56 pl-9 pr-4 py-2.5 bg-white border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10 focus:border-zinc-400 transition-all">
            </div>

            {{-- View Toggle --}}
            <div class="flex items-center bg-zinc-100 rounded-xl p-1 gap-0.5">
                <button type="button" id="db-view-list" class="db-view-btn active flex items-center justify-center w-9 h-9 rounded-lg transition-all text-zinc-400 [&.active]:bg-white [&.active]:text-zinc-900 [&.active]:shadow-sm" title="Tampilan List">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <button type="button" id="db-view-grid" class="db-view-btn flex items-center justify-center w-9 h-9 rounded-lg transition-all text-zinc-400 [&.active]:bg-white [&.active]:text-zinc-900 [&.active]:shadow-sm" title="Tampilan Grid">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Table List / Grid Container --}}
    <div id="db-cards-container" class="db-list-view flex flex-col gap-4">
        @foreach($schema as $tableName => $tableData)
        @php
            $fkCount = count($tableData['foreign_keys']);
            $colCount = count($tableData['columns']);
            $indexCount = count($tableData['indexes']);
        @endphp
        <div class="db-table-card relative bg-white bg-grid-pattern-box rounded-2xl border border-zinc-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200" data-table="{{ strtolower($tableName) }}">
            
            {{-- Table Header (Accordion Trigger) --}}
            <div class="db-accordion-trigger px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-zinc-50/80 transition-colors select-none">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-zinc-100 flex items-center justify-center text-zinc-500 shrink-0">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-zinc-900 truncate">{{ $tableName }}</h3>
                        <div class="flex items-center gap-3 mt-0.5">
                            <span class="text-[11px] font-medium text-zinc-400">{{ $colCount }} kolom</span>
                            @if($fkCount > 0)
                                <span class="text-[11px] font-medium text-indigo-500">{{ $fkCount }} relasi</span>
                            @endif
                            @if($indexCount > 0)
                                <span class="text-[11px] font-medium text-amber-500">{{ $indexCount }} index</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Grid-only: mini stats --}}
                <div class="db-grid-stats hidden flex-col items-end gap-1">
                    <span class="inline-flex items-center rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-semibold text-zinc-600">{{ $colCount }} col</span>
                    @if($fkCount > 0)
                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-[10px] font-semibold text-indigo-600">{{ $fkCount }} FK</span>
                    @endif
                </div>

                {{-- List-only: arrow --}}
                <svg class="db-list-arrow w-5 h-5 text-zinc-300 transition-transform duration-300 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

            {{-- Table Body (Accordion Content) --}}
            <div class="db-accordion-content hidden border-t border-zinc-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-600">
                        <thead class="bg-zinc-50/80 text-[11px] uppercase tracking-wider text-zinc-400 font-semibold border-b border-zinc-100">
                            <tr>
                                <th class="px-5 py-2.5">#</th>
                                <th class="px-5 py-2.5">Nama Kolom</th>
                                <th class="px-5 py-2.5">Tipe Data</th>
                                <th class="px-5 py-2.5">Atribut</th>
                                <th class="px-5 py-2.5">Relasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-50">
                            @foreach($tableData['columns'] as $idx => $col)
                                @php
                                    $fkMatch = null;
                                    foreach($tableData['foreign_keys'] as $fk) {
                                        if (in_array($col['name'], $fk['columns'])) {
                                            $fkMatch = $fk;
                                            break;
                                        }
                                    }
                                @endphp
                                <tr class="hover:bg-zinc-50/60 transition-colors">
                                    <td class="px-5 py-2.5 text-zinc-300 text-xs font-mono">{{ $idx + 1 }}</td>
                                    <td class="px-5 py-2.5">
                                        <span class="font-semibold text-zinc-900 text-[13px]">{{ $col['name'] }}</span>
                                    </td>
                                    <td class="px-5 py-2.5">
                                        <code class="inline-flex items-center rounded-md bg-zinc-100 px-2 py-0.5 text-xs font-mono text-zinc-600 ring-1 ring-inset ring-zinc-200/60">{{ $col['type'] }}</code>
                                    </td>
                                    <td class="px-5 py-2.5">
                                        <div class="flex flex-wrap gap-1">
                                            @if($col['auto_increment'])
                                                <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 border border-amber-100">AI</span>
                                            @endif
                                            @if($col['nullable'])
                                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 border border-emerald-100">NULL</span>
                                            @endif
                                            @if($col['default'] !== null && $col['default'] !== '')
                                                <span class="inline-flex items-center rounded-full bg-sky-50 px-2 py-0.5 text-[10px] font-semibold text-sky-700 border border-sky-100" title="Default: {{ $col['default'] }}">DEF</span>
                                            @endif
                                            @if(!$col['nullable'] && !$col['auto_increment'] && ($col['default'] === null || $col['default'] === ''))
                                                <span class="text-zinc-300 text-xs">—</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-2.5">
                                        @if(in_array($col['name'], ['id']))
                                            <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 px-2 py-1 text-[11px] font-bold text-amber-700 ring-1 ring-inset ring-amber-200/60">
                                                🔑 PK
                                            </span>
                                        @elseif($fkMatch)
                                            <span class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-2 py-1 text-[11px] font-bold text-indigo-700 ring-1 ring-inset ring-indigo-200/60">
                                                🔗 {{ $fkMatch['foreign_table'] }}.{{ implode(',', $fkMatch['foreign_columns']) }}
                                            </span>
                                        @else
                                            <span class="text-zinc-300 text-xs">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Foreign Keys Summary --}}
                @if(count($tableData['foreign_keys']) > 0)
                <div class="px-5 py-3 bg-indigo-50/40 border-t border-indigo-100/50">
                    <p class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider mb-2">Foreign Keys</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tableData['foreign_keys'] as $fk)
                            <div class="inline-flex items-center gap-1.5 bg-white rounded-lg px-3 py-1.5 text-xs border border-indigo-100 shadow-sm">
                                <span class="font-mono font-semibold text-zinc-700">{{ implode(', ', $fk['columns']) }}</span>
                                <svg class="w-3 h-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                <span class="font-mono font-semibold text-indigo-600">{{ $fk['foreign_table'] }}.{{ implode(',', $fk['foreign_columns']) }}</span>
                                <span class="text-[9px] text-zinc-400 ml-1">({{ $fk['on_delete'] }})</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

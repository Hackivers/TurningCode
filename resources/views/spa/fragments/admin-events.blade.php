<div class="spa-fragment space-y-8">

    {{-- ═══ HEADER ═══ --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-zinc-800">Event Management</h1>
            <p class="mt-1 text-xs font-medium text-zinc-400">Kelola event EXP Multiplier untuk meningkatkan retensi user.</p>
        </div>
        <button onclick="openAddEventModal()" class="inline-flex items-center gap-2 rounded-2xl bg-[#1C1C1E] px-5 py-2.5 text-xs font-semibold text-white transition-all hover:bg-zinc-800 shadow-md shadow-zinc-900/10 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Event
        </button>
    </div>

    {{-- ═══ ALERT ═══ --}}
    <div id="event-alert" style="display:none;" class="rounded-2xl px-5 py-3 text-sm font-semibold"></div>

    {{-- ═══ EVENT CARDS GRID ═══ --}}
    <div id="events-grid" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($events as $ev)
            <div class="event-card group relative overflow-hidden rounded-3xl bg-white border border-zinc-200 p-6 shadow-[0_2px_15px_-4px_rgba(0,0,0,0.03)] transition-all duration-300 hover:shadow-[0_8px_25px_-5px_rgba(99,102,241,0.1)] hover:-translate-y-1"
                 id="event-card-{{ $ev->id }}" data-dm-card>
                {{-- Left accent bar --}}
                <div class="absolute inset-y-0 left-0 w-1 {{ $ev->is_ongoing ? 'bg-blue-500' : ($ev->is_active ? 'bg-emerald-500/30 group-hover:bg-emerald-500' : 'bg-red-500/30 group-hover:bg-red-500') }} transition-all group-hover:w-1.5"></div>
                {{-- Decorative circle --}}
                <div class="absolute -top-12 -right-12 h-32 w-32 rounded-full {{ $ev->is_ongoing ? 'bg-blue-50' : ($ev->is_active ? 'bg-emerald-50' : 'bg-red-50') }} transition-all group-hover:scale-110"></div>

                {{-- Status badge --}}
                @if($ev->is_ongoing)
                    <div class="absolute top-4 right-4 z-10">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 border border-blue-200/50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest text-blue-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500 animate-pulse"></span> Live
                        </span>
                    </div>
                @elseif(!$ev->is_active)
                    <div class="absolute top-4 right-4 z-10">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 border border-red-200/50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest text-red-500">
                            Nonaktif
                        </span>
                    </div>
                @endif

                <div class="relative z-10 flex flex-col gap-5">
                    {{-- Multiplier + Title --}}
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-500 text-white text-lg font-black shadow-md shadow-indigo-500/20">
                            x{{ $ev->multiplier }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="truncate text-base font-bold text-zinc-800">{{ $ev->title }}</h3>
                            <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest mt-0.5">exp_multiplier_event</p>
                        </div>
                    </div>

                    {{-- Description --}}
                    <p class="text-xs text-zinc-500 leading-relaxed line-clamp-2">
                        {{ $ev->description ?: 'Tidak ada deskripsi.' }}
                    </p>

                    {{-- Time range --}}
                    <div class="flex items-center gap-2 text-[10px] font-medium text-zinc-400 bg-zinc-50 rounded-xl px-3 py-2 border border-zinc-100">
                        <svg class="w-3.5 h-3.5 text-zinc-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ \Carbon\Carbon::parse($ev->start_time)->format('d M Y, H:i') }} — {{ \Carbon\Carbon::parse($ev->end_time)->format('d M Y, H:i') }}</span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2 pt-1">
                        <button onclick="openEditEventModal({{ $ev->id }}, '{{ addslashes($ev->title) }}', '{{ addslashes($ev->description) }}', {{ $ev->multiplier }}, '{{ \Carbon\Carbon::parse($ev->start_time)->format('Y-m-d\TH:i') }}', '{{ \Carbon\Carbon::parse($ev->end_time)->format('Y-m-d\TH:i') }}', {{ $ev->is_active ? 'true' : 'false' }})"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-zinc-100 border border-zinc-200/50 px-3 py-2.5 text-[11px] font-semibold text-zinc-600 transition-all hover:bg-zinc-200 hover:text-zinc-800">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            Edit
                        </button>
                        <button onclick="deleteEvent({{ $ev->id }})"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-red-50 border border-red-100/50 px-3 py-2.5 text-[11px] font-semibold text-red-500 transition-all hover:bg-red-100 hover:text-red-600">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div id="events-empty" class="sm:col-span-2 lg:col-span-3 rounded-3xl border border-zinc-200 bg-white p-12 text-center shadow-sm" data-dm-card>
                <svg class="mx-auto h-10 w-10 text-zinc-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <p class="text-xs font-mono text-zinc-400">// no_active_events</p>
                <p class="text-sm text-zinc-500 mt-1">Belum ada event EXP Multiplier.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- ═══ MODAL: ADD EVENT ═══ --}}
<div id="add-event-modal" class="fixed inset-0 z-[500] hidden items-center justify-center">
    <div class="absolute inset-0 bg-zinc-900/40 backdrop-blur-sm" onclick="closeAddEventModal()"></div>
    <div class="relative z-10 w-full max-w-md rounded-3xl bg-white border border-zinc-200 p-7 shadow-2xl m-4 max-h-[90vh] overflow-y-auto" data-dm-card>
        <button onclick="closeAddEventModal()" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-700 bg-zinc-100 hover:bg-zinc-200 rounded-full p-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <h2 class="text-lg font-black text-zinc-800 mb-6">Tambah Event</h2>
        <form id="add-event-form" onsubmit="submitAddEvent(event)" class="space-y-4">
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Judul Event</label>
                <input type="text" name="title" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all resize-none"></textarea>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Multiplier (x)</label>
                <input type="number" step="0.1" min="1" name="multiplier" value="1.5" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Waktu Mulai</label>
                    <input type="datetime-local" name="start_time" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Waktu Selesai</label>
                    <input type="datetime-local" name="end_time" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                </div>
            </div>
            <div>
                <label class="flex items-center gap-2.5 text-xs font-semibold text-zinc-600 cursor-pointer select-none py-1">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-zinc-300 text-indigo-500 focus:ring-indigo-400">
                    Aktifkan Event
                </label>
            </div>
            <button type="submit" id="btn-add-submit" class="w-full rounded-2xl bg-[#1C1C1E] px-5 py-3 text-xs font-semibold text-white transition-all hover:bg-zinc-800 shadow-md shadow-zinc-900/10 mt-2">
                Simpan Event
            </button>
        </form>
    </div>
</div>

{{-- ═══ MODAL: EDIT EVENT ═══ --}}
<div id="edit-event-modal" class="fixed inset-0 z-[500] hidden items-center justify-center">
    <div class="absolute inset-0 bg-zinc-900/40 backdrop-blur-sm" onclick="closeEditEventModal()"></div>
    <div class="relative z-10 w-full max-w-md rounded-3xl bg-white border border-zinc-200 p-7 shadow-2xl m-4 max-h-[90vh] overflow-y-auto" data-dm-card>
        <button onclick="closeEditEventModal()" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-700 bg-zinc-100 hover:bg-zinc-200 rounded-full p-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <h2 class="text-lg font-black text-zinc-800 mb-6">Edit Event</h2>
        <form id="edit-event-form" onsubmit="submitEditEvent(event)" class="space-y-4">
            <input type="hidden" id="edit-event-id">
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Judul Event</label>
                <input type="text" name="title" id="edit-title" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Deskripsi</label>
                <textarea name="description" id="edit-description" rows="3" class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all resize-none"></textarea>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Multiplier (x)</label>
                <input type="number" step="0.1" min="1" name="multiplier" id="edit-multiplier" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Waktu Mulai</label>
                    <input type="datetime-local" name="start_time" id="edit-start" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-zinc-400 mb-1.5">Waktu Selesai</label>
                    <input type="datetime-local" name="end_time" id="edit-end" required class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-800 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all">
                </div>
            </div>
            <div>
                <label class="flex items-center gap-2.5 text-xs font-semibold text-zinc-600 cursor-pointer select-none py-1">
                    <input type="checkbox" name="is_active" id="edit-active" value="1" class="rounded border-zinc-300 text-indigo-500 focus:ring-indigo-400">
                    Aktifkan Event
                </label>
            </div>
            <button type="submit" id="btn-edit-submit" class="w-full rounded-2xl bg-[#1C1C1E] px-5 py-3 text-xs font-semibold text-white transition-all hover:bg-zinc-800 shadow-md shadow-zinc-900/10 mt-2">
                Update Event
            </button>
        </form>
    </div>
</div>



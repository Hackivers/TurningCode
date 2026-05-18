@php
    $typeLabels = [
        'daily' => 'Harian',
        'weekly' => 'Mingguan',
        'monthly' => 'Bulanan',
        'custom' => 'Kustom',
    ];
    $typeIcons = [
        'daily' => 'bx-sun',
        'weekly' => 'bx-calendar-week',
        'monthly' => 'bx-calendar',
        'custom' => 'bx-calendar-event',
    ];
    $color = $s->color ?? '#6366f1';
    $startTime = \Carbon\Carbon::parse($s->start_time)->format('H:i');
    $endTime = $s->end_time ? \Carbon\Carbon::parse($s->end_time)->format('H:i') : null;
@endphp
<div class="ntl-item {{ $s->is_active ? '' : 'ntl-inactive' }}" data-color="{{ $color }}">
    {{-- Timeline gutter --}}
    <div class="ntl-gutter">
        <span class="ntl-time">{{ $startTime }}</span>
        <div class="ntl-dot" style="background: {{ $color }}; box-shadow: 0 0 0 4px {{ $color }}22;"></div>
        @if($endTime)
            <span class="ntl-time ntl-time-end">{{ $endTime }}</span>
        @endif
    </div>

    {{-- Card --}}
    <div class="ntl-card" style="border-left: 3px solid {{ $color }};">
        <div class="ntl-card-head">
            <div class="ntl-badge" style="color: {{ $color }}; background: {{ $color }}12;">
                <i class='bx {{ $typeIcons[$s->schedule_type] ?? 'bx-calendar' }}'></i>
                {{ $typeLabels[$s->schedule_type] ?? '-' }}
            </div>
            <div class="ntl-actions">
                <button class="ntl-btn btn-toggle-schedule" data-id="{{ $s->id }}" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                    <i class='bx {{ $s->is_active ? "bx-pause" : "bx-play" }}'></i>
                </button>
                <button class="ntl-btn btn-edit-schedule" data-schedule="{{ json_encode($s) }}" title="Edit">
                    <i class='bx bx-edit-alt'></i>
                </button>
                <button class="ntl-btn ntl-btn-danger btn-delete-schedule" data-id="{{ $s->id }}" title="Hapus">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        </div>
        <h4 class="ntl-title">{{ $s->title }}</h4>
        @if($s->description)
            <p class="ntl-desc">{{ Str::limit($s->description, 80) }}</p>
        @endif
        @if(trim($s->getScheduleLabel()) !== '')
            <div class="ntl-label">
                <i class='bx bx-calendar-event'></i>
                {{ $s->getScheduleLabel() }}
            </div>
        @endif
    </div>
</div>

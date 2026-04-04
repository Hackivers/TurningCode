@php
    $typeLabels = [
        'daily'   => 'Harian',
        'weekly'  => 'Mingguan',
        'monthly' => 'Bulanan',
        'custom'  => 'Custom',
    ];
@endphp
<div class="sched-card {{ $s->is_active ? '' : 'inactive' }}">
    <div class="sched-color" style="background: {{ $s->color }}"></div>
    <div class="sched-info">
        <h4>{{ $s->title }}</h4>
        <h6>{{ $typeLabels[$s->schedule_type] ?? '-' }} · {{ $s->getScheduleLabel() }}</h6>
    </div>
    <div class="sched-time">
        <h5>{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}</h5>
        @if ($s->end_time)
            <h6>s/d {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}</h6>
        @endif
    </div>
    <div class="sched-actions">
        <button class="btn-toggle-schedule" data-id="{{ $s->id }}" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
            <i class='bx {{ $s->is_active ? "bx-pause" : "bx-play" }}'></i>
        </button>
        <button class="btn-edit-schedule" data-schedule="{{ json_encode($s) }}" title="Edit">
            <i class='bx bx-edit-alt'></i>
        </button>
        <button class="btn-delete-schedule" data-id="{{ $s->id }}" title="Hapus">
            <i class='bx bx-trash'></i>
        </button>
    </div>
</div>

@php
    $typeLabels = [
        'daily' => 'Harian',
        'weekly' => 'Mingguan',
        'monthly' => 'Bulanan',
        'custom' => 'Custom',
    ];
@endphp
<div class="modern-sched-card {{ $s->is_active ? '' : 'inactive' }}" style="--card-color: {{ $s->color ?? '#6366f1' }};">
    <div class="msc-indicator"></div>
    <div class="msc-content">
        <div class="msc-header">
            <h4>{{ $s->title }}</h4>
            <div class="msc-badge" style="color: {{ $s->color ?? '#6366f1' }}; background: {{ $s->color ? $s->color.'1A' : '#6366f11A' }}; border-color: {{ $s->color ? $s->color.'33' : '#6366f133' }};">
                {{ $typeLabels[$s->schedule_type] ?? '-' }}
            </div>
        </div>
        <div class="msc-body">
            @if(trim($s->getScheduleLabel()) !== '')
                <span class="msc-detail"><i class='bx bx-info-circle'></i> {{ $s->getScheduleLabel() }}</span>
            @endif
            @if($s->description)
                <span class="msc-detail"><i class='bx bx-align-left'></i> {{ Str::limit($s->description, 40) }}</span>
            @endif
        </div>
        <div class="msc-footer">
            <div class="msc-time">
                <i class='bx bx-time-five'></i>
                <span>{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} @if($s->end_time) - {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}@endif</span>
            </div>
            <div class="msc-actions">
                <button class="msc-btn toggle btn-toggle-schedule" data-id="{{ $s->id }}" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                    <i class='bx {{ $s->is_active ? "bx-pause" : "bx-play" }}'></i>
                </button>
                <button class="msc-btn edit btn-edit-schedule" data-schedule="{{ json_encode($s) }}" title="Edit">
                    <i class='bx bx-edit-alt'></i>
                </button>
                <button class="msc-btn delete btn-delete-schedule" data-id="{{ $s->id }}" title="Hapus">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        </div>
    </div>
</div>

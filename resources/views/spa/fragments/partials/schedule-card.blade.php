@php
    $typeLabels = [
        'daily' => 'Harian',
        'weekly' => 'Mingguan',
        'monthly' => 'Bulanan',
        'custom' => 'Kustom',
    ];
@endphp
<div class="fav-sched-card {{ $s->is_active ? '' : 'inactive' }}">
    <div class="fsc-content">
        <div class="fsc-top">
            <div class="fsc-badge" style="color: {{ $s->color ?? '#6366f1' }}; border-color: {{ $s->color ?? '#6366f1' }}33; background: {{ $s->color ?? '#6366f1' }}10;">
                <span class="fsc-badge-dot" style="background: {{ $s->color ?? '#6366f1' }};"></span>
                <span>{{ $typeLabels[$s->schedule_type] ?? '-' }}</span>
            </div>
            
            <div class="fsc-actions">
                <button class="fsc-btn btn-toggle-schedule" data-id="{{ $s->id }}" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                    <i class='bx {{ $s->is_active ? "bx-pause" : "bx-play" }}'></i>
                </button>
                <button class="fsc-btn btn-edit-schedule" data-schedule="{{ json_encode($s) }}" title="Edit">
                    <i class='bx bx-edit-alt'></i>
                </button>
                <button class="fsc-btn btn-delete btn-delete-schedule" data-id="{{ $s->id }}" title="Hapus">
                    <i class='bx bx-trash'></i>
                </button>
            </div>
        </div>

        <div class="fsc-main">
            <h4 class="fsc-title">{{ $s->title }}</h4>
            @if($s->description)
                 <p class="fsc-desc">{{ Str::limit($s->description, 50) }}</p>
            @endif
        </div>
        
        <div class="fsc-footer">
            @if(trim($s->getScheduleLabel()) !== '')
                <div class="fsc-detail-pill">
                    <i class='bx bx-calendar-event'></i> 
                    <span>{{ $s->getScheduleLabel() }}</span>
                </div>
            @else
                <div></div>
            @endif
            
            <div class="fsc-time" style="color: {{ $s->color ?? '#6366f1' }};">
                <i class='bx bx-time-five'></i>
                <span>{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }}@if($s->end_time) - {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}@endif</span>
            </div>
        </div>
    </div>
</div>

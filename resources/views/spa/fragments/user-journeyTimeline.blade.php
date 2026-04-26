@php
    $allSchedules = collect();
    if (isset($todaySchedules))
        $allSchedules = $allSchedules->merge($todaySchedules);
    if (isset($upcomingSchedules))
        $allSchedules = $allSchedules->merge($upcomingSchedules);
    $displaySchedules = $allSchedules->take(10)->values();

    // Map hari (1 = Senin ... 0 = Minggu)
    $daysOrder = [1, 2, 3, 4, 5, 6, 0];
    $dayNames = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        0 => 'Minggu'
    ];
    $todayDayOfWeek = now()->dayOfWeek;

    // Fungsi pembantu mengecek hari aktif
    $isActiveOnDay = function ($schedule, $dayOfWeek) {
        if (!$schedule->is_active)
            return false;
        if ($schedule->schedule_type === 'daily')
            return true;
        if ($schedule->schedule_type === 'weekly') {
            return in_array($dayOfWeek, $schedule->days_of_week ?? []);
        }
        if ($schedule->schedule_type === 'monthly') {
            $startOfWeek = now()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                if ($date->dayOfWeek == $dayOfWeek && $date->day == $schedule->day_of_month)
                    return true;
            }
        }
        if ($schedule->schedule_type === 'custom') {
            if ($schedule->custom_date) {
                $date = \Carbon\Carbon::parse($schedule->custom_date);
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                if ($date->between($startOfWeek, $endOfWeek) && $date->dayOfWeek == $dayOfWeek)
                    return true;
            }
        }
        return false;
    };

    // Hitung jam mulai (min) dan jam selesai (max) secara dinamis
    $minHour = 24;
    $maxHour = 0;
    $hasActiveSchedules = false;

    foreach ($displaySchedules as $schedule) {
        $isActive = false;
        foreach ($daysOrder as $d) {
            if ($isActiveOnDay($schedule, $d)) {
                $isActive = true;
                break;
            }
        }

        if ($isActive) {
            $hasActiveSchedules = true;
            $start = \Carbon\Carbon::parse($schedule->start_time ?: '00:00:00');
            $end = \Carbon\Carbon::parse($schedule->end_time ?: '01:00:00');
            if (!$schedule->end_time || $end->lessThan($start)) {
                $end = $start->copy()->addHour();
            }

            if ($start->hour < $minHour) {
                $minHour = $start->hour;
            }

            $endH = $end->minute > 0 ? $end->hour + 1 : $end->hour;
            if ($endH > $maxHour) {
                $maxHour = $endH;
            }
        }
    }

    if (!$hasActiveSchedules) {
        // Default bounds jika kosong
        $minHour = 8;
        $maxHour = 17;
    } else {
        // Gunakan jam yang persis dengan jadwal
        $minHour = max(0, $minHour);
        $maxHour = min(24, $maxHour);
    }

    $totalHours = $maxHour - $minHour;
    if ($totalHours <= 0)
        $totalHours = 1; // Fallback
@endphp

<div class="neo-card neo-card-light" style="padding: 48px; position: relative; border: 1px solid rgba(0,0,0,0.04);">
    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
        <div>
            <p style="margin: 0 0 4px; font-size: 14px; font-weight: 600; color: rgba(0,0,0,0.5);">This Week's Journey
            </p>
            <h2 style="margin: 0; font-size: 32px; font-weight: 800; color: #121212; letter-spacing: -0.5px;">Weekly
                Timeline</h2>
        </div>
        <div style="display: flex; align-items: center; gap: 16px;">
            <span style="font-size: 14px; font-weight: 700; color: #121212;">Agenda</span>
            <div style="display: flex; gap: 12px; font-size: 24px; color: #121212;">
                <i class='bx bx-calendar'></i>
            </div>
        </div>
    </div>

    @if ($displaySchedules->isEmpty())
        <div style="text-align:center; padding:40px; background:rgba(0,0,0,0.02); border-radius:16px;">
            <i class='bx bx-calendar-x' style="font-size:48px; color:#ccc; margin-bottom:12px;"></i>
            <p style="margin:0; font-weight:600; color:#888;">Belum ada jadwal. Tambahkan jadwal untuk melihat kalendermu!
            </p>
        </div>
    @else
        <div class="timeline-container">
            {{-- Calendar Header Row --}}
            <div class="calendar-header">
                <div class="time-col-spacer"></div>
                <div class="calendar-days">
                    @foreach ($daysOrder as $d)
                        <div class="cal-day-col {{ $todayDayOfWeek == $d ? 'active-day' : '' }}">
                            <span class="day-name">{{ $dayNames[$d] }}</span>
                            @if ($todayDayOfWeek == $d)
                                <span class="today-badge">HARI INI</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Calendar Body Scrollable --}}
            <div class="calendar-body-scroll">
                <div class="calendar-body-inner" style="height: {{ $totalHours * 60 }}px;">
                    {{-- Y-Axis: Time Labels --}}
                    <div class="time-labels">
                        @for ($h = $minHour; $h <= $maxHour; $h++)
                            @if($h < 24)
                                <div class="time-label" style="top: {{ ($h - $minHour) * 60 }}px;">
                                    {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:00
                                </div>
                            @endif
                        @endfor
                    </div>

                    {{-- X-Axis: Days Columns and Grid --}}
                    <div class="calendar-grid">
                        {{-- Background Grid Lines (Horizontal and Vertical) --}}
                        <div class="grid-bg">
                            @for ($h = $minHour; $h <= $maxHour; $h++)
                                <div class="grid-hour-line" style="top: {{ ($h - $minHour) * 60 }}px;"></div>
                            @endfor
                            <div class="grid-vertical-lines">
                                @for ($d = 0; $d < 7; $d++)
                                    <div class="grid-col-line"></div>
                                @endfor
                            </div>
                        </div>

                        {{-- Event Columns --}}
                        @foreach ($daysOrder as $colIdx => $d)
                            <div class="day-events-col" style="grid-column: {{ $colIdx + 1 }};">
                                @foreach ($displaySchedules as $schedule)
                                    @if ($isActiveOnDay($schedule, $d))
                                        @php
                                            $color = $schedule->color ?? '#1a1a1a';
                                            $start = \Carbon\Carbon::parse($schedule->start_time ?: '00:00:00');
                                            $end = \Carbon\Carbon::parse($schedule->end_time ?: '01:00:00');

                                            // Handle if end is missing or before start
                                            if (!$schedule->end_time || $end->lessThan($start)) {
                                                $end = $start->copy()->addHour();
                                            }

                                            $startMins = $start->hour * 60 + $start->minute;
                                            $endMins = $end->hour * 60 + $end->minute;

                                            // Calculate position offset dynamically by minHour
                                            $topPx = $startMins - ($minHour * 60);
                                            $heightPx = $endMins - $startMins;

                                            // Handle edge case height (minimum 20px to show something)
                                            if ($heightPx < 20)
                                                $heightPx = 20; 
                                        @endphp

                                        <div class="calendar-event"
                                            style="top: {{ $topPx }}px; height: {{ $heightPx }}px; background: {{ $color }};"
                                            title="{{ $schedule->title }} ({{ $start->format('H:i') }} - {{ $end->format('H:i') }})">
                                            <div class="event-title">{{ $schedule->title }}</div>
                                            <div class="event-time">
                                                <i class='bx bx-time'></i> {{ $start->format('H:i') }} - {{ $end->format('H:i') }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Detail Jadwal Bawah --}}
            <div style="margin-top: 40px; padding-top: 24px; border-top: 1px dashed rgba(0,0,0,0.1);">
                <h4 style="font-size: 16px; font-weight: 800; color: #121212; margin: 0 0 16px; letter-spacing: -0.3px;">
                    Detail Agenda</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
                    @foreach ($displaySchedules as $schedule)
                        <div
                            style="display: flex; align-items: center; gap: 12px; background: rgba(0,0,0,0.02); padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.04);">
                            <div
                                style="width: 12px; height: 12px; border-radius: 50%; background: {{ $schedule->color ?? '#1a1a1a' }}; box-shadow: 0 2px 6px {{ $schedule->color ?? '#1a1a1a' }}80;">
                            </div>
                            <div style="flex: 1; display: flex; align-items: baseline; gap: 8px;">
                                <span
                                    style="font-weight: 700; font-size: 14px; color: #121212; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;"
                                    title="{{ $schedule->title }}">{{ $schedule->title }}</span>
                                <span style="font-weight: 600; font-size: 13px; color: rgba(0,0,0,0.5);">
                                    : {{ $schedule->start_time ? substr($schedule->start_time, 0, 5) : '-' }} -
                                    {{ $schedule->end_time ? substr($schedule->end_time, 0, 5) : '-' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .timeline-container {
        position: relative;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .calendar-header {
        display: flex;
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 12px;
        z-index: 10;
    }

    .time-col-spacer {
        width: 60px;
        flex-shrink: 0;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        flex: 1;
    }

    .cal-day-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-align: center;
    }

    .day-name {
        font-size: 14px;
        font-weight: 700;
        color: rgba(0, 0, 0, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .active-day .day-name {
        color: #121212;
        font-weight: 900;
    }

    .today-badge {
        background: #121212;
        color: #fff;
        font-size: 9px;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 4px;
        letter-spacing: 0.5px;
    }

    .calendar-body-scroll {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
        margin-top: 10px;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .calendar-body-inner {
        display: flex;
        position: relative;
    }

    .time-labels {
        width: 60px;
        flex-shrink: 0;
        position: relative;
    }

    .time-label {
        position: absolute;
        width: 100%;
        text-align: right;
        padding-right: 12px;
        font-size: 12px;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.4);
        transform: translateY(-50%);
        /* Center on the line */
    }

    .calendar-grid {
        flex: 1;
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        position: relative;
    }

    .grid-bg {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 0;
    }

    .grid-hour-line {
        position: absolute;
        width: 100%;
        border-top: 1px dashed rgba(0, 0, 0, 0.1);
    }

    .grid-vertical-lines {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        height: 100%;
    }

    .grid-col-line {
        border-right: 1px dashed rgba(0, 0, 0, 0.1);
    }

    .grid-col-line:last-child {
        border-right: none;
    }

    .day-events-col {
        position: relative;
        height: 100%;
        z-index: 1;
    }

    .calendar-event {
        position: absolute;
        left: 4px;
        right: 4px;
        border-radius: 8px;
        padding: 6px 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s, box-shadow 0.2s, z-index 0s;
        cursor: default;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        z-index: 2;
    }

    .calendar-event:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        z-index: 10 !important;
    }

    .calendar-event .event-title {
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.2;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .calendar-event .event-time {
        color: rgba(255, 255, 255, 0.9);
        font-size: 10px;
        font-weight: 600;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .calendar-event .event-time i {
        color: rgba(255, 255, 255, 0.9);
        font-size: 10px;
    }

    /* Modifiers for tiny events (e.g., < 30mins) */
    .calendar-event[style*="height: 20px"],
    .calendar-event[style*="height: 25px"] {
        flex-direction: row;
        align-items: center;
        padding: 2px 8px;
        gap: 6px;
    }

    .calendar-event[style*="height: 20px"] .event-time,
    .calendar-event[style*="height: 25px"] .event-time {
        margin-top: 0;
    }

    @media(max-width: 1024px) {
        .timeline-container {
            overflow-x: auto;
        }

        .calendar-header,
        .calendar-body-inner {
            min-width: 900px;
        }
    }
</style>
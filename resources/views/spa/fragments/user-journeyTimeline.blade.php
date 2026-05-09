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

    // Fungsi pembantu mengecek tanggal aktif (untuk kalender bulanan)
    $isActiveOnDate = function ($schedule, $date) {
        if (!$schedule->is_active)
            return false;
        if ($schedule->schedule_type === 'daily')
            return true;
        if ($schedule->schedule_type === 'weekly') {
            return in_array($date->dayOfWeek, $schedule->days_of_week ?? []);
        }
        if ($schedule->schedule_type === 'monthly') {
            return $date->day == $schedule->day_of_month;
        }
        if ($schedule->schedule_type === 'custom') {
            if ($schedule->custom_date) {
                return $date->isSameDay(\Carbon\Carbon::parse($schedule->custom_date));
            }
        }
        return false;
    };

    // Bikin array tanggal untuk kalender bulan ini
    $todayDate = now();
    $startOfMonth = $todayDate->copy()->startOfMonth();
    $endOfMonth = $todayDate->copy()->endOfMonth();

    // Mulai dari hari Senin terdekat (1 = Senin)
    $startCell = $startOfMonth->copy();
    if ($startCell->dayOfWeek !== 1) {
        $startCell->startOfWeek();
    }

    // Berakhir di hari Minggu terdekat (0 = Minggu)
    $endCell = $endOfMonth->copy();
    if ($endCell->dayOfWeek !== 0) {
        $endCell->endOfWeek();
    }

    $calendarDays = [];
    $currentCell = $startCell->copy();
    while ($currentCell->lessThanOrEqualTo($endCell)) {
        $calendarDays[] = $currentCell->copy();
        $currentCell->addDay();
    }

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

    // Generate dates for mobile horizontal picker (7 days starting today)
    $mobileDays = [];
    $currentDateForMobile = $todayDate->copy();
    $shortDayNamesIndo = [
        1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 0 => 'Min'
    ];
    for ($i = 0; $i < 7; $i++) {
        $mobileDays[] = [
            'date_obj' => $currentDateForMobile->copy(),
            'day_of_week' => $currentDateForMobile->dayOfWeek,
            'day_name' => $shortDayNamesIndo[$currentDateForMobile->dayOfWeek],
            'day_num' => $currentDateForMobile->day,
            'is_today' => $i === 0
        ];
        $currentDateForMobile->addDay();
    }
@endphp

<div class="nw-cell" style="padding: 32px; border-radius: 16px; border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); backdrop-filter: blur(12px); position: relative;">
    {{-- Header --}}
    <div
        style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <div style="width: 6px; height: 6px; background: #d71921; border-radius: 50%;"></div>
                <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--text-muted);">LEARNING JOURNEY</div>
            </div>
            <h2 style="margin: 0; font-size: 24px; font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; font-family: 'Space Mono', monospace; text-transform: uppercase;">Schedule & Timeline</h2>
        </div>

        {{-- Switch Mode --}}
        <div class="view-mode-switch">
            <button class="mode-btn active" onclick="switchViewMode('timeline')" id="btn-mode-timeline">
                <i class='bx bx-time'></i> Timeline
            </button>
            <button class="mode-btn" onclick="switchViewMode('calendar')" id="btn-mode-calendar">
                <i class='bx bx-calendar'></i> Calendar
            </button>
        </div>
    </div>

    @if ($displaySchedules->isEmpty())
        <div style="text-align:center; padding:40px; background:var(--bg-secondary); border-radius:16px;">
            <i class='bx bx-calendar-x' style="font-size:48px; color:#ccc; margin-bottom:12px;"></i>
            <p style="margin:0; font-weight:600; color: var(--text-muted);">Belum ada jadwal. Tambahkan jadwal untuk melihat kalendermu!
            </p>
        </div>
    @else
        {{-- View Timeline (Mingguan) --}}
        <div id="view-timeline" class="timeline-container">
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

            {{-- Mobile Timeline Modern (Mobile Only) --}}
            <div class="mobile-timeline-modern">
                {{-- Horizontal Date Picker --}}
                <div class="mobile-timeline-picker-container">
                    <div class="mobile-timeline-picker-scroll">
                        @foreach($mobileDays as $md)
                            <div class="mobile-day-item {{ $md['is_today'] ? 'active' : '' }}" data-day="{{ $md['day_of_week'] }}" onclick="selectMobileDay(this, {{ $md['day_of_week'] }})">
                                <span class="mobile-day-name">{{ $md['day_name'] }}</span>
                                <span class="mobile-day-num">{{ $md['day_num'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Task List Container --}}
                <div class="mobile-timeline-tasks">
                    @php 
                        $hasTodayTask = false;
                    @endphp
                    @foreach ($displaySchedules as $schedule)
                        {{-- Determine which days this schedule is active --}}
                        @php
                            $activeDaysArr = [];
                            foreach($mobileDays as $md) {
                                if($isActiveOnDay($schedule, $md['day_of_week'])) {
                                    $activeDaysArr[] = $md['day_of_week'];
                                }
                            }
                            $activeDaysStr = implode(',', $activeDaysArr);
                            $isTodayTask = $isActiveOnDay($schedule, $todayDayOfWeek);
                            if ($isTodayTask) $hasTodayTask = true;
                        @endphp
                        
                        @if($activeDaysStr != '')
                            <div class="mobile-task-card {{ $isTodayTask ? 'show' : 'hide' }}" data-active-days="{{ $activeDaysStr }}">
                                <div class="task-indicator" style="background-color: {{ $schedule->color ?? '#1a1a1a' }}"></div>
                                <div class="task-content">
                                    <div class="task-header">
                                        <div class="task-title">{{ $schedule->title }}</div>
                                    </div>
                                    <div class="task-time-row">
                                        <i class='bx bx-time'></i> {{ $schedule->start_time ? substr($schedule->start_time, 0, 5) : '-' }} - {{ $schedule->end_time ? substr($schedule->end_time, 0, 5) : '-' }}
                                    </div>
                                    @if($schedule->description)
                                        <div class="task-desc">{{ $schedule->description }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                    <div id="mobile-empty-state" class="{{ !$hasTodayTask ? 'show' : 'hide' }}">
                        <i class='bx bx-check-circle'></i>
                        <span>Yeay! Tidak ada tugas di hari ini.</span>
                    </div>
                </div>
            </div>

            {{-- Detail Jadwal Bawah (Desktop Only) --}}
            <div class="desktop-detail-agenda" style="margin-top: 40px; padding-top: 24px; border-top: 2px dashed rgba(0,0,0,0.08);">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                    <div style="width: 6px; height: 6px; background: #d71921; border-radius: 50%;"></div>
                    <h4 style="font-size: 16px; font-weight: 800; color: var(--text-primary); margin: 0; letter-spacing: -0.3px; text-transform: uppercase; font-family: 'Space Mono', monospace;">
                        Detail Agenda</h4>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px; width: 100%; overflow: hidden;">
                    @foreach ($displaySchedules as $schedule)
                        <div
                            style="display: flex; align-items: center; gap: 16px; background: var(--bg-secondary); padding: 20px 24px; border-radius: 12px; border: 1px solid var(--border-color); transition: transform 0.2s, background 0.2s; cursor: default; width: 100%; box-sizing: border-box;"
                            onmouseover="this.style.transform='translateY(-4px)'; this.style.background='var(--bg-tertiary)';" onmouseout="this.style.transform=''; this.style.background='var(--bg-secondary)';">
                            <div
                                style="width: 16px; height: 16px; border-radius: 50%; border: 1px solid var(--border-color); background: {{ $schedule->color ?? '#1a1a1a' }}; flex-shrink: 0;">
                            </div>
                            <div style="flex: 1; display: flex; align-items: center; justify-content: space-between; gap: 12px; min-width: 0;">
                                <span
                                    style="font-weight: 700; font-size: 14px; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: 'Space Mono', monospace;"
                                    title="{{ $schedule->title }}">{{ $schedule->title }}</span>
                                <span style="font-family: var(--nothing-dot-font, 'DotGothic16', monospace); font-weight: 400; font-size: 14px; color: var(--text-muted); white-space: nowrap; flex-shrink: 0;">
                                    {{ $schedule->start_time ? substr($schedule->start_time, 0, 5) : '-' }} - {{ $schedule->end_time ? substr($schedule->end_time, 0, 5) : '-' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- View Calendar (Bulanan) --}}
        <div id="view-calendar" style="display: none;">
            <div class="month-calendar-container">
                <div class="month-header">
                    <h3 style="color: var(--text-primary); font-family: 'Space Mono', monospace;">{{ $todayDate->translatedFormat('F Y') }}</h3>
                </div>
                <div class="month-grid">
                    {{-- Day Names Header --}}
                    @foreach ($daysOrder as $d)
                        <div class="month-day-name">{{ $dayNames[$d] }}</div>
                    @endforeach

                    {{-- Day Cells --}}
                    @foreach ($calendarDays as $date)
                        @php
                            $isToday = $date->isToday();
                            $isCurrentMonth = $date->month === $todayDate->month;
                        @endphp
                        <div
                            class="month-cell {{ $isToday ? 'is-today' : '' }} {{ !$isCurrentMonth ? 'not-current-month' : '' }}">
                            <div class="month-cell-date">
                                <span>{{ $date->day }}</span>
                            </div>
                            <div class="month-cell-events">
                                @foreach ($allSchedules as $schedule)
                                    @if ($isActiveOnDate($schedule, $date))
                                        <div class="month-event-dot" style="background: {{ $schedule->color ?? '#1a1a1a' }};"
                                            title="{{ $schedule->title }} ({{ \Carbon\Carbon::parse($schedule->start_time ?: '00:00')->format('H:i') }})">
                                            {{ $schedule->title }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function switchViewMode(mode) {
        if (mode === 'timeline') {
            document.getElementById('view-timeline').style.display = 'flex';
            document.getElementById('view-calendar').style.display = 'none';
            document.getElementById('btn-mode-timeline').classList.add('active');
            document.getElementById('btn-mode-calendar').classList.remove('active');
        } else {
            document.getElementById('view-timeline').style.display = 'none';
            document.getElementById('view-calendar').style.display = 'block';
            document.getElementById('btn-mode-calendar').classList.add('active');
            document.getElementById('btn-mode-timeline').classList.remove('active');
        }
    }
</script>

<style>
    .timeline-container {
        position: relative;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .calendar-header {
        display: flex;
        border-bottom: 2px solid var(--border-color);
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
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .active-day .day-name {
        color: var(--text-primary)fff;
        font-weight: 900;
    }

    .today-badge {
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 9px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: var(--neo-btn-radius);
        letter-spacing: 0.5px;
        border: var(--nothing-border);
    }

    .calendar-body-scroll {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
        margin-top: 10px;
        border-bottom: 1px dashed var(--border-color);
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
        font-size: 14px;
        font-weight: 400;
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        color: var(--text-muted);
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
        border-top: 1px dashed var(--border-color);
    }

    .grid-vertical-lines {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        height: 100%;
    }

    .grid-col-line {
        border-right: 1px dashed var(--border-color);
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
        border: 2px solid #000;
        padding: 6px 8px;
        box-shadow: 2px 2px 0px var(--border-color);
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
        color: var(--text-primary);
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        font-size: 14px;
        font-weight: 400;
        line-height: 1.2;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-transform: uppercase;
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

        .month-grid {
            min-width: 700px;
        }

        .month-calendar-container {
            overflow-x: auto;
        }
    }

    /* View Mode Switch Styles */
    .view-mode-switch {
        display: flex;
        background: var(--bg-tertiary);
        padding: 4px;
        border-radius: 12px;
        gap: 4px;
    }

    .mode-btn {
        border: none;
        background: transparent;
        padding: 8px 16px;
        border-radius: var(--neo-btn-radius);
        font-size: 12px;
        font-family: var(--nothing-dot-font, 'DotGothic16', monospace);
        text-transform: uppercase;
        font-weight: 800;
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .mode-btn:hover {
        color: var(--text-primary)fff;
    }

    .mode-btn.active {
        background: var(--bg-primary);
        color: var(--text-primary);
        border: var(--nothing-border);
    }

    /* Calendar View Styles */
    .month-calendar-container {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .month-header {
        text-align: left;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
    }

    .month-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: var(--text-primary)fff;
        letter-spacing: -0.3px;
        text-transform: uppercase;
    }

    .month-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }

    .month-day-name {
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        padding-bottom: 8px;
        letter-spacing: 1px;
    }

    .month-cell {
        background: var(--text-primary);
        border-radius: 20px;
        min-height: 120px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        border: var(--nothing-border-light);
        box-shadow: 2px 2px 0px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
    }

    .month-cell:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .month-cell.not-current-month {
        opacity: 0.4;
        background: var(--bg-secondary);
    }

    .month-cell.is-today {
        border: 2px solid #121212;
        background: #fdfdfd;
    }

    .month-cell.is-today .month-cell-date span {
        background: #121212;
        color: var(--text-primary);
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .month-cell-date {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary)fff;
        margin-bottom: 8px;
        align-self: flex-end;
        display: flex;
    }

    .month-cell-events {
        display: flex;
        flex-direction: column;
        gap: 4px;
        overflow-y: auto;
        flex: 1;
        max-height: 80px;
    }

    .month-cell-events::-webkit-scrollbar {
        width: 2px;
    }

    .month-cell-events::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 2px;
    }

    .month-event-dot {
        font-size: 10px;
        font-weight: 700;
        color: var(--text-primary);
        padding: 4px 6px;
        border-radius: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        box-shadow: 0 2px 4px var(--border-color);
        cursor: default;
    }

    /* ═══ MOBILE TIMELINE MODERN ═══ */
    .mobile-timeline-modern {
        display: none;
    }

    /* ═══ MOBILE RESPONSIVENESS ═══ */
    @media (max-width: 768px) {
        .mobile-timeline-modern {
            display: block;
        }
        .view-mode-switch,
        #view-timeline .calendar-header,
        #view-timeline .calendar-body-scroll,
        .desktop-detail-agenda,
        #view-calendar {
            display: none !important;
        }

        /* Adjust main container padding */
        div[style*="padding: 48px"] {
            padding: 24px 20px !important;
        }
        div[style*="margin-bottom: 40px"] {
            margin-bottom: 16px !important;
        }

        /* Picker Styles */
        .mobile-timeline-picker-container {
            background: var(--text-primary)fff;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            padding: 12px;
            margin-bottom: 24px;
        }
        .mobile-timeline-picker-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: none; /* Firefox */
        }
        .mobile-timeline-picker-scroll::-webkit-scrollbar {
            display: none; /* Safari/Chrome */
        }
        .mobile-day-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px 14px;
            border-radius: 16px;
            min-width: 54px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .mobile-day-item.active {
            background: #f4f4f5;
        }
        .mobile-day-name {
            font-size: 12px;
            font-weight: 600;
            color: #a1a1aa;
            margin-bottom: 6px;
        }
        .mobile-day-item.active .mobile-day-name {
            color: #52525b;
        }
        .mobile-day-num {
            font-size: 16px;
            font-weight: 700;
            color: #3f3f46;
        }
        .mobile-day-item.active .mobile-day-num {
            color: var(--text-primary)fff;
            font-weight: 800;
        }

        /* Task List Styles */
        .mobile-timeline-tasks {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .mobile-task-card {
            background: var(--text-primary)fff;
            border-radius: 20px;
            padding: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            display: flex;
            gap: 12px;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .mobile-task-card.hide {
            display: none !important;
        }
        .mobile-task-card.show {
            display: flex !important;
            animation: fadeInTask 0.3s forwards;
        }
        @keyframes fadeInTask {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .task-indicator {
            width: 4px;
            border-radius: 4px;
            flex-shrink: 0;
        }
        .task-content {
            flex: 1;
        }
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
        }
        .task-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary)fff;
            line-height: 1.3;
        }
        .task-time-row {
            font-size: 12px;
            font-weight: 600;
            color: #71717a;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .task-desc {
            font-size: 13px;
            color: #a1a1aa;
            margin-top: 8px;
            line-height: 1.4;
        }
        #mobile-empty-state {
            background: var(--text-primary)fff;
            border-radius: 20px;
            padding: 32px 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            text-align: center;
            color: #a1a1aa;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        #mobile-empty-state.hide {
            display: none !important;
        }
        #mobile-empty-state.show {
            display: flex !important;
        }
        #mobile-empty-state i {
            font-size: 32px;
            color: #d4d4d8;
        }
    }
</style>

<script>
    function selectMobileDay(el, dayOfWeek) {
        // Update active class on day picker
        document.querySelectorAll('.mobile-day-item').forEach(item => item.classList.remove('active'));
        el.classList.add('active');

        // Scroll picker smoothly to center the clicked item
        el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });

        // Filter tasks
        let hasVisible = false;
        document.querySelectorAll('.mobile-task-card').forEach(card => {
            let activeDays = card.getAttribute('data-active-days').split(',');
            if (activeDays.includes(dayOfWeek.toString())) {
                card.classList.remove('hide');
                card.classList.add('show');
                hasVisible = true;
            } else {
                card.classList.remove('show');
                card.classList.add('hide');
            }
        });

        // Toggle empty state
        const emptyState = document.getElementById('mobile-empty-state');
        if(hasVisible) {
            emptyState.classList.remove('show');
            emptyState.classList.add('hide');
        } else {
            emptyState.classList.remove('hide');
            emptyState.classList.add('show');
        }
    }
</script>
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
            {{-- Dates Header Row --}}
            <div class="timeline-dates" style="grid-template-columns: repeat(7, 1fr);">
                @foreach ($daysOrder as $d)
                    <div class="tl-date-col {{ $todayDayOfWeek == $d ? 'active-day' : '' }}">
                        <span class="day-name">{{ $dayNames[$d] }}</span>
                        @if ($todayDayOfWeek == $d)
                            <span class="today-badge">HARI INI</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <div style="position: relative; margin-top: 20px;">
                {{-- Background Grid Lines --}}
                <div class="timeline-bg">
                    @for ($i = 0; $i < 7; $i++)
                        <div class="tl-col" style="{{ $i === 6 ? 'border-right: none;' : '' }}"></div>
                    @endfor
                </div>

                {{-- Gantt Bars --}}
                <div class="timeline-bars">
                    @foreach ($displaySchedules as $index => $schedule)
                        @php
                            $color = $schedule->color ?? '#1a1a1a';

                            // Hitung segmen hari berurutan
                            $segments = [];
                            $currentSegment = null;
                            foreach ($daysOrder as $colIdx => $d) {
                                if ($isActiveOnDay($schedule, $d)) {
                                    if ($currentSegment === null) {
                                        $currentSegment = ['start' => $colIdx, 'end' => $colIdx];
                                    } else {
                                        $currentSegment['end'] = $colIdx;
                                    }
                                } else {
                                    if ($currentSegment !== null) {
                                        $segments[] = $currentSegment;
                                        $currentSegment = null;
                                    }
                                }
                            }
                            if ($currentSegment !== null) {
                                $segments[] = $currentSegment;
                            }
                        @endphp

                        @if(count($segments) > 0)
                            <div class="tl-row">
                                @foreach ($segments as $seg)
                                    <div
                                        style="grid-column: {{ $seg['start'] + 1 }} / {{ $seg['end'] + 2 }}; padding: 0 4px; z-index: 2;">
                                        <div class="tl-bar-segment" style="background: {{ $color }};"
                                            title="{{ $schedule->title }} ({{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }})">
                                            <span class="bar-title">{{ $schedule->title }}</span>
                                            <span class="bar-time"><i class='bx bx-time'></i>
                                                {{ substr($schedule->start_time, 0, 5) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
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
    }

    .timeline-dates {
        display: grid;
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 12px;
    }

    .tl-date-col {
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

    .timeline-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        pointer-events: none;
        z-index: 0;
    }

    .tl-col {
        border-right: 1px dashed rgba(0, 0, 0, 0.1);
    }

    .timeline-bars {
        position: relative;
        z-index: 1;
        padding: 20px 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .tl-row {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        height: 48px;
        width: 100%;
    }

    .tl-bar-segment {
        height: 100%;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: default;
        overflow: hidden;
    }

    .tl-bar-segment span {
        color: #ffffff;
    }

    .tl-bar-segment i {
        color: #ffffff;
    }

    .tl-bar-segment:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .bar-title {
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bar-time {
        font-size: 11px;
        font-weight: 600;
        opacity: 0.8;
        display: flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        margin-left: 12px;
    }

    @media(max-width: 1024px) {
        .timeline-container {
            overflow-x: auto;
            padding-bottom: 20px;
        }

        .timeline-dates,
        .timeline-bg,
        .timeline-bars {
            min-width: 900px;
        }
    }
</style>
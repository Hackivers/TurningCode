@php
    $rank = auth()->user()->rank_name;
    
    $tierStyle = '';
    $pillStyle = 'background: #121212; color: #fff; border-color: #121212;';
    $mixBlend = 'filter: contrast(1.2); mix-blend-mode: multiply; opacity: 0.9;';
    
    switch($rank) {
        case 'Legend':
            $tierStyle = 'border: 2px solid rgba(251, 191, 36, 0.6); box-shadow: 0 12px 32px rgba(251, 191, 36, 0.15);';
            $pillStyle = 'background: #fbbf24; color: #000; border-color: #fbbf24; font-weight: 700;';
            $mixBlend = 'filter: drop-shadow(0 8px 16px rgba(251, 191, 36, 0.4)) contrast(1.1); transform: scale(1.05);';
            break;
        case 'Universe':
            $tierStyle = 'border: 2px solid rgba(6, 182, 212, 0.6); box-shadow: 0 12px 32px rgba(6, 182, 212, 0.15);';
            $pillStyle = 'background: #06b6d4; color: #fff; border-color: #06b6d4; font-weight: 700;';
            $mixBlend = 'filter: drop-shadow(0 8px 16px rgba(6, 182, 212, 0.4)) contrast(1.1); transform: scale(1.05);';
            break;
        case 'Domain':
            $tierStyle = 'border: 2px solid rgba(168, 85, 247, 0.6); box-shadow: 0 12px 32px rgba(168, 85, 247, 0.15);';
            $pillStyle = 'background: #a855f7; color: #fff; border-color: #a855f7; font-weight: 700;';
            $mixBlend = 'filter: drop-shadow(0 8px 16px rgba(168, 85, 247, 0.4)) contrast(1.1); transform: scale(1.05);';
            break;
        case 'Immortal':
            $tierStyle = 'border: 2px solid rgba(239, 68, 68, 0.6); box-shadow: 0 12px 32px rgba(239, 68, 68, 0.15);';
            $pillStyle = 'background: #ef4444; color: #fff; border-color: #ef4444; font-weight: 700;';
            $mixBlend = 'filter: drop-shadow(0 8px 16px rgba(239, 68, 68, 0.4)) contrast(1.1); transform: scale(1.05);';
            break;
        case 'Venerable':
            $tierStyle = 'border: 2px solid rgba(244, 63, 94, 0.6); box-shadow: 0 12px 32px rgba(244, 63, 94, 0.15);';
            $pillStyle = 'background: #f43f5e; color: #fff; border-color: #f43f5e; font-weight: 700;';
            $mixBlend = 'filter: drop-shadow(0 8px 16px rgba(244, 63, 94, 0.4)) contrast(1.1); transform: scale(1.05);';
            break;
        case 'Penguasa Sektor':
            $tierStyle = 'border: 2px solid rgba(217, 70, 239, 0.8); box-shadow: 0 12px 40px rgba(217, 70, 239, 0.3); background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(250,232,255,1) 100%);';
            $pillStyle = 'background: #d946ef; color: #fff; border-color: #d946ef; font-weight: 800; letter-spacing: 0.5px;';
            $mixBlend = 'filter: drop-shadow(0 10px 20px rgba(217, 70, 239, 0.5)) contrast(1.1); transform: scale(1.1);';
            break;
    }
@endphp

<div class="neo-card neo-card-light" style="height: 100%; display: flex; flex-direction: column; transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s; {{ $tierStyle }}" onmouseover="this.style.transform='translateY(-4px)'; {{ $rank == 'Penguasa Sektor' ? 'this.style.boxShadow=\'0 16px 48px rgba(217, 70, 239, 0.4)\';' : '' }}" onmouseout="this.style.transform=''; {{ $rank == 'Penguasa Sektor' ? 'this.style.boxShadow=\'0 12px 40px rgba(217, 70, 239, 0.3)\';' : '' }}">
    <div class="neo-header">
        <h3 class="neo-title" style="{{ $rank == 'Penguasa Sektor' ? 'background: -webkit-linear-gradient(45deg, #d946ef, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent;' : '' }}">Level &<br>Pengalaman</h3>
        <span class="neo-arrow" style="{{ $rank == 'Penguasa Sektor' ? 'color: #d946ef;' : '' }}">&#x2197;</span>
    </div>

    <div style="flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px 0;">
        <img src="{{ asset('assets/ico/' . auth()->user()->emblem_image) }}" alt="Emblem"
            style="width: 160px; height: 160px; object-fit: contain; {{ $mixBlend }} transition: transform 0.3s;">
    </div>

    <div>
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;">
            <span class="neo-pill" style="font-size: 14px; background: rgba(0,0,0,0.05); {{ $rank == 'Penguasa Sektor' ? 'border-color: rgba(217, 70, 239, 0.3);' : '' }}">{{ number_format(auth()->user()->exp ?? 0) }}
                EXP</span>
            <span class="neo-pill"
                style="font-size: 14px; {{ $pillStyle }}">Rank:
                {{ auth()->user()->rank_name }}</span>
        </div>

        @if(auth()->user()->next_rank_exp)
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span class="neo-pill" style="border-color: #121212;">Kurang <span
                        id="exp-needed" style="font-weight: 700;">{{ number_format(auth()->user()->next_rank_exp - (auth()->user()->exp ?? 0)) }}</span> exp lagi untuk naik tier {{ auth()->user()->next_rank_name }}</span>
            </div>
        @else
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span class="neo-pill" style="background: center; border-color: #121212; color: #121212; {{ $rank == 'Penguasa Sektor' ? 'border-color: #d946ef; color: #d946ef; font-weight: 700;' : '' }}">Maxed Out</span>
            </div>
        @endif
    </div>
</div>
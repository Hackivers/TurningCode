<div class="neo-card neo-card-light" style="height: 100%; display: flex; flex-direction: column;">
    <div class="neo-header">
        <h3 class="neo-title">Level &<br>Pengalaman</h3>
        <span class="neo-arrow">&#x2197;</span>
    </div>

    <div style="flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px 0;">
        <img src="{{ asset('assets/ico/' . auth()->user()->emblem_image) }}" alt="Emblem"
            style="width: 160px; height: 160px; object-fit: contain; filter: contrast(1.2); mix-blend-mode: multiply; opacity: 0.9;">
    </div>

    <div>
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px;">
            <span class="neo-pill" style="font-size: 14px; background: rgba(0,0,0,0.05);">{{ auth()->user()->exp ?? 0 }}
                EXP</span>
            <span class="neo-pill"
                style="font-size: 14px; background: #121212; color: #fff; border-color: #121212;">Rank:
                {{ auth()->user()->rank_name }}</span>
        </div>

        @if(auth()->user()->next_rank_exp)
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span class="neo-pill" style="border-color: #121212;">Kurang <span
                        id="exp-needed">{{ auth()->user()->next_rank_exp - (auth()->user()->exp ?? 0) }}</span> exp lagi untuk naik tier {{ auth()->user()->next_rank_name }}</span>
            </div>
        @else
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <span class="neo-pill" style="background: center; border-color: #121212; color: #121212;">Maxed Out</span>
            </div>
        @endif
    </div>
</div>
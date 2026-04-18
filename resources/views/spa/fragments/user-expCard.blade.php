<div class="title-example mt-4">
    <div>
        <h4>Level & Pengalaman</h4>
        <h5>Perbanyak waktu belajar untuk menambah EXP kamu!</h5>
    </div>
</div>
<div class="container container-exp mb-4">
    <main class="main-exp">
        <div class="wrapper-exp">
            <div class="info-exp">
                <div class="title-exp-section"><i class='bx bx-meteor'></i> EXP Points</div>
                
                <h1 class="exp-amount-display">
                    <span id="current-exp-amount">{{ auth()->user()->exp ?? 0 }}</span> <span class="exp-text">EXP</span>
                </h1>
                
                @if(auth()->user()->next_rank_exp)
                    <div class="exp-target">
                        <i class='bx bx-target-lock'></i> Target: <strong>{{ auth()->user()->next_rank_name }}</strong> (Butuh <span id="exp-needed">{{ auth()->user()->next_rank_exp - (auth()->user()->exp ?? 0) }}</span> EXP lagi)
                    </div>
                @else
                    <div class="exp-maxed">
                        <i class='bx bxs-crown'></i> Kamu sudah mencapai Rank Tertinggi (Legend)!
                    </div>
                @endif
                
                <div class="exp-hint"><i class='bx bx-info-circle'></i> Kamu mendapatkan +10 EXP secara otomatis setiap 1 menit aktif di dashboard.</div>
            </div>
            
            <div class="icon-exp">
                <div class="emblem-glow"></div>
                <img src="{{ asset('assets/ico/' . auth()->user()->emblem_image) }}" alt="Emblem">
            </div>
        </div>
    </main>
</div>

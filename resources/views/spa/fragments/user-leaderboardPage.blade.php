<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: var(--text-primary)fff;">Leaderboard</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Peringkat pemain terbaik di seluruh sistem.</p>
            </div>
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #f59e0b, #fbbf24); border-radius: 16px; display: flex; align-items: center; justify-content: center; transform: rotate(5deg); box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);">
                <i class='bx bx-bar-chart' style="font-size: 28px; color: var(--text-primary);"></i>
            </div>
        </div>

        @include('spa.fragments.user-leaderboard')

    </div>
</div>

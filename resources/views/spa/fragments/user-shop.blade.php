<div class="neo-dashboard rtd-dashboard">
    <div class="neo-bento-container">

        {{-- Header --}}
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
            <div>
                <h2 class="neo-title" style="font-size: 32px; margin: 0; color: #121212;">Reward Shop</h2>
                <p style="font-size: 15px; color: #888; margin: 4px 0 0;">Tukarkan koin untuk item eksklusif!</p>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 10px; padding: 12px 20px; background: linear-gradient(135deg, #1e1b4b, #312e81); border-radius: 16px; box-shadow: 0 8px 20px rgba(49, 46, 129, 0.25);">
                    <span style="font-size: 22px;">🪙</span>
                    <div>
                        <div style="font-size: 11px; color: rgba(255,255,255,0.6); text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Koin Kamu</div>
                        <div id="shop-coins-display" style="font-size: 24px; font-weight: 900; color: #fbbf24; line-height: 1.1;">{{ number_format($userCoins) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- How to Earn Coins --}}
        <div class="neo-card neo-card-light" style="padding: 20px 24px; border-radius: 16px; margin-bottom: 32px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #6366f1;">
            <i class='bx bx-info-circle' style="font-size: 24px; color: #6366f1; flex-shrink: 0;"></i>
            <div>
                <h4 style="margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #121212;">Cara Mendapatkan Koin</h4>
                <p style="margin: 0; font-size: 13px; color: #666;">Selesaikan misi harian (+10), lulus kuis (+15), capai streak belajar (+5/hari). Semakin aktif, semakin banyak koin!</p>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div style="display: flex; gap: 12px; margin-bottom: 32px; flex-wrap: wrap;">
            <button class="shop-filter-btn active" data-filter="all" onclick="filterShop('all', this)">Semua</button>
            <button class="shop-filter-btn" data-filter="border" onclick="filterShop('border', this)">🖼️ Bingkai</button>
            <button class="shop-filter-btn" data-filter="title" onclick="filterShop('title', this)">🏷️ Gelar</button>
            <button class="shop-filter-btn" data-filter="badge" onclick="filterShop('badge', this)">🏅 Lencana</button>
        </div>

        {{-- Item Grid --}}
        @if($items->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;" id="shop-items-grid">
                @foreach($items as $item)
                    @php
                        $owned = in_array($item->id, $purchasedIds);
                        $canAfford = $userCoins >= $item->price;

                        $typeLabel = match($item->type) {
                            'border' => '🖼️ Bingkai',
                            'title' => '🏷️ Gelar',
                            'badge' => '🏅 Lencana',
                            default => ucfirst($item->type),
                        };
                        $typeColor = match($item->type) {
                            'border' => '#f59e0b',
                            'title' => '#8b5cf6',
                            'badge' => '#10b981',
                            default => '#64748b',
                        };
                        $typeBg = match($item->type) {
                            'border' => 'rgba(245, 158, 11, 0.1)',
                            'title' => 'rgba(139, 92, 246, 0.1)',
                            'badge' => 'rgba(16, 185, 129, 0.1)',
                            default => 'rgba(100, 116, 139, 0.1)',
                        };
                    @endphp
                    <div class="shop-item-card neo-card neo-card-light"
                         data-type="{{ $item->type }}"
                         style="padding: 24px; border-radius: 20px; display: flex; flex-direction: column; align-items: center; text-align: center; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); position: relative; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); {{ $owned ? 'background: rgba(16,185,129,0.02); border-color: rgba(16,185,129,0.2);' : '' }}">

                        {{-- Owned overlay badge --}}
                        @if($owned)
                            <div style="position: absolute; top: 12px; right: 12px; background: #10b981; color: #fff; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                <i class='bx bxs-check-circle'></i> Dimiliki
                            </div>
                        @endif

                        {{-- Item icon --}}
                        <div style="width: 100px; height: 100px; border-radius: 28px; background: {{ $owned ? 'rgba(255,255,255,0.5)' : 'linear-gradient(135deg, #ffffff, #f8fafc)' }}; border: 1px solid rgba(0,0,0,0.04); display: flex; align-items: center; justify-content: center; margin-bottom: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.04); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);">
                            <img src="{{ asset('assets/ico/' . $item->icon) }}" alt="{{ $item->name }}"
                                 style="width: 72px; height: 72px; object-fit: contain; {{ $owned ? '' : 'filter: drop-shadow(0 8px 16px rgba(0,0,0,0.15));' }} transition: all 0.3s;">
                        </div>

                        {{-- Type badge --}}
                        <span class="neo-pill" style="background: {{ $typeBg }}; color: {{ $typeColor }}; border-color: {{ $typeColor }}33; padding: 6px 14px; border-radius: 12px; font-size: 11px; font-weight: 700; margin-bottom: 12px; letter-spacing: 0.5px;">
                            {{ $typeLabel }}
                        </span>

                        <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 800; color: #121212; line-height: 1.3;">{{ $item->name }}</h4>

                        {{-- Price --}}
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 16px;">
                            <span style="font-size: 22px;">🪙</span>
                            <span style="font-size: 22px; font-weight: 900; color: {{ $owned ? '#10b981' : ($canAfford ? '#121212' : '#ef4444') }};">
                                {{ number_format($item->price) }}
                            </span>
                        </div>

                        {{-- Action button --}}
                        @if($owned)
                            <button disabled style="width: 100%; padding: 14px; border-radius: 14px; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); font-weight: 800; font-size: 14px; cursor: default; display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <i class='bx bxs-check-circle' style="font-size: 18px;"></i> Dimiliki
                            </button>
                        @else
                            <button
                                onclick="buyItem({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }}, this)"
                                style="width: 100%; padding: 14px; border-radius: 14px; background: {{ $canAfford ? 'linear-gradient(135deg, #121212, #2a2a2a)' : '#f1f5f9' }}; color: {{ $canAfford ? '#fff' : '#94a3b8' }}; border: {{ $canAfford ? 'none' : '1px solid #e2e8f0' }}; font-weight: 800; font-size: 14px; cursor: {{ $canAfford ? 'pointer' : 'not-allowed' }}; transition: all 0.3s; box-shadow: {{ $canAfford ? '0 8px 20px rgba(0,0,0,0.15)' : 'none' }};"
                                {{ $canAfford ? '' : 'disabled' }}>
                                {{ $canAfford ? 'Beli Sekarang' : 'Koin Kurang' }}
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="neo-card neo-card-light" style="text-align: center; padding: 60px 40px;">
                <i class='bx bx-store-alt' style="font-size: 56px; color: #aaa; margin-bottom: 16px;"></i>
                <h4 style="margin: 0 0 8px 0; color: #555;">Toko Kosong</h4>
                <p style="margin: 0; color: #888;">Item sedang dipersiapkan. Pantau terus!</p>
            </div>
        @endif

    </div>
</div>

<style>
    .shop-filter-btn {
        padding: 10px 24px;
        border-radius: 100px;
        border: 1px solid rgba(0,0,0,0.06);
        background: rgba(255,255,255,0.8);
        color: #555;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .shop-filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    }
    .shop-filter-btn.active {
        background: linear-gradient(135deg, #1e1b4b, #312e81);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 8px 20px rgba(49, 46, 129, 0.3);
    }
    .shop-item-card {
        border: 1px solid rgba(255,255,255,0.5);
    }
    .shop-item-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 48px rgba(0,0,0,0.08) !important;
        border-color: rgba(99, 102, 241, 0.3) !important;
    }
    .shop-item-card:hover img {
        transform: scale(1.15) rotate(5deg);
        filter: drop-shadow(0 12px 24px rgba(0,0,0,0.2)) !important;
    }
</style>

<script>
    function filterShop(type, btn) {
        document.querySelectorAll('.shop-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.shop-item-card').forEach(card => {
            if (type === 'all' || card.dataset.type === type) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    async function buyItem(itemId, itemName, price, btn) {
        if (!confirm(`Beli "${itemName}" seharga 🪙 ${price.toLocaleString()}?`)) return;

        const original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i class='bx bx-loader-alt bx-spin'></i> Memproses...`;

        try {
            const res = await fetch(`{{ url('/app/api/shop/purchase') }}/${itemId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();
            if (data.success) {
                if (window.showFriendToast) window.showFriendToast(data.message, 'success');

                // Update coins display
                const coinsEl = document.getElementById('shop-coins-display');
                if (coinsEl && data.coins_left !== undefined) {
                    coinsEl.textContent = data.coins_left.toLocaleString('id-ID');
                }

                // Update button to owned state
                btn.style.background = 'rgba(16, 185, 129, 0.1)';
                btn.style.color = '#10b981';
                btn.style.border = '1px solid rgba(16, 185, 129, 0.3)';
                btn.style.cursor = 'default';
                btn.innerHTML = `<i class='bx bxs-check-circle'></i> Sudah Dibeli`;
            } else {
                if (window.showFriendToast) window.showFriendToast(data.message, 'error');
                btn.disabled = false;
                btn.innerHTML = original;
            }
        } catch (err) {
            if (window.showFriendToast) window.showFriendToast('Gagal terhubung ke server.', 'error');
            btn.disabled = false;
            btn.innerHTML = original;
        }
    }
</script>

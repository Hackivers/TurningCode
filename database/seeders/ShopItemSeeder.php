<?php

namespace Database\Seeders;

use App\Models\ShopItem;
use Illuminate\Database\Seeder;

class ShopItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Borders
            ['name' => 'Bingkai Emas', 'type' => 'border', 'price' => 500, 'icon' => 'achivement005Trans.png', 'preview_image' => null],
            ['name' => 'Bingkai Neon Hijau', 'type' => 'border', 'price' => 350, 'icon' => 'achivement001Trans.png', 'preview_image' => null],
            ['name' => 'Bingkai Sovereign', 'type' => 'border', 'price' => 999, 'icon' => 'achivement007Trans.png', 'preview_image' => null],

            // Titles
            ['name' => 'Gelar: Code Warrior', 'type' => 'title', 'price' => 200, 'icon' => 'achivement003Trans.png', 'preview_image' => null],
            ['name' => 'Gelar: Quiz Master', 'type' => 'title', 'price' => 300, 'icon' => 'achivement009Trans.png', 'preview_image' => null],
            ['name' => 'Gelar: Legend', 'type' => 'title', 'price' => 750, 'icon' => 'achivement008Trans.png', 'preview_image' => null],

            // Badges
            ['name' => 'Lencana: Bintang Merah', 'type' => 'badge', 'price' => 150, 'icon' => 'achivement002Trans.png', 'preview_image' => null],
            ['name' => 'Lencana: Perisai Biru', 'type' => 'badge', 'price' => 250, 'icon' => 'achivement004Trans.png', 'preview_image' => null],
            ['name' => 'Lencana: Mahkota Ungu', 'type' => 'badge', 'price' => 600, 'icon' => 'achivement006Trans.png', 'preview_image' => null],
        ];

        foreach ($items as $item) {
            ShopItem::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}

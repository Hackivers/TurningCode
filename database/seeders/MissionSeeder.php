<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        $missions = [
            // ── Daily Missions ──
            [
                'title'       => 'Selesaikan 1 Quiz',
                'description' => 'Lulus satu quiz dengan skor minimal 80%.',
                'type'        => 'daily',
                'action'      => 'quiz_pass',
                'target'      => 1,
                'exp_reward'  => 30,
                'icon'        => 'bx-check-circle',
            ],
            [
                'title'       => 'Baca 3 Materi',
                'description' => 'Buka dan baca 3 sub-materi berbeda.',
                'type'        => 'daily',
                'action'      => 'read_materi',
                'target'      => 3,
                'exp_reward'  => 25,
                'icon'        => 'bx-book-open',
            ],
            [
                'title'       => 'Tambah 1 Favorit',
                'description' => 'Tambahkan materi atau sub-materi ke daftar favorit.',
                'type'        => 'daily',
                'action'      => 'favorite_add',
                'target'      => 1,
                'exp_reward'  => 15,
                'icon'        => 'bx-star',
            ],
            [
                'title'       => 'Kirim 1 Diskusi',
                'description' => 'Tulis komentar atau pertanyaan di halaman materi.',
                'type'        => 'daily',
                'action'      => 'discussion_post',
                'target'      => 1,
                'exp_reward'  => 20,
                'icon'        => 'bx-chat',
            ],
            [
                'title'       => 'Dapatkan 100 EXP',
                'description' => 'Kumpulkan total 100 EXP hari ini dari aktivitas apapun.',
                'type'        => 'daily',
                'action'      => 'exp_gain',
                'target'      => 100,
                'exp_reward'  => 35,
                'icon'        => 'bx-trending-up',
            ],
            [
                'title'       => 'Baca 1 Materi',
                'description' => 'Buka dan baca 1 sub-materi.',
                'type'        => 'daily',
                'action'      => 'read_materi',
                'target'      => 1,
                'exp_reward'  => 10,
                'icon'        => 'bx-book-reader',
            ],

            // ── Weekly Missions ──
            [
                'title'       => 'Lulus 5 Quiz',
                'description' => 'Selesaikan 5 quiz dengan skor minimal 80% dalam seminggu.',
                'type'        => 'weekly',
                'action'      => 'quiz_pass',
                'target'      => 5,
                'exp_reward'  => 100,
                'icon'        => 'bx-trophy',
            ],
            [
                'title'       => 'Baca 15 Materi',
                'description' => 'Buka dan baca 15 sub-materi berbeda dalam seminggu.',
                'type'        => 'weekly',
                'action'      => 'read_materi',
                'target'      => 15,
                'exp_reward'  => 80,
                'icon'        => 'bx-library',
            ],
            [
                'title'       => 'Kumpulkan 500 EXP',
                'description' => 'Kumpulkan total 500 EXP minggu ini.',
                'type'        => 'weekly',
                'action'      => 'exp_gain',
                'target'      => 500,
                'exp_reward'  => 120,
                'icon'        => 'bx-rocket',
            ],
            [
                'title'       => 'Kirim 5 Diskusi',
                'description' => 'Tulis 5 komentar atau pertanyaan di halaman materi.',
                'type'        => 'weekly',
                'action'      => 'discussion_post',
                'target'      => 5,
                'exp_reward'  => 75,
                'icon'        => 'bx-conversation',
            ],
        ];

        foreach ($missions as $mission) {
            Mission::updateOrCreate(
                ['title' => $mission['title'], 'type' => $mission['type']],
                $mission
            );
        }
    }
}

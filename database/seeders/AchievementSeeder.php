<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'key'            => 'first_step',
                'title'          => 'First Step',
                'description'    => 'Mulai membaca materi pertama.',
                'icon'           => 'achivement001Trans.png',
                'criteria_type'  => 'history_count',
                'criteria_value' => 1,
                'exp_reward'     => 10,
                'order'          => 1,
            ],
            [
                'key'            => 'bookworm',
                'title'          => 'Kutu Buku',
                'description'    => 'Membaca 50 materi berbeda.',
                'icon'           => 'achivement002Trans.png',
                'criteria_type'  => 'history_count',
                'criteria_value' => 50,
                'exp_reward'     => 50,
                'order'          => 2,
            ],
            [
                'key'            => 'collector',
                'title'          => 'Kolektor',
                'description'    => 'Menyimpan 10 favorit.',
                'icon'           => 'achivement003Trans.png',
                'criteria_type'  => 'fav_count',
                'criteria_value' => 10,
                'exp_reward'     => 25,
                'order'          => 3,
            ],
            [
                'key'            => 'scheduled',
                'title'          => 'Terjadwal',
                'description'    => 'Membuat jadwal belajar pertama.',
                'icon'           => 'achivement004Trans.png',
                'criteria_type'  => 'schedule_count',
                'criteria_value' => 1,
                'exp_reward'     => 15,
                'order'          => 4,
            ],
            [
                'key'            => 'rank_master',
                'title'          => 'Ahli Rank',
                'description'    => 'Mencapai Rank Master (10,000 EXP).',
                'icon'           => 'achivement005Trans.png',
                'criteria_type'  => 'exp_min',
                'criteria_value' => 10000,
                'exp_reward'     => 100,
                'order'          => 5,
            ],
            [
                'key'            => 'most_active',
                'title'          => 'Most Active',
                'description'    => 'Mencoba 20 quiz atau lebih.',
                'icon'           => 'achivement006Trans.png',
                'criteria_type'  => 'quiz_attempt',
                'criteria_value' => 20,
                'exp_reward'     => 50,
                'order'          => 6,
            ],
            [
                'key'            => 'perfect_score',
                'title'          => 'Perfect Score',
                'description'    => 'Mendapatkan nilai sempurna 100 di quiz.',
                'icon'           => 'achivement007Trans.png',
                'criteria_type'  => 'quiz_perfect',
                'criteria_value' => 1,
                'exp_reward'     => 75,
                'order'          => 7,
            ],
            [
                'key'            => 'quiz_master',
                'title'          => 'Quiz Master',
                'description'    => 'Lulus 10 quiz dengan skor 80% atau lebih.',
                'icon'           => 'achivement008Trans.png',
                'criteria_type'  => 'quiz_pass',
                'criteria_value' => 10,
                'exp_reward'     => 60,
                'order'          => 8,
            ],
            [
                'key'            => 'socialite',
                'title'          => 'Sosialis',
                'description'    => 'Berteman dengan 5 pengguna lain.',
                'icon'           => 'achivement009Trans.png',
                'criteria_type'  => 'friend_count',
                'criteria_value' => 5,
                'exp_reward'     => 40,
                'order'          => 9,
            ],
            [
                'key'            => 'discussor',
                'title'          => 'Diskutor',
                'description'    => 'Menulis 10 komentar diskusi.',
                'icon'           => 'achivement001Trans.png',
                'criteria_type'  => 'discussion_count',
                'criteria_value' => 10,
                'exp_reward'     => 35,
                'order'          => 10,
            ],
            [
                'key'            => 'mission_hunter',
                'title'          => 'Misi Hunter',
                'description'    => 'Menyelesaikan 10 misi harian atau mingguan.',
                'icon'           => 'achivement002Trans.png',
                'criteria_type'  => 'mission_complete',
                'criteria_value' => 10,
                'exp_reward'     => 50,
                'order'          => 11,
            ],
            [
                'key'            => 'rank_legend',
                'title'          => 'Legendaris',
                'description'    => 'Mencapai Rank Legend (40,000 EXP).',
                'icon'           => 'achivement005Trans.png',
                'criteria_type'  => 'exp_min',
                'criteria_value' => 40000,
                'exp_reward'     => 200,
                'order'          => 12,
            ],
            // --- SEASONAL ACHIEVEMENTS ---
            [
                'key'            => 'veteran_s1',
                'title'          => 'Veteran Season 1',
                'description'    => 'Berpartisipasi di awal perjalanan sistem (Season 1).',
                'icon'           => 'achivement001Trans.png',
                'criteria_type'  => 'season_veteran',
                'criteria_value' => 1,
                'exp_reward'     => 150,
                'order'          => 101,
            ],
            [
                'key'            => 'veteran_s2',
                'title'          => 'Pengelana Season 2',
                'description'    => 'Menemani perkembangan sistem di Season 2.',
                'icon'           => 'achivement005Trans.png',
                'criteria_type'  => 'season_veteran',
                'criteria_value' => 2,
                'exp_reward'     => 150,
                'order'          => 102,
            ],
            [
                'key'            => 'veteran_s3',
                'title'          => 'Pahlawan Season 3',
                'description'    => 'Setia bertahan dan berkembang di Season 3.',
                'icon'           => 'achivement002Trans.png',
                'criteria_type'  => 'season_veteran',
                'criteria_value' => 3,
                'exp_reward'     => 150,
                'order'          => 103,
            ],
            [
                'key'            => 'veteran_s4',
                'title'          => 'Penjelajah Season 4',
                'description'    => 'Melanjutkan perjalanan panjang di Season 4.',
                'icon'           => 'achivement003Trans.png',
                'criteria_type'  => 'season_veteran',
                'criteria_value' => 4,
                'exp_reward'     => 150,
                'order'          => 104,
            ],
            [
                'key'            => 'veteran_s5',
                'title'          => 'Pejuang Season 5',
                'description'    => 'Menyelesaikan berbagai rintangan baru di Season 5.',
                'icon'           => 'achivement004Trans.png',
                'criteria_type'  => 'season_veteran',
                'criteria_value' => 5,
                'exp_reward'     => 150,
                'order'          => 105,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['key' => $achievement['key']],
                $achievement
            );
        }
    }
}

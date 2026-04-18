<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Get all sub_materi IDs
        $subMateriIds = \App\Models\SubMateri::pluck('id')->toArray();

        if (empty($subMateriIds)) {
            $this->command->warn('No sub_materis found. Skipping question seeding.');
            return;
        }

        foreach ($subMateriIds as $subMateriId) {
            // Seed 5 sample questions per sub-materi
            $questions = [
                [
                    'sub_materi_id'  => $subMateriId,
                    'question'       => 'Apa kepanjangan dari OSINT?',
                    'options'        => ['Open Source Intelligence', 'Online Security Intelligence Network', 'Open System Internet', 'Operating System Internal'],
                    'correct_option' => 0,
                    'order'          => 1,
                ],
                [
                    'sub_materi_id'  => $subMateriId,
                    'question'       => 'Manakah yang BUKAN merupakan teknik OSINT?',
                    'options'        => ['Google Dorking', 'Social Engineering', 'SQL Injection', 'Metadata Analysis'],
                    'correct_option' => 2,
                    'order'          => 2,
                ],
                [
                    'sub_materi_id'  => $subMateriId,
                    'question'       => 'Apa tujuan utama dari OSINT?',
                    'options'        => ['Meretas sistem', 'Mengumpulkan informasi dari sumber terbuka', 'Mengenkripsi data', 'Membuat virus'],
                    'correct_option' => 1,
                    'order'          => 3,
                ],
                [
                    'sub_materi_id'  => $subMateriId,
                    'question'       => 'Tool mana yang sering digunakan untuk OSINT?',
                    'options'        => ['Photoshop', 'Maltego', 'AutoCAD', 'Blender'],
                    'correct_option' => 1,
                    'order'          => 4,
                ],
                [
                    'sub_materi_id'  => $subMateriId,
                    'question'       => 'OSINT menggunakan data dari sumber apa?',
                    'options'        => ['Hanya dark web', 'Sumber tertutup perusahaan', 'Sumber publik yang tersedia', 'Database rahasia pemerintah'],
                    'correct_option' => 2,
                    'order'          => 5,
                ],
            ];

            foreach ($questions as $q) {
                Question::firstOrCreate(
                    [
                        'sub_materi_id' => $q['sub_materi_id'],
                        'question'      => $q['question'],
                    ],
                    $q
                );
            }
        }

        $this->command->info('Sample questions seeded successfully!');
    }
}

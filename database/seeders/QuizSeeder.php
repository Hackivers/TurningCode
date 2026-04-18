<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\SubMateri;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ganti ID ini sesuai dengan SubMateri yang ingin kamu beri kuis
        $subMateriId = 1;
        
        $subMateri = SubMateri::find($subMateriId);
        
        if (!$subMateri) {
            $this->command->warn("SubMateri dengan ID {$subMateriId} tidak ditemukan!");
            return;
        }

        $this->command->info("Membuat 50 soal contoh untuk materi: {$subMateri->title}...");

        // Hapus soal lama untuk submateri ini agar tidak ganda
        Question::where('sub_materi_id', $subMateriId)->delete();

        $questions = [];
        for ($i = 1; $i <= 50; $i++) {
            $correctOption = rand(0, 3);
            $questions[] = [
                'sub_materi_id'  => $subMateriId,
                'question'       => "Ini adalah pertanyaan contoh ke-{$i} tentang " . $subMateri->title . ". Apa jawaban yang benar?",
                'options'        => json_encode([
                    "Pilihan A untuk soal {$i}",
                    "Pilihan B untuk soal {$i}",
                    "Pilihan C untuk soal {$i}",
                    "Pilihan D untuk soal {$i}",
                ]),
                'correct_option' => $correctOption,
                'order'          => $i,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        Question::insert($questions);
        
        $this->command->info("50 soal contoh berhasil dibuat untuk sub-materi ID {$subMateriId}!");
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:reset-season')]
#[Description('Reset EXP semua user ke 0 untuk awal season baru')]
class ResetSeasonExp extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai reset season EXP...');

        $updated = \App\Models\User::query()->update(['exp' => 0]);

        $this->info("Season berhasil direset! Total $updated user EXP dikembalikan ke 0.");
        \Illuminate\Support\Facades\Log::info("Season Reset Command ran successfully. $updated users exp reset to 0.");
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:reset-season')]
#[Description('Mengurangi EXP semua user sebesar 80% untuk awal season baru')]
class ResetSeasonExp extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai reset season EXP...');

        $updated = \App\Models\User::query()->update([
            'exp' => \Illuminate\Support\Facades\DB::raw('FLOOR(exp * 0.2)')
        ]);

        $this->info("Season berhasil direset! Total $updated user EXP dikurangi 80%.");
        \Illuminate\Support\Facades\Log::info("Season Reset Command ran successfully. $updated users exp reduced by 80%.");
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\MissionService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:assign-daily-missions')]
#[Description('Assign misi harian dan mingguan ke semua user aktif')]
class AssignDailyMissions extends Command
{
    public function handle(): void
    {
        $service = new MissionService();

        $users = User::where('role', 'user')->get();

        $count = 0;
        foreach ($users as $user) {
            $service->assignDailyMissions($user);
            $service->assignWeeklyMissions($user);
            $count++;
        }

        $this->info("Misi berhasil di-assign ke {$count} user.");
        \Illuminate\Support\Facades\Log::info("AssignDailyMissions: Assigned to {$count} users.");
    }
}

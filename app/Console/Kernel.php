<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('computer:status-check')->everyMinute();
        $schedule->command('update:school-year')->everyThreeHours();
        // $schedule->command('backup:run  --filename=PUP-CLMS-DB-BACKUP-' . Carbon::now()->format('Y-m-d') . '.zip')->daily()->at('17:00');
        $schedule->command('backup:run  --filename=PUP-CLMS-DB-BACKUP-' . Carbon::now()->format('Y-m-d') . '.zip')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

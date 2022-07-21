<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        'App\Console\Commands\NitificationAlertSotck',
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notification:stock')->cron('00 12 * * *');
        $schedule->command('notification:stock')->cron('00 18 * * *');
        
    }
    
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

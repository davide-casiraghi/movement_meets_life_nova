<?php

namespace App\Console;

use App\Console\Commands\SendEmailsExpiringRepetitiveEvents;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $logPath = storage_path('logs/schedule.log');

        $schedule->command(SendEmailsExpiringRepetitiveEvents::class)
            ->daily()
            ->appendOutputTo($logPath)
            ->emailOutputTo(env('WEBMASTER_MAIL'));

        $schedule->command('sitemap:generate')->daily();

        // Backup
//        $schedule->command('backup:clean')->weekly()->sundays()->at('00:00');
        $schedule->command('backup:run')->weekly()->sundays()->at('00:30');
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

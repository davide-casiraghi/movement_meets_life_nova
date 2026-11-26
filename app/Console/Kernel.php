<?php

namespace App\Console;

use App\Console\Commands\SendEmailsExpiringRepetitiveEvents;
use App\Models\AccessLog;
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

        // Encrypted database backup every night, then retention clean-up and health check
        // (the monitor emails if the latest backup is older than one day).
        $schedule->command('gestionale:backup')->dailyAt('02:30')->appendOutputTo($logPath);
        $schedule->command('backup:clean')->dailyAt('03:15')->appendOutputTo($logPath);
        $schedule->command('backup:monitor')->dailyAt('09:00');

        // Removes access log entries older than AccessLog::RETENTION_MONTHS.
        $schedule->command('model:prune', ['--model' => [AccessLog::class]])->monthly();
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

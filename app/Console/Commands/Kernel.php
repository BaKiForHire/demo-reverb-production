<?php

/**
 * This file was not part of the Laravel Send Newsletter Tutorial.
 * But it was safe to define as it allows us to schedule the command
 * execution to send newsletters to all subscribers. At least in theory - A Laravel Development Theory.
 *
 * @package App\Console
 */

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule the newsletter command to run daily at 12:00 PM
        $schedule->command('send:newsletter')->dailyAt('12:00');
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

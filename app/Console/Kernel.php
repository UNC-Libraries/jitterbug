<?php

namespace Jitterbug\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Jitterbug\Presenters\ActivityStream;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Generate the activity stream
        $schedule->call(function () {
            $activityStream = new ActivityStream;
            $activityStream->generate();
        })->name('generateActivityStream')
      ->everyMinute()
      ->timezone('America/New_York')
      ->between('7:00', '18:00')
      ->withoutOverlapping(2);
    }
}

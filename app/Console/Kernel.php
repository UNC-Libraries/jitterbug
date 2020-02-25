<?php namespace Jitterbug\Console;

use Log;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Jitterbug\Presenters\ActivityStream;

class Kernel extends ConsoleKernel {

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
      ->when(function () {
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('America/New_York'));
        $hour = $date->format('G');
        return $hour >= 8 && $hour <= 17; })
      ->withoutOverlapping(10)
      ->everyMinute();
  }

}

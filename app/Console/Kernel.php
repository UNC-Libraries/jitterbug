<?php namespace Jitterbug\Console;

use Log;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Jitterbug\Presenters\ActivityStream;

class Kernel extends ConsoleKernel {

  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    'Jitterbug\Console\Commands\Inspire',
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    $schedule->command('inspire')
             ->hourly();

    // Generate the activity stream
    $schedule->call(function () {
      $activityStream = new ActivityStream;
      $activityStream->generate();
    })->everyMinute()->name('generateActivityStream')->withoutOverlapping();
  }

}

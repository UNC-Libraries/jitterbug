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
    'Jitterbug\Console\Commands\BackfillNewCollectionTypesSequences',
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
    })->everyMinute()
      ->when(function () { 
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('America/New_York'));
        $hour = $date->format('G');
        return $hour >= 8 && $hour <= 17; })
      ->name('generateActivityStream')
      ->withoutOverlapping();
  }

}

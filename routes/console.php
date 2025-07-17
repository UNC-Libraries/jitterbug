<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Jitterbug\Presenters\ActivityStream;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Generate the activity stream
Schedule::call(function () {
    $activityStream = new ActivityStream;
    $activityStream->generate();
})->name('generateActivityStream')
    ->everyMinute()
    ->timezone('America/New_York')
    ->between('7:00', '18:00')
    ->withoutOverlapping(15);

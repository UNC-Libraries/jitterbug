<?php namespace Jitterbug\Util;


class DurationFormat {

  // HH:MM:SS
  public static $pattern = '/^(?:2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9](.?[0-9]{1,3}?)?$/';

  public static function isDuration($duration)
  {
    if (preg_match(self::$pattern, $duration) === 1) {
      return true;
    }
    return false;
  }

  /**
   * Get duration in seconds from a duration in HH:MM:SS.mmm format. 
   */
  public static function toSeconds($duration)
  {
    if (!self::isDuration($duration)) {
      return null;
    }

    $hasMilliseconds = strpos($duration, '.') != false;
    $milliseconds = '';
    if ($hasMilliseconds) {
      $milliseconds = substr($duration, strpos($duration, '.'));
    }
    $durationWithoutMilliseconds = 
      substr($duration, 0, strlen($duration) - strlen($milliseconds));
    $durationParts = explode(':', $durationWithoutMilliseconds);
    $hours = $minutes = $seconds = $totalSeconds = 0;
    if (count($durationParts) === 3) {
      $hours = $durationParts[0];
      $minutes = $durationParts[1];
      $seconds = $durationParts[2];
    } else if (count($durationParts) === 2) {
      $minutes = $durationParts[0];
      $seconds = $durationParts[1];
    } else {
      $seconds = $durationParts[0];
    }
    $totalSeconds = $hours * 60 * 60;
    $totalSeconds = $totalSeconds + ($minutes * 60);
    $totalSeconds = $totalSeconds + $seconds;
    return $totalSeconds;
  }

  public static function toDuration($durationInSeconds)
  {
    if (empty($durationInSeconds)) {
      return '';
    }

    $hours = (int) ($durationInSeconds / 60 / 60);
    $minutes;
    // Prevent divide by 0 errors    
    if ($hours === 0) {
      $minutes = (int) ($durationInSeconds / 60);
    } else {
      $minutes = (int) ($durationInSeconds % ($hours * 60 * 60) / 60);
    }

    $seconds;
    // Prevent divide by 0 errors
    if ($hours === 0 && $minutes === 0) {
      $seconds = $durationInSeconds;
    } else {
      $seconds = $durationInSeconds % (($hours * 60 * 60) + ($minutes * 60));
    }

    $hoursOut = $hours < 10 ? '0' . $hours : $hours;
    $minutesOut = $minutes < 10 ? '0' . $minutes : $minutes;
    $secondsOut = $seconds < 10 ? '0' . $seconds : $seconds;

    $duration = $hoursOut . ':' . $minutesOut . ':' . $secondsOut;
    return $duration;
  }

}
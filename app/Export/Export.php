<?php namespace Junebug\Export;

use Log;

use Junebug\Export\Export;

class Export {

  /**
   * Create a new export instance.
   *
   * @return void
   */
  public function __construct()
  {

  }

  public function build($fields)
  {
    Log::info($this->ids);
  }
}

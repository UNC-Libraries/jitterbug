<?php namespace Junebug\Support;

use Illuminate\Support\Facades\Config;
use Log;
use Solarium;

class SolariumClientFactory {

  public static function getInstance($core)
  {
    $config = Config::get('solarium');
    $endpointKeys = array_keys($config);
    $endpointConfig = $config[$endpointKeys[0]];
    $hostKeys = array_keys($endpointConfig);
    $hostConfig = $config[$endpointKeys[0]][$hostKeys[0]];
    $path = $hostConfig['path'];
    $config[$endpointKeys[0]][$hostKeys[0]]['path'] = $path . $core;
    return new Solarium\Client($config);
  }
  
}
<?php namespace Jitterbug\Models;

use Log;

/**
 * Simple trait for preserving null fields in the database.
 * Eloquent's default is to overwrite null with emtpy
 * strings or 0 in the case of numbers.
 */
trait NullFieldPreserver {

  public static function bootNullFieldPreserver()
  {
    static::saving(function($model) {
      $attributes = $model->attributes;
      $original = $model->original;

      foreach ($attributes as $key => $value) {
        if($value==='') {
       	  $model->attributes[$key]=null;
        }
      }
  	});

  }
}
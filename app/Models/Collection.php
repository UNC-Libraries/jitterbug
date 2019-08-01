<?php namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Collection extends Model {
  use CamelCasing;
  use NullFieldPreserver;
  use SoftDeletes;

  protected $dates = array('deleted_at');

  protected $fillable = array('id', 'name', 'collectionTypeId', 'archivalIdentifier');

  public $incrementing = false;

  public function audioVisualItems()
  {
    return $this->hasMany('Jitterbug\Models\AudioVisualItem');
  }

  public function collectionType()
  {
    return $this->belongsTo(CollectionType::class);
  }

  public static function findArchivalIdentifier($collectionId)
  {
    $queryResult = DB::table('collections')->select('archival_identifier')
                                           ->where('id', $collectionId)
                                           ->get()
                                           ->first();
    if ($queryResult === null) {
      abort(404, 'Could not find archival identifier for collection ID ' . $collectionId);
    }
    return $queryResult->archival_identifier;
  }

  /**
   * Used by Revisionable to get a display name for the model.
   */
  public function identifiableName()
  {
    return $this->name;
  }
}
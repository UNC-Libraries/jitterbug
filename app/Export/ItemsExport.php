<?php namespace Junebug\Export;

use DB;
use Log;

use Junebug\Export\Export;
use Junebug\Models\AudioVisualItem;

class ItemsExport extends Export {

  protected $exportClass = 'AudioVisualItem';

  protected $commonExportFields = array(
    'Call Number' => 'call_number',
    'Title' => 'title',
    'Container Note' => 'container_note',
    'Collection' => 'collection_id',
    'Format' => 'format_id',
    'Recording Location' => 'recording_location',
    'OCLC Id' => 'oclc',
    'Item Year' => 'item_year',
    'Item Date' => 'item_date',
    'Speed' => 'speed',
    'Entry Date' => 'entry_date',
  ); 

  protected $audioExportFields = array(
    'Listening Copy' => 'listening_copy',
    'Mono/Stereo' => 'mono_stero',
    'Size' => 'size',
    'Track Config' => 'track_configuration',
    'Base' => 'base',
    'Content Description' => 'content_description',
  );

  protected $filmExportFields = array(
    'Element' => 'element',
    'Base' => 'base',
    'Color' => 'color',
    'Sound Type' => 'sound_type',
    'Length in Feet' => 'length_in_feet',
    'Film Stock' => 'film_stock',
    'Edge Code' => 'edge_code',
    'Shrinkage Percent' => 'shrinkage_percent',
    'Can Number' => 'can_number',
    'Content Description' => 'content_description',
  );

  protected $videoExportFields = array(
    'Mono/Stereo' => 'mono_stero',
    'Element' => 'element',
    'Color' => 'color',
    'Recording Standard' => 'recording_standard',
    'Content Description' => 'content_description',
  );

  protected $ids = null;

  public function __construct($ids)
  {
    $this->ids=$ids;
  }

  public function exportableFields()
  {
    // Get the unique types of items that fields are being requested for.
    // We only want to return fields that are relevant to the specific
    // record types. For example, if all the records are AudioItems, we
    // don't want to return fields that are specific to film.
    $types = collect(DB::table('audio_visual_items')
      ->select(DB::raw('TRIM(TRAILING "Item" FROM subclass_type) AS type'))
      ->whereIn('id', $this->ids)->distinct()->get())->pluck('type');
    $fields = array();
    // Fields at index 0 are intended to be rendered on the left in the
    // export dialog, and those at index 1 on the right.
    $fields[0] = $this->commonExportFields;
    $fields[1] = array();
    if ($types->contains('Audio')) {
      $fields[1] = array_merge($fields[1], $this->audioExportFields);
    }
    if ($types->contains('Film')) {
      $fields[1] = array_merge($fields[1], $this->filmExportFields);
    }
    if ($types->contains('Video')) {
      $fields[1] = array_merge($fields[1], $this->videoExportFields);
    }
    return $fields;
  }

}

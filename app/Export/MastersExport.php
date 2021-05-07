<?php namespace Jitterbug\Export;

use DB;
use Log;

use Jitterbug\Export\Export;
use Jitterbug\Models\PreservationInstance;

/**
 * Class for exporting PreservationMasters. See 
 * superclass for documentation.
 */
class MastersExport extends Export {

  protected $exportClass = 'PreservationInstance';

  protected $commonExportFields = array(
    'PM Number' => 'id',
    'Call Number' => 'call_number',
    'File Name' => 'file_name',
    'File Location' => 'file_location',
    'File Size (bytes)' => 'file_size_in_bytes',
    'Duration' => 'duration_in_seconds',
    'Checksum' => 'checksum',
    'Access File Location' => 'access_file_location',
    'Reproduction Machine' => 'reproduction_machine_id',
    'Project' => 'project_id',
    'Department' => 'department_id'
  );

  protected $audioExportFields = array(
    'File Format' => 'file_format',
    'File Codec' => 'file_codec',
    'Sampling Rate' => 'sampling_rate_id',
    'Tape Brand' => 'tape_brand_id',
    'PM Speed' => 'pm_speed_id',
    'Test Tones' => 'test_tones',
  );

  protected $filmExportFields = array(
    'File Format' => 'file_format',
    'File Codec' => 'file_codec',
    'Frame Size' => 'frame_size',
    'Aspect Ratio' => 'aspect_ratio',
  );

  protected $videoExportFields = array(
    'File Format' => 'file_format',
    'File Codec' => 'file_codec',
    'Frame Size' => 'frame_size',
    'Aspect Ratio' => 'aspect_ratio',
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
    $types = DB::table('preservation_instances')
      ->select(DB::raw('TRIM(TRAILING "Instance" FROM subclass_type) AS type'))
      ->whereIn('id', $this->ids)->distinct()->get()->pluck('type');
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

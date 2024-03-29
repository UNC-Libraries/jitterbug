<?php

namespace Jitterbug\Export;

use DB;

/**
 * Class for exporting Transfers. See superclass for documentation.
 */
class TransfersExport extends Export
{
    protected $exportClass = 'Transfer';

    protected $commonExportFields = [
        'Call Number' => 'call_number',
        'Transfer Date' => 'transfer_date',
        'Engineer' => 'engineer_id',
        'Vendor' => 'vendor_id',
        'Playback Machine' => 'playback_machine_id',
        'Transfer Note' => 'transfer_note',
        'Condition Note' => 'condition_note',
    ];

    protected $audioExportFields = [
        'Stylus' => 'stylus',
        'Cartridge' => 'cartridge',
        'First Sound' => 'first_sound',
        // This actually represents mulitiple fields
        // from the associated cut model.
        'Cut Information' => 'cut',
    ];

    // For future use
    protected $filmExportFields = [];

    protected $videoExportFields = [
        'Time Base Corrector' => 'time_base_corrector',
        'A/D Converter' => 'ad_converter',
    ];

    protected $cutExportFields = [
        'Cut Number' => 'cut_number',
        'Cut Side' => 'side',
        'Cut Performer/Composer' => 'performer_composer',
        'Cut Title' => 'title',
        'Cut PM Start Time' => 'pm_start_time',
    ];

    protected $ids = null;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function exportableFields()
    {
        // Get the unique types of items that fields are being requested for.
        // We only want to return fields that are relevant to the specific
        // record types. For example, if all the records are AudioItems, we
        // don't want to return fields that are specific to film.
        $types = DB::table('transfers')
      ->select(DB::raw('TRIM(TRAILING "Transfer" FROM subclass_type) AS type'))
      ->whereIn('id', $this->ids)->distinct()->get()->pluck('type');
        $fields = [];
        // Fields at index 0 are intended to be rendered on the left in the
        // export dialog, and those at index 1 on the right.
        $fields[0] = $this->commonExportFields;
        $fields[1] = [];
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

<?php namespace Jitterbug\Import;

use Illuminate\Support\MessageBag;

use Auth;
use DB;
use Log;
use Uuid;

use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Department;
use Jitterbug\Models\ImportTransaction;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\User;
use Jitterbug\Models\Vendor;
use Jitterbug\Models\VideoItem;
use Jitterbug\Models\VideoMaster;
use Jitterbug\Models\VideoTransfer;
use Jitterbug\Util\CsvReader;
use Jitterbug\Util\DurationFormat;
use Jitterbug\Support\SolariumProxy;


class VideoImport extends Import {

  protected $requiredVideoImportKeys = array(); 
  protected $videoImportKeys = array();

  protected $solrItems;
  protected $solrMasters;
  protected $solrTransfers;

  protected $data = null;

  public function __construct($filePath)
  {
    $this->requiredVideoImportKeys = array('CallNumber', 'FileName', 'IART');
    $this->videoImportKeys = array_merge($this->requiredVideoImportKeys, 
      array('Codec', 'Duration', 'FileSize', 'PreservationChecksum', 
        'AspectRatio', 'TransferMachine', 'TimeBaseCorrector', 
        'A/Dconverter', 'CaptureEngineer', 'Date', 'Color', 'Sound', 
        'Format'));

    $this->solrItems = new SolariumProxy('jitterbug-items');
    $this->solrMasters = new SolariumProxy('jitterbug-masters');
    $this->solrTransfers = new SolariumProxy('jitterbug-transfers');

    $reader = new CsvReader($filePath);
    $this->data = $reader->fetchKeys($this->videoImportKeys);
  }

  public function validate()
  {
    $fileNames = array();
    $messages = array();
    foreach($this->data as $row) {
      $bag = new MessageBag();
      $messages[] = $bag;
      foreach($this->videoImportKeys as $key) {
        // Validate that all required fields have values
        if (in_array($key, $this->requiredVideoImportKeys) 
          && empty($row[$key])) {
          $bag->add($key, 'A value for ' . $key . ' is required.');
        }
        // Validate call number exists
        if ($key==='CallNumber' 
          && !empty($row[$key]) && !$this->valueExists(AudioVisualItem::class, 'call_number', $row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate call number is video
        if ($key==='CallNumber' 
          && !empty($row[$key]) && !$this->isVideo($row[$key])) {
          $bag->add($key, $key . ' is not a video item.');
        }
        // Validate file name (preservation_master.file_name) doesn't exist
        if ($key==='FileName' 
          && !empty($row[$key]) && $this->valueExists(PreservationMaster::class,'file_name', $row[$key])) {
          $bag->add($key, $key . ' already exists in the database.');
        }
        // Validate file name (preservation_master.file_name) is unqiue 
        // amongst values in the rest of the file
        if ($key==='FileName' 
          && !empty($row[$key]) && in_array($row[$key], $fileNames)) {
          $bag->add($key, $key . ' has already been used in this file.');
        } else if ($key==='FileName' && !empty($row[$key])) {
          $fileNames[] = $row[$key];
        }
        // Validate duration format
        if ($key==='Duration' 
          && !empty($row[$key]) && !DurationFormat::isDuration($row[$key])) {
          $bag->add($key, 
            $key . ' must adhere to the following format: HH:MM:SS.mmm.');
        }
        // Validate playback machine exists
        if ($key==='TransferMachine' 
          && !empty($row[$key]) && !$this->valueExists(PlaybackMachine::class, 'name', $row[$key])) {
          $bag->add($key, $key . ' is not a recognized playback machine.');
        }
        // Validate vendor exists
        if ($key==='CaptureEngineer' 
          && !empty($row[$key]) && !$this->valueExists(Vendor::class, 'name', $row[$key])) {
          $bag->add($key, $key . ' is not a recognized vendor.');
        }
        // Validate file size is an integer
        if ($key==='FileSize' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate sound is either mono or stereo
        if ($key==='Sound' 
          && !empty($row[$key]) && !$this->validSound($row[$key])) {
          $bag->add($key, $key . ' must be either "Mono" or "Stereo".');
        }
        // Validate department exists
        if ($key==='IART' 
          && !empty($row[$key]) && !$this->valueExists(Department::class,'name', $row[$key])) {
          $bag->add($key, $key . ' is not a recognized department.');
        }
        // Validate date is formatted correctly
        if ($key==='Date' 
          && !empty($row[$key]) && !strtotime($row[$key])) {
          $bag->add(
            $key, $key . ' must be adhere to the following format: ' 
            . 'YYYY-MM-DDTHH:MM:SS-TZ');
        }
      }
    }
    return $messages;
  }

  public function execute()
  {
    // Keep track of which items, masters and transfers to update in Solr
    $items = array();
    $masters = array();
    $transfers = array();
    $created = $updated = 0;

    // Update MySQL
    DB::transaction( function () 
      use (&$items, &$masters, &$transfers, &$created, &$updated) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $importTransaction = new ImportTransaction;
      $importTransaction->transaction_id = $transactionId;
      $importTransaction->import_type = 'video';
      $importTransaction->save();

      $playbackMachineCache = array();
      $vendorCache = array();

      foreach($this->data as $row) {
        $callNumber = $row['CallNumber'];

        // We need to lookup the playback machine record to get the 
        // id. In order to avoid hitting the database, we will utilize
        // a simple cache.
        $playbackMachineName = 
          isset($row['TransferMachine']) ? $row['TransferMachine'] : null;
        // Check the cache first for this playback machine record
        $playbackMachine = 
          isset($playbackMachineCache[$playbackMachineName]) ? 
                        $playbackMachineCache[$playbackMachineName] : null;
        if ($playbackMachineName !== null) {
          // Not in cache, so get from database and add to cache
          if ($playbackMachine === null) {
            $playbackMachine =
              PlaybackMachine::where('name', $playbackMachineName)->first();
            if ($playbackMachine) {
              $playbackMachineCache[$playbackMachineName] = $playbackMachine;
            }
          }
        }

        // Same as playback machine, we will use a cache for the vendor
        $vendorName = 
          isset($row['CaptureEngineer']) ? $row['CaptureEngineer'] : null;
        // Check the cache first for this vendor record
        $vendor = 
          isset($vendorCache[$vendorName]) ? $vendorCache[$vendorName] : null;
        if ($vendorName !== null) {
          // Not in cache, so get from database and add to cache
          if ($vendor === null) {
            $vendor =
              Vendor::where('name', $vendorName)->first();
            if ($vendor) {
              $vendorCache[$vendorName] = $vendor;
            }
          }
        }

        // Same as playback machine, we will use a cache for the department
        $departmentName = $row['IART'];
        // Check the cache first for this department record
        $department = 
          isset($departmentCache[$departmentName]) ? 
                        $departmentCache[$departmentName] : null;
        // Not in cache, so get from database and add to cache
        if ($department === null) {
          $department =
            Department::where('name', $departmentName)->first();
          // Department should never be null as the validation proves it exists
          $departmentCache[$departmentName] = $department;
        }

        // Create the video master which we need for the PM.
        $videoMaster = new VideoMaster;
        $videoMaster->aspect_ratio =
          isset($row['AspectRatio']) ? $row['AspectRatio'] : null;
        $videoMaster->save();
        $created++;

        // Create the PM
        $master = new PreservationMaster;
        $master->call_number = $callNumber;
        $master->file_name = $row['FileName'];
        $master->file_size_in_bytes = isset($row['FileSize']) ? $row['FileSize'] : null;
        $master->checksum = 
          isset($row['PreservationChecksum']) ? $row['PreservationChecksum'] : null;
        $master->duration_in_seconds =
          isset($row['Duration']) ? DurationFormat::toSeconds($row['Duration']) : null;
        $master->file_format = isset($row['Format']) ? $row['Format'] : null;
        $master->file_codec = isset($row['Codec']) ? $row['Codec'] : null;
        $master->department_id = $department->id;
        $master->subclass_type = 'VideoMaster';
        $master->subclass_id = $videoMaster->id;
        $master->save();
        $masters[] = $master;
        $created++;

        // Create the video transfer
        $videoTransfer = new VideoTransfer;
        $videoTransfer->time_base_corrector =
          isset($row['TimeBaseCorrector']) ? $row['TimeBaseCorrector'] : null;
        $videoTransfer->ad_converter =
          isset($row['A/Dconverter']) ? $row['A/Dconverter'] : null;
        $videoTransfer->save();
        $created++;

        // Create the transfer
        $transfer = new Transfer;
        $transfer->call_number = $callNumber;
        $transfer->preservation_master_id = $master->id;
        $transfer->playback_machine_id =
          ($playbackMachine !== null) ? $playbackMachine->id : null;
        $transfer->vendor_id = ($vendor !== null) ? $vendor->id : null;
        $transfer->transfer_date =
          isset($row['Date']) ? date('Y-m-d', strtotime($row['Date'])) : null;
        $transfer->subclass_type = 'VideoTransfer';
        $transfer->subclass_id = $videoTransfer->id;
        $transfer->save();
        $transfers[] = $transfer;
        $created++;

        // Update the video item
        $videoItem = VideoItem::where('call_number', $callNumber)->first();
        $videoItem->color = isset($row['Color']) ? $row['Color'] : null;
        $videoItem->mono_stereo =
          isset($row['Sound']) ? $this->toMonoStereo($row['Sound']) : null;
        $videoItem->save();
        $updated++;

        // Touch the audio visual item
        $item = AudioVisualItem::where('call_number', $callNumber)->first();
        $item->touch();
        $item->save();
        $items[] = $item;
        $updated++;

      } // end foreach row

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrItems->update($items);
    $this->solrMasters->update($masters);
    $this->solrTransfers->update($transfers);

    return array('created' => $created, 'updated' => $updated);
  }

  private function isVideo($callNumber)
  {
    $item = AudioVisualItem::where('call_number', $callNumber)->first();
    return $item !== null && $item->subclass_type === 'VideoItem';
  }

  private function validSound($sound)
  {
    return $sound === 'Mono' || $sound === 'Stereo';
  }

  /**
   * Trim off all but 'S' or 'M'
   */
  private function toMonoStereo($sound)
  {
    return substr($sound, 0, 1);
  }

}

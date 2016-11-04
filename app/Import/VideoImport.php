<?php namespace Junebug\Import;

use Illuminate\Support\MessageBag;

use Auth;
use DB;
use Log;
use Uuid;

use Junebug\Models\AudioVisualItem;
use Junebug\Models\PlaybackMachine;
use Junebug\Models\PreservationMaster;
use Junebug\Models\Transfer;
use Junebug\Models\User;
use Junebug\Models\Vendor;
use Junebug\Models\VideoItem;
use Junebug\Models\VideoMaster;
use Junebug\Models\VideoTransfer;
use Junebug\Util\CsvReader;
use Junebug\Util\DurationFormat;
use Junebug\Support\SolariumProxy;


class VideoImport extends Import {

  protected $requiredVideoImportKeys = array(); 
  protected $videoImportKeys = array();

  protected $solrItems;
  protected $solrMasters;
  protected $solrTransfers;

  protected $data = null;

  public function __construct($filePath)
  {
    $this->requiredVideoImportKeys = array('CallNumber', 'FileName');
    $this->videoImportKeys = array_merge($this->requiredVideoImportKeys, 
      array('Codec', 'Duration', 'FileSize', 'PreservationChecksum', 
        'AspectRatio', 'TransferMachine', 'TimeBaseCorrector', 
        'A/Dconverter', 'CaptureEngineer', 'Date', 'Color', 'Sound', 
        'Format'));

    $this->solrItems = new SolariumProxy('junebug-items');
    $this->solrMasters = new SolariumProxy('junebug-masters');
    $this->solrTransfers = new SolariumProxy('junebug-transfers');

    $reader = new CsvReader($filePath);
    $this->data = $reader->fetchKeys($this->videoImportKeys);
  }

  public function validate()
  {
    $fileNames = array();
    $messages = array();
    foreach($this->data as $row) {
      $bag = new MessageBag();
      array_push($messages, $bag);
      foreach($this->videoImportKeys as $key) {
        // Validate that all required fields have values
        if (in_array($key, $this->requiredVideoImportKeys) 
          && empty($row[$key])) {
          $bag->add($key, 'A value for ' . $key . ' is required.');
        }
        // Validate call number exists
        if ($key==='CallNumber' 
          && !empty($row[$key]) && !$this->callNumberExists($row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate call number is video
        if ($key==='CallNumber' 
          && !empty($row[$key]) && !$this->isVideo($row[$key])) {
          $bag->add($key, $key . ' is not a video item.');
        }
        // Validate file name (preservation_master.file_name) doesn't exist
        if ($key==='FileName' 
          && !empty($row[$key]) && $this->fileNameExists($row[$key])) {
          $bag->add($key, $key . ' already exists in the database.');
        }
        // Validate file name (preservation_master.file_name) is unqiue 
        // amongst values in the rest of the file
        if ($key==='FileName' 
          && !empty($row[$key]) && in_array($row[$key], $fileNames)) {
          $bag->add($key, $key . ' has already been used in this file.');
        } else if ($key==='FileName' && !empty($row[$key])) {
          array_push($fileNames, $row[$key]);
        }
        // Validate duration format
        if ($key==='Duration' 
          && !empty($row[$key]) && !DurationFormat::isDuration($row[$key])) {
          $bag->add($key, 
            $key . ' must adhere to the following format: HH:MM:SS.mmm.');
        }
        // Validate file size is an integer
        if ($key==='FileSize' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate file size is an integer
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

      $playbackMachineCache = array();
      $vendorCache = array();

      foreach($this->data as $row) {
        $callNumber = $row['CallNumber'];

        // We need to lookup the playback machine record to get the 
        // id. In order to avoid hitting the database, we will utilize
        // a simple cache.
        $playbackMachineName = $row['TransferMachine'];
        // Check the cache first for this playback machine record
        $playbackMachine = 
          isset($playbackMachineCache[$playbackMachineName]) ? 
                        $playbackMachineCache[$playbackMachineName] : null;
        // Not in cache, so get from database and add to cache
        if ($playbackMachine === null) {
          $playbackMachine =
            PlaybackMachine::where('name', $playbackMachineName)->first();
          if ($playbackMachine) {
            $playbackMachineCache[$playbackMachineName] = $playbackMachine;
          }
        }
        // Not in cache and not in the database, so create a new record
        if ($playbackMachine === null) {
          $playbackMachine = new PlaybackMachine;
          $playbackMachine->name = $playbackMachineName;
          $playbackMachine->save();
          $created++;
        }

        // Same as playback machine, we will use a cache for the vendor
        $vendorName = $row['CaptureEngineer'];
        // Check the cache first for this vendor record
        $vendor = 
          isset($vendorCache[$vendorName]) ? $vendorCache[$vendorName] : null;
        // Not in cache, so get from database and add to cache
        if ($vendor === null) {
          $vendor =
            Vendor::where('name', $vendorName)->first();
          if ($vendor) {
            $vendorCache[$vendorName] = $vendor;
          }
        }
        // Not in cache and not in the database, so create a new record
        if ($vendor === null) {
          $vendor = new Vendor;
          $vendor->name = $vendorName;
          $vendor->save();
          $created++;
        }

        // Create the video master which we need for the PM.
        $videoMaster = new VideoMaster;
        $videoMaster->aspectRatio = $row['AspectRatio'];
        $videoMaster->save();
        $created++;

        // Create the PM
        $master = new PreservationMaster;
        $master->callNumber = $callNumber;
        $master->fileName = $row['FileName'];
        $master->fileSizeInBytes = $row['FileSize'];
        $master->checksum = $row['PreservationChecksum'];
        $master->durationInSeconds = 
            DurationFormat::toSeconds($row['Duration']);
        $master->fileFormat = $row['Format'];
        $master->fileCodec = $row['Codec'];
        $master->subclassType = 'VideoMaster';
        $master->subclassId = $videoMaster->id;
        $master->save();
        array_push($masters, $master);
        $created++;

        // Create the video transfer
        $videoTransfer = new VideoTransfer;
        $videoTransfer->timeBaseCorrector = $row['TimeBaseCorrector'];
        $videoTransfer->adConverter = $row['A/Dconverter'];
        $videoTransfer->save();
        $created++;

        // Create the transfer
        $transfer = new Transfer;
        $transfer->callNumber = $callNumber;
        $transfer->preservationMasterId = $master->id;
        $transfer->playbackMachineId = $playbackMachine->id;
        $transfer->vendorId = $vendor->id;
        $transfer->transferDate = date('Y-m-d', strtotime($row['Date']));
        $transfer->subclassType = 'VideoTransfer';
        $transfer->subclassId = $videoTransfer->id;
        $transfer->save();
        array_push($transfers, $transfer);
        $created++;

        // Update the video item
        $videoItem = VideoItem::where('call_number', $callNumber)->first();
        $videoItem->color = $row['Color'];
        $videoItem->monoStereo = $row['Sound'];
        $videoItem->save();
        $updated++;

        // Touch the audio visual item
        $item = AudioVisualItem::where('call_number', $callNumber)->first();
        $item->touch();
        $item->save();
        array_push($items, $item);
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
    return $item !== null && $item->subclassType === 'VideoItem';
  }

}

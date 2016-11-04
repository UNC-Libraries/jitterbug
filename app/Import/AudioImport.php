<?php namespace Junebug\Import;

use Illuminate\Support\MessageBag;

use Auth;
use DB;
use Log;
use Uuid;

use Junebug\Models\AudioVisualItem;
use Junebug\Models\AudioMaster;
use Junebug\Models\AudioTransfer;
use Junebug\Models\Cut;
use Junebug\Models\PlaybackMachine;
use Junebug\Models\PreservationMaster;
use Junebug\Models\Transfer;
use Junebug\Models\User;
use Junebug\Util\CsvReader;
use Junebug\Util\DurationFormat;
use Junebug\Support\SolariumProxy;


class AudioImport extends Import {

  protected $requiredAudioImportKeys = array(); 
  protected $audioImportKeys = array();

  protected $solrMasters;
  protected $solrTransfers;

  protected $data = null;

  public function __construct($filePath)
  {
    $this->requiredAudioImportKeys = array('CallNumber', 
      'OriginatorReference', 'Side', 'PlaybackMachine', 'FileSize', 'Duration');
    $this->audioImportKeys = array_merge($this->requiredAudioImportKeys, 
      array('OriginalPm'));

    $this->solrMasters = new SolariumProxy('junebug-masters');
    $this->solrTransfers = new SolariumProxy('junebug-transfers');

    $reader = new CsvReader($filePath);
    $this->data = $reader->fetchKeys($this->audioImportKeys);
  }

  public function validate()
  {
    $originatorReferences = array();
    $messages = array();
    foreach($this->data as $row) {
      $bag = new MessageBag();
      array_push($messages, $bag);
      foreach($this->audioImportKeys as $key) {
        // Validate that all required fields have values
        if (in_array($key, $this->requiredAudioImportKeys) 
          && empty($row[$key])) {
          $bag->add($key, 'A value for ' . $key . ' is required.');
        }
        // Validate call number exists
        if ($key==='CallNumber' 
          && !empty($row[$key]) && !$this->callNumberExists($row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate call number is audio
        if ($key==='CallNumber' 
          && !empty($row[$key]) && !$this->isAudio($row[$key])) {
          $bag->add($key, $key . ' is not an audio item.');
        }
        // Validate originator reference (preservation_master.file_name) 
        // doesn't exist
        if ($key==='OriginatorReference' 
          && !empty($row[$key]) && $this->fileNameExists($row[$key])) {
          $bag->add($key, $key . ' already exists in the database.');
        }
        // Validate originator reference (preservation_master.file_name) 
        // is unqiue amongst values in the rest of the file
        if ($key==='OriginatorReference' 
          && !empty($row[$key]) && in_array($row[$key], $originatorReferences)) {
          $bag->add($key, $key . ' has already been used in this file.');
        } else if ($key==='OriginatorReference' && !empty($row[$key])) {
          array_push($originatorReferences, $row[$key]);
        }
        // Validate file size is an integer
        if ($key==='FileSize' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate duration format
        if ($key==='Duration' 
          && !empty($row[$key]) && !DurationFormat::isDuration($row[$key])) {
          $bag->add($key, 
            $key . ' must adhere to the following format: HH:MM:SS.mmm.');
        }
        // Validate pm is an integer
        if ($key==='OriginalPm' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate pm belongs to the audio visual item identified by
        // call number
        if ($key==='OriginalPm' 
          && !empty($row[$key]) && !empty($row['CallNumber'])
          && !$this->belongsToItem($row[$key], $row['CallNumber'])) {
          $bag->add($key, $key . ' does not belong to the given call number.');
        }
      }
    }
    return $messages;
  }

  public function execute()
  {
    // Keep track of which masters and transfers to update in Solr
    $masters = array();
    $transfers = array();
    $created = $updated = 0;

    // Update MySQL
    DB::transaction( function () 
      use (&$masters, &$transfers, &$created, &$updated) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");

      $playbackMachineCache = array();

      foreach($this->data as $row) {
        $callNumber = $row['CallNumber'];

        // We need to lookup the playback machine record to get the 
        // id. In order to avoid hitting the database, we will utilize
        // a simple cache.
        $playbackMachineName = $row['PlaybackMachine'];
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

        $originalPm = $row['OriginalPm'];
        
        if (!empty($originalPm)) { 
          // Original PM not empty so this is an update
          $master = PreservationMaster::find($originalPm);
          $master->fileName = $row['OriginatorReference'];
          $master->fileSizeInBytes = $row['FileSize'];
          $master->durationInSeconds = 
            DurationFormat::toSeconds($row['Duration']);
          $master->save();
          array_push($masters, $master);
          $updated++;

          // Update related transfers, which should exist
          $relatedTransfers = $master->transfers()->get();
          if ($relatedTransfers->count() > 0) {
            foreach ($relatedTransfers as $transfer) {
              $transfer->playbackMachineId = $playbackMachine->id;
              // Right now we will assume the person importing is the
              // engineer, but that might change in the future.
              $transfer->engineerId = Auth::user()->id;
              $transfer->save();
              array_push($transfers, $transfer);
              $updated++;
            }
          }

          // Update related cuts, which should exist
          $relatedCuts = $master->cuts()->get();
          if ($relatedCuts->count() > 0) {
            foreach ($relatedCuts as $cut) {
              $cut->side = $row['Side'];
              $cut->save();
              $updated++;
            }
          }
        } else {
          // Original PM is empty, so all new records will be created.
          // For the audio PM, there is nothing to save, we just need the
          // ID for the new PM record.
          $audioMaster = new AudioMaster;
          $audioMaster->save();
          $created++;

          // Create the PM using data from the import.
          $master = new PreservationMaster;
          $master->callNumber = $callNumber;
          $master->fileName = $row['OriginatorReference'];
          $master->fileSizeInBytes = $row['FileSize'];
          $master->durationInSeconds = 
              DurationFormat::toSeconds($row['Duration']);
          $master->subclassType = 'AudioMaster';
          $master->subclassId = $audioMaster->id;
          $master->save();
          array_push($masters, $master);
          $created++;

          // Again, there's really no information to import
          // here, we just need a new id for the Transfer.
          $audioTransfer = new AudioTransfer;
          $audioTransfer->save();
          $created++;

          // Create the transfer
          $transfer = new Transfer;
          $transfer->callNumber = $callNumber;
          $transfer->preservationMasterId = $master->id;
          $transfer->playbackMachineId = $playbackMachine->id;
          // Right now we will assume the person importing is the
          // engineer, but that might change in the future.
          $transfer->engineerId = Auth::user()->id;
          $transfer->subclassType = 'AudioTransfer';
          $transfer->subclassId = $audioTransfer->id;
          $transfer->save();
          array_push($transfers, $transfer);
          $created++;

          // Create the cut
          $cut = new Cut;
          $cut->callNumber = $callNumber;
          $cut->preservationMasterId = $master->id;
          $cut->transferId = $transfer->id;
          $cut->side = $row['Side'];
          $cut->save();
          $created++;

        }

      } // end foreach row

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrMasters->update($masters);
    $this->solrTransfers->update($transfers);

    return array('created' => $created, 'updated' => $updated);
  }

  private function belongsToItem($pmId, $callNumber)
  {
    $item = AudioVisualItem::where('call_number', $callNumber)->first();
    if ($item != null) {
      $masters = $item->preservationMasters;
      foreach ($masters as $master) {
        if ($master->id == $pmId) {
          return true;
        }
      }
    }
    return false;
  }

  private function isAudio($callNumber)
  {
    $item = AudioVisualItem::where('call_number', $callNumber)->first();
    return $item !== null && $item->subclassType === 'AudioItem';
  }

}

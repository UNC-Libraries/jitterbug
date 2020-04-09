<?php namespace Jitterbug\Import;

use Auth;
use DB;
use Log;
use Uuid;

use Illuminate\Support\MessageBag;

use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\AudioMaster;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Department;
use Jitterbug\Models\ImportTransaction;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;
use Jitterbug\Util\CsvReader;
use Jitterbug\Util\DurationFormat;
use Jitterbug\Support\SolariumProxy;


class AudioImport extends Import {

  protected $requiredAudioImportKeys = array();
  protected $audioImportKeys = array();

  protected $solrMasters;
  protected $solrTransfers;

  protected $data = null;

  public function __construct($filePath)
  {
    $this->requiredAudioImportKeys = array('CallNumber', 
      'OriginatorReference', 'Side', 'PlaybackMachine', 'FileSize', 
      'Duration', 'OriginationDate', 'IART');
    $this->audioImportKeys = array_merge($this->requiredAudioImportKeys, 
      array('TransferNote', 'OriginalPm', 'Size', 'TrackConfiguration', 'Base'));

    $this->solrMasters = new SolariumProxy('jitterbug-masters');
    $this->solrTransfers = new SolariumProxy('jitterbug-transfers');

    $reader = new CsvReader($filePath);
    $this->data = $reader->fetchKeys($this->audioImportKeys);
  }

  public function validate()
  {
    $originalPms = array();
    $originatorReferences = array();
    $messages = array();
    foreach($this->data as $row) {
      $bag = new MessageBag();
      $messages[] = $bag;
      foreach($this->audioImportKeys as $key) {
        // if the batch import edit field is empty, this is a new record
        $new_record = empty($row[Transfer::BATCH_IMPORT_KEY]);

        // Validate that all required fields have values if this is a new record
        if ($new_record &&
          in_array($key, $this->requiredAudioImportKeys)
          && empty($row[$key])) {
          $bag->add($key, 'A value for ' . $key . ' is required.');
        }

        // Validate call number exists
        if ($key === 'CallNumber'
          && !empty($row[$key])
          && !$this->valueExists(AudioVisualItem::class, 'call_number', $row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }

        // Validate call number is audio
        if ($key === 'CallNumber'
          && !empty($row[$key]) && !$this->isAudio($row[$key])) {
          $bag->add($key, $key . ' is not an audio item.');
        }
        // Validate playback machine exists
        if ($key === 'PlaybackMachine'
          && !empty($row[$key]) && !$this->valueExists(PlaybackMachine::class, 'name', $row[$key])) {
          $bag->add($key, $key . ' is not a recognized playback machine.');
        }
        // Validate originator reference (preservation_master.file_name) 
        // doesn't exist
        if ($key === 'OriginatorReference'
          && !empty($row[$key]) && $this->valueExists(PreservationMaster::class,'file_name', $row[$key])) {
          $bag->add($key, $key . ' already exists in the database.');
        }
        // Validate originator reference (preservation_master.file_name) 
        // is unique amongst values in the rest of the file
        if ($key === 'OriginatorReference'
          && !empty($row[$key]) && in_array($row[$key], $originatorReferences)) {
          $bag->add($key, $key . ' has already been used in this file.');
        } else if ($key==='OriginatorReference' && !empty($row[$key])) {
          $originatorReferences[] = $row[$key];
        }
        // Validate file size is an integer
        if ($key === 'FileSize'
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate duration format
        if ($key === 'Duration'
          && !empty($row[$key]) && !DurationFormat::isDuration($row[$key])) {
          $bag->add($key, 
            $key . ' must adhere to the following format: HH:MM:SS.mmm.');
        }
        // Validate transfer date is formatted correctly
        if ($key === 'OriginationDate'
          && !empty($row[$key]) && !$this->isValidDate($row[$key])) {
          $bag->add(
            $key, $key . ' must be adhere to the following format: ' 
            . 'YYYY-MM-DD');
        }
        // Validate department exists
        if ($key === 'IART'
          && !empty($row[$key]) && !$this->valueExists(Department::class, 'name', $row[$key])) {
          $bag->add($key, $key . ' is not a recognized department.');
        }
        // Validate pm is an integer
        if ($key === 'OriginalPm'
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate pm number exists in the DB
        if ($key === 'OriginalPm'
          && !empty($row[$key]) && !$this->pmExists($row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate pm belongs to the audio visual item identified by
        // call number
        if ($key === 'OriginalPm'
          && !empty($row[$key]) && !empty($row['CallNumber'])
          && !$this->belongsToItem($row[$key], $row['CallNumber'])) {
          $bag->add($key, $key . ' does not belong to the given call number.');
        }
        // Validate the pm is unique amongst pm values in the rest of the file
        if ($key === 'OriginalPm'
          && !empty($row[$key]) && in_array($row[$key], $originalPms)) {
          $bag->add($key, $key . ' has already been used in this file.');
        } else if ($key === 'OriginalPm' && !empty($row[$key])) {
          $originalPms[] = $row[$key];
        }
        // Validate size exists in the DB
        if ($key === 'Size'
          && !empty($row[$key]) && !$this->valueExists(AudioItem::class, 'size', $row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate track configuration exists in the DB
        if ($key === 'TrackConfiguration'
          && !empty($row[$key]) && !$this->valueExists(AudioItem::class, 'track_configuration', $row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate track configuration exists in the DB
        if ($key === 'Base'
          && !empty($row[$key]) && !$this->valueExists(AudioItem::class, 'base', $row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
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

      $importTransaction = new ImportTransaction;
      $importTransaction->transaction_id = $transactionId;
      $importTransaction->import_type = 'audio';
      $importTransaction->save();

      $playbackMachineCache = array();
      $departmentCache = array();

      foreach($this->data as $row) {
        $callNumber = $row['CallNumber'];

        // We need to lookup the playback machine record to get the 
        // id. In order to avoid hitting the database, we will utilize
        // a simple cache.
        $playbackMachineName = $row['PlaybackMachine'];
        if (isset($playbackMachineName)) {
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
        }

        // Same as playback machine, we will use a cache for the department
        $departmentName = $row['IART'];
        if (isset($departmentName)) {
          // Check the cache first for this department record
          $department =
            isset($departmentCache[$departmentName]) ?
              $departmentCache[$departmentName] : null;
          // Not in cache, so get from database and add to cache
          if ($department === null) {
            $department =
              Department::where('name', $departmentName)->first();
            if ($department) {
              $departmentCache[$departmentName] = $department;
            }
          }
        }

        // Original PM is optional, so the column may not be present in the file
        $originalPm = isset($row['OriginalPm']) ? $row['OriginalPm'] : null;
        $duration = DurationFormat::toSeconds($row['Duration']);
        
        if (!empty($originalPm)) { 
          // Original PM not empty so this is an update
          $masterUpdated = false;
          $master = PreservationMaster::find($originalPm);
          if (!empty($row['OriginatorReference'])) {
            $master->file_name = $row['OriginatorReference'];
            $masterUpdated = true;
          }
          if (!empty($row['FileSize'])) {
            $master->file_size_in_bytes = $row['FileSize'];
            $masterUpdated = true;
          }
          if (isset($duration)) {
            $master->duration_in_seconds = $duration;
            $masterUpdated = true;
          }
          if (isset($department)) {
            $master->department_id = $department->id;
            $masterUpdated = true;
          }
          if ($masterUpdated === true) {
            $master->save();
            $masters[] = $master;
            $updated++;
          }

          // Update related transfers if specified, which should exist
          if (isset($playbackMachine) || !empty($row['OriginationDate']) || !empty($row['TransferNote'])) {
            $relatedTransfers = $master->transfers;
            foreach ($relatedTransfers as $transfer) {
              if (isset($playbackMachine)) {
                $transfer->playback_machine_id = $playbackMachine->id;
              }
              if (!empty($row['OriginationDate'])) {
                $transfer->transfer_date = $row['OriginationDate'];
              }
              if (!empty($row['TransferNote'])) {
                $transfer->transfer_note = $row['TransferNote'];
              }
              $transfer->save();
              $transfers[] = $transfer;
              $updated++;
            }
          }

          // Update related cuts if specified, which should exist
          if (!empty($row['Side'])) {
            $relatedCuts = $master->cuts;
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
          // Sampling rate id 8 = 96kHz/24bit
          $audioMaster->sampling_rate_id = 8;
          $audioMaster->save();
          $created++;

          // Create the PM using data from the import.
          $master = new PreservationMaster;
          $master->call_number = $callNumber;
          $master->file_name = $row['OriginatorReference'];
          $master->file_size_in_bytes = $row['FileSize'];
          $master->duration_in_seconds = $duration;
          $master->department_id = $department->id;
          // APPDEV-6760
          $master->file_format = 'BWF';
          $master->file_codec = 'Uncompressed PCM';

          $master->subclass_type = 'AudioMaster';
          $master->subclass_id = $audioMaster->id;
          $master->save();
          $masters[] = $master;
          $created++;

          // There's really no information to import here, 
          // we just need a new id for the Transfer.
          $audioTransfer = new AudioTransfer;
          $audioTransfer->save();
          $created++;

          // Create the transfer
          $transfer = new Transfer;
          $transfer->call_number = $callNumber;
          $transfer->preservation_master_id = $master->id;
          $transfer->playback_machine_id = $playbackMachine->id;
          // Right now we will assume the person importing is the
          // engineer, but that might change in the future.
          $transfer->engineer_id = Auth::user()->id;
          $transfer->transfer_date = $row['OriginationDate'];
          $transfer->transfer_note =
            isset($row['TransferNote']) ? $row['TransferNote'] : null;
          $transfer->subclass_type = 'AudioTransfer';
          $transfer->subclass_id = $audioTransfer->id;
          $transfer->save();
          $transfers[] = $transfer;
          $created++;

          // Create the cut
          $cut = new Cut;
          $cut->call_number = $callNumber;
          $cut->preservation_master_id = $master->id;
          $cut->transfer_id = $transfer->id;
          $cut->side = $row['Side'];
          $cut->cut_number = 1;
          $cut->save();
          $created++;

        }

        if (!empty($row['Size']) || !empty($row['TrackConfiguration']) || !empty($row['Base'])) {
          $audioVisualItem = AudioVisualItem::where('call_number', $callNumber)->first();
          $audioItem = $audioVisualItem->subclass;
          if (!empty($row['Size'])) {
            $audioItem->size = $row['Size'];
          }
          if (!empty($row['TrackConfiguration'])) {
            $audioItem->track_configuration = $row['TrackConfiguration'];
          }
          if (!empty($row['Base'])) {
            $audioItem->base = $row['Base'];
          }
          $audioItem->save();
          $updated++;
        }

      } // end foreach row

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrMasters->update($masters);
    $this->solrTransfers->update($transfers);

    return array('created' => $created, 'updated' => $updated);
  }

  private function belongsToItem($pmId, $callNumber)
  { // TODO can reduce to 1 query by querying preservation masters directly
    $item = AudioVisualItem::where('call_number', $callNumber)->first();
    if ($item !== null) {
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
    return $item !== null && $item->subclass_type === 'AudioItem';
  }

}

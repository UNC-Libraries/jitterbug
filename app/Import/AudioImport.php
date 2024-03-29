<?php

namespace Jitterbug\Import;

use Auth;
use DB;
use Illuminate\Support\MessageBag;
use Jitterbug\Models\AudioInstance;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\AudioTransfer;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Department;
use Jitterbug\Models\ImportTransaction;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\Transfer;
use Jitterbug\Support\SolariumProxy;
use Jitterbug\Util\CsvReader;
use Jitterbug\Util\DurationFormat;
use Uuid;

class AudioImport extends Import
{
    protected $requiredAudioImportKeys = [];

    protected $audioImportKeys = [];

    protected $mustAlreadyExistInDbKeys = [];

    protected $avItemFieldKeys = [];

    protected $solrItems;

    protected $solrInstances;

    protected $solrTransfers;

    protected $data = null;

    public function __construct($filePath)
    {
        $this->requiredAudioImportKeys = ['CallNumber',
            'OriginatorReference', 'Side', 'PlaybackMachine', 'FileSize',
            'Duration', 'OriginationDate', 'IART', ];
        $this->avItemFieldKeys = ['Size', 'TrackConfiguration', 'Base', 'Speed'];
        $this->audioImportKeys = array_merge($this->requiredAudioImportKeys,
            ['TransferNote', 'OriginalPm'], $this->avItemFieldKeys);
        $this->mustAlreadyExistInDbKeys = [
            'Size' => AudioItem::class,
            'TrackConfiguration' => AudioItem::class,
            'Base' => AudioItem::class,
            'Speed' => AudioVisualItem::class,
        ];

        $this->solrItems = new SolariumProxy('jitterbug-items');
        $this->solrInstances = new SolariumProxy('jitterbug-instances');
        $this->solrTransfers = new SolariumProxy('jitterbug-transfers');

        $reader = new CsvReader($filePath);
        $this->data = $reader->fetchKeys($this->audioImportKeys);
    }

    public function validate()
    {
        $originalPms = [];
        $originatorReferences = [];
        $messages = [];
        foreach ($this->data as $row) {
            $bag = new MessageBag();
            $messages[] = $bag;
            foreach ($this->audioImportKeys as $key) {
                // if the batch import edit field is empty, this is a new record
                $new_record = empty($row[Transfer::BATCH_IMPORT_KEY]);

                // Validate that all required fields have values if this is a new record
                if ($new_record && empty($row[$key]) &&
          in_array($key, $this->requiredAudioImportKeys, true)) {
                    $bag->add($key, 'A value for '.$key.' is required.');
                }
                // Validate call number exists if AV item fields are present and filled in
                if (! $new_record && ! empty($row[$key]) && empty($row['CallNumber']) &&
          in_array($key, $this->avItemFieldKeys, true)) {
                    $bag->add($key, 'Call number must be filled in.');
                }
                // Validate call number is audio
                if ($key === 'CallNumber'
          && ! empty($row[$key]) && ! $this->isAudio($row[$key])) {
                    $bag->add($key, $key.' is not an audio item.');
                }
                //  Validate playback machine exists
                if ($key === 'PlaybackMachine'
          && ! empty($row[$key]) && ! $this->valueExists(PlaybackMachine::class, 'name', $row[$key])) {
                    $bag->add($key, $key.' is not a recognized playback machine.');
                }
                // Validate originator reference (preservation_instance.file_name)
                // doesn't exist
                if ($key === 'OriginatorReference'
          && ! empty($row[$key]) && $this->valueExists(PreservationInstance::class, 'file_name', $row[$key])) {
                    $bag->add($key, $key.' already exists in the database.');
                }
                // Validate originator reference (preservation_instance.file_name)
                // is unique amongst values in the rest of the file
                if ($key === 'OriginatorReference'
          && ! empty($row[$key]) && in_array($row[$key], $originatorReferences)) {
                    $bag->add($key, $key.' has already been used in this file.');
                } elseif ($key === 'OriginatorReference' && ! empty($row[$key])) {
                    $originatorReferences[] = $row[$key];
                }
                // Validate file size is an integer
                if ($key === 'FileSize'
          && ! empty($row[$key]) && ! ctype_digit($row[$key])) {
                    $bag->add($key, $key.' must be an integer.');
                }
                // Validate duration format
                if ($key === 'Duration'
          && ! empty($row[$key]) && ! DurationFormat::isDuration($row[$key])) {
                    $bag->add($key,
                        $key.' must adhere to the following format: HH:MM:SS.mmm.');
                }
                // Validate transfer date is formatted correctly
                if ($key === 'OriginationDate'
          && ! empty($row[$key]) && ! $this->isValidDate($row[$key])) {
                    $bag->add(
                        $key, $key.' must be adhere to the following format: '
                        .'YYYY-MM-DD');
                }
                // Validate department exists
                if ($key === 'IART'
          && ! empty($row[$key]) && ! $this->valueExists(Department::class, 'name', $row[$key])) {
                    $bag->add($key, $key.' is not a recognized department.');
                }
                // Validate pm is an integer
                if ($key === 'OriginalPm'
          && ! empty($row[$key]) && ! ctype_digit($row[$key])) {
                    $bag->add($key, $key.' must be an integer.');
                }
                // Validate pm number exists in the DB
                if ($key === 'OriginalPm'
          && ! empty($row[$key]) && ! $this->pmExists($row[$key])) {
                    $bag->add($key, $key.' must already exist in the database.');
                }
                // Validate pm belongs to the audio visual item identified by
                // call number
                if ($key === 'OriginalPm'
          && ! empty($row[$key]) && ! empty($row['CallNumber'])
          && ! $this->belongsToItem($row[$key], $row['CallNumber'])) {
                    $bag->add($key, $key.' does not belong to the given call number.');
                }
                // Validate the pm is unique amongst pm values in the rest of the file
                if ($key === 'OriginalPm'
          && ! empty($row[$key]) && in_array($row[$key], $originalPms)) {
                    $bag->add($key, $key.' has already been used in this file.');
                } elseif ($key === 'OriginalPm' && ! empty($row[$key])) {
                    $originalPms[] = $row[$key];
                }

                // Validates certain field values already exist in the DB
                foreach ($this->mustAlreadyExistInDbKeys as $dbKey => $class) {
                    if (! empty($row[$dbKey]) && ! $this->valueExists($class, snake_case($dbKey), $row[$dbKey])) {
                        $bag->add($dbKey, $dbKey.' must already exist in the database.');
                    }
                }
            }
        }

        return $messages;
    }

    public function execute()
    {
        // Keep track of which instances and transfers to update in Solr
        $items = [];
        $instances = [];
        $transfers = [];
        $created = $updated = 0;

        // Update MySQL
        DB::transaction(function () use (&$items, &$instances, &$transfers, &$created, &$updated) {
            $transactionId = Uuid::uuid4();
            DB::statement("set @transaction_id = '$transactionId';");

            $importTransaction = new ImportTransaction;
            $importTransaction->transaction_id = $transactionId;
            $importTransaction->import_type = 'audio';
            $importTransaction->save();

            $playbackMachineCache = [];
            $departmentCache = [];

            foreach ($this->data as $row) {
                // call number has been validated to see if it's allowed to be null
                $callNumber = $row['CallNumber'] ?? null;

                // We need to lookup the playback machine record to get the
                // id. In order to avoid hitting the database, we will utilize
                // a simple cache.
                if (isset($row['PlaybackMachine'])) {
                    $playbackMachineName = $row['PlaybackMachine'];
                    // Check the cache first for this playback machine record
                    $playbackMachine = $playbackMachineCache[$playbackMachineName] ?? null;
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
                if (isset($row['IART'])) {
                    $departmentName = $row['IART'];
                    // Check the cache first for this department record
                    $department = $departmentCache[$departmentName] ?? null;
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
                $originalPm = $row['OriginalPm'] ?? null;
                $duration = isset($row['Duration']) ? DurationFormat::toSeconds($row['Duration']) : null;

                if (! empty($originalPm)) {
                    // Original PM not empty so this is an update
                    $instanceUpdated = false;
                    $instance = PreservationInstance::find($originalPm);
                    if (! empty($row['OriginatorReference'])) {
                        $instance->file_name = $row['OriginatorReference'];
                        $instanceUpdated = true;
                    }
                    if (! empty($row['FileSize'])) {
                        $instance->file_size_in_bytes = $row['FileSize'];
                        $instanceUpdated = true;
                    }
                    if (isset($duration)) {
                        $instance->duration_in_seconds = $duration;
                        $instanceUpdated = true;
                    }
                    if (isset($department)) {
                        $instance->department_id = $department->id;
                        $instanceUpdated = true;
                    }
                    if ($instanceUpdated === true) {
                        $instance->save();
                        $instances[] = $instance;
                        $updated++;
                    }

                    // Update related transfers if specified, which should exist
                    if (isset($playbackMachine) || ! empty($row['OriginationDate']) || ! empty($row['TransferNote'])) {
                        $relatedTransfers = $instance->transfers;
                        foreach ($relatedTransfers as $transfer) {
                            if (isset($playbackMachine)) {
                                $transfer->playback_machine_id = $playbackMachine->id;
                            }
                            if (! empty($row['OriginationDate'])) {
                                $transfer->transfer_date = $row['OriginationDate'];
                            }
                            if (! empty($row['TransferNote'])) {
                                $transfer->transfer_note = $row['TransferNote'];
                            }
                            $transfer->save();
                            $transfers[] = $transfer;
                            $updated++;
                        }
                    }

                    // Update related cuts if specified, which should exist
                    if (! empty($row['Side'])) {
                        $relatedCuts = $instance->cuts;
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
                    $audioInstance = new AudioInstance;
                    // Sampling rate id 8 = 96kHz/24bit
                    $audioInstance->sampling_rate_id = 8;
                    $audioInstance->save();
                    $created++;

                    // Create the PM using data from the import.
                    $instance = new PreservationInstance;
                    $instance->call_number = $callNumber;
                    $instance->file_name = $row['OriginatorReference'];
                    $instance->file_size_in_bytes = $row['FileSize'];
                    $instance->duration_in_seconds = $duration;
                    $instance->department_id = $department->id;
                    // APPDEV-6760
                    $instance->file_format = 'BWF';
                    $instance->file_codec = 'Uncompressed PCM';

                    $instance->subclass_type = 'AudioInstance';
                    $instance->subclass_id = $audioInstance->id;
                    $instance->save();
                    $instances[] = $instance;
                    $created++;

                    // There's really no information to import here,
                    // we just need a new id for the Transfer.
                    $audioTransfer = new AudioTransfer;
                    $audioTransfer->save();
                    $created++;

                    // Create the transfer
                    $transfer = new Transfer;
                    $transfer->call_number = $callNumber;
                    $transfer->preservation_instance_id = $instance->id;
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
                    $cut->preservation_instance_id = $instance->id;
                    $cut->transfer_id = $transfer->id;
                    $cut->side = $row['Side'];
                    $cut->cut_number = 1;
                    $cut->save();
                    $created++;
                }

                if (! empty($row['Size']) || ! empty($row['TrackConfiguration']) || ! empty($row['Base']) || ! empty($row['Speed'])) {
                    $audioVisualItem = AudioVisualItem::where('call_number', $callNumber)->first();
                    $audioItem = $audioVisualItem->subclass;
                    if (! empty($row['Size'])) {
                        $audioItem->size = $row['Size'];
                    }
                    if (! empty($row['TrackConfiguration'])) {
                        $audioItem->track_configuration = $row['TrackConfiguration'];
                    }
                    if (! empty($row['Base'])) {
                        $audioItem->base = $row['Base'];
                    }
                    if (! empty($row['Speed'])) {
                        $audioVisualItem->speed = $row['Speed'];
                    }

                    if ($audioItem->isDirty()) {
                        $audioItem->save();
                        $updated++;
                    }
                    if ($audioVisualItem->isDirty()) {
                        $audioVisualItem->save();
                        $updated++;
                    }
                }

                // collect related AV item in array for solr update
                $item = AudioVisualItem::where('call_number', $callNumber)->first();
                $items[] = $item;
            } // end foreach row
            // if nothing was created and records were updated, the import is an update
            if (empty($created) && ! empty($updated)) {
                $importTransaction->import_action = 'update';
                $importTransaction->save();
            }
            DB::statement('set @transaction_id = null;');
        });

        $this->solrItems->update($items);
        $this->solrInstances->update($instances);
        $this->solrTransfers->update($transfers);

        return ['created' => $created, 'updated' => $updated];
    }

    private function belongsToItem($pmId, $callNumber)
    { // TODO can reduce to 1 query by querying preservation instances directly
        $item = AudioVisualItem::where('call_number', $callNumber)->first();
        if ($item !== null) {
            $instances = $item->preservationInstances;
            foreach ($instances as $instance) {
                if ($instance->id == $pmId) {
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

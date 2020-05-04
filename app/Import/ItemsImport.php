<?php namespace Jitterbug\Import;

use Auth;
use DB;
use Illuminate\Support\Facades\Log;
use Uuid;

use Illuminate\Support\MessageBag;

use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\AudioItem;
use Jitterbug\Models\CallNumberSequence;
use Jitterbug\Models\Collection;
use Jitterbug\Models\FilmItem;
use Jitterbug\Models\Format;
use Jitterbug\Models\ImportTransaction;
use Jitterbug\Models\VideoItem;
use Jitterbug\Util\CsvReader;
use Jitterbug\Support\SolariumProxy;


class ItemsImport extends Import {

  protected $requiredItemsImportKeys = array();
  protected $itemsImportKeys = array();
  protected $mustAlreadyExistInDbKeys = array();

  protected $solrItems;

  protected $data = null;

  public function __construct($filePath)
  {
    $this->requiredItemsImportKeys = array('Type', 'Title', 'ArchivalIdentifier',
      'AccessionNumber', 'FormatID');
    $this->itemsImportKeys = array_merge($this->requiredItemsImportKeys, 
      array('CallNumber', 'ContainerNote', 'LegacyID', 'RecLocation', 'ItemYear',
        'ItemDate', 'Size', 'Element', 'Base', 'Color', 'SoundType', 
        'LengthInFeet', 'ContentDescription', 'ReelTapeNumber'));
    $this->mustAlreadyExistInDbKeys = array(
      'CallNumber' => AudioVisualItem::class,
      'ArchivalIdentifier' => Collection::class
    );

    $this->solrItems = new SolariumProxy('jitterbug-items');

    $reader = new CsvReader($filePath);
    $this->data = $reader->fetchKeys($this->itemsImportKeys);
  }

  public function validate()
  {
    $messages = array();
    foreach($this->data as $row) {
      $bag = new MessageBag();
      $messages[] = $bag;
      $callNumbers = array();
      foreach($this->itemsImportKeys as $key) {
        // Validate that all required fields have values
        if (in_array($key, $this->requiredItemsImportKeys) 
          && empty($row[$key])) {
          $bag->add($key, 'A value for ' . $key . ' is required.');
        }
        // Validate type is audio, film, or video
        if ($key==='Type' 
          && !empty($row[$key]) && !$this->isValidType($row[$key])) {
          $bag->add($key, $key . ' is not valid. Must be \'audio\', \'film\' or \'video\'.');
        }
        // Validates certain field values already exist in the DB
        foreach($this->mustAlreadyExistInDbKeys as $dbKey => $class) {
          if (!empty($row[$dbKey]) && !$this->valueExists($class, snake_case($dbKey), $row[$dbKey])) {
            $bag->add($dbKey, $dbKey . ' must already exist in the database.');
          }
        }
        // Validate format exists
        if ($key==='FormatID' 
          && !empty($row[$key]) && !$this->formatExists($row[$key])) {
          $bag->add($key, $key . ' is not a recognized format.');
        }
        // Validate call number exists for Collection & Format pair
        if (!empty($row['ArchivalIdentifier']) && !empty($row['FormatID']) &&
          !$this->callNumberSequenceExists($row['ArchivalIdentifier'], $row['FormatID'])) {
          $bag->add('ArchivalIdentifier', 'The Collection/Format pairing does not have a valid CallNumberSequence available.');
          $bag->add('FormatID', 'The Collection/Format pairing does not have a valid CallNumberSequence available.');
        }
        // Validate item date is formatted correctly
        if ($key==='ItemDate' 
          && !empty($row[$key]) && !$this->isValidDate($row[$key])) {
          $bag->add(
            $key, $key . ' must be adhere to the following format: ' 
            . 'YYYY-MM-DD');
        }
        // Validate length in feet is an integer
        if ($key==='LengthInFeet' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate record type is audio since this field is set
        if ($key==='Size' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && $row['Type'] !== 'audio') {
          $bag->add($key, $key . ' is not a valid field for the specified ' 
            . 'item type.');
        }
        // Validate record type is film or video since this field is set
        if ($key==='Element' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && $row['Type'] === 'audio') {
          $bag->add($key, $key . ' is not a valid field for the specified ' 
            . 'item type.');
        }
        // Validate record type is audio or film since this field is set
        if ($key==='Base' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && $row['Type'] === 'video') {
          $bag->add($key, $key . ' is not a valid field for the specified ' 
            . 'item type.');
        }
        // Validate record type is film or video since this field is set
        if ($key==='Color' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && $row['Type'] === 'audio') {
          $bag->add($key, $key . ' is not a valid field for the specified ' 
            . 'item type.');
        }
        // Validate record type is film since this field is set
        if ($key==='SoundType' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && ($row['Type'] === 'audio' || 
                                                  $row['Type'] === 'video')) {
          $bag->add($key, $key . ' is not a valid field for the specified ' 
            . 'item type.');
        }
        // Validate sound type is "Magnetic", "Optical", "Magnetic; Optical", or "Silent"
        if ($key==='SoundType' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && $row['Type'] === 'film' 
          && !$this->validSoundType($row[$key])) {
          // TODO APPDEV-8900 fix hardcoded values
          $bag->add($key, $key . ' must be "Magnetic", "Optical", "Magnetic; Optical", or "Silent".');
        }
        // Validate record type is film since this field is set
        if ($key==='LengthInFeet' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && $row['Type'] !== 'film') {
          $bag->add($key, $key . ' is not a valid field for the specified ' 
            . 'item type.');
        }

        // Validate the call number is unique amongst call number values in the rest of the file
        if ($key === 'CallNumber'
          && !empty($row[$key]) && in_array($row[$key], $callNumbers, true)) {
          $bag->add($key, $key . ' has already been used in this file.');
        } else if ($key === 'CallNumber' && !empty($row[$key])) {
          $callNumbers[] = $row[$key];
        }
      }
    }
    return $messages;
  }

  public function execute()
  {
    // Keep track of the items to create in Solr
    $items = array();
    $created = 0;

    // Update MySQL
    DB::transaction( function () 
      use (&$items, &$created) {
      $transactionId = Uuid::uuid4();
      DB::statement("set @transaction_id = '$transactionId';");
      
      $importTransaction = new ImportTransaction;
      $importTransaction->transaction_id = $transactionId;
      $importTransaction->import_type = 'items';
      $importTransaction->save();

      foreach($this->data as $row) {
        $callNumber = $row['CallNumber'] ?? null;
        $subclassType = studly_case($row['Type'] . '_item');

        if (isset($callNumber)) {
          // this is an update
          $audioVisualItem = AudioVisualItem::where('call_number', $callNumber)->first();

          if (!empty($row['Title'])) {
            $audioVisualItem->title = $row['Title'];
          }
          if (!empty($row['ContainerNote'])) {
            $audioVisualItem->container_note = $row['ContainerNote'];
          }
          if (!empty($row['AccessionNumber'])) {
            $audioVisualItem->accession_number = $row['AccessionNumber'];
          }
          if (!empty($row['LegacyID'])) {
            $audioVisualItem->legacy = $row['LegacyID'];
          }
          if (!empty($row['FormatID'])) {
            $audioVisualItem->format_id = $row['FormatID'];
          }
          if (!empty($row['RecLocation'])) {
            $audioVisualItem->recording_location = $row['RecLocation'];
          }
          if (!empty($row['ItemYear'])) {
            $audioVisualItem->item_year = $row['ItemYear'];
          }
          if (!empty($row['ItemDate'])) {
            $audioVisualItem->item_date = $row['ItemDate'];
          }
          if (!empty($row['ReelTapeNumber'])) {
            $audioVisualItem->reel_tape_number = $row['ReelTapeNumber'];
          }

          // take care of subclass changes
          $subclass = $audioVisualItem->subclass;
          $row['subclassType'] = $subclassType;
          $subclass = $this->updateSubclassAttributes($subclass, $row, true);

          if ($audioVisualItem->isDirty()) {
            $audioVisualItem->save;
          }
          if ($subclass->isDirty()) {
            $subclass->save;
          }
        } else {
          $collectionId = Collection::where('archival_identifier', $row['ArchivalIdentifier'])->first()->id;
          $formatId = $row['FormatID'];
          $sequence = CallNumberSequence::next($collectionId, $formatId);

          // create subclass for audio visual item
          $subclass = new $subclassType;
          $row['subclassType'] = $subclassType;
          $subclass = $this->updateSubclassAttributes($subclass, $row, false);
          $subclass->call_number = $sequence->callNumber();
          $subclass->save();

          $item = new AudioVisualItem;
          $item->call_number = $sequence->callNumber();
          $item->subclass_type = $subclassType;
          $item->subclass_id = $subclass->id;
          $item->entry_date = date('Y-m-d');
          // Required fields
          $item->title = $row['Title'];
          $item->collection_id = $collectionId;
          $item->format_id = $formatId;
          $item->accession_number = $row['AccessionNumber'];
          // Optional fields
          $item->container_note =
            isset($row['ContainerNote']) ? $row['ContainerNote'] : null;
          $item->legacy =
            isset($row['LegacyID']) ? $row['LegacyID'] : null;
          $item->recording_location =
            isset($row['RecLocation']) ? $row['RecLocation'] : null;
          $item->item_year =
            isset($row['ItemYear']) ? $row['ItemYear'] : null;
          $item->item_date =
            isset($row['ItemDate']) ? $row['ItemDate'] : null;
          $item->reel_tape_number =
            isset($row['ReelTapeNumber']) ? $row['ReelTapeNumber'] : null;
          $item->save();
          $created++;

          $sequence->increase();

          $items[] = $item;
        }
      } // end foreach row

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrItems->update($items);

    return array('created' => $created);
  }

  private function formatExists($formatId)
  {
    return Format::where('id', $formatId)->exists();
  }

  private function callNumberSequenceExists($archivalIdentifier, $formatId)
  {
    $collection = Collection::where('archival_identifier', $archivalIdentifier)->first();
    if ($collection === null) {
      return false;
    }
    return CallNumberSequence::next($collection->id, $formatId) !== null;
  }

  private function validSoundType($soundType)
  {
    return $soundType === 'Optical' || $soundType === 'Silent' || 
          $soundType === 'Magnetic' || $soundType === 'Magnetic; Optical';
  }

  private function isValidType($type)
  {
    return $type === 'audio' || $type === 'film' || $type === 'video';
  }

  private function updateSubclassAttributes($subclass, $array, $isUpdate)
  {
    $subclassType = $array['subclassType'];
    // if it's an update, the default is the original value.
    // if it's a new record, the default is null
    $defaultSize = $isUpdate ? $subclass->size : null;
    $defaultElement = $isUpdate ? $subclass->element : null;
    $defaultBase = $isUpdate ? $subclass->base : null;
    $defaultColor = $isUpdate ? $subclass->color : null;
    $defaultSoundType = $isUpdate ? $subclass->sound_type : null;
    $defaultLength = $isUpdate ? $subclass->length : null;
    $defaultContentDescription = $isUpdate ? $subclass->content_description : null;

    // if the array has a value for the attribute, use it. otherwise use the default
    $subclass->content_description = $array['ContentDescription'] ?? $defaultContentDescription;
    if ($subclassType === 'AudioItem') {
      $subclass->base = $array['Base'] ?? $defaultBase;
      $subclass->size = $array['Size'] ?? $defaultSize;
    } else if ($subclassType === 'FilmItem') {
      $subclass->element = $array['Element'] ?? $defaultElement;
      $subclass->base = $array['Base'] ?? $defaultBase;
      $subclass->color = $array['Color'] ?? $defaultColor;
      $subclass->sound_type = $array['SoundType'] ?? $defaultSoundType;
      $subclass->length_in_feet = $array['LengthInFeet'] ?? $defaultLength;
    } else if ($subclassType === 'VideoItem') {
      $subclass->element = $array['Element'] ?? $defaultElement;
      $subclass->color = $array['Color'] ?? $defaultColor;
    }
    return $subclass;
  }

}

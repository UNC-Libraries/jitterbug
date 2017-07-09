<?php namespace Jitterbug\Import;

use Auth;
use DB;
use Log;
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

  protected $solrItems;

  protected $data = null;

  public function __construct($filePath)
  {
    $this->requiredItemsImportKeys = array('Type', 'Title', 'Collection',
      'AccessionNumber', 'FormatID');
    $this->itemsImportKeys = array_merge($this->requiredItemsImportKeys, 
      array('ContainerNote', 'LegacyID', 'RecLocation', 'ItemYear', 
        'ItemDate', 'Size', 'Element', 'Base', 'Color', 'SoundType', 
        'LengthInFeet', 'ContentDescription'));

    $this->solrItems = new SolariumProxy('jitterbug-items');

    $reader = new CsvReader($filePath);
    $this->data = $reader->fetchKeys($this->itemsImportKeys);
  }

  public function validate()
  {
    $messages = array();
    foreach($this->data as $row) {
      $bag = new MessageBag();
      array_push($messages, $bag);
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
        // Validate collection exists
        if ($key==='Collection' 
          && !empty($row[$key]) && !$this->collectionExists($row[$key])) {
          $bag->add($key, $key . ' must already exist in the database.');
        }
        // Validate accession number is an integer
        if ($key==='AccessionNumber' 
          && !empty($row[$key]) && !ctype_digit($row[$key])) {
          $bag->add($key, $key . ' must be an integer.');
        }
        // Validate format exists
        if ($key==='FormatID' 
          && !empty($row[$key]) && !$this->formatExists($row[$key])) {
          $bag->add($key, $key . ' is not a recognized format.');
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
          $bag->add($key, $key . ' must be "Magnetic", "Optical", "Magnetic; Optical", or "Silent".');
        }
        // Validate record type is film since this field is set
        if ($key==='LengthInFeet' 
          && !empty($row[$key]) && !empty($row['Type']) 
          && $this->isValidType($row['Type']) && $row['Type'] !== 'film') {
          $bag->add($key, $key . ' is not a valid field for the specified ' 
            . 'item type.');
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
      $importTransaction->transactionId = $transactionId;
      $importTransaction->importType = 'items';
      $importTransaction->save();

      foreach($this->data as $row) {
        $subclassType = studly_case($row['Type'] . '_item');
        $subclass = new $subclassType;
        $collectionId = $row['Collection'];
        $formatId = $row['FormatID'];
        $sequence = CallNumberSequence::next($collectionId, $formatId);
        $subclass->callNumber = $sequence->callNumber();
        // Optional subclass fields
        $size = isset($row['Size']) ? $row['Size'] : null;
        $element = isset($row['Element']) ? $row['Element'] : null;
        $base = isset($row['Base']) ? $row['Base'] : null;
        $color = isset($row['Color']) ? $row['Color'] : null;
        $soundType = isset($row['SoundType']) ? $row['SoundType'] : null;
        $length = isset($row['LengthInFeet']) ? $row['LengthInFeet'] : null;
        $subclass->contentDescription = 
          isset($row['ContentDescription']) ? $row['ContentDescription'] : null;
        if ($subclassType === 'AudioItem') {
          $subclass->base = $base;
          $subclass->size = $size;
        } else if ($subclassType === 'FilmItem') {
          $subclass->element = $element;
          $subclass->base = $base;
          $subclass->color = $color;
          $subclass->soundType = $soundType;
          $subclass->lengthInFeet = $length;
        } else if ($subclassType === 'VideoItem') {
          $subclass->element = $element;
          $subclass->color = $color;
        }
        $subclass->save();

        $item = new AudioVisualItem;
        $item->callNumber = $sequence->callNumber();
        $item->subclassType = $subclassType;
        $item->subclassId = $subclass->id;
        $item->entryDate = date('Y-m-d');
        // Required fields
        $item->title = $row['Title'];
        $item->collectionId = $collectionId;
        $item->formatId = $formatId;
        $item->accessionNumber = $row['AccessionNumber'];
        // Optional fields
        $item->containerNote = 
          isset($row['ContainerNote']) ? $row['ContainerNote'] : null;
        $item->legacy = 
          isset($row['LegacyID']) ? $row['LegacyID'] : null;
        $item->recordingLocation = 
          isset($row['RecLocation']) ? $row['RecLocation'] : null;
        $item->itemYear = 
          isset($row['ItemYear']) ? $row['ItemYear'] : null;
        $item->itemDate = 
          isset($row['ItemDate']) ? $row['ItemDate'] : null;
        $item->save();
        $created++;

        $sequence->increase();

        array_push($items, $item);
      } // end foreach row

      DB::statement('set @transaction_id = null;');      
    });

    $this->solrItems->update($items);

    return array('created' => $created);
  }


  private function formatExists($formatId)
  {
    $format = Format::find($formatId);
    if ($format !== null) {
      return true;
    }
    return false;
  }

  private function collectionExists($collectionId)
  {
    $collection = Collection::find($collectionId);
    if ($collection !== null) {
      return true;
    }
    return false;
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

}

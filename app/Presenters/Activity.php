<?php namespace Jitterbug\Presenters;

use Log;

class Activity
{
  // The transaction UUID.
  public $transactionId = null;
  // Created, updated, deleted or imported.
  public $action = null;
  // True or false if batch.
  public $batch = null;
  // The total number of objects that the user selected for modification.
  public $batchSize = null;
  // The field that was updated, only populated for updates.
  public $field = null;
  // It it was an import, the type (audio, film or video).
  public $importType = null;
  // The call number of the related item, not populated for batch operations.
  public $itemCallNumber = null;
  // The type of the related item, (audio, film or video).
  public $itemType = null;
  // The number of fields that were updated, only populated for single object 
  // update transactions.
  public $numFields = null;
  // The number of records that were affected by the activity.
  public $numAffected = null;
  // The types of objects that were affected (audio item, video item, audio 
  // master, etc) mapped to the base object ids that were affected for 
  // each type.
  public $objectTypesToIds = null;
  // The time that the activity occurred.
  public $timestamp = null;
  // The name of the user responsible for the activity.
  public $user = null;

  /**
   * Return a formatted string representation of the original object this 
   * activity relates to. For example, if a user chooses to delete an audio 
   * visual item along with its preservation masters and transfers, the 
   * original object would be the audio visual item.
   *
   * Returned string is like: 'audio item' OR 'audio and film item' OR 'audio, 
   * film and video item'. Batch deletions can be of multiple types, which 
   * is why we have to accommodate the multipe media types scenario.
   *
   * @return string
   */
  public function object()
  {
    if ($this->action === 'imported' && $this->importType === 'audio') {
      return 'audio record';
    }
    if ($this->action === 'imported' && $this->importType === 'film') {
      return 'film record';
    }
    if ($this->action === 'imported' && $this->importType === 'video') {
      return 'video record';
    }

    $objectType = $this->objectType();
    if ($objectType === 'master' && !$this->batch) {
      return 'preservation master';
    } else if ($objectType === 'transfer' && !$this->batch) {
      return 'transfer';
    }

    $mediaTypes = array();
    foreach ($this->objectTypesToIds as $key => $value) {
      $explodedKey = explode(' ', $key);
      if ($explodedKey[0] === 'cut') {
        break;
      }
      $mediaType = array_shift($explodedKey);
      if ($explodedKey[0] !== $objectType) {
        break;
      }
      array_push($mediaTypes, $mediaType);
    }
    // sort media types in order of audio, film, video
    sort($mediaTypes);

    $formattedObject = 
                $this->formatMediaTypesAndObject($mediaTypes, $objectType);

    if ($this->batch) {
      return 'batch of ' . $this->batchSize . ' ' . $formattedObject . 's'; 
    } else {
      return $formattedObject;
    }
  }

  /**
   * Format an array of media types along with the object name. The array
   * will only ever be more than a single element in length if the user
   * batch deletes objects of multiple types.
   */
  private function formatMediaTypesAndObject($types, $object)
  {
    if (count($types) === 0) {
      // this will be a cut
      return $object;
    } else if (count($types) === 1) {
      // this will the usual case
      return $types[0] . ' ' . $object;
    } else if (count($types) === 2) {
      // this will only ever be a batch delete
      return $types[0] . ' and ' . $types[1] . ' ' . $object;
    } else if (count($types) === 3) {
      // this will only ever be a batch delete
      return $types[0] . ', ' . $types[1] . ' and ' 
        . $types[1] . ' ' . $object;
    }
  }

  /**
   * Return the object type (item, master, transfer or cut) of the 
   * original object.
   *
   * @return string
   */
  public function objectType()
  {
    // We can be sure the first object in the objectTypesToIds map is the 
    // original object because when the objects were saved (in the 
    // controllers), the last save was for the original object, which 
    // means it will be the first one when the revisions are fetched in 
    // descending order of their ids, which is done in the constructor
    // of TransactionDigest.
    reset($this->objectTypesToIds);
    $objectKey = key($this->objectTypesToIds);
    if ($objectKey === 'cut') {
      return 'cut';
    }

    // e.g. will explode 'audio item' to ['audio', 'item']
    $explodedKey = explode(' ', $objectKey);
    // This will get the last element of the array, which is the object type 
    // (item, master or transfer)
    $objectType = $explodedKey[1];

    return $objectType;
  }

  /**
   * Return the object id (item, master, transfer or cut) of the 
   * original object.
   *
   * @return int
   */
  public function objectId()
  {
    reset($this->objectTypesToIds);
    return key(current($this->objectTypesToIds));
  }

  /**
   * Test if the original object exists. This value is stored when the object
   * map is created in TransactionDigest.
   *
   * @return boolean
   */
  public function objectExists()
  {
    reset($this->objectTypesToIds);
    return current($this->objectTypesToIds)[key(current($this->objectTypesToIds))];
  }

  /**
   * Test whether the original object is an audio visual item.
   *
   * @return boolean
   */
  public function objectIsItem()
  {
    return str_contains($this->object(), 'item') && !$this->batch;
  }

  /**
   * Return the word that connects the action to the object.
   *
   * @return string
   */
  public function objectArticle()
  {
    // If object() begins with a vowel
    if (preg_match('/^[aeiou]/i', $this->object())) {
      return 'an';
    } else {
      return 'a';
    }
  }

}


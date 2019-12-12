<?php namespace Jitterbug\Presenters;

use DB;
use Log;

use Illuminate\Support\Collection;

use Venturecraft\Revisionable\Revision;

use Jitterbug\Models\Activity;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\ImportTransaction;

/**
 * Analyzes and summarizes a revision transaction and compiles a
 * list of activities to be displayed in the activity stream module 
 * of the dashboard.
 */
class TransactionDigest
{

  /**
   * The base model classes in Jitterbug that we track revisions
   * for that don't have a 'parent' Jitterbug class. This array is used
   * in analyzing the revisions.
   *
   * @var array
   */
  protected $baseClasses = array('AudioVisualItem' => 1,
                                 'PreservationMaster' => 1,
                                 'Transfer' => 1,
                                 'Cut' => 1);

  /**
   * The activites, generated by this class from analyzing the revisions
   * of the transaction.
   *
   * @var array
   */
  protected $activities = null;

  /**
   * The UUID for this transaction.
   *
   * @var string
   */
  protected $transactionId = null;

  /**
   * The revisions involved in this transaction.
   *
   * @var Illuminate\Support\Collection
   */
  protected $revisions = null;

  /**
   * The action of the transaction (created, updated, deleted, 
   * or imported), determined by the analyzeRevisions() function.
   *
   * @var string
   */
  protected $action = null;

  /**
   * If this transaction was an import, the type of import
   * (audio, film, or video).
   *
   * @var string
   */
  protected $importType = null;

  /**
   * Whether or not the transaction was a batch operation,
   * determined by the analyzeRevisions() function.
   * 
   * @var boolean
   */
  protected $batch = null;

  /**
   * The number of objects that were selected for batch modification
   * by the user.
   * 
   * @var int
   */
  protected $batchSize = null;

  /**
   * The number of revisionable records affected by the transaction.
   * This is the number the user should potentially know about, not
   * necessarily the actual number of jitterbug records that changed
   * behind the scenes.
   *
   * @var int
   */
  protected $numAffected = null;

  /**
   * The AudioVisualItem associated with this transaction, if it's not a
   * batch transaction (which might be associated with multiple items).
   *
   * @var AudioVisualItem
   */
  protected $associatedItem = null;

  /**
   * The call number associated with the transaction, if it's not a batch 
   * transaction (which might be associated with multiple call numbers).
   *
   * @var string
   */
  protected $associatedCallNumber = null;

  /**
   * The type of the item that is ultimately associated with this transaction,
   * if it's not batch.
   *
   * @var string
   */
  protected $associatedItemType = null;

  /**
   * The types of objects (audio item, film item, video item, audio master, 
   * etc.) affected by the transaction mapped to ids of objects affected.
   *
   * @var array
   */
  protected $objectTypesToIds = null;

  /**
   * Create a new instance.
   *
   * @return void
   */
  public function __construct($transactionId)
  {
    $this->transactionId = $transactionId;
    // Order revisions by most recent, which is important for analysis
    $this->revisions = Revision::where('transaction_id', $transactionId)
                                     ->orderBy('id', 'desc')
                                     ->get();
    $this->analyzeRevisions();
    $this->generateActivities();
  }

  /**
   * Return the generated activities.
   *
   * @return array
   */
  public function activities()
  {
    return $this->activities;
  }

  /**
   * Perform the analysis of the transaction revisions to determine
   * the action that took place, and to what objects. 
   */
  protected function analyzeRevisions()
  {
    $this->buildObjectTypesToIds();

    if ($this->wasCreate()) {
      $this->action = 'created';
    } else if ($this->wasUpdate()) {
      $this->action = 'updated';
    } else if ($this->wasDelete()) {
      $this->action = 'deleted';
    }

    if ($this->wasAudioImport()) {
      $this->action = 'imported';
      $this->importType = 'audio';
    } else if ($this->wasVideoImport()) {
      $this->action = 'imported';
      $this->importType = 'video';
    } else if ($this->wasItemsImport()) {
      $this->action = 'imported';
      $this->importType = 'items';
    }

    if ($this->action === 'imported') {
      $this->batch = true;
      $this->batchSize = $this->computeImportSize();
    }

    if ($this->action === null) {
      throw new \Exception('Unrecognized transaction type: ' 
        . $this->transactionId);
    }

    if ($this->batch === null && $this->wasBatch()) {
      $this->batch = true;
    } else if ($this->batch === null) {
      $this->batch = false;
    }

    // If this is not a batch operation, find the call number
    // and item type it relates to.
    if (!$this->batch) {
      $this->findAssociatedCallNumber();
      $this->findAssociatedItemType();
    }

    $this->computeNumAffected();
  }

  
  /**
   * Create the activities associated with this transaction. Assumes 
   * the analyzeRevisions() function has already been called. 
   *
   * @return void
   */
  protected function generateActivities()
  {
    $this->activities = array();

    // Populate a new activity with the base attributes
    $activity = new Activity;
    $activity->transactionId = $this->transactionId;
    $activity->action = $this->action;
    $activity->batch = $this->batch;
    $activity->batchSize = $this->batchSize;
    $activity->timestamp = $this->revisions->first()->created_at;
    $activity->user = $this->getUserResponsibleName();
    // If batch, itemCallNumber & itemType will be null
    $activity->itemCallNumber = $this->associatedCallNumber;
    $activity->itemType = $this->associatedItemType;
    $activity->importType = $this->importType;

    $this->filterCallNumberUpdates();

    // filterCallNumberUpdates() may change the numAffected value and
    // objectTypesToIds map, so setting these need to come after that 
    // function call
    $activity->numAffected = $this->numAffected;
    $activity->objectTypesToIds = $this->objectTypesToIds;

    // Since this is a regular update, each revision will
    // be for an individual field. If there are just a handfull
    // of fields, we will create activities for each revision.
    // If there are more than a handfull, we'll create 1 activity
    // to summarize so as not to fill up the user's activity
    // stream with a single transaction.
    if ($this->action === 'updated' 
                           && !$this->batch && $this->revisions->count() < 5) {
      foreach ($this->revisions as $revision) {
        $updateActivity = clone $activity;
        $updateActivity->field = $revision->fieldName();
        array_push($this->activities, $updateActivity);
      }
      return;
    } else if ($this->action === 'updated' && !$this->batch) {
      $activity->numFields = $this->revisions->count();
    }

    array_push($this->activities, $activity);
  }

  /**
   * Test whether or not a call number was updated.
   */
  protected function callNumberUpdated()
  {
    foreach ($this->revisions as $revision) {
      if ($revision->field === 'call_number') {
        return true;
      }
    }
    return false;
  }

  /**
   * If this is an update where the call number was updated, this function
   * filters out revisions and object types that aren't for the original
   * object type. We use call numbers as foreign keys on preservation
   * masters, transfers, and cuts, so those need to change if a call number 
   * on an original object changes (such as an audio visual item), but 
   * the user probably doesn't need to know that.
   */
  protected function filterCallNumberUpdates()
  {
    if ($this->action === 'updated' && $this->callNumberUpdated()) {

      $objectType;
      reset($this->objectTypesToIds);
      $objectKey = key($this->objectTypesToIds);
      if ($objectKey === 'cut') {
        $objectType = $objectKey;
      } else {
        // e.g. will explode 'audio item' to ['audio', 'item']
        $explodedKey = explode(' ', $objectKey);
        // This will get the last element of the array, which is the object type 
        // (item, master or transfer)
        $objectType = $explodedKey[1];
      }

      $revisionableType = null;
      if ($objectType === 'item') {
        $revisionableType = 'AudioVisualItem';
      } else if ($objectType === 'master') {
        $revisionableType = 'PreservationMaster';
      } else if ($objectType === 'transfer') {
        $revisionableType = 'Transfer';
      } else if ($objectType === 'cut') {
        $revisionableType = 'Cut';
      }

      foreach ($this->revisions as $key => $revision) {
        if ($revision->field === 'call_number' 
          && $revision->revisionable_type !== $revisionableType) {
          $this->revisions->forget($key);
        }
        // The preservation master id of a cut changes only
        // if the call number changes on the associated transfer, 
        // so we will filter this out too.
        if ($revision->field === 'preservation_master_id' 
          && $revision->revisionable_type === 'Cut') {
          $this->revisions->forget($key);
        }
      }
      
      foreach ($this->objectTypesToIds as $key => $ids) {
        if (!ends_with($key, $objectType)) {
          unset($this->objectTypesToIds[$key]);
        }
      }

      // We've potentially changed the objectTypesToIds map, so we need to
      // recalculate the num affected.
      $this->computeNumAffected();
    }

  }
  
  /**
   * Return the name of the user that carried out the transaction.
   *
   * @return string
   */
  protected function getUserResponsibleName()
  {
    $firstRev = $this->revisions->first();
    return $firstRev->userResponsible()->fullName();
  }

  /**
   * Every object that we keep revisions for is ultimately associated
   * with an audio visual item, unless it's been orphaned. This 
   * function returns said item.
   *
   * @return string
   */
  protected function findAssociatedItem()
  {
    if ($this->associatedItem) return $this->associatedItem;
    if ($this->batch) return null;
    $firstRev = $this->revisions->first();
    $class = $firstRev->revisionable_type;
    $instance = 
      $class::withTrashed()->findOrFail($firstRev->revisionable_id);
    if (!array_key_exists($firstRev->revisionable_type, $this->baseClasses)) {
      $instance = $instance->superclass;
    }
    $this->associatedItem = AudioVisualItem::withTrashed()
      ->where('call_number', $instance->callNumber)
      ->first();
    return $this->associatedItem;
  }

  /**
   * Every object that we keep revisions for is ultimately associated
   * with an audio visual item. This function returns the type of this 
   * item (audio, film, or video).
   *
   * @return string
   */
  protected function findAssociatedItemType()
  {
    if ($this->associatedItemType) return $this->associatedItemType;
    $item = AudioVisualItem::withTrashed()
      ->where('call_number', $this->findAssociatedCallNumber())
      ->first();
    if ($item !== null) {
      $this->associatedItem = $item;
      $this->associatedItemType = strtolower($item->type);
    }
    return $this->associatedItemType;
  }

  /**
   * Get the call number from the referenced object (item, master, transfer
   * or cut) in the first revision.
   *
   * @return string
   */
  protected function findAssociatedCallNumber()
  {
    if ($this->associatedCallNumber) return $this->associatedCallNumber;
    $firstRev = $this->revisions->first();
    $class = $firstRev->revisionable_type;
    $instance = 
      $class::withTrashed()->findOrFail($firstRev->revisionable_id);
    if (!array_key_exists($firstRev->revisionable_type, $this->baseClasses)) {
      $instance = $instance->superclass;
    }
    $this->associatedCallNumber = $instance->callNumber;
    return $instance->callNumber;
  }

  /**
   * Determine if this transaction was for creating records.
   *
   * @return boolean
   */
  protected function wasCreate()
  {
    foreach ($this->revisions as $revision) {
      if ($revision->field !== 'created_at') {
        return false;
      }
    }
    return true;
  }

  /**
   * Determine if this transaction was for updating records.
   *
   * @return boolean
   */
  protected function wasUpdate()
  {
    foreach ($this->revisions as $revision) {
      if ($revision->field === 'created_at' ||
          $revision->field === 'deleted_at') {
        return false;
      }
    }
    return true;
  }

  /**
   * Determine if this transaction was for deleting records.
   *
   * @return boolean
   */
  protected function wasDelete()
  {
    foreach ($this->revisions as $revision) {
      if ($revision->field !== 'deleted_at') {
        return false;
      }
    }
    return true;
  }

  /**
   * Determine if this transaction was for importing audio visual items.
   */
  protected function wasItemsImport()
  {
    $importTransaction = 
      ImportTransaction::where('transaction_id', $this->transactionId)
                       ->where('import_type', 'items')->first();

    return $importTransaction !== null;
  }

  /**
   * Determine if this transaction was for importing audio records.
   *
   * @return boolean
   */
  protected function wasAudioImport()
  {
    $importTransaction = 
      ImportTransaction::where('transaction_id', $this->transactionId)
                       ->where('import_type', 'audio')->first();

    return $importTransaction !== null;
  }

  /**
   * Determine if this transaction was for importing video records.
   *
   * @return boolean
   */
  protected function wasVideoImport()
  {
    $importTransaction = 
      ImportTransaction::where('transaction_id', $this->transactionId)
                       ->where('import_type', 'video')->first();

    return $importTransaction !== null;
  }

  /**
   * Computes the number of records that were in the batch import.
   */
  protected function computeImportSize()
  {
    if ($this->batchSize) return $this->batchSize;
    
    if ($this->importType === 'items') {
      $totalItems = 0;
      foreach ($this->objectTypesToIds as $key => $value) {
        if (ends_with($key, 'item')) {
          $totalItems = $totalItems + count($value);
        }
      }
      $this->batchSize = $totalItems;
    } else { // This is an audio, film or video import
      // We can just count the number of unique preservation master revisions.
      $ids = array();
      foreach ($this->revisions as $revision) {
        if ($revision->revisionable_type === 'PreservationMaster') {
          $ids[$revision->revisionable_id] = 1;
        }
      }
      $this->batchSize = count($ids);
    }

    return $this->batchSize;
  }

  /**
   * Determine if this transaction was a regular batch operation (i.e.
   * a batch but not an import).
   *
   * @return boolean
   */
  protected function wasBatch()
  {
    $totalItems = 0;
    $totalMasters = 0;
    $totalTransfers = 0;
    
    // Total up the number of ids affected for each object type.
    // We can use these totals to determine which object type
    // the batch operation originated from. For exampple, if 
    // there are items in the array, the transaction originated
    // from items, and if multiple items were involved, then it
    // was batch. Likewise, if there are masters in the map but 
    // no items, the operation originated from masters. If there
    // was more than one master involved, it was batch, and so on.
    foreach ($this->objectTypesToIds as $key => $value) {
      if (ends_with($key, 'item')) {
        $totalItems = $totalItems + count($value);
      } else if (ends_with($key, 'master')) {
        $totalMasters = $totalMasters + count($value);
      } else if (ends_with($key, 'transfer')) {
        $totalTransfers = $totalTransfers + count($value);
      }
    }

    if ($totalItems > 1) {
      $this->batchSize = $totalItems;
      return true;
    } else if ($totalMasters > 1 && $totalItems === 0) {
      $this->batchSize = $totalMasters;
      return true;
    } else if ($totalTransfers > 1 && $totalMasters === 0) {
      $this->batchSize = $totalTransfers;
      return true;
    }

    return false;
  }

  /**
   * Iterates through the revisions in this transaction, finding the object types
   * that were modified in the transaction, along with the ids that were modified.
   * Returns an array of object types with each type mapped to an array of ids that
   * were modified.
   *
   * @return array
   */
  protected function buildObjectTypesToIds()
  {
    if ($this->objectTypesToIds !== null) return $this->objectTypesToIds;

    $typesToIds = array();
    foreach ($this->revisions as $revision) {
      $class = $revision->revisionable_type;
      $instance = 
          $class::withTrashed()->findOrFail($revision->revisionable_id);
      $id = $revision->revisionable_id;

      if (!array_key_exists($revision->revisionable_type, $this->baseClasses)) {
        // This will also result in a db query.
        $instance = $instance->superclass;
        $class = class_basename(get_class($instance));
        $id = $instance->id;
      }

      // e.g. convert 'AudioVisualItem' to 'audio_visual_item'
      $snakeClass = snake_case($class);
      $explodedClass = explode('_', $snakeClass);
      // We have a base class instance, so get the subclass type 
      // ('audio', 'film' or 'video')
      $type = $snakeClass === 'cut' ? '' : strtolower($instance->type);
      // e.g. results in: 'audio item'
      $displayClass = trim($type . ' ' . array_pop($explodedClass));
      $exists = $instance->deletedAt === null;
      if (!isset($typesToIds[$displayClass])) {
        $typesToIds[$displayClass] = array($id => $exists);
      } else {
        $typesToIds[$displayClass][$id] = $exists;
      }
    }
    $this->objectTypesToIds = $typesToIds;
    return $this->objectTypesToIds;
  }

  /**
   * Get the number of records (items, masters or transfers) involved in
   * this transaction.
   *
   * @return int
   */
  protected function computeNumAffected()
  {
    $total = 0;
    foreach ($this->objectTypesToIds as $type => $ids) {
      $total = $total + count($ids);
    }
    $this->numAffected = $total;

    return $this->numAffected;
  }
}


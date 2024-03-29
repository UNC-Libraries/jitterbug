<?php

namespace Jitterbug\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Westsworld\TimeAgo;

/**
 * Models a single entry in the recent activity module of the dashboard.
 * Instances of this model should not be created directly. Rather, a
 * TransactionDigest is used to summarize and generate activities for a
 * particular revision transaction id, which may include hundreds of
 * revisions. Instances of this class are meant to be short lived, and
 * only for the purpose of display in the recent activity stream.
 */
class Activity extends Model
{
    // Fields in this model:
    // transactionId: the transaction UUID.
    // action: created, updated, deleted or imported.
    // batch: true or false if batch. (stored as tiny int in the database)
    // batch_size: the total number of objects that the user selected for modification.
    // field: the field that was updated, only populated for updates.
    // import_type: it it was an import, the type (audio, film or video).
    // itemCallNumber: the call number of the related item, not populated for
    // batch operations.
    // itemType: the type of the related item, (audio, film or video).
    // numFields: the number of fields that were updated, only populated for single object
    // update transactions.
    // numAffected: the number of records that were affected by the activity.
    // objectTypesToIds: the types of objects that were affected (audio item, video item,
    // audio instance, etc) mapped to the base object ids that were affected. the array
    // is stored serialized in the database.
    // each type. stored as a serialized array in the database.
    // timestamp: the time that the activity occurred.
    // user: the name of the user responsible for the activity.

    protected $unserializedObjectTypesToIds = null;

    public function getBatchAttribute($value)
    {
        if ($value === null) {
            $value = $this->batch;
        }

        return $value === 1;
    }

    public function setBatchAttribute($value)
    {
        $this->attributes['batch'] = ($value === true ? 1 : 0);
    }

    public function getObjectTypesToIdsAttribute($value)
    {
        if ($value === null) {
            $value = $this->object_types_to_ids;
        }
        if ($this->unserializedObjectTypesToIds === null) {
            $this->unserializedObjectTypesToIds = unserialize($value);

            return $this->unserializedObjectTypesToIds;
        } else {
            return $this->unserializedObjectTypesToIds;
        }
    }

    public function setObjectTypesToIdsAttribute($value)
    {
        $this->attributes['object_types_to_ids'] = serialize($value);
    }

    public function getTimeAgoAttribute($value)
    {
        if ($value === null) {
            $value = $this->timestamp;
        }

        $timeAgo = new TimeAgo();

        return $timeAgo->inWordsFromStrings($value);
    }

    /**
     * Return a formatted string representation of the original object this
     * activity relates to. For example, if a user chooses to delete an audio
     * visual item along with its preservation instances and transfers, the
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
        if (Str::contains($this->action, 'import')) {
            $type = $this->import_type === 'items' ? 'audio visual item' : $this->import_type;

            return 'batch of '.$this->batch_size.' '.$type.' records';
        }

        $objectType = $this->objectType();
        if ($objectType === 'instance' && ! $this->batch) {
            return 'preservation instance';
        } elseif ($objectType === 'transfer' && ! $this->batch) {
            return 'transfer';
        }

        $mediaTypes = [];
        foreach ($this->getAttribute('object_types_to_ids') as $key => $value) {
            $explodedKey = explode(' ', $key);
            if ($explodedKey[0] === 'cut') {
                break;
            }
            $mediaType = array_shift($explodedKey);
            if ($explodedKey[0] !== $objectType) {
                break;
            }
            $mediaTypes[] = $mediaType;
        }
        // sort media types in order of audio, film, video
        sort($mediaTypes);

        $formattedObject =
                $this->formatMediaTypesAndObject($mediaTypes, $objectType);

        if ($this->batch) {
            return 'batch of '.$this->batch_size.' '.$formattedObject.'s';
        } else {
            return $formattedObject;
        }
    }

    /**
     * Format an array of media types along with the object name. The array
     * will only ever be more than a single element in length unless the user
     * batch deletes objects of multiple types.
     */
    private function formatMediaTypesAndObject($types, $object)
    {
        if (count($types) === 0) {
            // this will be a cut
            return $object;
        } elseif (count($types) === 1) {
            // this will be the usual case, e.g. update
            return $types[0].' '.$object;
        } elseif (count($types) === 2) {
            // this will only ever be a batch delete
            return $types[0].' and '.$types[1].' '.$object;
        } elseif (count($types) === 3) {
            // this will only ever be a batch delete
            return $types[0].', '.$types[1].', and '
        .$types[2].' '.$object;
        }
    }

    /**
     * Return the object type (item, instance, transfer or cut) of the
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
        $objectTypesToIds = $this->getAttribute('object_types_to_ids');
        reset($objectTypesToIds);
        $objectKey = key($objectTypesToIds);
        if ($objectKey === 'cut') {
            return 'cut';
        }

        // e.g. will explode 'audio item' to ['audio', 'item']
        $explodedKey = explode(' ', $objectKey);
        // This will get the last element of the array, which is the object type
        // (item, instance or transfer)
        $objectType = $explodedKey[1];

        return $objectType;
    }

    /**
     * Return the object id (item, instance, transfer or cut) of the
     * original object.
     *
     * @return int
     */
    public function objectId()
    {
        $objectTypesToIds = $this->getAttribute('object_types_to_ids');
        reset($objectTypesToIds);

        return key(current($objectTypesToIds));
    }

    /**
     * Test if the original object exists. This value is stored when the object
     * map is created in TransactionDigest.
     *
     * @return bool
     */
    public function objectExists()
    {
        $objectTypesToIds = $this->getAttribute('object_types_to_ids');
        reset($objectTypesToIds);

        return current($objectTypesToIds)[key(current($objectTypesToIds))];
    }

    /**
     * Test whether the original object is an audio visual item.
     *
     * @return bool
     */
    public function objectIsItem()
    {
        return str_contains($this->object(), 'item') && ! $this->batch;
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

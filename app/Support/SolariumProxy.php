<?php namespace Jitterbug\Support;

use Illuminate\Support\Facades\Config;
use Log;
use Solarium;

use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Cut;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\Transfer;

/**
 * The intermediary between Jitterbug and Solr. All interactions
 * with Solr should go through this class, which itself uses
 * Solarium to query and update Solr.
 */
class SolariumProxy {

  protected $client;
  protected $core;


  public function __construct($core)
  {
    $this->core = $core;
    $this->client = $this->clientFor($core);
  }

  protected function clientFor($core)
  {
    $config = Config::get('solarium');
    $endpointKeys = array_keys($config);
    $endpointConfig = $config[$endpointKeys[0]];
    $hostKeys = array_keys($endpointConfig);
    $config[$endpointKeys[0]][$hostKeys[0]]['core'] = $core;
    return new Solarium\Client($config);
  }

  public function query($queryParams, $start, $rows, $sortColumn = 'updatedAt', $sortDirection = 'desc')
  {
    $solariumQuery = $this->client->createSelect();

    $searchTerms = $queryParams->search;
    $solariumQuery->setQuery($searchTerms);

    $dismax = $solariumQuery->getDisMax();
    if(strlen($searchTerms)==0) {
      $dismax->setQueryAlternative('*:*');
    }
    if ($this->core==='jitterbug-items') {
      // Query fields with boost values
      $dismax->setQueryFields('callNumber^5 title^4 collectionName^3 ' .
      'collectionId containerNote^2 cutTitles cutPerformerComposers ' .
      'formatName accessionNumber filmElement videoElement');

    } else if ($this->core==='jitterbug-instances') {
      $dismax->setQueryFields('id callNumber^5 fileName^4 collectionName^3 ' .
      'collectionId cutTitles cutPerformerComposers formatName ' . 
      'departmentName projectName');

    } else if ($this->core==='jitterbug-transfers') {
      $dismax->setQueryFields('preservationInstanceId callNumber^5 ' .
      'engineerFirstName^4 engineerLastName^4 collectionName^3 collectionId ' . 
      'cutTitle cutPerformerComposer formatName departmentName');
    }

    $this->createFilterQueries($solariumQuery,$queryParams);

    if ($sortColumn === null && $sortDirection === null) {
      // sometimes null values are specifically sent in for sorts
      // like when a user does select all, so default values must be assigned
      $sortColumn = 'updatedAt';
      $sortDirection = 'desc';
    } else if ($sortColumn !== 'updatedAt') {
      // use Sortable version of solr field if it's not the updatedAt field
      // ex. callNumber => callNumberSortable
      $sortColumn .= 'Sortable';
    }

    $solariumQuery->setStart($start);
    $solariumQuery->setRows($rows);
    $solariumQuery->addSort($sortColumn, $sortDirection);

    $resultSet = $this->client->execute($solariumQuery);

    return $resultSet;
  }

  /**
   * Update the Solr index for the given model or array (or collection)
   * of models.
   * 
   * @param mixed $modelOrModels
   * @return mixed
   */
  public function update($modelOrModels)
  {
    $iterable = is_array($modelOrModels) || 
                             $modelOrModels instanceof \IteratorAggregate;
    if (!$iterable) {
      $modelOrModels = array($modelOrModels);
    }

    $update = $this->client->createUpdate();

    if ($this->core==='jitterbug-items') {
      foreach ($modelOrModels as $item) {
        $this->addItemDocument($item, $update);
      }
    } else if ($this->core==='jitterbug-instances') {
      foreach ($modelOrModels as $instance) {
        $this->addInstanceDocument($instance, $update);
      }
    } else if ($this->core==='jitterbug-transfers') {
      foreach ($modelOrModels as $transfer) {
        $this->addTransferDocument($transfer, $update);
      }
    }

    $update->addCommit();
    
    return $this->client->update($update);
  }

  /**
   * Add an item document to the given update query.
   *
   * @param AudioVisualItem $item
   * @param Query $update
   */
  protected function addItemDocument($item, &$update)
  {
    if ($item === null) return;

    $doc = $update->createDocument();

    $doc->setKey('id', $item->id);
    $doc->setField('callNumber', $item->call_number, null, 'set');
    $doc->setField('title', $item->title, null, 'set');
    $doc->setField('containerNote', $item->container_note, null, 'set');
    $doc->setField('collectionId', 
      $item->collection ? $item->collection->id : null, null, 'set');
    $doc->setField('collectionName', 
      $item->collection ? $item->collection->name : null, null, 'set');
    $doc->setField('formatId', 
      $item->format ? $item->format->id : null, null, 'set');
    $doc->setField('formatName',
      $item->format ? $item->format->name : null, null, 'set');
    $doc->setField('accessionNumber', $item->accession_number, null, 'set');
    $doc->setField('typeName', $item->type, null, 'set');
    $doc->setField('typeId', $item->type_id, null, 'set');
    $doc->setField('preservationInstanceExists', $item->preservationInstances()->exists(), null, 'set');
    $doc->setField('createdAt', $item->created_at, null, 'set');
    $doc->setField('updatedAt', $item->updated_at, null, 'set');

    if ($item->subclass_type === 'FilmItem') {
      $doc->setField('filmElement', $item->subclass->element, null, 'set');
    } else if ($item->subclass_type === 'VideoItem') {
      $doc->setField('videoElement', $item->subclass->element, null, 'set');
    }

    $this->appendCutsForItem($item->call_number, $doc);

    $update->addDocument($doc);
  }

  /**
   * Add a instance document to the given update query.
   *
   * @param PreservationInstance $instance
   * @param Query $update
   */
  protected function addInstanceDocument($instance, &$update)
  {
    if ($instance === null) return;

    $doc = $update->createDocument();

    $doc->setKey('id', $instance->id);
    $doc->setField('callNumber', $instance->call_number, null, 'set');
    $doc->setField('fileName', $instance->file_name, null, 'set');
    $doc->setField('durationInSeconds', $instance->duration_in_seconds, null, 'set');
    $doc->setField('departmentId', 
      $instance->department ? $instance->department->id : null, null, 'set');
    $doc->setField('departmentName', 
      $instance->department ? $instance->department->name : null, null, 'set');
    $doc->setField('projectId', 
      $instance->project ? $instance->project->id : null, null, 'set');
    $doc->setField('projectName', 
      $instance->project ? $instance->project->name : null, null, 'set');
    $doc->setField('typeName', $instance->type, null, 'set');
    $doc->setField('typeId', $instance->type_id, null, 'set');
    $doc->setField('createdAt', $instance->created_at, null, 'set');
    $doc->setField('updatedAt', $instance->updated_at, null, 'set');
    
    // Get other fields from the associated audio visual item since that's where
    // they reside, not on the instance
    $this->appendCollectionAndFormat($instance->call_number, $doc);
    $this->appendCutsForInstance($instance->id, $doc);

    $update->addDocument($doc);
  }

  /**
   * Add a transfer document to the given update query.
   *
   * @param Transfer $transfer
   * @param Query $update
   */
  protected function addTransferDocument($transfer, &$update)
  {
    if ($transfer === null) return;

    $doc = $update->createDocument();

    $doc->setKey('id', $transfer->id);
    $doc->setField('callNumber', $transfer->call_number, null, 'set');
    $doc->setField('transferDate', $transfer->transfer_date, null, 'set');
    $doc->setField('preservationInstanceId',
      $transfer->preservation_instance_id, null, 'set');
    $doc->setField('vendorId', 
      $transfer->vendor != null ? $transfer->vendor->id : null, null, 'set');
    $doc->setField('vendorName', 
      $transfer->vendor != null ? $transfer->vendor->name : null, null, 'set');
    $doc->setField('engineerId', $transfer->engineer_id, null, 'set');
    $doc->setField('engineerFirstName', 
      $transfer->engineer != null ? 
      $transfer->engineer->first_name : null, null, 'set');
    $doc->setField('engineerLastName', 
      $transfer->engineer != null ? 
      $transfer->engineer->last_name : null, null, 'set');
    $doc->setField('typeName', $transfer->type, null, 'set');
    $doc->setField('typeId', $transfer->type_id, null, 'set');
    $doc->setField('createdAt', $transfer->created_at, null, 'set');
    $doc->setField('updatedAt', $transfer->updated_at, null, 'set');

    // Get other fields from the associated audio visual item since that's where
    // they reside, not on the transfer
    $this->appendCollectionAndFormat($transfer->call_number, $doc);

    $cut = Cut::where('transfer_id', $transfer->id)->first();
    if ($cut !== null) {
      $doc->setField('cutId', $cut->id, null, 'set');
      $doc->setField('cutTitle', $cut->title, null, 'set');
      $doc->setField('cutPerformerComposer', 
        $cut->performer_composer, null, 'set');
    }

    $update->addDocument($doc);
  }

  public function delete($modelOrModels)
  {
    $result;
    $iterable = is_array($modelOrModels) || 
                            $modelOrModels instanceof \IteratorAggregate;
    if ($iterable) {
      $result = array();
      foreach ($modelOrModels as $model) {
        $result[] = $this->deleteOne($model);
      }
    } else {
      $result = $this->deleteOne($modelOrModels);
    }

    return $result;
  }

  private function deleteOne($model)
  {
    $update = $this->client->createUpdate();
    $update->addDeleteById($model->id);
    $update->addCommit();

    return $this->client->update($update);
  }

  private function appendCollectionAndFormat($callNumber, &$doc)
  {
    $item = AudioVisualItem::where('call_number', $callNumber)->first();
    if ($item !== null) {
      $doc->setField('collectionId', 
        $item->collection ? $item->collection->id : null, null, 'set');
      $doc->setField('collectionName', 
        $item->collection ? $item->collection->name : null, null, 'set');
      $doc->setField('formatId', 
        $item->format ? $item->format->id : null, null, 'set');
      $doc->setField('formatName',
        $item->format ? $item->format->name : null, null, 'set');
    }
  }

  private function appendCutsForItem($callNumber, &$doc)
  {
    $cuts = Cut::where('call_number', $callNumber)->get();
    $this->appendCuts($cuts, $doc);
  }

  private function appendCutsForInstance($preservationInstanceId, &$doc)
  {
    $cuts = Cut::where('preservation_instance_id', $preservationInstanceId)->get();
    $this->appendCuts($cuts, $doc);
  }

  private function appendCuts($cuts, &$doc)
  {
    $cutIds = array();
    $cutTitles = array();
    $cutPerformerComposers = array();
    if ($cuts->count() > 0) {
      foreach ($cuts as $cut) {
        $cutIds[] = $cut->id;
        $cutTitles[] = $cut->title;
        $cutPerformerComposers[] = $cut->performerComposer;
      }
    }
    if (count($cutIds) === 0) {
      $cutIds = null;
      $cutTitles = null;
      $cutPerformerComposers = null;
    }
    $doc->setField('cutIds', $cutIds, null, 'set');
    $doc->setField('cutTitles', $cutTitles, null, 'set');
    $doc->setField('cutPerformerComposers', 
      $cutPerformerComposers, null, 'set');
  }

  protected function createFilterQueries($solariumQuery, $queryParams)
  {
    $keys = array_keys((array)($queryParams));
    foreach ($keys as $key) {
      if($this->endsWith($key, 'filters')) {
        $filters = $queryParams->{$key};
        if($this->hasFilters($filters)) {
          $filterType = $this->filterType($key);
          $filterQuery = $this->filterQueryFor($filterType . 'Id', $filters);
          $solariumQuery->
            createFilterQuery($filterType . 's')->setQuery($filterQuery);
        }
      }
    }
  }

  protected function hasFilters($filterArray)
  {
    return $filterArray[0] != 0;
  }
  
  protected function filterType($filterKey)
  {
    return substr($filterKey,0,strlen($filterKey) - strlen('-filters'));
  }

  protected function filterQueryFor($field, $filters)
  {
    $filterQuery = $field . ':(';
    $numFilters = count($filters);
    for ($i = 0; $i < $numFilters; $i++) {
      $filter = $filters[$i];
      if ($i != $numFilters - 1) {
        $filterQuery = $filterQuery . $filter . ' OR ';
      } else {
        $filterQuery = $filterQuery . $filter . ')';
      }
    }
    return $filterQuery;
  }

  protected function endsWith($haystack, $needle)
  {
    $needleLen = strlen($needle);
    $needleTest = substr($haystack, strlen($haystack) - 
        $needleLen, strlen($haystack));
    return $needleTest === $needle;
  }

}
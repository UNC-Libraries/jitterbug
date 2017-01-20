<?php namespace Jitterbug\Support;

use Illuminate\Support\Facades\Config;
use Log;
use Solarium;

use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Cut;
use Jitterbug\Models\PreservationMaster;
use Jitterbug\Models\Transfer;

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
    $hostConfig = $config[$endpointKeys[0]][$hostKeys[0]];
    $path = $hostConfig['path'];
    $config[$endpointKeys[0]][$hostKeys[0]]['path'] = $path . $core;
    return new Solarium\Client($config);
  }

  public function query($queryParams, $start, $rows)
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
      'formatName');

    } else if ($this->core==='jitterbug-masters') {
      $dismax->setQueryFields('id callNumber^5 fileName^4 collectionName^3 ' .
      'collectionId cutTitles cutPerformerComposers formatName ' . 
      'departmentName projectName');

    } else if ($this->core==='jitterbug-transfers') {
      $dismax->setQueryFields('preservationMasterId callNumber^5 ' . 
      'engineerFirstName^4 engineerLastName^4 collectionName^3 collectionId ' . 
      'cutTitle cutPerformerComposer formatName departmentName');
    }

    $this->createFilterQueries($solariumQuery,$queryParams);

    $solariumQuery->setStart($start);
    $solariumQuery->setRows($rows);
    $solariumQuery->addSort('updatedAt', $solariumQuery::SORT_DESC);

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
    } else if ($this->core==='jitterbug-masters') {
      foreach ($modelOrModels as $master) {
        $this->addMasterDocument($master, $update);
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
    $doc->setField('callNumber', $item->callNumber, null, 'set');
    $doc->setField('title', $item->title, null, 'set');
    $doc->setField('containerNote', $item->containerNote, null, 'set');
    $doc->setField('collectionId', 
      $item->collection ? $item->collection->id : null, null, 'set');
    $doc->setField('collectionName', 
      $item->collection ? $item->collection->name : null, null, 'set');
    $doc->setField('formatId', 
      $item->format ? $item->format->id : null, null, 'set');
    $doc->setField('formatName',
      $item->format ? $item->format->name : null, null, 'set');
    $doc->setField('typeName', $item->type, null, 'set');
    $doc->setField('typeId', $item->typeId, null, 'set');
    $doc->setField('createdAt', $item->createdAt, null, 'set');
    $doc->setField('updatedAt', $item->updatedAt, null, 'set');

    $this->appendCutsForItem($item->callNumber, $doc);

    $update->addDocument($doc);
  }

  /**
   * Add a master document to the given update query.
   *
   * @param PreservationMaster $master
   * @param Query $update
   */
  protected function addMasterDocument($master, &$update)
  {
    if ($master === null) return;

    $doc = $update->createDocument();

    $doc->setKey('id', $master->id);
    $doc->setField('callNumber', $master->callNumber, null, 'set');
    $doc->setField('fileName', $master->fileName, null, 'set');
    $doc->setField('durationInSeconds', $master->durationInSeconds, null, 'set');
    $doc->setField('departmentId', 
      $master->department ? $master->department->id : null, null, 'set');
    $doc->setField('departmentName', 
      $master->department ? $master->department->name : null, null, 'set');
    $doc->setField('projectId', 
      $master->project ? $master->project->id : null, null, 'set');
    $doc->setField('projectName', 
      $master->project ? $master->project->name : null, null, 'set');
    $doc->setField('typeName', $master->type, null, 'set');
    $doc->setField('typeId', $master->typeId, null, 'set');
    $doc->setField('createdAt', $master->createdAt, null, 'set');
    $doc->setField('updatedAt', $master->updatedAt, null, 'set');
    
    // Get other fields from the associated audio visual item since that's where
    // they reside, not on the master
    $this->appendCollectionAndFormat($master->callNumber, $doc);
    $this->appendCutsForMaster($master->id, $doc);

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
    $doc->setField('callNumber', $transfer->callNumber, null, 'set');
    $doc->setField('transferDate', $transfer->transferDate, null, 'set');
    $doc->setField('preservationMasterId',
      $transfer->preservationMasterId, null, 'set');
    $doc->setField('vendorId', 
      $transfer->vendor != null ? $transfer->vendor->id : null, null, 'set');
    $doc->setField('vendorName', 
      $transfer->vendor != null ? $transfer->vendor->name : null, null, 'set');
    $doc->setField('engineerId', $transfer->engineerId, null, 'set');
    $doc->setField('engineerFirstName', 
      $transfer->engineer != null ? 
      $transfer->engineer->firstName : null, null, 'set');
    $doc->setField('engineerLastName', 
      $transfer->engineer != null ? 
      $transfer->engineer->lastName : null, null, 'set');
    $doc->setField('typeName', $transfer->type, null, 'set');
    $doc->setField('typeId', $transfer->typeId, null, 'set');
    $doc->setField('createdAt', $transfer->createdAt, null, 'set');
    $doc->setField('updatedAt', $transfer->updatedAt, null, 'set');

    // Get other fields from the associated audio visual item since that's where
    // they reside, not on the transfer
    $this->appendCollectionAndFormat($transfer->callNumber, $doc);

    $cut = Cut::where('transfer_id', $transfer->id)->first();
    if ($cut !== null) {
      $doc->setField('cutId', $cut->id, null, 'set');
      $doc->setField('cutTitle', $cut->title, null, 'set');
      $doc->setField('cutPerformerComposer', 
        $cut->performerComposer, null, 'set');
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
        array_push($result, $this->deleteOne($model));
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
    $doc->setField('collectionId', 
      $item->collection ? $item->collection->id : null, null, 'set');
    $doc->setField('collectionName', 
      $item->collection ? $item->collection->name : null, null, 'set');
    $doc->setField('formatId', 
      $item->format ? $item->format->id : null, null, 'set');
    $doc->setField('formatName',
      $item->format ? $item->format->name : null, null, 'set');
  }

  private function appendCutsForItem($callNumber, &$doc)
  {
    $cuts = Cut::where('call_number', $callNumber)->get();
    $this->appendCuts($cuts, $doc);
  }

  private function appendCutsForMaster($preservationMasterId, &$doc)
  {
    $cuts = Cut::where('preservation_master_id', $preservationMasterId)->get();
    $this->appendCuts($cuts, $doc);
  }

  private function appendCuts($cuts, &$doc)
  {
    $cutIds = array();
    $cutTitles = array();
    $cutPerformerComposers = array();
    if ($cuts->count() > 0) {
      foreach ($cuts as $cut) {
        array_push($cutIds, $cut->id);
        array_push($cutTitles, $cut->title);
        array_push($cutPerformerComposers, $cut->performerComposer);
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
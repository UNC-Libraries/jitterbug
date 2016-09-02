<?php namespace Junebug\Support;

use Illuminate\Support\Facades\Config;
use Log;
use Solarium;

use Junebug\Models\AudioVisualItem;

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
    if ($this->core==='junebug-items') {
      // Query fields with boost values
      $dismax->setQueryFields('callNumber^5 title^4 collectionName^3 ' .
      'containerNote^2 cutTitles cutPerformerComposers formatName');

    } else if ($this->core==='junebug-masters') {
      $dismax->setQueryFields('id, callNumber^5 fileName^4 collectionName^3 ' .
      'cutTitles cutPerformerComposers formatName departmentName');

    } else if ($this->core==='junebug-transfers') {
      $dismax->setQueryFields('id, callNumber^5 engineerFirstName^4 ' . 
      ' engineerLastName^4 collectionName^3 cutTitle cutPerformerComposer ' .
      ' formatName departmentName');
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
    $result;
    $iterable = is_array($modelOrModels) || 
                             $modelOrModels instanceof \IteratorAggregate;
    if ($this->core==='junebug-items') {
      if ($iterable) {
        $result = array();
        foreach ($modelOrModels as $item) {
          array_push($result, $this->updateItem($item));
        }
      } else {
        $result = $this->updateItem($modelOrModels);
      }
    } else if ($this->core==='junebug-masters') {
      if ($iterable) {
        $result = array();
        foreach ($modelOrModels as $master) {
          array_push($result, $this->updateMaster($master));
        }
      } else {
        $result = $this->updateMaster($modelOrModels);
      }
    } else if ($this->core==='junebug-transfers') {
      if ($iterable) {
        $result = array();
        foreach ($modelOrModels as $transfer) {
          array_push($result, $this->updateTransfer($transfer));
        }
      } else {
        $result = $this->updateTransfer($modelOrModels);
      }
    }
    return $result;
  }

  /**
   * Updates the Solr index for the given AudioVisualItem.
   *
   * @param AudioVisualItem $item
   */
  protected function updateItem($item)
  {
    $update = $this->client->createUpdate();
    $doc = $update->createDocument();

    $doc->setKey('id', $item->id);
    $doc->setField('callNumber', $item->callNumber, null, 'set');
    $doc->setField('title', $item->title, null, 'set');
    $doc->setField('containerNote', $item->containerNote, null, 'set');
    $doc->setField('collectionId', $item->collection->id, null, 'set');
    $doc->setField('collectionName', $item->collection->name, null, 'set');
    $doc->setField('formatId', $item->format->id, null, 'set');
    $doc->setField('formatName', $item->format->name, null, 'set');
    $doc->setField('typeName', $item->type, null, 'set');
    $doc->setField('typeId', $item->typeId, null, 'set');
    $doc->setField('createdAt', $item->createdAt, null, 'set');
    $doc->setField('updatedAt', $item->updatedAt, null, 'set');

    $update->addDocument($doc);
    $update->addCommit();

    return $this->client->update($update);
  }

  /**
   * Updates the Solr index for the given PreservationMaster.
   *
   * @param PreservationMaster $master
   */
  protected function updateMaster($master)
  {
    $update = $this->client->createUpdate();
    $doc = $update->createDocument();

    $doc->setKey('id', $master->id);
    $doc->setField('callNumber', $master->callNumber, null, 'set');
    $doc->setField('fileName', $master->fileName, null, 'set');
    $doc->setField('durationInSeconds', $master->durationInSeconds, null, 'set');
    $doc->setField('typeName', $master->type, null, 'set');
    $doc->setField('typeId', $master->typeId, null, 'set');
    $doc->setField('createdAt', $master->createdAt, null, 'set');
    $doc->setField('updatedAt', $master->updatedAt, null, 'set');
    
    // Get other fields from the associated audio visual item since that's where
    // they reside, not on the master
    $item = 
      AudioVisualItem::where('call_number', $master->callNumber)->get()->first();
    $doc->setField('collectionId', $item->collection->id, null, 'set');
    $doc->setField('collectionName', $item->collection->name, null, 'set');
    $doc->setField('formatId', $item->format->id, null, 'set');
    $doc->setField('formatName', $item->format->name, null, 'set');

    $update->addDocument($doc);
    $update->addCommit();

    return $this->client->update($update);
  }

  protected function updateTransfer($transfer)
  {
    // pending
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
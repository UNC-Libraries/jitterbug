<?php namespace Junebug\Support;

use Illuminate\Support\Facades\Config;
use Log;
use Solarium;

class SolariumProxy {

  protected $client;
  protected $core;


  public function __construct($core)
  {
    $this->core = $core;
    $this->client = $this->clientFor($core);
  }

  protected static function clientFor($core)
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

    $searchTerms = $queryParams->{'search'};
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
      $dismax->setQueryFields('callNumber^5 fileName^4 collectionName^3 ' .
      'cutTitles cutPerformerComposers');
    }

    $this->createFilterQueries($solariumQuery,$queryParams);

    $solariumQuery->setStart($start);
    $solariumQuery->setRows($rows);
    $solariumQuery->addSort('updatedAt', $solariumQuery::SORT_DESC);

    $resultSet = $this->client->execute($solariumQuery);

    return $resultSet;
  }

  public function update($model)
  {
    $result;
    if ($this->core==='junebug-items') {
      $result = $this->updateItem($model);
    } else if ($this->core==='junebug-masters') {
      $result = $this->updateMaster($model);
    }
    return $result;
  }

  protected function updateItem($item)
  {
    $update = $this->client->createUpdate();
    $doc = $update->createDocument();

    $doc->setKey('id', $item->id);
    $doc->setField('title', $item->title, null, 'set');
    $doc->setField('containerNote', $item->containerNote, null, 'set');
    $doc->setField('callNumber', $item->callNumber, null, 'set');
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

  public function delete($model)
  {
    $update = $this->client->createUpdate();
    $update->addDeleteById($model->id);
    $update->addCommit();

    $result = $this->client->update($update);
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
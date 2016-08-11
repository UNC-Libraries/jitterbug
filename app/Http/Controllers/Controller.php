<?php namespace Junebug\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {
  use DispatchesJobs, ValidatesRequests;


  public function rangeFor(Request $request, $proxy)
  {
    $queryParams = json_decode(urldecode($request->query('q')));
    $range = json_decode(urldecode($request->query('r')));
    $beginIndex = $range->beginIndex;
    $beginId = $range->beginId;
    $endIndex = $range->endIndex;
    $endId = $range->endId;
    $firstIndex = min($beginIndex, $endIndex);
    $lastIndex = max($beginIndex, $endIndex);
    $start = $firstIndex;
    $rows = $lastIndex - $firstIndex + 1;
    $resultSet = $proxy->query($queryParams,$start,$rows);

    $itemIds = array();
    $index = $start;
    foreach ($resultSet as $item) {
      if ($index == $beginIndex && $item->id != $beginId) {
        $this->invalidRange();
      }
      if ($index == $endIndex && $item->id != $endId) {
        $this->invalidRange();
      }      
      array_push($itemIds, $item->id);
      $index++;
    }
    $ids = array('ids'=>$itemIds);
    return response()->json($ids);
  }

  private function invalidRange()
  {
    abort(400, 'Requested range is out of sync with datastore.');
  }

}

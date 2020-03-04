<?php namespace Jitterbug\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Resolve a table selection range (beginning and ending indices) to an
   * array of record ids, fetching the ids from Solr. If beginning and
   * ending ids are found in the range variable in the request, the range
   * ids will be validated. This provides some modicum of protection against
   * stale table selections, where the range selection doesn't match up to
   * the current state of the data in Solr. A use case where no validation
   * would be required would be a select all operation where the beginning
   * and ending ids would not be known.
   *
   * @param Illuminate\Http\Request request
   * @param Jitterbug\Support\SolariumProxy proxy
   */
  protected function rangeFor(Request $request, $proxy)
  {
    $queryParams = json_decode(urldecode($request->query('q')));
    $range = json_decode(urldecode($request->query('r')));
    $beginIndex = $range->beginIndex;
    $beginId = isset($range->beginId) ? $range->beginId : null;
    $endIndex = $range->endIndex;
    $endId = isset($range->endId) ? $range->endId : null;
    $firstIndex = min($beginIndex, $endIndex);
    $lastIndex = max($beginIndex, $endIndex);
    $start = $firstIndex;
    $rows = $lastIndex - $firstIndex + 1;
    $resultSet = $proxy->query($queryParams,$start,$rows);

    $itemIds = array();
    $index = $start;
    $validateRange = $beginId !== null && $endId !== null;
    foreach ($resultSet as $item) {
      if ($validateRange) {
        if ($index == $beginIndex && $item->id != $beginId) {   
          $this->invalidRange();
        }
        if ($index == $endIndex && $item->id != $endId) {
          $this->invalidRange();
        }
      }
      $itemIds[] = $item->id;
      $index++;
    }
    $ids = array('ids'=>$itemIds);
    return response()->json($ids);
  }

  private function invalidRange()
  {
    abort(400, 'Requested range is out of sync with datastore.');
  }

  public function batchExportDownload(Request $request)
  {
    $filePath = $request->session()->get('exportFilePath');
    if ($filePath !== null) {
      $headers = array('Content-Type' => 'text/csv');
      return response()->download($filePath, basename($filePath), $headers);
    }
  }

}

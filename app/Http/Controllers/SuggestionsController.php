<?php namespace Junebug\Http\Controllers;

use Junebug\Http\Requests;
use Junebug\Http\Controllers\Controller;

use Illuminate\Http\Request;

/**
 * Controller for producing form level autocomplete suggestions for
 * the devbridge autocomplete jQuery plugin 
 * (https://github.com/devbridge/jQuery-Autocomplete). JSON results are
 * formatted per plugin requirements.
 */
class SuggestionsController extends Controller {

  public function trackConfigurations(Request $request)
  {
    $query = $request->query('query');
    $suggestions = $this->getAutocompleteSuggestions(
                                      'AudioItem','track_configuration',$query);
    return response()->json($suggestions);
  }

  public function audioBases(Request $request)
  {
    $query = $request->query('query');
    $suggestions = $this->getAutocompleteSuggestions('AudioItem','base',$query);
    return response()->json($suggestions);
  }

  private function getAutocompleteSuggestions($modelClass,$field,$query)
  {
    $results = $modelClass::select($field)->distinct()->
      where($field, '!=', '')->
      where($field, '!=', 'null')->
      where($field, 'like', '%'.$query.'%')->get();
    $suggestions = array('suggestions'=>[]);
    foreach($results as $result) {
      $suggestions['suggestions'][] = $result[$field];
    }
    return $suggestions;
  }

}

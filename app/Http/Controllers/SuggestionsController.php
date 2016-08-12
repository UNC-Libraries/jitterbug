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

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function recordingLocations(Request $request)
  {
    $query = $request->query('query');
    $suggestions = $this->getAutocompleteSuggestions(
                                      'AudioVisualItem','recording_location',$query);
    return response()->json($suggestions);
  }

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

  public function filmElements(Request $request)
  {
    $query = $request->query('query');
    $suggestions = $this->getAutocompleteSuggestions('FilmItem','element',$query);
    return response()->json($suggestions);
  }

  public function filmBases(Request $request)
  {
    $query = $request->query('query');
    $suggestions = $this->getAutocompleteSuggestions('FilmItem','base',$query);
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

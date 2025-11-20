<?php

namespace Jitterbug\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

/**
 * Controller for producing form level autocomplete suggestions for
 * the devbridge autocomplete jQuery plugin
 * (https://github.com/devbridge/jQuery-Autocomplete). JSON results are
 * formatted per plugin requirements.
 *
 * To add support for a new suggested field, do the following:
 *
 * 1. Define a controller method in this class for the field using
 * plural naming conventions. You only need to copy and paste one
 * of the exsiting methods and change the parameters for the
 * getAutocompleteSuggestions() method call to correspnod to the
 * model you want the suggestions for, and then the field name.
 *
 * 2. Add a route to routes.php in the 'suggestions' group that
 * references the controller method that was defined in step 1.
 *
 * 3. Go to the form where you want the suggestions to appear, and give
 * the input element a css id name. e.g. #speed, or #recording-location,
 * etc.
 *
 * 4. In jitterbug.js, add a jQuery selector using the id you created in step 3,
 * then call autocomplete. The serviceUrl should correspond to the route
 * you created in step 2. For example:
 *
 *  $('#speed').autocomplete({
 *    serviceUrl: '/suggestions/speeds',
 *    deferRequestBy: 100
 *  });
 */
class SuggestionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function recordingLocations(Request $request)
    {
        $query = $request->query('query');
        $suggestions = $this->getAutocompleteSuggestions(
            'AudioVisualItem', 'recording_location', $query);

        return response()->json($suggestions);
    }

    public function speeds(Request $request)
    {
        $query = $request->query('query');
        $suggestions = $this->getAutocompleteSuggestions('AudioVisualItem', 'speed', $query);

        return response()->json($suggestions);
    }

    public function trackConfigurations(Request $request)
    {
        $query = $request->query('query');
        $suggestions = $this->getAutocompleteSuggestions(
            'AudioItem', 'track_configuration', $query);

        return response()->json($suggestions);
    }

    public function audioBases(Request $request)
    {
        $query = $request->query('query');
        $suggestions = $this->getAutocompleteSuggestions('AudioItem', 'base', $query);

        return response()->json($suggestions);
    }

    public function filmElements(Request $request)
    {
        $query = $request->query('query');
        $suggestions = $this->getAutocompleteSuggestions('FilmItem', 'element', $query);

        return response()->json($suggestions);
    }

    public function filmBases(Request $request)
    {
        $query = $request->query('query');
        $suggestions = $this->getAutocompleteSuggestions('FilmItem', 'base', $query);

        return response()->json($suggestions);
    }

    private function getAutocompleteSuggestions($modelClass, $field, $query)
    {
        $results = $modelClass::select($field)->distinct()->
      where($field, '!=', '')->
      where($field, '!=', 'null')->
      where($field, 'like', '%'.$query.'%')->get();
        $suggestions = ['suggestions' => []];
        foreach ($results as $result) {
            $suggestions['suggestions'][] = $result[$field];
        }

        return $suggestions;
    }
}

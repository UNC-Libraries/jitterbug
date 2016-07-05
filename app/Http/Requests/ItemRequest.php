<?php namespace Junebug\Http\Requests;

use Log;
use Junebug\Http\Requests\Request;

class ItemRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return true;
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

      $itemableType = $this->input('itemableType');
      $itemableRules = array();
      if($itemableType == 'AudioItem') {
        $itemableRules = [
          'itemable.size' => 'required'
        ];
      } else if ($itemableType == 'FilmItem') {
        $itemableRules = [
          'itemable.filmBase' => 'required',
          'itemable.lengthInFeet' => 'required'
        ];
      } else if ($itemableType == 'VideoItem') {
      	$itemableRules = [];
      }

      $itemRules = [
        'callNumber' => 'required|min:4|unique:audio_visual_items,call_number,'.$this->input('id'),
        'title' => 'required|min:3',
        'collectionId' => 'required',
        'formatId' => 'required',
        'itemDate' => 'date_format:Y-m-d',
        'entryDate' => 'required|date_format:Y-m-d'
      ];

      return array_merge($itemRules,$itemableRules);
    }

    public function messages()
    { 
      return [
        'formatId.required' => 'The format field is required.',
        'collectionId.required' => 'The collection field is required.',
        'itemDate.date_format' => 'The item date does not match the format YYYY-MM-DD.',
        'entryDate.date_format' => 'The item date does not match the format YYYY-MM-DD.',

        'itemable.size.required' => 'The size field is required.',
        'itemable.filmBase.required' => 'The base field is required.',
        'itemable.lengthInFeet.required' => 'The length in feet field is required.'
      ];
    }
}

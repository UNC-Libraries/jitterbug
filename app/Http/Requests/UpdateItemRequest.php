<?php namespace Junebug\Http\Requests;

use Junebug\Http\Requests\Request;

class UpdateItemRequest extends Request {

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
    	dd($this);
      return [
        'callNumber' => 'required|min:4|unique:audio_visual_items,call_number,'.$item->id,
        'title' => 'required|min:3',
        'collectionId' => 'required',
        'formatId' => 'required',
        'itemDate' => 'date_format:Y-m-d',
        'entryDate' => 'required|date_format:Y-m-d',
        'itemable.size' => 'required'
      ];
    }

    public function messages()
    { 
      return [
        'formatId.required' => 'The format field is required.',
        'collectionId.required' => 'The collection field is required.'
      ];
    }
}

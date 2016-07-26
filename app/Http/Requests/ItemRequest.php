<?php namespace Junebug\Http\Requests;

use Log;

use Illuminate\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

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

    public function allWithoutMixed()
    {
      // Attbributes for batch edits are given a magic value of
      // '<mixed>' when the attribute value is different across
      // items in the batch and the attribute hasn't been set
      // in the edit form. Here, we remove those magic values
      // so they don't get applied when the models are filled 
      // and saved.
      $attributes = $this->all();
      foreach ($attributes as $key => $value) {
        // Itemable attributes will come in a nested array
        if(is_array($value)) {
          foreach ($value as $innerKey => $innerValue) {
            if (trim($innerValue)==='<mixed>') {
              unset($attributes[$key][$innerKey]);
            }
          }
        } else if (trim($value)==='<mixed>') {
          unset($attributes[$key]);
        }
      }
      
      return $attributes;
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
      if($itemableType === 'AudioItem') {
        $this->addRuleIfNotMixed($itemableRules,'itemable.size','required');
      } else if ($itemableType === 'FilmItem') {
        $this->addRuleIfNotMixed($itemableRules,'itemable.filmBase','required');
        $this->
          addRuleIfNotMixed($itemableRules,'itemable.lengthInFeet','required');
      } else if ($itemableType === 'VideoItem') {
        // No rules yet for video items
      	$itemableRules = [];
      }

      $itemRules = array();
      $itemRules['batchSize'] = 'required_if:batch,1|integer|between:2,100';
      $this->addRuleIfNotMixed($itemRules,'callNumber',
        'required|min:4|unique:audio_visual_items,call_number,'.
         $this->input('id'));
      $this->addRuleIfNotMixed($itemRules,'title','required|min:3');
      $this->addRuleIfNotMixed($itemRules,'collectionId','required');
      $this->addRuleIfNotMixed($itemRules,'formatId','required');
      $this->addRuleIfNotMixed($itemRules,'itemDate','date_format:Y-m-d');
      $this->addRuleIfNotMixed($itemRules,'entryDate',
                                            'required|date_format:Y-m-d');
      return array_merge($itemRules,$itemableRules);
    }

    public function addRuleIfNotMixed(&$rules, $attributeName, $rule)
    {
      $input = trim($this->input($attributeName));
      if($input === '<mixed>') {
        return;
      } else {
        $rules[$attributeName] = $rule;
      }
    }

    public function messages()
    { 
      return [
        'formatId.required' => 'The format field is required.',
        'collectionId.required' => 'The collection field is required.',
        'itemDate.date_format' => 'The item date does not match the format YYYY-MM-DD.',
        'entryDate.date_format' => 'The entry date does not match the format YYYY-MM-DD.',

        'itemable.size.required' => 'The size field is required.',
        'itemable.filmBase.required' => 'The base field is required.',
        'itemable.lengthInFeet.required' => 'The length in feet field is required.'
      ];
    }

    protected function failedValidation(Validator $validator)
    {
      // Since there's not really a good place for this message on the form,
      // we're going to flash a message at the top of the page.
      if ($validator->errors()->has('batchSize')) {
        $this->session()->put('alert', array('type' => 'danger', 'message' => 
            '<strong>Oops!</strong> ' . 
            'Please provide a batch size between 2 and 100 items.'));
      }

      throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
      ));
    }

}

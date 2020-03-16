<?php namespace Jitterbug\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;


abstract class Request extends FormRequest {

  /**
   * Get all attributes except those with the value of '<mixed>'.
   *
   * @return array
   */
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
      // Subclass attributes will come in a nested array
      if (is_array($value)) {
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

  protected function addRuleIfNotMixed(&$rules, $attributeName, $rule)
  {
    $input = trim($this->input($attributeName));
    if ($input !== '<mixed>') {
      $rules[$attributeName] = $rule;
    }
  }

  protected function failedValidation(Validator $validator)
  {
    // Since there's not really a good place for this message on the form,
    // we're going to flash a message at the top of the page.
    if ($validator->errors()->has('batch_size')) {
      $this->session()->put('alert', array('type' => 'danger', 'message' =>
          '<strong>Oops!</strong> ' .
          'Please provide a batch size between 2 and 100 items.'));
    }

    throw new ValidationException($validator);
  }

}

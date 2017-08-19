<?php namespace Jitterbug\Http\Requests;

use Log;

use Illuminate\Routing\Route;

use Jitterbug\Http\Requests\Request;

class CollectionRequest extends Request {

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
    $required = '';
    // Only require the fields if it's a new record
    if ($this->route()->getName() === 'collections.store') {
      $required = 'required|';
    }
    return [
      'id' => $required . 'integer|unique:collections,id,' . 
         $this->route()->parameter('collections'),
      'name' => $required . 'min:3|max:255|unique:collections,name,' .
         $this->route()->parameter('collections'),
    ];
  }

  /**
   * Get the messages for field/validator combinations.
   *
   * @return array of messages
   */
  public function messages()
  {
    return [
      'name.required' => 'A collection name is required.',
      'name.unique' => 'The collection name has already been used.',
      'name.min' => 'The collection name must be at least :min characters.',
      'name.max' => 'The collection name must be less than :max characters.',
    ];
  }

}

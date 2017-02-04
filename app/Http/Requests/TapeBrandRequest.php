<?php namespace Jitterbug\Http\Requests;

use Log;

use Illuminate\Routing\Route;

use Jitterbug\Http\Requests\Request;

class TapeBrandRequest extends Request {

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
    return [
      'name' => 'required|min:2|max:255|unique:tape_brands,name,' .
         $this->route()->getParameter('tape-brands'),
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
      'name.required' => 'A tape brand name is required.',
      'name.unique' => 'The tape brand name has already been used.',
      'name.min' => 'The tape brand name must be at least :min characters.',
      'name.max' => 'The tape brand name must be less than :max characters.',
    ];
  }

}

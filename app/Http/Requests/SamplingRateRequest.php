<?php namespace Jitterbug\Http\Requests;

use Log;

use Illuminate\Routing\Route;

use Jitterbug\Http\Requests\Request;

class SamplingRateRequest extends Request {

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
      'name' => 'required|min:2|max:255|unique:sampling_rates,name,' .
         $this->route()->getParameter('sampling-rates'),
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
      'name.required' => 'A sampling rate name is required.',
      'name.unique' => 'The sampling rate name has already been used.',
      'name.min' => 'The sampling rate name must be at least :min characters.',
      'name.max' => 'The sampling rate name must be less than :max characters.',
    ];
  }

}

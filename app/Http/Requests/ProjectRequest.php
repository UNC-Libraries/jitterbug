<?php namespace Jitterbug\Http\Requests;

use Log;

use Illuminate\Routing\Route;

use Jitterbug\Http\Requests\Request;

class ProjectRequest extends Request {

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
      'name' => 'required|min:2|max:255|unique:projects,name,' .
         $this->route()->parameter('projects'),
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
      'name.required' => 'A project name is required.',
      'name.unique' => 'The project name has already been used.',
      'name.min' => 'The project name must be at least :min characters.',
      'name.max' => 'The project name must be less than :max characters.',
    ];
  }

}

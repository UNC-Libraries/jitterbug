<?php namespace Jitterbug\Http\Requests;

use Log;

use Jitterbug\Http\Requests\Request;
use Jitterbug\Models\PreservationMaster;

class CutRequest extends Request {

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
      'preservationMasterId' => 'required|exists:preservation_masters,id,deleted_at,NULL',
      'side' => 'required|max:4',
      'cutNumber' => 'integer',
      'title' => 'max:255',
      'performerComposer' => 'max:255',
      'pmStartTime' => 'max:10',
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
      // Messages for transfer fields
      'preservationMasterId.required' => 'The preservation master number field is required.',
      'preservationMasterId.exists' => 'The given preservation master does not exist.',
      'side.required' => 'The side field is required.',
      'side.max' => 'The side field must be less than :max characters.',
      'title.max' => 'The title field must be less than :max characters.',
      'performerComposer.max' => 'The performer composer field must be less than :max characters.',
      'pmStartTime.max' => 'The PM start time must be less than :max characters.',
    ];
  }

}

<?php namespace Junebug\Http\Requests;

use Log;

use Junebug\Http\Requests\Request;
use Junebug\Models\PreservationMaster;

class TransferRequest extends Request {

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
    // Add rules for base audio visual item
    $rules = array();
    $this->addRuleIfNotMixed($rules, 'preservationMasterId',
      'required|exists:preservation_masters,id');
    $this->addRuleIfNotMixed($rules, 'transferDate', 'required|date_format:Y-m-d');
    $this->addRuleIfNotMixed($rules, 'playbackMachineId', 'required');
    $this->addRuleIfNotMixed($rules, 'transferNote', 'max:1000');
    $this->addRuleIfNotMixed($rules, 'conditionNote', 'max:1000');

    $subclassType = $this->input('subclassType');
    // Add rules for audio transfers
    if($subclassType === 'AudioTransfer') {
      $this->addRuleIfNotMixed($rules, 'subclass.stylus', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.cartridge', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.firstSound', 'max:1000');
    // Add rules for film transfers
    } else if ($subclassType === 'FilmTransfer') {
        // No film transfer rules at the moment
    // Add rules for video transfers
    } else if ($subclassType === 'VideoTransfer') {
      $this->addRuleIfNotMixed($rules, 'subclass.timeBaseCorrector', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.adConverter', 'max:255');
    }
    
    return $rules;
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
      'playbackMachineId.required' => 'The playback machine field is required.',
      'transferNote.max' => 'The transfer note must be less than :max characters.',
      'conditionNote.max' => 'The condition note must be less than :max characters.',

      // Messages for audio transfer fields
      'subclass.stylus.max' => 'The stylus field must be less than :max characters.',
      'subclass.cartridge.max' => 'The cartridge field must be less than :max characters.',
      'subclass.firstSound.max' => 'The first sound field must be less than :max characters.',

      // Messages for film transfer fields
      // Add fillm transfer messages here when necessary

      // Messages for video transfer fields
      'subclass.timeBaseCorrector.max' => 'The time base corrector field must be less than :max characters.',
      'subclass.adConverter.max' => 'The A/D converter field must be less than :max characters.',
    ];
  }

  public function validator($factory)
  {
    // call allWithoutMixed() here?
    $validator = $factory->make(
      $this->all(), $this->rules(), $this->messages(), $this->attributes()
    );

    $validator->after(function($validator) {
      if ($this->typeMismatch()) {
        $validator->errors()->add('preservationMasterId', 'The preservation master type must match the transfer type.');
      }
    });

    return $validator;
  }

  private function typeMismatch()
  {
    $inputType = $this->input('subclassType');
    $type = substr($inputType, 0, strlen($inputType) - strlen('Transfer'));
    $master = PreservationMaster::findOrFail($this->input('preservationMasterId'));
    return $master !== null && $type !== $master->type;
  }

}

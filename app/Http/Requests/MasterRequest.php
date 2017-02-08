<?php namespace Jitterbug\Http\Requests;

use Log;

use Jitterbug\Http\Requests\Request;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Util\DurationFormat;

class MasterRequest extends Request {

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
    // Add rules for base preservation masters
    $rules = array();
    $rules['batchSize'] = 'required_if:batch,1|integer|between:2,100';
    $this->addRuleIfNotMixed($rules, 'callNumber',
      'required|min:4|max:30|exists:audio_visual_items,call_number,deleted_at,NULL');
    // If this is a batch create or update, don't require a file name since it
    // needs to be unique across every master.
    if (!$this->input('batch') && $this->route()->getName()!=='masters.batch.update') {
      $this->addRuleIfNotMixed($rules, 'fileName', 
        'required|max:60|unique:preservation_masters,file_name,NULL,id,deleted_at,NULL' . 
        $this->input('id'));
    }
    $this->addRuleIfNotMixed($rules, 'fileLocation', 'max:60');
    $this->addRuleIfNotMixed($rules, 'fileSizeInBytes', 
      'integer|required|digits_between:0,15');
    $this->addRuleIfNotMixed($rules, 'duration', array('required', 
      'regex:' . DurationFormat::$pattern));
    $this->addRuleIfNotMixed($rules, 'checksum', 'max:255');
    $this->addRuleIfNotMixed($rules, 'accessFileLocation', 'max:60');
    $this->addRuleIfNotMixed($rules, 'departmentId', 'required');

    $subclassType = $this->input('subclassType');
    // Add rules for audio masters
    if($subclassType === 'AudioMaster') {
      $this->addRuleIfNotMixed($rules, 'audioFileFormat', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'audioFileCodec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'subclass.samplingRateId', 'required');
      $this->addRuleIfNotMixed($rules, 'subclass.testTones', 'max:255');     
    // Add rules for film masters
    } else if ($subclassType === 'FilmMaster') {
      $this->addRuleIfNotMixed($rules, 'filmFileFormat', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'filmFileCodec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'subclass.filmFrameSize', 'max:30');
      $this->addRuleIfNotMixed($rules, 'subclass.filmAspectRatio', 'max:30');
    // Add rules for video masters
    } else if ($subclassType === 'VideoMaster') {
      $this->addRuleIfNotMixed($rules, 'videoFileFormat', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'videoFileCodec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'subclass.videoFrameSize', 'max:30');
      $this->addRuleIfNotMixed($rules, 'subclass.videoAspectRatio', 'max:30');
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
      // Messages for preservation master fields
      'callNumber.exists' => 'The given call number does not exist.',
      'callNumber.max' => 'The call number must be less than :max characters.',
      'fileName.unique' => 'The file name is already in use.',
      'fileName.max' => 'The file name must be less than :max characters.',
      'fileLocation.max' => 'The file location field must be less than :max characters.',
      'fileSizeInBytes.required' => 'The file size field is required.',
      'fileSizeInBytes.integer' => 'The file size field must be an integer.',
      'fileSizeInBytes.digits_between' => 'The file size must be less than :max digits.',
      'duration.regex' => 'The duration field must be in the format of HH:MM:SS.',
      'departmentId.required' => 'The department field is required.',

      // Messages for audio master fields
      'subclass.samplingRateId.required' => 'The sampling rate field is required.',
      'subclass.testTones.max' => 'The test tones field must be less than :max characters.',
      'audioFileFormat.required' => 'The file format field is required.',
      'audioFileCodec.required' => 'The file codec field is required.',
      'audioFileFormat.max' => 'The file format must be less than :max characters.',
      'audioFileCodec.max' => 'The file codec must be less than :max characters.',

      // Messages for film master fields
      'filmFileFormat.required' => 'The file format field is required.',
      'filmFileFormat.max' => 'The file format must be less than :max characters.',
      'filmFileCodec.required' => 'The file codec field is required.',
      'filmFileCodec.max' => 'The file codec must be less than :max characters.',
      'subclass.filmFrameSize.max' => 'The frame size must be less than :max characters.',
      'subclass.filmAspectRatio.max' => 'The aspect ratio must be less than :max characters.',

      // Messages for video master fields
      'videoFileFormat.required' => 'The file format field is required.',
      'videoFileCodec.required' => 'The file codec field is required.',
      'videoFileFormat.max' => 'The file format must be less than :max characters.',
      'videoFileCodec.max' => 'The file codec must be less than :max characters.',
      'subclass.videoFrameSize.max' => 'The frame size must be less than :max characters.',
      'subclass.videoAspectRatio.max' => 'The aspect ratio must be less than :max characters.',

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
        $validator->errors()->add('callNumber', 'The call number type must match the master type.');
      }
    });

    return $validator;
  }

  private function typeMismatch()
  {
    $inputType = $this->input('subclassType');
    $type = substr($inputType, 0, strlen($inputType) - strlen('Master'));
    $item = AudioVisualItem::where('call_number', $this->input('callNumber'))->first();
    return $item !== null && $type !== $item->type;
  }

}

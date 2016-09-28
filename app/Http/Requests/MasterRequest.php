<?php namespace Junebug\Http\Requests;

use Log;

use Junebug\Http\Requests\Request;
use Junebug\Util\DurationFormat;

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
      'required|min:4|max:30|exists:audio_visual_items,call_number');
    // If this is a batch create, don't require a file name since it
    // needs to be unique across every master.
    if (!$this->input('batch')) {
      $this->addRuleIfNotMixed($rules, 'fileName', 
        'required|max:60|unique:preservation_masters,file_name,' . 
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

    $masterableType = $this->input('masterableType');
    // Add rules for audio masters
    if($masterableType === 'AudioMaster') {
      $this->addRuleIfNotMixed($rules, 'audioFileFormat', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'audioFileCodec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'masterable.samplingRateId', 'required');
      $this->addRuleIfNotMixed($rules, 'masterable.testTones', 'max:255');     
    // Add rules for film masters
    } else if ($masterableType === 'FilmMaster') {
      $this->addRuleIfNotMixed($rules, 'filmFileFormat', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'filmFileCodec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'masterable.filmFrameSize', 'max:30');
      $this->addRuleIfNotMixed($rules, 'masterable.filmAspectRatio', 'max:30');
    // Add rules for video masters
    } else if ($masterableType === 'VideoMaster') {
      $this->addRuleIfNotMixed($rules, 'videoFileFormat', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'videoFileCodec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'masterable.videoFrameSize', 'max:30');
      $this->addRuleIfNotMixed($rules, 'masterable.videoAspectRatio', 'max:30');
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
      'masterable.samplingRateId.required' => 'The sampling rate field is required.',
      'masterable.testTones.max' => 'The test tones field must be less than :max characters.',
      'audioFileFormat.required' => 'The file format field is required.',
      'audioFileCodec.required' => 'The file codec field is required.',
      'audioFileFormat.max' => 'The file format must be less than :max characters.',
      'audioFileCodec.max' => 'The file codec must be less than :max characters.',

      // Messages for film master fields
      'filmFileFormat.required' => 'The file format field is required.',
      'filmFileFormat.max' => 'The file format must be less than :max characters.',
      'filmFileCodec.required' => 'The file codec field is required.',
      'filmFileCodec.max' => 'The file codec must be less than :max characters.',
      'masterable.filmFrameSize.max' => 'The frame size must be less than :max characters.',
      'masterable.filmAspectRatio.max' => 'The aspect ratio must be less than :max characters.',

      // Messages for video master fields
      'videoFileFormat.required' => 'The file format field is required.',
      'videoFileCodec.required' => 'The file codec field is required.',
      'videoFileFormat.max' => 'The file format must be less than :max characters.',
      'videoFileCodec.max' => 'The file codec must be less than :max characters.',
      'masterable.videoFrameSize.max' => 'The frame size must be less than :max characters.',
      'masterable.videoAspectRatio.max' => 'The aspect ratio must be less than :max characters.',

    ];
  }

}

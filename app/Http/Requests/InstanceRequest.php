<?php namespace Jitterbug\Http\Requests;

use Log;

use Jitterbug\Http\Requests\Request;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Util\DurationFormat;

class InstanceRequest extends Request {

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
    $rules['batch_size'] = 'required_if:batch,1|integer|between:2,100';
    $this->addRuleIfNotMixed($rules, 'call_number',
      'required|min:4|max:30|exists:audio_visual_items,call_number,deleted_at,NULL');
    // If this is a batch create or update, don't require a file name since it
    // needs to be unique across every master.
    if (!$this->input('batch') && $this->route()->getName()!=='instances.batch.update') {
      $this->addRuleIfNotMixed($rules, 'file_name',
        'required|max:60|unique:preservation_instances,file_name,'.
          $this->input('id').',id,deleted_at,NULL' 
        );
    }
    $this->addRuleIfNotMixed($rules, 'file_location', 'max:60');
    $this->addRuleIfNotMixed($rules, 'file_size_in_bytes',
      'integer|required|digits_between:0,15');
    $this->addRuleIfNotMixed($rules, 'duration', array('required', 
      'regex:' . DurationFormat::$pattern));
    $this->addRuleIfNotMixed($rules, 'checksum', 'max:255');
    $this->addRuleIfNotMixed($rules, 'access_file_location', 'max:60');
    $this->addRuleIfNotMixed($rules, 'department_id', 'required');

    $subclassType = $this->input('subclassType');
    // Add rules for audio masters
    if($subclassType === 'AudioMaster') {
      $this->addRuleIfNotMixed($rules, 'audio_file_format', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'audio_file_codec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'subclass.sampling_rate_id', 'required');
      $this->addRuleIfNotMixed($rules, 'subclass.test_tones', 'max:255');
    // Add rules for film masters
    } else if ($subclassType === 'FilmInstance') {
      $this->addRuleIfNotMixed($rules, 'film_file_format', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'film_file_codec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'subclass.film_frame_size', 'max:30');
      $this->addRuleIfNotMixed($rules, 'subclass.film_aspect_ratio', 'max:30');
    // Add rules for video masters
    } else if ($subclassType === 'VideoInstance') {
      $this->addRuleIfNotMixed($rules, 'video_file_format', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'video_file_codec', 'required|max:60');
      $this->addRuleIfNotMixed($rules, 'subclass.video_frame_size', 'max:30');
      $this->addRuleIfNotMixed($rules, 'subclass.video_aspect_ratio', 'max:30');
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
      'call_number.exists' => 'The given call number does not exist.',
      'call_number.max' => 'The call number must be less than :max characters.',
      'file_name.unique' => 'The file name is already in use.',
      'file_name.max' => 'The file name must be less than :max characters.',
      'file_location.max' => 'The file location field must be less than :max characters.',
      'file_size_in_bytes.required' => 'The file size field is required.',
      'file_size_in_bytes.integer' => 'The file size field must be an integer.',
      'file_size_in_bytes.digits_between' => 'The file size must be less than :max digits.',
      'duration.regex' => 'The duration field must be in the format of HH:MM:SS.',
      'department_id.required' => 'The department field is required.',

      // Messages for audio master fields
      'subclass.sampling_rate_id.required' => 'The sampling rate field is required.',
      'subclass.test_tones.max' => 'The test tones field must be less than :max characters.',
      'audio_file_format.required' => 'The file format field is required.',
      'audio_file_codec.required' => 'The file codec field is required.',
      'audio_file_format.max' => 'The file format must be less than :max characters.',
      'audio_file_codec.max' => 'The file codec must be less than :max characters.',

      // Messages for film master fields
      'film_file_format.required' => 'The file format field is required.',
      'film_file_format.max' => 'The file format must be less than :max characters.',
      'film_file_codec.required' => 'The file codec field is required.',
      'film_file_codec.max' => 'The file codec must be less than :max characters.',
      'subclass.film_frame_size.max' => 'The frame size must be less than :max characters.',
      'subclass.film_aspect_ratio.max' => 'The aspect ratio must be less than :max characters.',

      // Messages for video master fields
      'video_file_format.required' => 'The file format field is required.',
      'video_file_codec.required' => 'The file codec field is required.',
      'video_file_format.max' => 'The file format must be less than :max characters.',
      'video_file_codec.max' => 'The file codec must be less than :max characters.',
      'subclass.video_frame_size.max' => 'The frame size must be less than :max characters.',
      'subclass.video_aspect_ratio.max' => 'The aspect ratio must be less than :max characters.',

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
        $validator->errors()->add('call_number', 'The call number type must match the instance type.');
      }
    });

    return $validator;
  }

  private function typeMismatch()
  {
    $inputType = $this->input('subclass_type');
    $type = substr($inputType, 0, strlen($inputType) - strlen('Master'));
    $item = AudioVisualItem::where('call_number', $this->input('call_number'))->first();
    return $item !== null && $type !== $item->type;
  }

}

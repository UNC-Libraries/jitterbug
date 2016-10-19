<?php namespace Junebug\Http\Requests;

use Log;

use Junebug\Http\Requests\Request;

class ItemRequest extends Request {

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
    $rules['batchSize'] = 'required_if:batch,1|integer|between:2,100';
    if ($this->route()->getName()!=='items.store') {
      $this->addRuleIfNotMixed($rules, 'callNumber',
        'required|min:4|max:30|unique:audio_visual_items,call_number,'.
         $this->input('id'));
    }
    $this->addRuleIfNotMixed($rules, 'title', 'required|min:3|max:255');
    $this->addRuleIfNotMixed($rules, 'containerNote', 'max:1000');
    $this->addRuleIfNotMixed($rules, 'collectionId', 'required');
    $this->addRuleIfNotMixed($rules, 'formatId', 'required');
    $this->addRuleIfNotMixed($rules, 'recordingLocation', 'max:255');
    $this->addRuleIfNotMixed($rules, 'oclc', 'integer|digits_between:0,15');
    $this->addRuleIfNotMixed($rules, 'itemYear', 'max:255');
    $this->addRuleIfNotMixed($rules, 'itemDate', 'date_format:Y-m-d');
    $this->addRuleIfNotMixed($rules, 'speed', 'max:255');
    $this->addRuleIfNotMixed($rules, 'entryDate',
                                          'required|date_format:Y-m-d');

    $subclassType = $this->input('subclassType');
    // Add rules for audio items
    if($subclassType === 'AudioItem') {
      $this->addRuleIfNotMixed($rules, 'subclass.size', 'required|max:30');
      $this->addRuleIfNotMixed($rules, 'subclass.trackConfiguration', 'max:100');
      $this->addRuleIfNotMixed($rules, 'subclass.audioBase', 'max:100');
      $this->addRuleIfNotMixed($rules, 'subclass.audioContentDescription','max:1000');
    // Add rules for film items
    } else if ($subclassType === 'FilmItem') {
      $this->addRuleIfNotMixed($rules, 'subclass.filmElement', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.filmBase', 'required|max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.filmColor', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.lengthInFeet', 'required|integer|digits_between:0,5');
      $this->addRuleIfNotMixed($rules, 'subclass.filmStock', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.edgeCode', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.shrinkagePercent', 'numeric|digits_between:0,6');
      $this->addRuleIfNotMixed($rules, 'subclass.canNumber','integer|digits_between:0,6');
      $this->addRuleIfNotMixed($rules, 'subclass.filmContentDescription','max:1000');
    // Add rules for video items
    } else if ($subclassType === 'VideoItem') {
      $this->addRuleIfNotMixed($rules, 'subclass.videoElement', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.videoColor', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.recordingStandard', 'max:255');
      $this->addRuleIfNotMixed($rules, 'subclass.videoContentDescription', 'max:1000');
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
      // Messages for audio visual item fields
      'formatId.required' => 'The format field is required.',
      'collectionId.required' => 'The collection field is required.',
      'oclc.integer' => 'The OCLC id must be an integer.',
      'oclc.digits_between' => 'The OCLC id must be less than :max digits.',
      'itemDate.date_format' => 'The item date does not match the format YYYY-MM-DD.',
      'entryDate.date_format' => 'The entry date does not match the format YYYY-MM-DD.',

      // Messages for audio item fields
      'subclass.size.required' => 'The size field is required.',
      'subclass.size.max' => 'The size field must be less than :max characters.',
      'subclass.trackConfiguration.max' => 'The track config must be less than :max characters.',
      'subclass.audioBase.max' => 'The base field must be less than :max characters.',
      'subclass.audioContentDescription.max' => 'The content description must be less than :max characters.',

      // Messages for film item fields
      'subclass.filmElement.max' => 'The element field must be less than :max characters.',
      'subclass.filmBase.required' => 'The base field is required.',
      'subclass.filmBase.max' => 'The base field must be less than :max characters.',
      'subclass.filmColor.max' => 'The color field must be less than :max characters.',
      'subclass.lengthInFeet.required' => 'The length in feet field is required.',
      'subclass.lengthInFeet.digits_between' => 'The length in feet field must be less than :max digits.',
      'subclass.lengthInFeet.integer' => 'The length in feet field must be an integer.',
      'subclass.filmStock.max' => 'The film stock field must be less than :max characters.',
      'subclass.edgeCode.max' => 'The edge code field must be less than :max characters.',
      'subclass.shrinkagePercent.numeric' => 'The shrinkage percent field must be a number.',
      'subclass.shrinkagePercent.digits_between' => 'The shrinkage percent field must be less than :max digits.',
      'subclass.canNumber.integer' => 'The can number field must be an integer.',
      'subclass.canNumber.digits_between' => 'The can number field must less than :max digits.',
      'subclass.filmContentDescription.max' => 'The content description must be less then :max characters.',

      // Messages for video item fields
      'subclass.videoElement.max' => 'The element field must be less than :max characters.',
      'subclass.videoColor.max' => 'The color field must be less than :max characters.',
      'subclass.recordingStandard.max' => 'The recording standard must be less than :max characters.',
      'subclass.videoContentDescription.max' => 'The content description must be less then :max characters.',
    ];
  }

}

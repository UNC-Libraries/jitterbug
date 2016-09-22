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
      $itemableType = $this->input('itemableType');
      $itemableRules = array();
      // Add rules for audio items
      if($itemableType === 'AudioItem') {
        $this->addRuleIfNotMixed($itemableRules, 'itemable.size', 'required|max:30');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.trackConfiguration', 'max:100');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.audioBase', 'max:100');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.audioContentDescription','max:1000');
      // Add rules for film items
      } else if ($itemableType === 'FilmItem') {
        $this->addRuleIfNotMixed($itemableRules, 'itemable.filmElement', 'max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.filmBase', 'required|max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.filmColor', 'max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.lengthInFeet', 'required|integer|digits_between:0,5');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.filmStock', 'max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.edgeCode', 'max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.shrinkagePercent', 'numeric|digits_between:0,6');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.canNumber','integer|digits_between:0,6');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.filmContentDescription','max:1000');
      // Add rules for video items
      } else if ($itemableType === 'VideoItem') {
        $this->addRuleIfNotMixed($itemableRules, 'itemable.videoElement', 'max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.videoColor', 'max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.recordingStandard', 'max:255');
        $this->addRuleIfNotMixed($itemableRules, 'itemable.videoContentDescription', 'max:1000');
      }

      // Add rules for base audio visual item
      $itemRules = array();
      $itemRules['batchSize'] = 'required_if:batch,1|integer|between:2,100';
      $this->addRuleIfNotMixed($itemRules, 'callNumber',
        'required|min:4|max:30|unique:audio_visual_items,call_number,'.
         $this->input('id'));
      $this->addRuleIfNotMixed($itemRules, 'title', 'required|min:3|max:255');
      $this->addRuleIfNotMixed($itemRules, 'containerNote', 'max:1000');
      $this->addRuleIfNotMixed($itemRules, 'collectionId', 'required');
      $this->addRuleIfNotMixed($itemRules, 'formatId', 'required');
      $this->addRuleIfNotMixed($itemRules, 'recordingLocation', 'max:255');
      $this->addRuleIfNotMixed($itemRules, 'oclc', 'integer|digits_between:0,15');
      $this->addRuleIfNotMixed($itemRules, 'itemYear', 'max:255');
      $this->addRuleIfNotMixed($itemRules, 'itemDate', 'date_format:Y-m-d');
      $this->addRuleIfNotMixed($itemRules, 'speed', 'max:255');
      $this->addRuleIfNotMixed($itemRules, 'entryDate',
                                            'required|date_format:Y-m-d');
      return array_merge($itemRules,$itemableRules);
    }

    /**
     * Get the messages for field/validator combinations.
     *
     * @return array of messages
     */
    public function messages()
    {
      return [
        // AudioVisualItem fields
        'formatId.required' => 'The format field is required.',
        'collectionId.required' => 'The collection field is required.',
        'oclc.integer' => 'The OCLC id must be an integer.',
        'oclc.digits_between' => 'The OCLC id must be less than :max digits.',
        'itemDate.date_format' => 'The item date does not match the format YYYY-MM-DD.',
        'entryDate.date_format' => 'The entry date does not match the format YYYY-MM-DD.',

        // AudioItem fields
        'itemable.size.required' => 'The size field is required.',
        'itemable.size.max' => 'The size field must be less than :max characters.',
        'itemable.trackConfiguration.max' => 'The track config must be less than :max characters.',
        'itemable.audioBase.max' => 'The base field must be less than :max characters.',
        'itemable.audioContentDescription.max' => 'The content description must be less than :max characters.',

        // FilmItem fields
        'itemable.filmElement.max' => 'The element field must be less than :max characters.',
        'itemable.filmBase.required' => 'The base field is required.',
        'itemable.filmBase.max' => 'The base field must be less than :max characters.',
        'itemable.filmColor.max' => 'The color field must be less than :max characters.',
        'itemable.lengthInFeet.required' => 'The length in feet field is required.',
        'itemable.lengthInFeet.digits_between' => 'The length in feet field must be less than :max digits.',
        'itemable.lengthInFeet.integer' => 'The length in feet field must be an integer.',
        'itemable.filmStock.max' => 'The film stock field must be less than :max characters.',
        'itemable.edgeCode.max' => 'The edge code field must be less than :max characters.',
        'itemable.shrinkagePercent.numeric' => 'The shrinkage percent field must be a number.',
        'itemable.shrinkagePercent.digits_between' => 'The shrinkage percent field must be less than :max digits.',
        'itemable.canNumber.integer' => 'The can number field must be an integer.',
        'itemable.canNumber.digits_between' => 'The can number field must less than :max digits.',
        'itemable.filmContentDescription.max' => 'The content description must be less then :max characters.',

        // VideoItem fields
        'itemable.videoElement.max' => 'The element field must be less than :max characters.',
        'itemable.videoColor.max' => 'The color field must be less than :max characters.',
        'itemable.recordingStandard.max' => 'The recording standard must be less than :max characters.',
        'itemable.videoContentDescription.max' => 'The content description must be less then :max characters.',
      ];
    }

}

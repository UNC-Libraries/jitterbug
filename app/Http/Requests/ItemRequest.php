<?php

namespace Jitterbug\Http\Requests;

class ItemRequest extends Request
{
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
        $rules = [];
        $rules['batch_size'] = 'required_if:batch,1|integer|between:2,100';
        if ($this->route()->getName() !== 'items.store') {
            $this->addRuleIfNotMixed($rules, 'call_number',
                'required|min:4|max:30|unique:audio_visual_items,call_number,'.
                 $this->input('id').',id,deleted_at,NULL');
        }
        $this->addRuleIfNotMixed($rules, 'title', 'required|min:3|max:255');
        $this->addRuleIfNotMixed($rules, 'container_note', 'max:1000');
        $this->addRuleIfNotMixed($rules, 'collection_id', 'required');
        $this->addRuleIfNotMixed($rules, 'accession_number', 'max:255');
        $this->addRuleIfNotMixed($rules, 'legacy', 'max:255');
        $this->addRuleIfNotMixed($rules, 'format_id', 'required');
        $this->addRuleIfNotMixed($rules, 'reel_tape_number', 'max:255');
        $this->addRuleIfNotMixed($rules, 'recording_location', 'max:255');
        $this->addRuleIfNotMixed($rules, 'physical_location', 'max:255');
        $this->addRuleIfNotMixed($rules, 'access_restrictions', 'max:255');
        $this->addRuleIfNotMixed($rules, 'oclc', 'integer|digits_between:0,15');
        $this->addRuleIfNotMixed($rules, 'item_year', 'max:255');
        $this->addRuleIfNotMixed($rules, 'item_date', 'date_format:Y-m-d');
        $this->addRuleIfNotMixed($rules, 'speed', 'max:255');
        $this->addRuleIfNotMixed($rules, 'entry_date',
            'required|date_format:Y-m-d');

        $subclassType = $this->input('subclassType');
        // Add rules for audio items
        if ($subclassType === 'AudioItem') {
            $this->addRuleIfNotMixed($rules, 'subclass.size', 'required|max:30');
            $this->addRuleIfNotMixed($rules, 'subclass.track_configuration', 'max:100');
            $this->addRuleIfNotMixed($rules, 'subclass.audio_base', 'max:100');
            $this->addRuleIfNotMixed($rules, 'subclass.audio_content_description', 'max:1000');
        // Add rules for film items
        } elseif ($subclassType === 'FilmItem') {
            $this->addRuleIfNotMixed($rules, 'subclass.film_element', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.film_base', 'required|max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.film_color', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.length_in_feet', 'required|integer|digits_between:0,5');
            $this->addRuleIfNotMixed($rules, 'subclass.film_stock', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.edge_code', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.shrinkage_percent', 'numeric|digits_between:0,6');
            $this->addRuleIfNotMixed($rules, 'subclass.can_number', 'integer|digits_between:0,6');
            $this->addRuleIfNotMixed($rules, 'subclass.condition', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.film_content_description', 'max:1000');
        // Add rules for video items
        } elseif ($subclassType === 'VideoItem') {
            $this->addRuleIfNotMixed($rules, 'subclass.video_element', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.video_color', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.recording_standard', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.video_content_description', 'max:1000');
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
            'format_id.required' => 'The format field is required.',
            'reel_tape_number.max' => ' The reel/tape number field must be less than :max characters.',
            'accession_number.max' => 'The accession number must be less than :max characters.',
            'legacy.max' => 'The legacy id field must be less than :max characters.',
            'collection_id.required' => 'The collection field is required.',
            'physical_location.max' => ' The physical location field must be less than :max characters.',
            'access_restrictions.max' => ' The access restrictions field must be less than :max characters.',
            'oclc.integer' => 'The OCLC id must be an integer.',
            'oclc.digits_between' => 'The OCLC id must be less than :max digits.',
            'item_date.date_format' => 'The item date does not match the format YYYY-MM-DD.',
            'entry_date.date_format' => 'The entry date does not match the format YYYY-MM-DD.',

            // Messages for audio item fields
            'subclass.size.required' => 'The size field is required.',
            'subclass.size.max' => 'The size field must be less than :max characters.',
            'subclass.track_configuration.max' => 'The track config must be less than :max characters.',
            'subclass.audio_base.max' => 'The base field must be less than :max characters.',
            'subclass.audio_content_description.max' => 'The content description must be less than :max characters.',

            // Messages for film item fields
            'subclass.film_element.max' => 'The element field must be less than :max characters.',
            'subclass.film_base.required' => 'The base field is required.',
            'subclass.film_base.max' => 'The base field must be less than :max characters.',
            'subclass.film_color.max' => 'The color field must be less than :max characters.',
            'subclass.length_in_feet.required' => 'The length in feet field is required.',
            'subclass.length_in_feet.digits_between' => 'The length in feet field must be less than :max digits.',
            'subclass.length_in_feet.integer' => 'The length in feet field must be an integer.',
            'subclass.film_stock.max' => 'The film stock field must be less than :max characters.',
            'subclass.edge_code.max' => 'The edge code field must be less than :max characters.',
            'subclass.shrinkage_percent.numeric' => 'The shrinkage percent field must be a number.',
            'subclass.shrinkage_percent.digits_between' => 'The shrinkage percent field must be less than :max digits.',
            'subclass.can_number.integer' => 'The can number field must be an integer.',
            'subclass.can_number.digits_between' => 'The can number field must less than :max digits.',
            'subclass.condition.max' => 'The condition field must be less than :max characters.',
            'subclass.film_content_description.max' => 'The content description must be less then :max characters.',

            // Messages for video item fields
            'subclass.video_element.max' => 'The element field must be less than :max characters.',
            'subclass.video_color.max' => 'The color field must be less than :max characters.',
            'subclass.recording_standard.max' => 'The recording standard must be less than :max characters.',
            'subclass.video_content_description.max' => 'The content description must be less then :max characters.',
        ];
    }
}

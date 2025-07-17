<?php

namespace Jitterbug\Http\Requests;

class CutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'preservation_instance_id' => 'required|exists:preservation_instances,id,deleted_at,NULL',
            'side' => 'required|max:4',
            'cut_number' => 'integer',
            'title' => 'max:255',
            'performer_composer' => 'max:255',
            'pm_start_time' => 'max:10',
        ];
    }

    /**
     * Get the messages for field/validator combinations.
     *
     * @return array of messages
     */
    public function messages(): array
    {
        return [
            // Messages for transfer fields
            'preservation_instance_id.required' => 'The preservation instance number field is required.',
            'preservation_instance_id.exists' => 'The given preservation instance does not exist.',
            'side.required' => 'The side field is required.',
            'side.max' => 'The side field must be less than :max characters.',
            'title.max' => 'The title field must be less than :max characters.',
            'performer_composer.max' => 'The performer composer field must be less than :max characters.',
            'pm_start_time.max' => 'The PM start time must be less than :max characters.',
        ];
    }
}

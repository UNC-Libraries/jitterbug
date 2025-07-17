<?php

namespace Jitterbug\Http\Requests;

class PlaybackMachineRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:255|unique:playback_machines,name,'.
               $this->route()->parameter('playback-machines'),
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
            'name.required' => 'A playback machine name is required.',
            'name.unique' => 'The playback machine name has already been used.',
            'name.min' => 'The playback machine name must be at least :min characters.',
            'name.max' => 'The playback machine name must be less than :max characters.',
        ];
    }
}

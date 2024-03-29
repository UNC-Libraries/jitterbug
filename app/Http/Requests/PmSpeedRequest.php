<?php

namespace Jitterbug\Http\Requests;

class PmSpeedRequest extends Request
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
        return [
            'name' => 'required|min:2|max:255|unique:pm_speeds,name,'.
               $this->route()->parameter('pm-speeds'),
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
            'name.required' => 'A PM speed name is required.',
            'name.unique' => 'The PM speed name has already been used.',
            'name.min' => 'The PM speed name must be at least :min characters.',
            'name.max' => 'The PM speed name must be less than :max characters.',
        ];
    }
}

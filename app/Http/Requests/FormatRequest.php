<?php

namespace Jitterbug\Http\Requests;

class FormatRequest extends Request
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
        $required = '';
        // Only require if it's a new record
        if ($this->route()->getName() === 'formats.store') {
            $required = 'required|';
        }

        return [
            'name' => $required.'min:2|max:255|unique:formats,name,'.
               $this->route()->parameter('formats'),
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
            'name.required' => 'A format name is required.',
            'name.unique' => 'The format name has already been used.',
            'name.min' => 'The format name must be at least :min characters.',
            'name.max' => 'The format name must be less than :max characters.',
        ];
    }
}

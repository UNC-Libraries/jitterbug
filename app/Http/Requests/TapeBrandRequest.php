<?php

namespace Jitterbug\Http\Requests;

class TapeBrandRequest extends Request
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
            'name' => 'required|min:2|max:255|unique:tape_brands,name,'.
               $this->route()->parameter('tape-brands'),
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
            'name.required' => 'A tape brand name is required.',
            'name.unique' => 'The tape brand name has already been used.',
            'name.min' => 'The tape brand name must be at least :min characters.',
            'name.max' => 'The tape brand name must be less than :max characters.',
        ];
    }
}

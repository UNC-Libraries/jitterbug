<?php

namespace Jitterbug\Http\Requests;

class VendorRequest extends Request
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
            'name' => 'required|min:2|max:255|unique:vendors,name,'.
               $this->route()->parameter('vendors'),
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
            'name.required' => 'A vendor name is required.',
            'name.unique' => 'The vendor name has already been used.',
            'name.min' => 'The vendor name must be at least :min characters.',
            'name.max' => 'The vendor name must be less than :max characters.',
        ];
    }
}

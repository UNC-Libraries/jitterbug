<?php

namespace Jitterbug\Http\Requests;

class DepartmentRequest extends Request
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
            'name' => 'required|min:2|max:255|unique:departments,name,'.
               $this->route()->parameter('departments'),
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
            'name.required' => 'A department name is required.',
            'name.unique' => 'The department name has already been used.',
            'name.min' => 'The department name must be at least :min characters.',
            'name.max' => 'The department name must be less than :max characters.',
        ];
    }
}

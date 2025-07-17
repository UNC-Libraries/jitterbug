<?php

namespace Jitterbug\Http\Requests;

class ReproductionMachineRequest extends Request
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
            'name' => 'required|min:2|max:255|unique:reproduction_machines,name,'.
               $this->route()->parameter('reproduction-machines'),
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
            'name.required' => 'A reproduction machine name is required.',
            'name.unique' => 'The reproduction machine name has already been used.',
            'name.min' => 'The reproduction machine name must be at least :min characters.',
            'name.max' => 'The reproduction machine name must be less than :max characters.',
        ];
    }
}

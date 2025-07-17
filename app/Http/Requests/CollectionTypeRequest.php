<?php

namespace Jitterbug\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionTypeRequest extends FormRequest
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
            'name' => 'required|min:2|max:255|unique:collection_types,name,',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A collection type name is required.',
            'name.unique' => 'The collection type name has already been used.',
            'name.min' => 'The collection type name must be at least :min characters.',
            'name.max' => 'The collection type name must be less than :max characters.',
        ];
    }
}

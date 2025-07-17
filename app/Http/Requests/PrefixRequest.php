<?php

namespace Jitterbug\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrefixRequest extends FormRequest
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
        $required = '';
        // Only require the fields if it's a new record
        if ($this->route()->getName() === 'prefixes.store') {
            $required = 'required|';
        }

        return [
            'label' => $required.'min:2|max:255',
            'collection_type_id' => $required.'integer',
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'A prefix label is required.',
            'label.min' => 'The prefix label must be at least :min characters.',
            'label.max' => 'The prefix label must be less than :max characters.',
            'collection_type_id.required' => 'A collection type ID is required.',
            'collection_type_id.integer' => 'The collection type ID must be an integer.',
        ];
    }
}

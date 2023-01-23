<?php

namespace Jitterbug\Http\Requests;

class CollectionRequest extends Request
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
        // Only require the fields if it's a new record
        if ($this->route()->getName() === 'collections.store') {
            $required = 'required|';
        }

        return [
            'name' => $required.'min:3|max:255|unique:collections,name,'.
               $this->route()->parameter('collections'),
            'collection_type_id' => $required.'integer',
            'archival_identifier' => $required.'min:3|max:255|unique:collections,archival_identifier,'.
              $this->route()->parameter('collections'),
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
            'name.required' => 'A collection name is required.',
            'name.unique' => 'The collection name has already been used.',
            'name.min' => 'The collection name must be at least :min characters.',
            'name.max' => 'The collection name must be less than :max characters.',
            'collection_type_id.required' => 'A collection type ID is required.',
            'collection_type_id.integer' => 'The collection type ID must be an integer.',
            'archival_identifier.required' => 'A collection archival identifier is required.',
            'archival_identifier.unique' => 'The collection archival identifier has already been used.',
            'archival_identifier.min' => 'The collection archival identifier must be at least :min characters.',
            'archival_identifier.max' => 'The collection archival identifier must be less than :max characters.',
        ];
    }
}

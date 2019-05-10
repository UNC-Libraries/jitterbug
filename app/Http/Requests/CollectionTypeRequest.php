<?php

namespace Jitterbug\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollectionTypeRequest extends FormRequest
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
        'name' => 'required|min:2|max:255|unique:collection_types,name,',
      ];
    }

    public function messages()
    {
        return [
          'name.required' => 'A collection type name is required.',
          'name.unique' => 'The collection type name has already been used.',
          'name.min' => 'The collection type name must be at least :min characters.',
          'name.max' => 'The collection type name must be less than :max characters.',
        ];
    }
}

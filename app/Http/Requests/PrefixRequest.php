<?php

namespace Jitterbug\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrefixRequest extends FormRequest
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
      if ($this->route()->getName() === 'prefixes.store') {
        $required = 'required|';
      }
      return [
        'label' => $required.'min:2|max:255',
        'collectionTypeId' => $required.'integer',
      ];
    }

  public function messages()
  {
    return [
      'label.required' => 'A prefix label is required.',
      'label.min' => 'The prefix label must be at least :min characters.',
      'label.max' => 'The prefix label must be less than :max characters.',
      'collectionTypeId.required' => 'A collection type ID is required.',
      'collectionTypeId.integer' => 'The collection type ID must be an integer.',
    ];
  }
}

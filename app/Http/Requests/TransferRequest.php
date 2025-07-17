<?php

namespace Jitterbug\Http\Requests;

use Jitterbug\Models\PreservationInstance;

class TransferRequest extends Request
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
        // Add rules for base transfer
        $rules = [];
        $this->addRuleIfNotMixed($rules, 'preservation_instance_id',
            'required|exists:preservation_instances,id,deleted_at,NULL');
        $this->addRuleIfNotMixed($rules, 'transfer_date', 'required|date_format:Y-m-d');
        $this->addRuleIfNotMixed($rules, 'playback_machine_id', 'required');
        $this->addRuleIfNotMixed($rules, 'transfer_note', 'max:1000');
        $this->addRuleIfNotMixed($rules, 'condition_note', 'max:1000');

        $subclassType = $this->input('subclassType');
        // Add rules for audio transfers
        if ($subclassType === 'AudioTransfer') {
            $this->addRuleIfNotMixed($rules, 'subclass.stylus', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.cartridge', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.first_sound', 'max:1000');
            // Add rules for film transfers
        } elseif ($subclassType === 'FilmTransfer') {
            // No film transfer rules at the moment
            // Add rules for video transfers
        } elseif ($subclassType === 'VideoTransfer') {
            $this->addRuleIfNotMixed($rules, 'subclass.time_base_corrector', 'max:255');
            $this->addRuleIfNotMixed($rules, 'subclass.ad_converter', 'max:255');
        }

        return $rules;
    }

    /**
     * Get the messages for field/validator combinations.
     *
     * @return array of messages
     */
    public function messages(): array
    {
        return [
            // Messages for transfer fields
            'preservation_instance_id.required' => 'The preservation instance number field is required.',
            'preservation_instance_id.exists' => 'The given preservation instance does not exist.',
            'playback_machine_id.required' => 'The playback machine field is required.',
            'transfer_note.max' => 'The transfer note must be less than :max characters.',
            'condition_note.max' => 'The condition note must be less than :max characters.',

            // Messages for audio transfer fields
            'subclass.stylus.max' => 'The stylus field must be less than :max characters.',
            'subclass.cartridge.max' => 'The cartridge field must be less than :max characters.',
            'subclass.first_sound.max' => 'The first sound field must be less than :max characters.',

            // Messages for film transfer fields
            // Add fillm transfer messages here when necessary

            // Messages for video transfer fields
            'subclass.time_base_corrector.max' => 'The time base corrector field must be less than :max characters.',
            'subclass.ad_converter.max' => 'The A/D converter field must be less than :max characters.',
        ];
    }

    public function validator($factory)
    {
        // call allWithoutMixed() here?
        $validator = $factory->make(
            $this->all(), $this->rules(), $this->messages(), $this->attributes()
        );

        $validator->after(function ($validator) {
            if ($this->typeMismatch()) {
                $validator->errors()->add('preservation_instance_id', 'The preservation instance type must match the transfer type.');
            }
        });

        return $validator;
    }

    private function typeMismatch()
    {
        $inputType = $this->input('subclass_type');
        $type = substr($inputType, 0, strlen($inputType) - strlen('Transfer'));
        $instance = PreservationInstance::find($this->input('preservation_instance_id'));

        return $instance !== null && $type !== $instance->type;
    }
}

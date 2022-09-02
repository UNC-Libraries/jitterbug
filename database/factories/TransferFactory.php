<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\PlaybackMachine;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\Transfer;
use Jitterbug\Models\User;
use Jitterbug\Models\Vendor;

class TransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transfer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'preservation_instance_id' => PreservationInstance::factory(),
            'call_number' => function (array $attributes) {
                return PreservationInstance::find($attributes['preservation_instance_id'])->call_number;
            },
            'transfer_date' => $this->faker->date(),
            'playback_machine_id' => PlaybackMachine::factory(),
            'engineer_id' => User::factory(),
            'vendor_id' => Vendor::factory(),
            'condition_note' => $this->faker->text,
            'transfer_note' => $this->faker->text,
            'subclass_type' => $this->faker->word,
            'subclass_id' => $this->faker->randomNumber(),
        ];
    }
}

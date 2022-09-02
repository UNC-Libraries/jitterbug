<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\Cut;
use Jitterbug\Models\Transfer;

class CutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cut::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'transfer_id' => Transfer::factory(),
            'preservation_instance_id' => function (array $attributes) {
                return Transfer::find($attributes['transfer_id'])->preservation_instance_id;
            },
            'call_number' => function (array $attributes) {
                return Transfer::find($attributes['transfer_id'])->call_number;
            },
            'side' => 1,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\Prefix;

class PrefixFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prefix::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'label' => strtoupper($this->faker->lexify('??')),
            'collection_type_id' => $this->faker->randomNumber(),
        ];
    }
}

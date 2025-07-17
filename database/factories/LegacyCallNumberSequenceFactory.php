<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\LegacyCallNumberSequence;

class LegacyCallNumberSequenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LegacyCallNumberSequence::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'prefix' => $this->faker->word(),
            'next' => $this->faker->randomNumber(),
            'reserved' => $this->faker->word(),
        ];
    }
}

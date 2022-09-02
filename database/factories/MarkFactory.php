<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\Mark;

class MarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'markable_type' => $this->faker->word(),
            'markable_id' => $this->faker->randomNumber(),
        ];
    }
}

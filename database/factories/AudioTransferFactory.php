<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\AudioTransfer;

class AudioTransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AudioTransfer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'stylus' => $this->faker->word(),
            'cartridge' => $this->faker->word(),
            'first_sound' => $this->faker->text(),
        ];
    }
}

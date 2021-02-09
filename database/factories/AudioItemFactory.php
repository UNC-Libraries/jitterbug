<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\AudioItem;

class AudioItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AudioItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'call_number' => 'FS-'.$this->faker->randomNumber(4),
          'listening_copy' => $this->faker->boolean,
          'size' => null,
          'track_configuration' => null,
          'mono_stereo' => 'M',
          'base' => $this->faker->word,
          'content_description' => $this->faker->text,
        ];
    }
}

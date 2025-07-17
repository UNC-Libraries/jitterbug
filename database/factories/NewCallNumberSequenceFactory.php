<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\Collection;
use Jitterbug\Models\NewCallNumberSequence;

class NewCallNumberSequenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewCallNumberSequence::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'prefix' => strtoupper($this->faker->lexify('??')),
            'collection_id' => Collection::factory(),
            'archival_identifier' => static function (array $attributes) {
                return Collection::find($attributes['collection_id'])->archival_identifier;
            },
            'next' => $this->faker->randomNumber(),
            'reserved' => $this->faker->word(),
        ];
    }
}

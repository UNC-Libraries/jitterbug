<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\AudioVisualItem;
use Jitterbug\Models\Collection;
use Jitterbug\Models\Format;
use Jitterbug\Models\AudioItem;

class AudioVisualItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AudioVisualItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'call_number' => 'FS-'.$this->faker->randomNumber(4),
          'title' => $this->faker->text,
          'recording_location' => 'Durham, NC',
          'physical_location' => null,
          'access_restrictions' => null,
          'item_year' => (string) $this->faker->numberBetween(1920, 2015),
          'item_date' => $this->faker->date(),
          'collection_id' => Collection::factory(),
          'accession_number' => $this->faker->bothify('##??#???###?#?#'),
          'legacy' => null,
          'container_note' => $this->faker->text,
          'condition_note' => $this->faker->text,
          'oclc' => null,
          'format_id' => Format::factory(),
          'reel_tape_number' => $this->faker->word,
          'entry_date' => $this->faker->date(),
          'speed' => $this->faker->word,
          'subclass_type' => 'AudioItem',
          'subclass_id' => static function (array $attributes) {
            return AudioItem::factory()->create([
              'call_number' => $attributes['call_number'],
            ]);
          },
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\Department;
use Jitterbug\Models\PreservationInstance;
use Jitterbug\Models\Project;
use Jitterbug\Models\ReproductionMachine;

class PreservationInstanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PreservationInstance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'call_number' => 'FS-'.$this->faker->randomNumber(4),
            'checksum' => $this->faker->word(),
            'project_id' => Project::factory(),
            'reproduction_machine_id' => ReproductionMachine::factory(),
            'department_id' => Department::factory(),
            'duration_in_seconds' => $this->faker->randomNumber(),
            'file_name' => $this->faker->word(),
            'file_location' => $this->faker->word(),
            'file_size_in_bytes' => $this->faker->randomNumber(),
            'file_format' => $this->faker->word(),
            'file_codec' => $this->faker->word(),
            'access_file_location' => $this->faker->word(),
            'subclass_type' => 'AudioInstance',
            'subclass_id' => $this->faker->randomNumber(),
        ];
    }
}

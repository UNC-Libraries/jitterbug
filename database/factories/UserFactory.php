<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jitterbug\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'first_name' => $this->faker->firstName,
          'middle_name' => $this->faker->word,
          'last_name' => $this->faker->lastName,
          'email' => $this->faker->safeEmail,
          'username' => $this->faker->userName,
          'password' => bcrypt($this->faker->password),
          'admin' => $this->faker->boolean,
          'remember_token' => str_random(10),
          'legacy_initials' => $this->faker->word,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    protected $model = \App\Models\Person::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'course' => $this->faker->randomElement(['ET', 'INF', 'DIB', 'MCD', 'WI']),
            'img' => '',
            'is_tutor' => $this->faker->boolean(10), // 10% Chance
            'is_special' => $this->faker->boolean(5), // 5% Chance
            'is_disabled' => $this->faker->boolean(2), // 2% Chance
        ];
    }
}

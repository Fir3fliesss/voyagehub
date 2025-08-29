<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journey>
 */
class JourneyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'location' => $this->faker->city(),
            'temprature' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}

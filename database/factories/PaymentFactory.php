<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $regular = $this->faker->boolean(20);
        $period = $regular ? $this->faker->numberBetween(2, 30) : null;
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->numberBetween(100, 10000),
            'title' => $this->faker->word(),
            'period' => $period,
            'regular' => $regular,
            'type' => $this->faker->randomElement(['food_drink', 'entertainment', 'housing', 'healthcare', 'transportation', 'other']),
            'type_of_payment' => $this->faker->randomElement(['cash', 'card']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

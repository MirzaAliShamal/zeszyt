<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OperationEnter>
 */
class OperationEnterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['income', 'expense']),
            'category' => $this->faker->randomElement(['credit', 'materials', 'transport', 'employes-payment','sell','service']),
            'brut_value' => $this->faker->randomFloat(2, 1000, 100000),
            'profit' => $this->faker->randomFloat(2, 100, 10000),
            'vat_tax_percent' => $this->faker->numberBetween(5, 20),
            'vat_tax_value' => $this->faker->randomFloat(2, 50, 2000),
            'net_value' => $this->faker->randomFloat(2, 900, 90000),
            'title' => $this->faker->sentence,
            'comment' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}

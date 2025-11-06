<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'desc' => $this->faker->paragraph,
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'category_id' => \App\Models\Category::factory(),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'tags' => json_encode($this->faker->words($this->faker->numberBetween(0, 5))),
        ];
    }
}

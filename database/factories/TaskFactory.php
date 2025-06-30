<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'finalizado' => $this->faker->boolean(),
            'data_limite' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Rebanho;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rebanho>
 */
class RebanhoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'especie' => $this->faker->randomElement(Rebanho::ESPECIES),
            'quantidade' => $this->faker->numberBetween(10, 500),
            'finalidade' => $this->faker->randomElement(['Corte', 'Leite', 'Reprodução']),
            'data_atualizacao' => $this->faker->date(),
        ];
    }
}

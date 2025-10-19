<?php

namespace Database\Factories;

use App\Models\Produtor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Propriedade>
 */
class PropriedadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Fazenda ' . $this->faker->lastName,
            'municipio' => $this->faker->city,
            'uf' => $this->faker->stateAbbr,
            'inscricao_estadual' => $this->faker->unique()->numerify('##########'),
            'area_total' => $this->faker->randomFloat(2, 50, 1000),
            'produtor_id' => Produtor::factory(),
        ];
    }
}

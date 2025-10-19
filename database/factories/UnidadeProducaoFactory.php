<?php

namespace Database\Factories;

use App\Models\UnidadeProducao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnidadeProducao>
 */
class UnidadeProducaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_cultura' => $this->faker->randomElement(UnidadeProducao::CULTURAS),
            'area_total_ha' => $this->faker->randomFloat(2, 5, 100),
            'coordenadas_geograficas' => $this->faker->latitude() . ', ' . $this->faker->longitude(),
        ];
    }
}

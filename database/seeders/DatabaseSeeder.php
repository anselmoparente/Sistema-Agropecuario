<?php

namespace Database\Seeders;

use App\Models\Produtor;
use App\Models\Propriedade;
use App\Models\Rebanho;
use App\Models\UnidadeProducao;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        Produtor::factory(10)->create()->each(function ($produtor) {
            Propriedade::factory(rand(1, 3))->create([
                'produtor_id' => $produtor->id,
            ])->each(function ($propriedade) {
                if (rand(0, 1)) {
                    Rebanho::factory(rand(1, 2))->create([
                        'propriedade_id' => $propriedade->id,
                    ]);
                }

                if (rand(0, 1)) {
                    UnidadeProducao::factory(rand(1, 4))->create([
                        'propriedade_id' => $propriedade->id,
                    ]);
                }
            });
        });
    }
}

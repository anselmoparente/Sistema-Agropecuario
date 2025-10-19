<?php

namespace App\Http\Controllers;

use App\Models\Propriedade;
use App\Models\Rebanho;
use App\Models\UnidadeProducao;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RelatorioController extends Controller
{
    public function index()
    {
        $propriedadesPorMunicipio = Propriedade::query()
            ->select('municipio', DB::raw('count(*) as total'))
            ->groupBy('municipio')
            ->orderBy('municipio')
            ->get();

        $animaisPorEspecie = Rebanho::query()
            ->select('especie', DB::raw('sum(quantidade) as total'))
            ->groupBy('especie')
            ->orderBy('especie')
            ->get();

        $hectaresPorCultura = UnidadeProducao::query()
            ->select('nome_cultura', DB::raw('sum(area_total_ha) as total'))
            ->groupBy('nome_cultura')
            ->orderBy('nome_cultura')
            ->get();

        return Inertia::render('Relatorios/Relatorios', [
            'propriedadesPorMunicipio' => $propriedadesPorMunicipio,
            'animaisPorEspecie' => $animaisPorEspecie,
            'hectaresPorCultura' => $hectaresPorCultura,
        ]);
    }
}

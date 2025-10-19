<?php

namespace App\Http\Controllers;

use App\Models\Produtor;
use App\Models\Propriedade;
use App\Models\Rebanho;
use App\Models\UnidadeProducao;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $propriedadesPorMunicipio = Propriedade::query()
            ->select('municipio', DB::raw('count(*) as total'))
            ->groupBy('municipio')
            ->orderBy('total', 'desc')->limit(10)->get();

        $animaisPorEspecie = Rebanho::query()
            ->select('especie', DB::raw('sum(quantidade) as total'))
            ->where('quantidade', '>', 0)
            ->groupBy('especie')
            ->orderBy('total', 'desc')->get();

        $hectaresPorCultura = UnidadeProducao::query()
            ->select('nome_cultura', DB::raw('sum(area_total_ha) as total'))
            ->where('area_total_ha', '>', 0)
            ->groupBy('nome_cultura')
            ->orderBy('total', 'desc')->get();

        $totalProdutores = Produtor::count();
        $totalPropriedades = Propriedade::count();
        $totalAnimais = Rebanho::sum('quantidade');
        $totalHectares = UnidadeProducao::sum('area_total_ha');

        $ultimosProdutores = Produtor::latest('created_at')->take(5)->get();
        $ultimasPropriedades = Propriedade::with('produtor:id,nome')->latest('created_at')->take(5)->get();

        return Inertia::render('Home/Home', [
            'propriedadesPorMunicipio' => $propriedadesPorMunicipio,
            'animaisPorEspecie' => $animaisPorEspecie,
            'hectaresPorCultura' => $hectaresPorCultura,
            'totalProdutores' => $totalProdutores,
            'totalPropriedades' => $totalPropriedades,
            'totalAnimais' => (int) $totalAnimais,
            'totalHectares' => (float) $totalHectares,
            'ultimosProdutores' => $ultimosProdutores,
            'ultimasPropriedades' => $ultimasPropriedades,
        ]);
    }
}

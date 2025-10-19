<?php

namespace App\Http\Controllers;

use App\Models\Produtor;
use App\Models\Propriedade;
use App\Models\Rebanho;
use App\Models\UnidadeProducao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\SimpleExcel\SimpleExcelWriter;

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

    public function exportarPropriedadesExcel()
    {
        $filePath = storage_path('app/relatorio-propriedades.xlsx');

        $writer = SimpleExcelWriter::create($filePath)
            ->addHeader([
                'Nome da Propriedade',
                'Produtor',
                'Município',
                'UF',
                'Inscrição Estadual',
                'Área Total (ha)',
            ]);

        Propriedade::with('produtor:id,nome')->chunk(200, function ($propriedades) use ($writer) {
            foreach ($propriedades as $propriedade) {
                $writer->addRow([
                    'nome' => $propriedade->nome,
                    'produtor' => $propriedade->produtor->nome ?? 'N/A',
                    'municipio' => $propriedade->municipio,
                    'uf' => $propriedade->uf,
                    'inscricao_estadual' => $propriedade->inscricao_estadual,
                    'area_total' => $propriedade->area_total,
                ]);
            }
        });

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportarRebanhosPdf()
    {
        $produtores = Produtor::query()
            ->whereHas('rebanhos')
            ->with('rebanhos.propriedade')
            ->orderBy('nome')
            ->get();

        $pdf = Pdf::loadView('relatorios.rebanhos_por_produtor', compact('produtores'));

        return $pdf->download("relatorio-geral-rebanhos.pdf");
    }
}

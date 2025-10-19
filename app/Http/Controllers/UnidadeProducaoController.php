<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnidadeProducaoRequest;
use App\Http\Requests\UpdateUnidadeProducaoRequest;
use App\Models\Produtor;
use App\Models\Propriedade;
use App\Models\UnidadeProducao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UnidadeProducaoController extends Controller
{
    public function index(Request $request)
    {
        $ups = UnidadeProducao::query()
            ->with('propriedade.produtor')
            ->when(
                $request->string('cultura')->toString(),
                fn($query, $cultura) => $query->where('nome_cultura', $cultura)
            )
            ->when(
                $request->integer('propriedade_id'),
                fn($query, $propriedadeId) => $query->where('propriedade_id', $propriedadeId)
            )
            ->when(
                $request->integer('produtor_id'),
                fn($query, $produtorId) => $query->whereHas('propriedade', fn($q) => $q->where('produtor_id', $produtorId))
            )
            ->orderBy('nome_cultura')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return Inertia::render('UnidadesProducao/Index', [
            'ups' => $ups,
            'filters' => $request->only(['cultura', 'propriedade_id', 'produtor_id']),
            'culturas' => UnidadeProducao::CULTURAS,
            'propriedades' => Propriedade::orderBy('nome')->get(['id', 'nome']),
            'produtores' => Produtor::orderBy('nome')->get(['id', 'nome']),
        ]);
    }

    public function create()
    {
        return Inertia::render('UnidadesProducao/Create', [
            'propriedades' => Propriedade::orderBy('nome')->get(['id', 'nome']),
            'culturas' => UnidadeProducao::CULTURAS,
        ]);
    }

    public function store(StoreUnidadeProducaoRequest $request)
    {
        $up = UnidadeProducao::create($request->validated());

        return Redirect::route('unidades-producao.show', $up)->with('success', 'Unidade de Produção criada.');
    }

    public function show(UnidadeProducao $up)
    {
        $up->load('propriedade.produtor');

        return Inertia::render('UnidadesProducao/Show', ['up' => $up]);
    }

    public function edit(UnidadeProducao $up)
    {
        return Inertia::render('UnidadesProducao/Edit', [
            'up' => $up,
            'culturas' => UnidadeProducao::CULTURAS,
        ]);
    }

    public function update(UpdateUnidadeProducaoRequest $request, UnidadeProducao $up)
    {
        $up->update($request->validated());

        return Redirect::route('unidades-producao.show', $up)->with('success', 'Unidade de Produção atualizada.');
    }

    public function destroy(UnidadeProducao $up)
    {
        $up->delete();

        return Redirect::route('unidades-producao.index')->with('success', 'Unidade de Produção removida.');
    }
}

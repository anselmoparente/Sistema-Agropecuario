<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnidadeProducaoRequest;
use App\Http\Requests\UpdateUnidadeProducaoRequest;
use App\Models\Propriedade;
use App\Models\UnidadeProducao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UnidadeProducaoController extends Controller
{
    public function index(Request $request)
    {
        $cultura = $request->string('cultura')->toString();

        $ups = UnidadeProducao::query()
            ->when($cultura, fn($q) => $q->daCultura($cultura))
            ->with('propriedade.produtor')
            ->orderBy('nome_cultura')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return Inertia::render('UnidadesProducao/Index', [
            'ups' => $ups,
            'cultura' => $cultura
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

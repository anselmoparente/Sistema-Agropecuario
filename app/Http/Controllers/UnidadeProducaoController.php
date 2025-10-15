<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnidadeProducaoRequest;
use App\Http\Requests\UpdateUnidadeProducaoRequest;
use App\Models\Propriedade;
use App\Models\UnidadeProducao;
use Illuminate\Http\Request;

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

        return view('unidades-producao.index', compact('ups', 'cultura'));
    }

    public function create()
    {
        $propriedades = Propriedade::orderBy('nome')->get(['id', 'nome']);
        $culturas = UnidadeProducao::CULTURAS;

        return view('unidades-producao.create', compact('propriedades', 'culturas'));
    }

    public function store(StoreUnidadeProducaoRequest $request)
    {
        $up = UnidadeProducao::create($request->validated());

        return redirect()->route('unidades-producao.show', $up)->with('success', 'Unidade de Produção criada.');
    }

    public function show(UnidadeProducao $up)
    {
        $up->load('propriedade.produtor');

        return view('unidades-producao.show', ['up' => $up]);
    }

    public function edit(UnidadeProducao $up)
    {
        $culturas = UnidadeProducao::CULTURAS;

        return view('unidades-producao.edit', ['up' => $up, 'culturas' => $culturas]);
    }

    public function update(UpdateUnidadeProducaoRequest $request, UnidadeProducao $up)
    {
        $up->update($request->validated());

        return redirect()->route('unidades-producao.show', $up)->with('success', 'Unidade de Produção atualizada.');
    }

    public function destroy(UnidadeProducao $up)
    {
        $up->delete();

        return redirect()->route('unidades-producao.index')->with('success', 'Unidade de Produção removida.');
    }
}

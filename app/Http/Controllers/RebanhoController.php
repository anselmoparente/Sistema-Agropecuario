<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRebanhoRequest;
use App\Http\Requests\UpdateRebanhoRequest;
use App\Models\Produtor;
use App\Models\Propriedade;
use App\Models\Rebanho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RebanhoController extends Controller
{
    public function index(Request $request)
    {
        $rebanhos = Rebanho::query()
            ->with('propriedade.produtor')
            ->when(
                $request->string('especie')->toString(),
                fn($query, $especie) => $query->where('especie', $especie)
            )
            ->when(
                $request->integer('propriedade_id'),
                fn($query, $propriedadeId) => $query->where('propriedade_id', $propriedadeId)
            )
            ->when(
                $request->integer('produtor_id'),
                fn($query, $produtorId) => $query->whereHas('propriedade', fn($q) => $q->where('produtor_id', $produtorId))
            )
            ->orderBy('especie')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return Inertia::render('Rebanhos/Index', [
            'rebanhos' => $rebanhos,
            'filters' => $request->only(['especie', 'propriedade_id', 'produtor_id']),
            'especies' => Rebanho::ESPECIES,
            'propriedades' => Propriedade::orderBy('nome')->get(['id', 'nome']),
            'produtores' => Produtor::orderBy('nome')->get(['id', 'nome']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Rebanhos/Create', [
            'propriedades' => Propriedade::orderBy('nome')->get(['id', 'nome']),
            'especies' => Rebanho::ESPECIES,
        ]);
    }

    public function store(StoreRebanhoRequest $request)
    {
        $rebanho = Rebanho::create($request->validated());

        return Redirect::route('rebanhos.show', $rebanho)->with('success', 'Rebanho criado.');
    }

    public function show(Rebanho $rebanho)
    {
        $rebanho->load('propriedade.produtor');

        return Inertia::render('Rebanhos/Show', ['rebanho' => $rebanho]);
    }

    public function edit(Rebanho $rebanho)
    {
        return Inertia::render('Rebanhos/Edit', [
            'rebanho' => $rebanho,
            'especies' => Rebanho::ESPECIES,
        ]);
    }

    public function update(UpdateRebanhoRequest $request, Rebanho $rebanho)
    {
        $rebanho->update($request->validated());

        return Redirect::route('rebanhos.show', $rebanho)->with('success', 'Rebanho atualizado.');
    }

    public function destroy(Rebanho $rebanho)
    {
        $rebanho->delete();

        return Redirect::route('rebanhos.index')->with('success', 'Rebanho removido.');
    }
}

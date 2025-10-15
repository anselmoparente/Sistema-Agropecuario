<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRebanhoRequest;
use App\Http\Requests\UpdateRebanhoRequest;
use App\Models\Propriedade;
use App\Models\Rebanho;
use Illuminate\Http\Request;

class RebanhoController extends Controller
{
    public function index(Request $request)
    {
        $especie = $request->string('especie')->toString();

        $rebanhos = Rebanho::query()
            ->when($especie, fn($q) => $q->daEspecie($especie))
            ->with('propriedade.produtor')
            ->orderBy('especie')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return view('rebanhos.index', compact('rebanhos', 'especie'));
    }

    public function create()
    {
        $propriedades = Propriedade::orderBy('nome')->get(['id', 'nome']);
        $especies = Rebanho::ESPECIES;

        return view('rebanhos.create', compact('propriedades', 'especies'));
    }

    public function store(StoreRebanhoRequest $request)
    {
        $rebanho = Rebanho::create($request->validated());

        return redirect()->route('rebanhos.show', $rebanho)->with('success', 'Rebanho criado.');
    }

    public function show(Rebanho $rebanho)
    {
        $rebanho->load('propriedade.produtor');

        return view('rebanhos.show', compact('rebanho'));
    }

    public function edit(Rebanho $rebanho)
    {
        $especies = Rebanho::ESPECIES;

        return view('rebanhos.edit', compact('rebanho', 'propriedades', 'especies'));
    }

    public function update(UpdateRebanhoRequest $request, Rebanho $rebanho)
    {
        $rebanho->update($request->validated());

        return redirect()->route('rebanhos.show', $rebanho)->with('success', 'Rebanho atualizado.');
    }

    public function destroy(Rebanho $rebanho)
    {
        $rebanho->delete();

        return redirect()->route('rebanhos.index')->with('success', 'Rebanho removido.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutorRequest;
use App\Http\Requests\UpdateProdutorRequest;
use App\Models\Produtor;
use Illuminate\Http\Request;

class ProdutorController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();

        $produtores = Produtor::query()
            ->when(
                $q,
                fn($query) =>
                $query->where(function ($w) use ($q) {
                    $w->where('nome', 'ilike', "%{$q}%")
                        ->orWhere('cpf_cnpj', 'ilike', "%{$q}%")
                        ->orWhere('email', 'ilike', "%{$q}%");
                })
            )
            ->withCount(['propriedades', 'rebanhos'])
            ->orderBy('nome')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return view('produtores.index', compact('produtores', 'q'));
    }

    public function create()
    {
        return view('produtores.create');
    }

    public function store(StoreProdutorRequest $request)
    {
        $produtor = Produtor::create($request->validated());

        return redirect()->route('produtores.show', $produtor)->with('success', 'Produtor criado com sucesso.');
    }

    public function show(Produtor $produtor)
    {
        $produtor->load(['propriedades', 'rebanhos', 'unidadesProducao']);

        return view('produtores.show', compact('produtor'));
    }

    public function edit(Produtor $produtor)
    {
        return view('produtores.edit', compact('produtor'));
    }

    public function update(UpdateProdutorRequest $request, Produtor $produtor)
    {
        $produtor->update($request->validated());

        return redirect()->route('produtores.show', $produtor)->with('success', 'Produtor atualizado.');
    }

    public function destroy(Produtor $produtor)
    {
        if ($produtor->propriedades()->exists()) {
            return back()->withErrors('Não é possível excluir: produtor possui propriedades vinculadas.');
        }

        $produtor->delete();

        return redirect()->route('produtores.index')->with('success', 'Produtor removido.');
    }
}

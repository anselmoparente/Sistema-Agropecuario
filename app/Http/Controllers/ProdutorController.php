<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutorRequest;
use App\Http\Requests\UpdateProdutorRequest;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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
            ->withCount(['propriedades', 'rebanhos', 'unidadesProducao'])
            ->orderBy('nome')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return Inertia::render('Produtores/Index', [
            'produtores' => $produtores,
            'filters' => ['q' => $q]
        ]);
    }

    public function create()
    {
        return Inertia::render('Produtores/Create');
    }

    public function store(StoreProdutorRequest $request)
    {
        Produtor::create($request->validated());

        return Redirect::route('produtores.index')->with('success', 'Produtor criado com sucesso.');
    }

    public function show(Produtor $produtore)
    {
        $produtore->load(['propriedades', 'rebanhos', 'unidadesProducao']);

        return Inertia::render('Produtores/Show', ['produtor' => $produtore]);
    }

    public function edit($id)
    {
        $produtor = Produtor::findOrFail($id);

        return Inertia::render('Produtores/Edit', ['produtor' => $produtor]);
    }

    public function update(UpdateProdutorRequest $request, Produtor $produtore)
    {
        $produtore->update($request->validated());

        return Redirect::route('produtores.show', $produtore)->with('success', 'Produtor atualizado.');
    }

    public function destroy(Produtor $produtore)
    {
        if ($produtore->propriedades()->exists()) {
            return back()->withErrors('Não é possível excluir: produtor possui propriedades vinculadas.');
        }

        $produtore->delete();

        return Redirect::route('produtores.index')->with('success', 'Produtor removido.');
    }
}

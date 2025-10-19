<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropriedadeRequest;
use App\Http\Requests\UpdatePropriedadeRequest;
use App\Models\Produtor;
use App\Models\Propriedade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PropriedadeController extends Controller
{
    public function index(Request $request)
    {
        $propriedades = Propriedade::query()
            ->with('produtor')
            ->when(
                $request->string('q')->toString(),
                fn($query, $q) =>
                $query->where(function ($w) use ($q) {
                    $w->where('nome', 'ilike', "%{$q}%")
                        ->orWhereHas('produtor', fn($pq) => $pq->where('nome', 'ilike', "%{$q}%"));
                })
            )
            ->when(
                $request->integer('produtor_id'),
                fn($query, $produtorId) => $query->where('produtor_id', $produtorId)
            )
            ->when(
                $request->string('municipio')->toString(),
                fn($query, $municipio) => $query->where('municipio', $municipio)
            )
            ->orderBy('nome')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return Inertia::render('Propriedades/Index', [
            'propriedades' => $propriedades,
            'filters' => $request->only(['q', 'produtor_id', 'municipio']),
            'produtores' => Produtor::orderBy('nome')->get(['id', 'nome']),
            'municipios' => Propriedade::query()->select('municipio')->distinct()->orderBy('municipio')->pluck('municipio'),
        ]);
    }

    public function create()
    {
        $produtores = Produtor::orderBy('nome')->get(['id', 'nome']);

        return Inertia::render('Propriedades/Create', ['produtores' => $produtores]);
    }

    public function store(StorePropriedadeRequest $request)
    {
        $propriedade = Propriedade::create($request->validated());

        return Redirect::route('propriedades.show', $propriedade)->with('success', 'Propriedade criada.');
    }

    public function show(Propriedade $propriedade)
    {
        $propriedade->load(['produtor', 'unidadesProducao', 'rebanhos']);

        return Inertia::render('Propriedades/Show', ['propriedade' => $propriedade]);
    }

    public function edit(Propriedade $propriedade)
    {
        return Inertia::render('Propriedades/Edit', ['propriedade' => $propriedade]);
    }

    public function update(UpdatePropriedadeRequest $request, Propriedade $propriedade)
    {
        $propriedade->update($request->validated());

        return Redirect::route('propriedades.show', $propriedade)->with('success', 'Propriedade atualizada com sucesso.');
    }

    public function destroy(Propriedade $propriedade)
    {
        if ($propriedade->unidadesProducao()->exists() || $propriedade->rebanhos()->exists()) {
            return back()->withErrors(['geral' => 'Não é possível excluir: há unidades de produção ou rebanhos vinculados.']);
        }

        $propriedade->delete();

        return Redirect::route('propriedades.index')->with('success', 'Propriedade removida com sucesso.');
    }
}

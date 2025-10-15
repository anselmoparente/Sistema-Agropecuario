<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropriedadeRequest;
use App\Http\Requests\UpdatePropriedadeRequest;
use App\Models\Produtor;
use App\Models\Propriedade;
use Illuminate\Http\Request;

class PropriedadeController extends Controller
{
    public function index(Request $request)
    {
        $uf = $request->string('uf')->toString();
        $municipio = $request->string('municipio')->toString();
        $q = $request->string('q')->toString();

        $propriedades = Propriedade::query()
            ->when(
                $q,
                fn($query) =>
                $query->where(function ($w) use ($q) {
                    $w->where('nome', 'ilike', "%{$q}%")
                        ->orWhere('inscricao_estadual', 'ilike', "%{$q}%");
                })
            )
            ->daLocalidade($uf ?: null, $municipio ?: null)
            ->with(['produtor'])
            ->withCount(['unidadesProducao', 'rebanhos'])
            ->orderBy('nome')->orderBy('id')
            ->paginate(min(max((int) $request->get('per_page', 15), 1), 100))
            ->withQueryString();

        return view('propriedades.index', compact('propriedades', 'uf', 'municipio', 'q'));
    }

    public function create()
    {
        $produtores = Produtor::orderBy('nome')->get(['id', 'nome']);

        return view('propriedades.create', compact('produtores'));
    }

    public function store(StorePropriedadeRequest $request)
    {
        $prop = Propriedade::create($request->validated());

        return redirect()->route('propriedades.show', $prop)->with('success', 'Propriedade criada.');
    }

    public function show(Propriedade $propriedade)
    {
        $propriedade->load(['produtor', 'unidadesProducao', 'rebanhos']);

        return view('propriedades.show', compact('propriedade'));
    }

    public function edit(Propriedade $propriedade)
    {
        return view('propriedades.edit', compact('propriedade'));
    }

    public function update(UpdatePropriedadeRequest $request, Propriedade $propriedade)
    {
        $propriedade->update($request->validated());

        return redirect()->route('propriedades.show', $propriedade)->with('success', 'Propriedade atualizada.');
    }

    public function destroy(Propriedade $propriedade)
    {
        if ($propriedade->unidadesProducao()->exists() || $propriedade->rebanhos()->exists()) {
            return back()->withErrors(['geral' => 'Não é possível excluir: há unidades de produção ou rebanhos vinculados.']);
        }

        $propriedade->delete();

        return redirect()->route('propriedades.index')->with('success', 'Propriedade removida.');
    }
}

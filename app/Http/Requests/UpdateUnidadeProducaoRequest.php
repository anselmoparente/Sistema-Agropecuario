<?php

namespace App\Http\Requests;

use App\Models\UnidadeProducao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnidadeProducaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_cultura' => ['sometimes', 'required', 'string', 'max:255', Rule::in(UnidadeProducao::CULTURAS)],
            'area_total_ha' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'coordenadas_geograficas' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}

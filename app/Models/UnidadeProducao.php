<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnidadeProducao extends Model
{
    use HasFactory;

    protected $table = 'unidades_producao';

    protected $fillable = [
        'nome_cultura',
        'area_total_ha',
        'coordenadas_geograficas',
        'propriedade_id',
    ];

    protected $casts = [
        'area_total_ha' => 'decimal:2',
    ];

    public const CULTURAS = [
        'Laranja Pera',
        'Melancia Crimson Sweet',
        'Goiaba Paluma',
    ];

    public function propriedade(): BelongsTo
    {
        return $this->belongsTo(Propriedade::class);
    }

    public function scopeDaCultura($query, string $nomeCultura)
    {
        return $query->where('nome_cultura', 'ILIKE', "%{$nomeCultura}%");
    }
}

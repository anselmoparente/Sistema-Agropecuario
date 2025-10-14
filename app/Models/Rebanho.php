<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rebanho extends Model
{
    use HasFactory;

    protected $table = 'rebanhos';

    protected $fillable = [
        'especie',
        'quantidade',
        'finalidade',
        'data_atualizacao',
        'propriedade_id',
    ];

    protected $casts = [
        'quantidade'       => 'integer',
        'data_atualizacao' => 'date',
    ];

    public const ESPECIES = [
        'Suínos',
        'Caprinos',
        'Bovinos',
    ];

    public function propriedade(): BelongsTo
    {
        return $this->belongsTo(Propriedade::class);
    }

    public function scopeDaEspecie($query, string $especie)
    {
        return $query->where('especie', 'ILIKE', "%{$especie}%");
    }
}

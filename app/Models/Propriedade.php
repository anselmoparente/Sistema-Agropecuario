<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Propriedade extends Model
{
    use HasFactory;

    protected $table = 'propriedades';

    protected $fillable = [
        'nome',
        'municipio',
        'uf',
        'inscricao_estadual',
        'area_total',
        'produtor_id',
    ];

    protected $casts = [
        'area_total' => 'decimal:2',
    ];

    public function produtor(): BelongsTo
    {
        return $this->belongsTo(Produtor::class);
    }

    public function unidadesProducao(): HasMany
    {
        return $this->hasMany(UnidadeProducao::class);
    }

    public function rebanhos(): HasMany
    {
        return $this->hasMany(Rebanho::class);
    }

    public function scopeDaLocalidade($query, ?string $uf = null, ?string $municipio = null)
    {
        return $query
            ->when($uf, fn($q) => $q->where('uf', mb_strtoupper($uf)))
            ->when($municipio, fn($q) => $q->where('municipio', $municipio));
    }
}

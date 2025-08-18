<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Peca extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pecas';

    protected $fillable = [
        'descricao',
        'codigo',
        'quantidade',
        'unidade',
        'preco',
        'ativo',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    public function ordensServico()
    {
        return $this->belongsToMany(OrdemServico::class, 'ordem_servico_peca')
            ->withPivot(['quantidade', 'valor_unitario', 'valor_total'])
            ->withTimestamps();
    }
}

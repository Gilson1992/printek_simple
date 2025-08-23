<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Servico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicos';

    protected $fillable = [
        'descricao',
        'codigo',
        'contador',
        'preco',
    ];

    public function ordensServico()
    {
        return $this->belongsToMany(OrdemServico::class, 'ordem_servico_servico')
            ->withPivot(['quantidade', 'valor_unitario', 'valor_total'])
            ->withTimestamps();
    }
}

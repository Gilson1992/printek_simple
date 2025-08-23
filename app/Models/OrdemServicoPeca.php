<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class OrdemServicoPeca extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ordem_servico_peca';

    protected $fillable = [
        'ordem_servico_id',
        'peca_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
    ];

    public function ordemServico()
    {
        return $this->belongsTo(OrdemServico::class);
    }

    public function peca()
    {
        return $this->belongsTo(Peca::class);
    }
}

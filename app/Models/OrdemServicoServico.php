<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class OrdemServicoServico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ordem_servico_servico';

    protected $fillable = [
        'ordem_servico_id',
        'servico_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
    ];

    public function ordemServico()
    {
        return $this->belongsTo(OrdemServico::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class OrdemServico extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'equipamento_id',
        'tecnico_id',
        'data_abertura',
        'data_prevista',
        'data_fechamento',
        'defeito_declarado',
        'defeito_encontrado',
        'solucao',
        'observacao_recebimento',
        'observacao_servico',
        'observacao_tecnica',
        'status',
    ];

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }
}

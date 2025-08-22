<?php

namespace App\Models;

use App\Enums\StatusOs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class OrdemServico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ordens_servico';

    protected $fillable = [
        'equipamento_id',
        'tecnico_id',
        'data_entrada',
        'data_prevista',
        'data_conclusao',
        'defeito_declarado',
        'defeito_encontrado',
        'solucao',
        'observacao_recebimento',
        'observacao_servico',
        'observacao_tecnico',
        'contador',
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

    public function pecas()
    {
        return $this->belongsToMany(Peca::class, 'ordem_servico_peca')
            ->withPivot(['quantidade', 'valor_unitario', 'valor_total'])
            ->withTimestamps();
    }

    public function servicos()
    {
        return $this->belongsToMany(Servico::class, 'ordem_servico_servico')
            ->withPivot(['quantidade', 'valor_unitario', 'valor_total'])
            ->withTimestamps();
    }
}

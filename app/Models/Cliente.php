<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'cnpj',
        'contato',
        'email',
        'endereco',
        'observacao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $attributes = [
        'ativo' => true,
    ];

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}

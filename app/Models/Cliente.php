<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

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
    ];

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }
}

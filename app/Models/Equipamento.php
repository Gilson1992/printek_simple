<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Equipamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipamentos';

    protected $fillable = [
        'tipo',
        'tipo_posse',
        'marca',
        'modelo',
        'serial',
        'contador',
        'observacao',
    ];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_equipamento')
                    ->withTimestamps();
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}

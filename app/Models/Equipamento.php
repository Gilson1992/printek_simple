<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Equipamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'tipo',
        'tipo_posse',
        'marca',
        'modelo',
        'serial',
        'contador',
        'observacao',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}

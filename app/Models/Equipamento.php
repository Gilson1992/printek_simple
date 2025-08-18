<?php

namespace App\Models;

use App\Enums\{Tipo, TipoPosse};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Equipamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipamentos';

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

    protected $casts = [
        'contador'    => 'integer',
        'tipo'        => Tipo::class,
        'tipo_posse'  => TipoPosse::class,
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}

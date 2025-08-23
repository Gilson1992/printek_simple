<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class ClienteEquipamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cliente_equipamento';

    protected $fillable = [
        'cliente_id',
        'equipamento_id',
    ];

    public $timestamps = true;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}

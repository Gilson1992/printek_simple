<?php

namespace App\Models;

use App\Enums\Disponibilidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Tecnico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tecnicos';

    protected $fillable = [
        'matricula',
        'nome',
        'contato',
        'disponibilidade',
    ];

    protected $casts = [
        'disponibilidade' => Disponibilidade::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}

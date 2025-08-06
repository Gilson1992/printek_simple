<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tecnico extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome', 'cnpj', 'contato', 'email', 'endereco', 'observacao', 'ativo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}
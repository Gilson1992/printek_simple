<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tecnico extends Model
{
    // ...
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}
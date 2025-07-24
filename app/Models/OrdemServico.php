<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    // ...
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }
}
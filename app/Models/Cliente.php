<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // ...
    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}
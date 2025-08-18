<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Servico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = ['servicos'];

    protected $fillable = [
        
    ];
}

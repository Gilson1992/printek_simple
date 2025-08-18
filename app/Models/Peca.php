<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class Peca extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = ['pecas'];

    protected $fillable = [
        
    ];
}

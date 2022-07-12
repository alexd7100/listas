<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'articulos_id',
        'url',
        'name',
        'state'
    ];
}

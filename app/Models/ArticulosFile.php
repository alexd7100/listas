<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticulosFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'articulos_id',
        'url',
        'nombre',
        'estado'
    ];
}

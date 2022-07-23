<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListasFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'listas_id',
        'url',
        'name',
        'state'
    ];
}

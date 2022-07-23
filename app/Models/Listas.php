<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listas extends Model
{
    use HasFactory;

    protected $fillable = [
        'listas_code',
        'title',
        'reference',
        'state'
    ];
}

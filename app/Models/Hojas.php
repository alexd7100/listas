<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hojas extends Model
{
    use HasFactory;

    protected $fillable = [
        'hojas_code',
        'title',
        'reference',
        'state'
    ];
}

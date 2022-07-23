<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HojasFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'hojas_id',
        'url',
        'name',
        'state'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'type',
        'couleur',
        'image',
        'date_de_publier',
        'prix',
    ];
}

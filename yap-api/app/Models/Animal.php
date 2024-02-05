<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_animal',
        'type_animal',
        'couleur_animal',
        'image_animal',
        'date_de_naissance_animal',
        'prix_animal',
    ];
    public function Catalogues_animals()
    {
        return $this->belongsTo(Catalogues_animals::class, 'animal_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $fillable = [
        'durée__catalogue',
        'image_catalogue',
        'nom_catalogue',
    ];
    public function Catalogues_animals()
    {
        return $this->belongsTo(Catalogues_animals::class, 'catalogue_id', 'id');
    }
}

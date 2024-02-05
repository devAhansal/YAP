<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogues_animals extends Model
{
    use HasFactory;
    protected $fillable = [
        'animal_id',
        'catalogue_id',
    ];
    public function animals()
    {
        return $this->hasMany(Animal::class, "animal_id", "id");
    }
    public function catalogues()
    {
        return $this->hasMany(Catalogue::class, "catalogue_id", "id");
    }
}

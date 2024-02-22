<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'NumCommande',
        'status',
        'user_id'
    ];
    public function paniers()
    {
        return $this->hasMany(Panier::class,'car_id','id');
    }
    
}

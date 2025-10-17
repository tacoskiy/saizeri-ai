<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [
        'name',
        'number',
        'price',
        'image_path',
        'description',
        'sweetness',
        'sourness',
        'saltiness',
        'bitterness',
        'umami',
        'spiciness',
        'astringency',
    ];
    
    public function allergens()
    {
        return $this->belongsToMany(Allergen::class);
    }
}

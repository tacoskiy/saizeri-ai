<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    //
    protected $fillable = [
        'name',
    ];
    
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
}

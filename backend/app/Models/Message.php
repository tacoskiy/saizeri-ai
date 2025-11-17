<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [
        'talk_session_id',
        'content',
        'speaker',
        'review',
    ];
    public function seeMenu()
    {
        return $this->belongsTo(Menu::class);
    }
}

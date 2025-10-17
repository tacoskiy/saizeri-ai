<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    //
    protected $fillable = [
        'number',
        'capacity',
    ];
    
    public function talkSessions()
    {
        return $this->hasMany(TalkSession::class);
    }
}

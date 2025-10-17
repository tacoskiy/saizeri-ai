<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalkSession extends Model
{
    //
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'table_id',
        'ip_address',
        'user_agent',
        'started_at',
        'ended_at',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

}

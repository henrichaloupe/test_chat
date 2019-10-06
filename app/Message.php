<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'message', 'created_by',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}

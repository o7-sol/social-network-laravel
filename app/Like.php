<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'like'
    ];

   /* public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }*/

     public function user()
     {
     return $this->belongsTo('App\User');
     }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}

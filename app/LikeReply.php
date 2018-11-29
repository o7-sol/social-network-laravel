<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeReply extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function reply()
    {
        return $this->belongsTo('App\Reply');
    }
}

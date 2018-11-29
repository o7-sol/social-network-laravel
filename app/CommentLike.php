<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $fillable = [ 'like' ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
    
}

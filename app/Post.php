<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body', 'public', 'friends', 'image',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function like()
    {
        return $this->hasMany('App\Like');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function scopeSearchByTag($query, $tag)
    {
        if ($tag!='') {
            $query->where(function ($query) use ($tag) {
                $query->where("post", "LIKE","%$tag%");
            });
        }
        return $query;
    }

}

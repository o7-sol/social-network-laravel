<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
	protected $fillable = ['friend_id'];

   public function user()
   {
   	return $this->belongsTo('App\User');
   }
}

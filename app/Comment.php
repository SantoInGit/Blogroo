<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

   protected $fillable = array('body', 'post_id', 'user_id');
    //Relationship with Post model. Comment belongs to a post
    public function post(){
      return $this->belongsTo('App\Post');
    }

    //Relationship with User model. Comment belongs to user
    public function user(){
      return $this->belongsTo('App\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{


    //creating a relationship betwenn Post Model and User Model.
    public function user(){
      return $this->belongsTo('App\User'); //simply means single Post belongs to a user.
    }

    //createing a relationship between Post Model and Comment Model.
    public function comments(){
      return $this->hasMany('App\Comment');
    }

    //creating a relationship between Post Model and Like Model
    public function likes(){
      return $this->hasMany('App\Like');
    }
}

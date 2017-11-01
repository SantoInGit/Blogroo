<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    public function post(){
        return $this->belongsTo('App\Post');
    }

    //Relationship with User model. Comment belongs to user
    public function user(){
      return $this->belongsTo('App\User');
    }
}

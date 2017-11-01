<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //creating relationship with Post model
    public function posts(){
      return $this->hasMany('App\Post'); //user has many post.
    }

    //creating relationship with Profile model
    public function profile(){
      return $this->hasOne('App\Profile');
    }

    public function followers(){
      return $this->hasMany(Follower::class);
    }
}

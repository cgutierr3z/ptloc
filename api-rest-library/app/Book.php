<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    // Rel OneToMany
    public function comments(){
        return $this->hasMany('App\Comment');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'title', 'author', 'description','image',
    ];
    
    /* Relation: ManyToOne
     *
     * Muchos libros pueden pertenecer a un usuario.
     */
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    /* Relation: ManyToOne
     *
     * Muchos comentarios pueden pertenecer a un usuario.
     */
    public function comments(){
        return $this->hasMany('App\Comment');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'comment',
    ];

    /* Relation: ManyToOne
     *
     * Muchos comentarios pueden pertenecer a un usuario.
     */
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    /* Relation: ManyToOne
     *
     * Muchos comentarios pueden pertenecer a un libro.
     */
    public function book(){
        return $this->belongsTo('App\Book', 'book_id');
    }
}

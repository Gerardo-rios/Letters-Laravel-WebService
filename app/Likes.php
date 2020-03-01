<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model 
{
    protected $table = 'modelo_likes';
    protected $primaryKey = 'like_id';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
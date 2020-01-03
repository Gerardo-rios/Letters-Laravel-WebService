<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{
    protected $table = 'modelo_post';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenido', 'descripcion', 'etiquetas'
    ];

    public $timestamps = true;

}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model 
{
    protected $table = 'modelo_comentario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenido'
    ];

    public $timestamps = true;

}

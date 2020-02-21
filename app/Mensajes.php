<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensajes extends Model 
{
    protected $table = 'modelo_mensajes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mensaje'
    ];


}
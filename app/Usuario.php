<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model 
{
    protected $table = 'modelo_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'username', 'descripcion', 'fecha_nacimiento', 'foto_perfil', 'celular', 'correo'
    ];

    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
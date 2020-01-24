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
        'nombre', 'username', 'descripcion', 'fecha_nacimiento', 'foto_perfil', 'celular', 'correo', 'status'
    ];

    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'external_id'
    ];


    /**
     * Helper methods
     */

    public function tieneFoto(): bool {
        return !is_null($this->attributes['foto_perfil']) 
        && !empty($this->attributes['foto_perfil']);
    }

    /**
     * Accessors and Mutators
     */

     public function obtenerFoto() {
        return url('profile_pictures/' . $this->attributes['foto_perfil']);
     }

}
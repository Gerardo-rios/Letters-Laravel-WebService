<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model 
{
    protected $table = 'modelo_user';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'username', 'descripcion', 'foto_perfil', 'celular', 'correo', 'status'
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
/*
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function followers()
    {
        return $this->belongsToMany(Usuario::class, 'modelo_seguidores', 'user_id', 'seguidor_id');
    }

    public function following()
    {
        return $this->belongsToMany(Usuario::class, 'modelo_seguidores', 'seguidor_id', 'user_id');
    }
*/

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
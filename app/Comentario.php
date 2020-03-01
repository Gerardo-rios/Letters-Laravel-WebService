<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model 
{
    protected $table = 'modelo_comentario';
    protected $primaryKey = 'coment_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenido'
    ];

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public $timestamps = true;

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{
    protected $table = 'modelo_post';
    protected $primaryKey = 'post_id';
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
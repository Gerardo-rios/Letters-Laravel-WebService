<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguidores extends Model 
{
    protected $table = 'modelo_seguidores';
    protected $primaryKey = 'Seg_id';

    public $timestamps = false;
}

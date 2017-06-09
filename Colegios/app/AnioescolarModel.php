<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnioescolarModel extends Model
{
    public $timestamps = false;
    
    protected $table = 'anioescolar';
    protected $primaryKey = 'idanioescolar';
    protected $fillable = [ 'anio','estado', 'institucion_idinstitucion' ];
    protected $hidden = [];
}

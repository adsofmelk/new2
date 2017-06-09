<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoModel extends Model
{
        
    public $timestamps = false;
    
    protected $table = 'periodo';
    protected $primaryKey = 'idperiodo';
    protected $fillable = [ 'nombre','inicio','fin','anioescolar_idanioescolar' ];
    protected $hidden = [];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesorModel extends Model
{
    protected $table = 'profesor';
    protected $primaryKey = 'idprofesor';
    protected $fillable = ['estado','persona_idpersona'];
    protected $hidden = [];
    public $timestamps = false;
}

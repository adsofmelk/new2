<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametrosModel extends Model
{
    protected $table = 'parametros';
    protected $primaryKey = 'idparametros';
    protected $fillable = ['key','value'];
    protected $hidden = [];
    public $timestamps = false;
}

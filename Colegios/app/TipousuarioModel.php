<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipousuarioModel extends Model
{
    protected $table = 'tipousuario';
    protected $primaryKey = 'idtipousuario';
    protected $fillable = ['nombre'];
    protected $hidden = [];
    public $timestamps = false;
}

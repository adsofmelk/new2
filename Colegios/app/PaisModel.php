<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaisModel extends Model
{
	protected $table = 'pais';
	protected $primaryKey = 'idpais';
	protected $fillable = [ 'nombre' ];
	protected $hidden = [];
}

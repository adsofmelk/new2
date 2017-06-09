<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CiudadModel extends Model
{
	public $timestamps = false;
	
	protected $table = 'ciudad';
	protected $primaryKey = 'idciudad';
	protected $fillable = [ 'nombre','departamento_iddepartamento' ];
	protected $hidden = [];
}

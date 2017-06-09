<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesorUsuarioModel extends Model
{
	protected $table = 'profesor_usuario';
	protected $primaryKey = 'idprofesor_usuario';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoModel extends Model
{
	protected $table = 'alumno';
	protected $primaryKey = 'idalumno';
	protected $fillable = ['codigo','estado','persona_idpersona'];
	protected $hidden = [];
	public $timestamps = false;
}

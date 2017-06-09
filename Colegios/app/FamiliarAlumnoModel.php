<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamiliarAlumnoModel extends Model
{
	public $timestamps = false;
	
	protected $table = 'familiar_alumno';
	protected $primaryKey = 'idfamiliar_alumno';
	protected $fillable = ['acudiente','familiar_idfamiliar','alumno_idalumno', 'tipofamiliar_idtipofamiliar' ];
	protected $hidden = [];
}

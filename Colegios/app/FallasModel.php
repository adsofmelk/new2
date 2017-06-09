<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FallasModel extends Model
{
	protected $table = 'fallas';
	protected $primaryKey = 'idfallas';
	protected $fillable = ['fecha','numerohoras','observaciones','estado','anioescolar_idanioescolar',
							'periodo_idperiodo','curso_idcurso','materia_idmateria','alumno_idalumno',
							'profesor_curso_idprofesor_curso'
							];
	protected $hidden = [];
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	public $timestamps = true;
}

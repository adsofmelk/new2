<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluacionModel extends Model
{
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	protected $table = 'evaluacion';
	protected $primaryKey = 'idevaluacion';
	protected $fillable = ['fechaevaluacion','porcentaje',
			'detalle','estado','tipoestandar_idtipoestandar','curso_idcurso',
			'periodo_idperiodo','tipoevaluacion_idtipoevaluacion',
			'anioescolar_idanioescolar','materia_idmateria','profesor_idprofesor'
	];
	protected $hidden = [];
	public $timestamps = true;
}

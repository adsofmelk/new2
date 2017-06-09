<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EvaluacionDetalleModel extends Model
{
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	protected $table = 'evaluaciondetalle';
	protected $primaryKey = 'idevaluaciondetalle';
	protected $fillable = ['nota','letra','observaciones', 
			'estado','evaluacion_idevaluacion','alumno_idalumno'
	];
	protected $hidden = [];
	public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewEvaluacionEstandarTipoCurMatModel extends Model
{
	protected $table = 'view_evaluacionestandartipocurmat';
	protected $primaryKey = 'idevaluacion';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}

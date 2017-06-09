<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEvaluacionModel extends Model
{
	protected $table = 'tipoevaluacion';
	protected $primaryKey = 'idtipoevaluacion';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}

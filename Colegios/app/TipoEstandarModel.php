<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEstandarModel extends Model
{
	protected $table = 'tipoestandar';
	protected $primaryKey = 'idtipoestandar';
	protected $fillable = ['nombre'];
	protected $hidden = [];
	public $timestamps = false;
}

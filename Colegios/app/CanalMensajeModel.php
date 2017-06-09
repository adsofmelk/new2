<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanalMensajeModel extends Model
{
	//protected $dates = ['deleted_at'];
	protected $table = 'canalmensaje';
	protected $primaryKey = 'idcanalmensaje';
	protected $fillable = ['nombre','parametros','estado'];
	protected $hidden = [];
	//public $timestamps = true;
}

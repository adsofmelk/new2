<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoMensajeModel extends Model
{
	//protected $dates = ['deleted_at'];
	protected $table = 'tipomensaje';
	protected $primaryKey = 'idtipomensaje';
	protected $fillable = ['nombre','class'];
	protected $hidden = [];
	//public $timestamps = true;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeCanalmensajeModel extends Model
{
	
	
	//protected $dates = ['deleted_at'];
	protected $table = 'mensaje_canalmensaje';
	protected $primaryKey = 'idmensaje_canalmensaje';
	protected $fillable = [
			'mensaje_idmensaje',
			'canalmensaje_idcanalmensaje',
                        'estado',
	];
	protected $hidden = [];
	public $timestamps = false;
}

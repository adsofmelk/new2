<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeUsuarioModel extends Model
{
    	
	
	//protected $dates = ['deleted_at'];
	protected $table = 'mensaje_usuario';
	protected $primaryKey = 'idmensaje_usuario';
	protected $fillable = [
                            'estado','usuario_idusuario','mensaje_idmensaje'
			];
	protected $hidden = [];
	public $timestamps = false;
}

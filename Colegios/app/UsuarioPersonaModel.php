<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPersonaModel extends Model
{
	protected $table = 'usuario_persona';
	protected $primaryKey = 'idusuario_persona';
	protected $fillable = ['usuario_idusuario','persona_idpersona'];
	protected $hidden = [];
	public $timestamps = false;
	
}

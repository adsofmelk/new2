<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioTipousuarioModel extends Model
{
	
	protected $table = 'usuario_tipousuario';
	protected $primaryKey = 'idusuario_tipousuario';
	protected $fillable = ['usuario_idusuario','tipousuario_idtipousuario'];
	protected $hidden = [];
	public $timestamps = false;
}

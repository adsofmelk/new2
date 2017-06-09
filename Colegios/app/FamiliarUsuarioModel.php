<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamiliarUsuarioModel extends Model
{
	public $timestamps = false;
	
	protected $table = 'familiar_usuario';
	protected $primaryKey = 'idfamiliar_usuario';
	protected $fillable = ['familiar_idfamiliar','usuario_idusuario' ];
	protected $hidden = [];
}

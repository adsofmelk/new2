<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MensajeModel extends Model
{
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	protected $table = 'mensaje';
	protected $primaryKey = 'idmensaje';
	protected $fillable = [
					'asunto','mensaje',
					'fechaenvio','fechavencimiento',
					'profesores','acudientes',
					'acudientesdetalle','numerosadicionales',
                                        'emailsadicionales',
					'estado','usuario_idusuario',
					'tipomensaje_idtipomensaje',
			];
	protected $hidden = [];
	public $timestamps = true;
}

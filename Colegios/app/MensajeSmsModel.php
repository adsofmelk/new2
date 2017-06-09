<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeSmsModel extends Model
{
        //protected $dates = ['deleted_at'];
	protected $table = 'mensaje_sms';
	protected $primaryKey = 'idmensaje_sms';
	protected $fillable = [
					'fechaenvio',
                                        'telefono',
                                        'MessageId',
                                        'statusCode',
					'estado',
					'mensaje_idmensaje',
			];
	protected $hidden = [];
	public $timestamps = false;
}

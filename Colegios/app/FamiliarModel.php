<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamiliarModel extends Model
{
	public $timestamps = false;
	
	protected $table = 'familiar';
	protected $primaryKey = 'idfamiliar';
	protected $fillable = [ 'persona_idpersona' ];
	protected $hidden = [];
}

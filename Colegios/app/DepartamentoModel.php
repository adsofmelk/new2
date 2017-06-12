<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartamentoModel extends Model
{
	protected $table = 'departamento';
	protected $primaryKey = 'iddepartamento';
	protected $fillable = [ 'pais_idpais','nombre' ];
	protected $hidden = [];
}

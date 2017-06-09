<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradoModel extends Model
{
	protected $table = 'grado';
	protected $primaryKey = 'idgrado';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}

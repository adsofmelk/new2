<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GruposanguineoModel extends Model
{
	protected $table = 'gruposanguineo';
	protected $primaryKey = 'idgruposanguineo';
	protected $fillable = ['grupo'];
	protected $hidden = [];
	public $timestamps = false;
}

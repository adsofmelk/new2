<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpsModel extends Model
{
	protected $table = 'eps';
	protected $primaryKey = 'ideps';
	protected $fillable = ['nombre'];
	protected $hidden = [];
	public $timestamps = false;
}

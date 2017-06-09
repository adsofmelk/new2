<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipofamiliarModel extends Model
{
	protected $table = 'tipofamiliar';
	protected $primaryKey = 'idtipofamiliar';
	protected $fillable = ['nombre'];
	protected $hidden = [];
	public $timestamps = false;
}

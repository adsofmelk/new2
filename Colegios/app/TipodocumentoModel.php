<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipodocumentoModel extends Model
{
	protected $table = 'tipodocumento';
	protected $primaryKey = 'idtipodocumento';
	protected $fillable = [];
	protected $hidden = [];
	public $timestamps = false;
}

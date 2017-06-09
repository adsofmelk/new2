<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoModel extends Model
{
    protected $table = 'curso';
    protected $primaryKey = 'idcurso';
    protected $fillable = ['nombre','estado','grado_idgrado','anioescolar_idanioescolar'];
    protected $hidden = [];
    public $timestamps = false;
}

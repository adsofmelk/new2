<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesorCursoModel extends Model
{
    protected $table = 'profesor_curso';
    protected $primaryKey = 'idprofesor_curso';
    protected $fillable = ['director','profesor_idprofesor','curso_idcurso','maretia_idmateria'];
    protected $hidden = [];
    public $timestamps = false;
}

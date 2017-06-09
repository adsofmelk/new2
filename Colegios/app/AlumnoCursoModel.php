<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoCursoModel extends Model
{
    protected $table = 'alumno_curso';
    protected $primaryKey = 'idalumno_curso';
    protected $fillable = ['codigolista','ordenlista','estado','alumno_idalumno','curso_idcurso'];
    protected $hidden = [];
    public $timestamps = false;
} 

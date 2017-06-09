<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InformeAlumnoDetalleModel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'informe_alumno_detalle';
    protected $primaryKey = 'idinforme_alumno_detalle';
    protected $fillable = ['nota','letra','fallas','estado','hash','materia_idmateria','curso_idcurso','periodo_idperiodo','anioescolar_idanioescolar','alumno_idalumno'];
    protected $hidden = [];
    public $timestamps = true;
}

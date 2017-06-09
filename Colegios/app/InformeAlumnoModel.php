<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformeAlumnoModel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'informe_alumno';
    protected $primaryKey = 'idinforme_alumno';
    protected $fillable = ['promedio','promediocurso','puestocurso',
                            'puestogrado','puestocolegio',
                            'estado','observaciones',
                            'anioescolar_idanioescolar','periodo_idperiodo',
                            'curso_idcurso','alumno_idalumno',
                            'profesor_idprofesor',
                            'informeacademico_idinformeacademico'
                            ];
    protected $hidden = [];
    public $timestamps = true;
}

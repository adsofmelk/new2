<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewAlumnosCursoModel extends Model
{
    protected $table = 'view_alumnoscurso';
    //protected $primaryKey = 'idalumno_curso';
    protected $fillable = [];
    protected $hidden = [];
    public $timestamps = false;
}

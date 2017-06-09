<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MateriaModel extends Model
{
    protected $table = 'materia';
    protected $primaryKey = 'idmateria';
    protected $fillable = ['nombre','horassemana','estado','area_idarea','grado_idgrado'];
    protected $hidden = [];
    public $timestamps = false;
    
    public static function getMateriasCurso($idCurso){
        return MateriaModel::select(DB::raw('materia.*, curso.idcurso, curso.nombre as nombrecurso'))
                        ->join('profesor_curso','profesor_curso.materia_idmateria','=','materia.idmateria')
                        ->join('curso','curso.idcurso','=','profesor_curso.curso_idcurso')
                        ->where('profesor_curso.curso_idcurso','=',$idCurso)->get();
    }
    
}

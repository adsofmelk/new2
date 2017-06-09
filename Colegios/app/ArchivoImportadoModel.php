<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ArchivoImportadoModel extends Model
{
    use SoftDeletes; 
    
    protected $dates = ['deleted_at'];
    protected $table = 'archivoimportado';
    protected $primaryKey = 'idarchivoimportado';
    protected $fillable = ['nombre','path','usuario_idusuario','estado', 'curso_idcurso', 'materia_idmateria','periodo_idperiodo','anioescolar_idanioescolar'];
    protected $hidden = [];
    public $timestamps = true;
    
    
    
}

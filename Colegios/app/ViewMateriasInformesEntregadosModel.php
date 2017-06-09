<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewMateriasInformesEntregadosModel extends Model
{
    protected $table = 'view_materiasinformesentregados';
    protected $primaryKey = 'materia_idmateria';
    protected $fillable = [];
    protected $hidden = [];
    public $timestamps = false;
}

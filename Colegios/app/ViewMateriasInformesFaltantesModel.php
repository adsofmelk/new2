<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewMateriasInformesFaltantesModel extends Model
{
    protected $table = 'view_materiasinformesfaltantes';
    protected $primaryKey = 'materia_idmateria';
    protected $fillable = [];
    protected $hidden = [];
    public $timestamps = false;
}

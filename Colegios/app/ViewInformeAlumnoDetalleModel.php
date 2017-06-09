<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewInformeAlumnoDetalleModel extends Model
{
    protected $table = 'view_informealumnodetalle';
    protected $primaryKey = 'idinforme_alumno_detalle';
    protected $fillable = [];
    protected $hidden = [];
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class InformeAcademicoModel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $hidden = [];
    public $timestamps = true;
    
    protected $table = 'informeacademico';
    protected $primaryKey = 'idinformeacademico';
    protected $fillable = [ 'fechalimite',
                            'observacioneshidden',
                            'observacionesshow',
                            'estado',
                            'anioescolar_idanioescolar',
                            'periodo_idperiodo'
                            ];
    
    
}

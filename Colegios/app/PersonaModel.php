<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonaModel extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'idpersona';
    protected $fillable = ['nombres','apellidos',
    						'fechanacimiento','numerodocumento',
    						'telefono','celular','fotografia','email',
    						'genero_idgenero','ciudad_nacimiento_idciudad',
    						'tipodocumento_idtipodocumento',
    						'ciudad_documento_idciudad',
    						'gruposanguineo_idgruposanguineo',
    						'rh_idrh',
    						'eps_ideps',
    						];
    protected $hidden = [];
    public $timestamps = false;
}

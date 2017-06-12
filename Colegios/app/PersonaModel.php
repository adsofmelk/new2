<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PersonaModel extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'idpersona';
    protected $fillable = ['nombres','apellidos',
    						'fechanacimiento','numerodocumento',
    						'telefono','celular','fotografia','email',
    						'direccion',
    						'observaciones',
    						'genero_idgenero','ciudad_nacimiento_idciudad',
    						'tipodocumento_idtipodocumento',
    						'ciudad_documento_idciudad',
    						'gruposanguineo_idgruposanguineo',
    						'rh_idrh',
    						'eps_ideps',
    						'ciudad_residencia_idciudad',
    						];
    protected $hidden = [];
    public $timestamps = false;
    
    //Carga de la fotografia
    public function setFotografiaAttribute($fotografia){
    	$this->attributes['fotografia'] = Carbon::now()->second . $fotografia->getName();
    	
    	\Storage::disk('public')->put(Carbon::now()->second . $fotografia->getName(),\File::get($fotografia));
    	
    }
    
}

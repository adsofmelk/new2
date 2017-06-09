<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioModel extends Model implements AuthenticatableContract
{
    use SoftDeletes;
    use Authenticatable;
    
    
    protected $dates = ['deleted_at'];
    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    protected $fillable = ['nombres','apellidos','email','password','intentos','hash','estado'];
    protected $hidden = ['password','hash'];
    public $timestamps = true;
    
    public function setPasswordAttribute($valor){
        if(!empty($valor)){
            $this->attributes['password'] = \Hash::make($valor);
        }
    }
}

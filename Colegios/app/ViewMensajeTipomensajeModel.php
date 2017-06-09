<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewMensajeTipomensajeModel extends Model
{
    protected $table = 'view_mensajetipomensaje';
    protected $primaryKey = 'idmensaje';
    protected $fillable = [];
    protected $hidden = [];
    public $timestamps = false;
}

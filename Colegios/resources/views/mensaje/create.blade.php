@extends('admin.template')

@section('content')
<h2>Nuevo envío de mensaje</h2>
{!!Form::open(['route'=>'mensaje.store','method'=>'POST','id'=>'formulario'])!!}
    
    @include('mensaje.forms.mensajeforms')
    
    {!!Form::submit("Guardar y Enviar",["class"=>"btn btn-primary","id"=>"btn-save"])!!}
{!!Form::close()!!}

    

@stop



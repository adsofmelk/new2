@extends('admin.template')

@section('content')
{!!Form::open(['route'=>'tipousuario.store','method'=>'POST'])!!}
    <div class='form-group'>
        {!!Form::label("nombre","Nombre:")!!}
        {!!Form::text("nombre",null,['class'=>'form-control','placeholder'=>'Ingrese el tipo de usuario'])!!}
    </div>
    {!!Form::submit("Guardar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

@stop
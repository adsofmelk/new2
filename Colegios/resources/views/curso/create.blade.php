@extends('admin.template')

@section('content')
{!!Form::open(['route'=>'usuario.store','method'=>'POST'])!!}
    
    @include('usuario.forms.usuarioforms')
    
    {!!Form::submit("Guardar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

    

@stop



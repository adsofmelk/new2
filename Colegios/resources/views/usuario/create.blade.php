@extends('admin.template')

@section('content')
@include('usuario.menu.menu')
<h2>Nuevo Usuario</h2>
{!!Form::open(['route'=>'usuario.store','method'=>'POST'])!!}
    
    @include('usuario.forms.usuarioforms')
    
    {!!Form::submit("Guardar",["class"=>"btn btn-primary",'id'=>'btn-save'])!!}
{!!Form::close()!!}

{!!Html::script('app/js/ModUsuario.js')!!}   
    

@stop



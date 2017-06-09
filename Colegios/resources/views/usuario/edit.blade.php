@extends('admin.template')

@section('content')
@include('usuario.menu.menu')
<h2>Modificar usuario</h2>
{!!Form::model($usuario,['route'=>['usuario.update',$usuario->idusuario],'method'=>'PUT'])!!}
   
    @include('usuario.forms.usuarioforms')

     {!!Form::submit("Actualizar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}
<hr>
{!!Form::open(['route'=>['usuario.destroy',$usuario->idusuario],'method'=>'DELETE'])!!}
     {!!Form::submit("Eliminar",["class"=>"btn btn-danger"])!!}
{!!Form::close()!!}
<hr>
    
{!!Html::script('app/js/ModUsuario.js')!!}
@stop



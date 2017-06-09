@extends('admin.template')

@section('content')

{!!Form::model($usuario,['route'=>['cuentausuario.update',$usuario->idusuario],'method'=>'PUT'])!!}
   
    @include('cuentausuario.form.usuarioform')

     {!!Form::submit("Actualizar",["class"=>"btn btn-primary",'id'=>'btn-save'])!!}
{!!Form::close()!!}


{!!Html::script('app/js/ModCuentaUsuario.js')!!}

@stop



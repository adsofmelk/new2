@extends('admin.template')

@section('content')
<h2>Modificar parametros del informe de periodo</h2>
{!!Form::model($informeacademico,['route'=>['informeacademicoparametros.update',$informeacademico->idinformeacademico],'method'=>'PUT'])!!}
   
    @include('informeacademicoparametros.form.informeacademicoforms')

     {!!Form::submit("Actualizar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

@stop



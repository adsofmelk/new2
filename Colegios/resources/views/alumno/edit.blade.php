@extends('admin.template')

@section('content')

<h3>Modificar Estudiante</h3>
{!!Form::model($alumno,['route'=>['alumno.update',$alumno->idalumno],'method'=>'PUT'])!!}
   
     @include('alumno.forms.alumnoforms')

     {!!Form::submit("Actualizar",["class"=>"btn btn-primary","id"=>"btn-save",'files'=>true])!!}
{!!Form::close()!!}
    
{!!Html::script('app/js/ModAlumno.js')!!}
@stop



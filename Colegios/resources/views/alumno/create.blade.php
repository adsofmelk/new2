@extends('admin.template')

@section('content')

<h3>Nuevo Alumno </h3>

<p>&nbsp;</p>

{!!Form::open(['route'=>'alumno.store','method'=>'POST'])!!}
    
    @include('alumno.forms.alumnoforms')
    
    {!!Form::submit("Guardar",["class"=>"btn btn-primary","id"=>"btn-save"])!!}
{!!Form::close()!!}

{!!Html::script('app/js/ModAlumno.js')!!}    

@stop



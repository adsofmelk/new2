@extends('admin.template')

@section('content')

@include('admin.menuidprofesorcurso')


<h3>Registrar Falla</h3>
<div class='row'>
	<div class='col-sm-3'><h5>Curso: {{$profesorcursomateria->nombrecurso}}</h5></div>
	<div class='col-sm-3'><h5>Materia: {{$profesorcursomateria->nombremateria}}</h5></div>
	<div class='col-sm-6'><h5>Periodo: {{\App\Helpers::getPeriodo()['nombre']}}</h5></div>
	
	<div class='col-sm-6'><h5>Alumno: {{$alumno->nombres . ' '. $alumno->apellidos}}</h5></div>
	<div class='col-sm-6'><h5>Profesor: {{$profesorcursomateria->nombres . ' '. $profesorcursomateria->apellidos}}</h5></div>
	
</div>
<p>&nbsp;</p>

{!!Form::open(['route'=>'fallas.store','method'=>'POST'])!!}    
	@include('fallas.forms.fallasforms')
    
    {!!Form::submit("Guardar",["class"=>"btn btn-primary","id"=>"btn-save"])!!}
{!!Form::close()!!}

{!!Html::script('app/js/ModFallas.js')!!}    

@stop



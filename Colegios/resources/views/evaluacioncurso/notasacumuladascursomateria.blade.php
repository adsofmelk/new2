
	@extends('admin.template')
	
	@section('content')
	
	@include('admin.menuidprofesorcurso')
	
	
	
	<h3>Evaluaciones del Periodo </h3>
	
	<div class='row panel panel-default'>
	
	
		<div class='col-sm-2'><h4>Curso: {{$profesorcursomateria->nombrecurso}}</h4></div>
		<div class='col-sm-3'><h4>Materia: {{$profesorcursomateria->nombremateria}}</h4></div>
		<div class='col-sm-2'><h4>Periodo: {{\App\Helpers::getPEriodo()['nombre']}}</h4></div>
	
		<div class='col-sm-5'><h4>Profesor: {{$profesorcursomateria->nombres . ' '. $profesorcursomateria->apellidos}}</h4></div>
	
	</div>
	
	
   <p>&nbsp;</p>
	



@include('evaluacioncurso.forms.detallenotasacumuladas')
	

		
@stop


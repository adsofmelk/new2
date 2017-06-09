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
	@if(sizeof($evaluaciones)>0)
		
		<table class='table'>
		<thead>
			<tr>
				<th >Fecha</th>
				<th >Estandar</th>
				<th >Tipo</th>
				<th>Detalles</th>
				<th>Acciones</th>
				
			</tr>
		</thead>
		
		@foreach($evaluaciones as $evaluacion)
		<tr>
			<td>{{$evaluacion->fechaevaluacion}}</td>
			<td>{{$evaluacion->nombretipoestandar}}</td>
			<td>{{$evaluacion->nombretipoevaluacion}}</td>
			<td>{{$evaluacion->detalle}}</td>
			<td>{!!link_to_action('EvaluacionCursoController@verDetalleEvaluacion',$title= "Ver +", $parameters = $evaluacion->idevaluacion, $attributes = ["class"=>'btn btn-info'])!!}
			{!!link_to_route('evaluacioncurso.edit',$title= "Modificar", $parameters = $evaluacion->idevaluacion, $attributes = ["class"=>'btn btn-warning'])!!}</td>
		</tr>
			
		@endforeach
		
		</table>
	@endif
@stop
@extends('admin.template')

@section('content')

@include('admin.menuidprofesorcurso')


<h3>Control de asistencia</h3>

<div class='row panel panel-default'>
	
	
	<div class='col-sm-2'><h4>Curso: {{$profesorcursomateria->nombrecurso}}</h4></div>
	<div class='col-sm-3'><h4>Materia: {{$profesorcursomateria->nombremateria}}</h4></div>
	<div class='col-sm-2'><h4>Periodo: {{\App\Helpers::getPEriodo()['nombre']}}</h4></div>
	
	<div class='col-sm-5'><h4>Profesor: {{$profesorcursomateria->nombres . ' '. $profesorcursomateria->apellidos}}</h4></div>
	
</div>

<div class='row panel panel-default'>
	
	
	<div class='col-sm-12'><h4>Alumno: {{$alumno->nombres . " " .$alumno->apellidos }}</h4></div>
	
	@if(sizeof($fallas)>0)
	<table class='table table-striped'>
		<thead>
		<tr>
			<th>Fecha (Año-mes-día)</th>
			<th>Numero de fallas</th>
			<th>Observaciones</th>
			<th>Acciones</th>
		</tr>
		</thead>
		<tbody>
			@foreach($fallas as $row)
				<tr>
					<td>{{$row->fecha}}</td>
					<td>{{$row->numerohoras}}</td>
					<td>{{$row->observaciones}}</td>
					<td>{!!link_to_route('fallas.edit',$title= "Modificar", $parameters = $row->idfallas, $attributes = ["class"=>'btn btn-primary'])!!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	@else
	<div class='col-sm-6'><h3>El alumno no registra fallas en este periodo</h3></div>
	
	@endif
	<div class='col-sm-6'>
	{!!link_to_action('FallasController@createFalla',"+ Agregar Nueva Falla", [$alumno->idalumno,$profesor_curso->idprofesor_curso], $attributes = ["class"=>'btn btn-danger'])!!}
	</div>
	<br>&nbsp;<br>
</div>


@stop
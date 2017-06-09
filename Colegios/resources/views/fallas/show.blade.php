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

	
	<p>&nbsp;</p>
	
		
		<table class='table table-striped'>
		<thead>
			<tr>
				<th >Alumno</th>
				
				<th style='text-align: center;'>
					Acumulado periodo	
				</th>
				<th style='text-align: center;'>
					Hoy	
				</th>
				<th colspan = "2" style='text-align: center;'>
					Acciones
				</th>
				
				
				
			</tr>
		</thead>
		
		@foreach($alumnos as $alumno)
		<tr>
			<td><strong>{{'[ '. $alumno->codigolista .' ] '.$alumno->nombres . " " . $alumno->apellidos}}</strong></td>
			<td style='text-align: center;'>
			@foreach($alumno['fallas'] as $fallas)
				{{$fallas->cantidad}}
			@endforeach
			</td>
			<td style='text-align: center;'>
			@foreach($alumno['fallashoy'] as $fallas)
				{{$fallas->fallashoy}}
			@endforeach
			</td>
			<td style='text-align: right;'>
				{!!Form::open(['route'=>'fallas.store','method'=>'POST'])!!}
				@include('fallas.forms.registrarfallaform')
				{!!Form::submit("Registrar 1 Falla",["class"=>"btn btn-danger"])!!}
				{!!Form::close()!!}
			</td>
			<td >
				{!!link_to_action('FallasController@verDetalle',$title= "Ver +", ["idalumno"=>$alumno->alumno_idalumno , "profesor_curso"=> $profesor_curso->idprofesor_curso], $attributes = ["class"=>'btn btn-info'])!!}
			</td>
			</tr>
			
		@endforeach
		
		</table>
	
@stop
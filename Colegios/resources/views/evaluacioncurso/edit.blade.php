@extends('admin.template')

@section('content')

@include('admin.menuidprofesorcurso')


<h3>Modificar Evaluación </h3>
<div class='row'>
	<div class='col-sm-3'><h5>Curso: {{$profesorcursomateria->nombrecurso}}</h5></div>
	<div class='col-sm-3'><h5>Materia: {{$profesorcursomateria->nombremateria}}</h5></div>
	<div class='col-sm-6'><h5>Periodo: {{\App\Helpers::getPeriodo()['nombre']}}</h5></div>
	
	<div class='col-sm-12'><h5>Profesor: {{$profesorcursomateria->nombres . ' '. $profesorcursomateria->apellidos}}</h5></div>
</div>
<p>&nbsp;</p>

{!!Form::model($evaluacion,['route'=>['evaluacioncurso.update',$evaluacion->idevaluacion],'method'=>'PUT'])!!}    
    @include('evaluacioncurso.forms.evaluacioncursoforms')
    
    {!!Form::submit("Guardar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

{!!Html::script('app/js/ModEvaluacionCurso.js')!!}    

@stop



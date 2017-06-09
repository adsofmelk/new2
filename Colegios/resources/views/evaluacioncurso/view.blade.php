@extends('admin.template')

@section('content')

@include('admin.menuidprofesorcurso')


<h3>Información de la Evaluación</h3>

	
<p>&nbsp;</p>

    @include('evaluacioncurso.forms.evaluacioncursoview')    


@stop



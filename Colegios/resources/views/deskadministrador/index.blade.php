@extends('layouts.admin')

@section('content')

@include('layouts.modal')

{!!Html::script("app/js/ModDeskAdministrador.js")!!}

<h2>Informes del Sistema</h2>
<div class="row panel panel-body">
	<div class='col-sm-8'>
            
		@include('deskadministrador.forms.profesores')
		
	</div>
	<div class='col-sm-4'>
		@include('deskadministrador.forms.anuncios')
	</div>

</div>


@stop
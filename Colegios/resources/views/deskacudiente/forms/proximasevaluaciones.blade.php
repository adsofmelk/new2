	<h3>Próximas Evaluaciónes</h3>
	
	  		<ul class="list-group">
	  		@foreach($alumno['proximasevaluaciones'] as $evaluacion)
			 <li class="list-group-item list-group-item-info">
			 <div class='row'>
			 	<div class='col-sm-12'>
			 		<h3><strong>Materia: </strong>{{$evaluacion->nombremateria}}</h3>
			 	</div>
			 	<div class='col-sm-6'>
			 		<h4><strong>Tipo de Actividad:</strong> {{$evaluacion->nombretipoevaluacion}}</h4>
			 	</div>
			 	<div class='col-sm-6'>
			 		<h4><strong>Fecha (Año-mes-día):</strong>&nbsp;&nbsp; {{$evaluacion->fechaevaluacion}}</h4>
			 	</div>
			 	@if(sizeof($evaluacion->detalle)>0)
			 	<div class='col-sm-12'>
			 		<h4><strong>Detalle de la actividad:</strong></h4>
			 		{{$evaluacion->detalle}}
			 	</div>
			 	@endif
			 </div>
			 
			 </li>
			 @endforeach
			</ul>
	
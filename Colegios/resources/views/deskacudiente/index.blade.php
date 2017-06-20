@extends('layouts.acudiente')

@section('content')


<?php 
	$activo=true;
	$i=0;
?>


<ul class="nav nav-tabs">
@foreach($alumnos as $alumno)
	<?php 
		if($activo){
			$activo=false;
			$class='active';
		}else{
			$class='';
		}
		
	?>

  <li class="{{$class}}"><a data-toggle="tab" href="#alumno{{$i}}">{{$alumno->nombres}}</a></li>
  <?php 
  	$i++;
  ?>
@endforeach
</ul>


<?php 
	$activo=true;
	$i=0;
?>
<div class='row'>
<div class="tab-content col-sm-8">

	@foreach($alumnos as $alumno)
	
	<?php 
		if($activo){
			$activo=false;
			$class='in active';
		}else{
			$class='';
		}
		
	?>
	
	<div id="alumno{{$i}}" class="tab-pane fade {{$class}}">
	
	<?php $i++;?>	
	
		<div class="row panel panel-body">
		  <div class="col-sm-2" style='background:""; height:200px;'>
			  <img src="/images/alumnos/default.png" class="img-thumbnail" alt="{{$alumno->nombres . " " . $alumno->apellidos}}" style="width:100%;">
		  </div>
		  <div class="col-sm-10 panel-body">
		  	<div class="row">
		  		<div class="col-sm-12">
		  			<h3><strong>Nombre: </strong>{{$alumno->nombres . " " . $alumno->apellidos}}</h3>
		  		</div>
		  		 <div class="col-sm-6 ">
				  	
				  	<h4><strong>Edad: </strong>
				  	<?php 
				  	$datetime1 = date_create($alumno->fechanacimiento);
				  	$datetime2 = date_create(date('Y-m-d'));
				  	$interval = date_diff($datetime1, $datetime2);
				  	echo $interval->format('%y años');
				  	?></h4>
				  	<h4><strong>Fecha de nacimiento (año-mes-día): </strong>{{$alumno->fechanacimiento}}</h4>
				  	<h4><strong>Estado: </strong>{{$alumno->estadoalumno}}</h4>
				  </div>
				  <div class="col-sm-6 ">
				  	<h4><strong>Curso: </strong>{{$alumno->nombrecurso}}</h4>
				  	<h4><strong>Director de Curso: </strong>{{$alumno['directorcurso'][0]->nombres . ' ' . $alumno['directorcurso'][0]->apellidos}}</h4>
				  	<p>&nbsp;</p>
				  <!--  	<button type="button" class="btn btn-primary">Enviar Mensaje</button> -->
				  </div>
				  
			</div>
		  </div>
		  
		</div>
		<div class="row">
			<div class="col-sm-12  panel panel-body"> <!-- TABS -->
				<div class="col-sm-12  panel panel-body">
				@include('deskacudiente.forms.resumen')
				</div>
				<div class="col-sm-12  panel panel-body">
				@include('deskacudiente.forms.evaluaciones')
				</div>
				<div class="col-sm-12  panel panel-body">
				@include('deskacudiente.forms.proximasevaluaciones')
				</div>
		
			</div>
			
		
		</div>

	</div>
	@endforeach
</div>

<div class='col-sm-4'> <!-- ANUNCIOS -->
			@include('deskacudiente.forms.anuncios')
</div>
</div>
{!!Html::script('app/js/ModDeskAcudiente.js')!!}  
@stop
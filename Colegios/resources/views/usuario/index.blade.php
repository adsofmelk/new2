@extends('admin.template')

@section('content')
@include('usuario.menu.menu')


<h2>Usuarios del Sistema</h2>
	
	
<?php 
	$activo=true;
	$i=0;
?>


<ul class="nav nav-tabs">
@foreach($tipousuarios as $tipousuario)
	<?php 
		if($activo){
			$activo=false;
			$class='active';
		}else{
			$class='';
		}
		
	?>

  <li class="{{$class}}"><a data-toggle="tab" href="#tipousuario{{$i}}">{{strtoupper($tipousuario->nombre)}}</a></li>
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
<div class="tab-content col-sm-12">

	@foreach($tipousuarios as $tipousuario)
	
	<?php 
		if($activo){
			$activo=false;
			$class='in active';
		}else{
			$class='';
		}
		
	?>
	
	<div id="tipousuario{{$i}}" class="tab-pane fade {{$class}}">
	
	<?php $i++;?>	
	
		<div class="row panel panel-body">
		 	@if(isset($tipousuario['usuarios']))
		 		@foreach($tipousuario['usuarios'] as $usuario)
		 			<div class='col-sm-3' style='padding:9px; border: 1px solid #eee;'>
		 				<div class='col-sm-12'>
		 				{{$usuario->nombres . " " .$usuario->apellidos}}
		 				</div>
		 				<div class='col-sm-6'>
		 					{!!link_to_route('usuario.edit',$title= "Editar", $parameters = $usuario->idusuario, $attributes = ["class"=>'btn btn-sm btn-primary'])!!}
		 				</div>
		 			</div>
		 		@endforeach
		 	@elseif(isset($tipousuario['cursos']))
		 		<div class='row'>
		 		@foreach($tipousuario['cursos'] as $curso)
		 			<div class='col-sm-6'>
		 				<div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion" href="#curso{{$curso->idcurso}}">
						        {{$curso->nombre}}
						        <span class="badge" style='float:right;'>{{sizeof($curso['alumnos'])}}</span>
						        </a>
						      </h4>
						    </div>
						    <div id="curso{{$curso->idcurso}}" class="panel-collapse collapse">
						      <div class="panel-body row">
						      	@foreach($curso['alumnos'] as $alumno)
						      	
						      		<div class='col-sm-12' style='padding:9px; border: 1px solid #eee;'>
						 				<div class='col-sm-12'>
						 					<strong>[{{$alumno->alumno_idalumno}}] {{$alumno->nombres . " " .$alumno->apellidos}}</strong>
						 				</div>
						 				@foreach($alumno['acudientes'] as $acudiente)
						 				<div class='col-sm-6' style='border: 1px solid #eee; padding:8px;'>
						 					{!!link_to_route('usuario.edit',$title= ($acudiente->nombres. " " . $acudiente->apellidos), $parameters = $acudiente->usuario_idusuario)!!}
						 				</div>
						 				@endforeach
						 				
						 			</div>
						      	
						      	@endforeach
						      </div>
						    </div>
						  </div>
		 			</div>
		 		@endforeach
		 		</div>
		 	@endif
		  
		</div>


	</div>
	@endforeach
</div>

</div>	


@stop
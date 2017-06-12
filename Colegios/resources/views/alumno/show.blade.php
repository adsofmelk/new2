@extends('admin.template')

@section('content')


<h3>Detalle del Estudiante</h3>
	

<div class='row'>
	<div class='col-sm-6'>
	<div class="panel panel-default">
	  <div class="panel-heading">Información Personal</div>
	  <div class="panel-body">
		 
		  <div class='form-group col-sm-5'>
		  		@if(sizeof($alumno->fotografia)>0)
		  			<img src="{{$alumno->fotografia}}" class="img-thumbnail" alt="{{$alumno->nombres}}" style='width:100%;' >
		  		@else
		  			<img src="/images/alumnos/default.png" class="img-thumbnail" alt="{{$alumno->nombres}}" style='width:100%;' >
		  		@endif
		  </div>
	  	
	  		
	  		<div class='form-group col-sm-7'>
				 <h3>{{$alumno->nombres}}<br>{{$alumno->apellidos}}</h3>       
		    </div>
		    
		    <div class='form-group col-sm-6'>
		        <strong>Edad:</strong>
		        <?php 
			        if(sizeof($alumno->fechanacimiento)>0){
			        	$datetime1 = date_create($alumno->fechanacimiento);
			        	$datetime2 = date_create(date('Y-m-d'));
			        	$interval = date_diff($datetime1, $datetime2);
			        	echo $interval->format('%y años');
			        }
			        
		        ?>
		    </div>
		    
		    <div class='form-group col-sm-6'>
		        <strong>Fecha Nacimiento:</strong>{{$alumno->fechanacimiento}}
		    </div>
		    
		    <div class='form-group col-sm-6'>
				 <strong>Genero: </strong>{{$alumno->nombregenero}}       
		    </div>
		    
		    <div class='form-group col-sm-6'>
				 <strong>Lugar de Nacimiento: </strong><br>{{$alumno->nombreciudadnacimiento}}       
		    </div>
		    
		    <div class='form-group col-sm-12'>
		    	<hr>
		    </div>
		    <div class='form-group col-sm-12'>
				 <strong>Tipo de Documento: </strong>{{$alumno->nombretipodocumento}}       
		    </div>
		    <div class='form-group col-sm-12'>
				 <strong>Numero de Documento: </strong>{{$alumno->numerodocumento}}       
		    </div>
		    <div class='form-group col-sm-12'>
				 <strong>Lugar de expedición: </strong>{{$alumno->nombreciudaddocumento}}       
		    </div>
	  </div>
	</div>
	
	<div class="panel panel-default">
		  <div class="panel-heading">Datos Acudientes</div>
		  <div class="panel-body">
			<div class='form-group col-sm-12'>
	    	@if(sizeof($acudientes)>0)
	    		<table class='table'>
	    		<thead>
	    				<th>Nombre</th>
	    				<th>Celular</th>
	    				<th>Telefono</th>
	    			</thead>
	    			<tbody>
	    		@foreach($acudientes as $acudiente)
	    			
	    			<tr>
	    				<td>
	    					{{$acudiente->nombres . " ".$acudiente->apellidos}}
	    				</td>
	    				<td>
	    					{{$acudiente->celular}}
	    				</td>
	    				<td>
	    					{{$acudiente->telefono}}
	    				</td>
	    			</tr>
	    		@endforeach
	    			</tbody>
	    		</table>
	    	@endif
		    </div>
		</div>
	</div>
	
	<div class='col-sm-6'>
		{!!link_to_route('alumno.edit',$title= "Editar", $parameters = $alumno->idalumno, $attributes = ["class"=>'btn btn-primary  '])!!}
	</div>
	
	</div>
	
	<div class='col-sm-6'>
	
				
		<div class="panel panel-default">
		  <div class="panel-heading">Información Académica</div>
		  <div class="panel-body">
				<div class='form-group col-sm-6'>
		    		<strong>Curso: </strong>{{$curso->nombrecurso}}
		    	</div>
		    	<div class='form-group col-sm-6'>
		    		<strong># de lista: </strong>{{$curso->codigolista}}
		    	</div>
		    	<div class='form-group col-sm-12'>
		    		<strong>Director de curso: </strong>{{$curso->nombres . " " .$curso->apellidos}}
		    	</div>
			</div>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-heading">Datos de Contácto</div>
		  <div class="panel-body">
				<div class='form-group col-sm-12'>
		    		<strong>Ciudad de residencia: </strong>{{$alumno->nombreciudadresidencia}}
		    	</div>
		    	<div class='form-group col-sm-12'>
		    		<strong>Dirección: </strong>{{$alumno->direccion}}
		    	</div>
		    	<div class='form-group col-sm-12'>
		    		<strong>Teléfono: </strong>{{$alumno->telefono}}
		    	</div>
		    	<div class='form-group col-sm-12'>
		    		<strong>Celular: </strong>{{$alumno->celular}}
		    	</div>
		    	<div class='form-group col-sm-12'>
		    		<strong>E-mail: </strong>{{$alumno->email}}
		    	</div>
		    	
		    	
			</div>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-heading">Datos de Salud</div>
		  <div class="panel-body">
				<div class='form-group col-sm-12'>
		    	
			        <strong>Eps: </strong>
			        {{$alumno->nombreeps}}
			    </div>
			    <div class='form-group col-sm-12'>
		    	
			        <strong>Grupo Sanguineo: </strong>
			        {{$alumno->nombregruposanguineo}} {{$alumno->factorrh}}
			    </div>
			</div>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-heading">Observaciones</div>
		  <div class="panel-body">
				<div class='form-group col-sm-12'>
			        {{$alumno->observaciones}}
			    </div>
			</div>
		</div>
	
	</div>
	
	</div> 

	
@stop
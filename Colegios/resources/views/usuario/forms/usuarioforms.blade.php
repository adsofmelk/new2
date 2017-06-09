<div class="row">
  <div class="col-sm-6">
  		<h3>Datos Básicos</h3>
  		
  		<div class='form-group'>
	        {!!Form::label("nombres","Nombres:")!!}
	        {!!Form::text("nombres",null,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
	    </div>
	    <div class='form-group'>
	        {!!Form::label("apellidos","Apellidos:")!!}
	        {!!Form::text("apellidos",null,['class'=>'form-control','placeholder'=>'Ingrese los apellidos del usuario'])!!}
	    </div>
	    
	    <div class='form-group '>
	    	{!!Form::label("idgenero","Genero:	")!!}
	        {!!Form::select("genero_idgenero",$genero,(($persona!=null)?$persona->genero_idgenero:null),['class'=>'form-control'])!!}
	    </div>
	    <div class='form-group '>
	        {!!Form::label("tipodocumento","Tipo de Documento:")!!}
	        {!!Form::select("tipodocumento",$tipodocumento,(($persona!=null)?$persona->tipodocumento_idtipodocumento:null),['class'=>'form-control'])!!}
	    </div>
	    
	    <div class='form-group '>
	        {!!Form::label("numerodocumento","Numero de Documento:")!!}
	        {!!Form::text("numerodocumento",(($persona!=null)?$persona->numerodocumento:null),['class'=>'form-control','placeholder'=>'Ingrese el numero de documento de identidad'])!!}
	    </div>
	    <div class='form-group'>
	        {!!Form::label("email","Email:")!!}
	        {!!Form::email("email",null,['class'=>'form-control','placeholder'=>'Correo electrónico'])!!}
	    </div>
	    
	    
	    
	    
	    
	    
	    <div class='form-group '>
	        {!!Form::label("telefono","Teléfono:")!!}
	        {!!Form::text("telefono",(($persona!=null)?$persona->telefono:null),['class'=>'form-control','placeholder'=>'Ingrese numero fijo'])!!}
	    </div>
	    
	    <div class='form-group '>
	        {!!Form::label("celular","Celular:")!!}
	        {!!Form::text("celular",(($persona!=null)?$persona->celular:null),['class'=>'form-control','placeholder'=>'Ingrese numero celular'])!!}
	    </div>
	    
	    <hr>
	    <div class='form-group'>
	        {!!Form::label("password","Password:")!!}
	        {!!Form::password("password",'',['class'=>'form-control','placeholder'=>'Password','id'=>'password'])!!}
	    </div>
	    <div class='form-group'>
	        {!!Form::label("password2","Confirmar Password:")!!}
	        {!!Form::password("password2",'',['class'=>'form-control','placeholder'=>'Ingrese nuevamente su Password','id'=>'password2'])!!}
	    </div>
	    <hr>
	    <div class='form-group '>
	        {!!Form::label("estado","Estado del Usuario:")!!}
	        {!!Form::select("estado",$estado,null,['class'=>'form-control'])!!}
	    </div>
  </div> 
  	<h3>Grupos del usuario</h3>
    <div class="col-sm-6">
	    <div class='form-group'>
	   
	        {!!Form::label("idtipousuario","Tipo de usuario:")!!}
	        {!!Form::select("idtipousuario[]",$tipousuario,$selected,['class'=>'form-control','multiple'=>true,'id'=>'idtipousuario'])!!}
	    </div>
	</div>
	@if(isset($cursos))
	<div class='col-sm-6'  id='cursos' style=''>		
	    <h3>Acudiente Alumnos</h3>
	    
	    @foreach($cursos as $curso)
	    
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
			 				<div class='col-sm-6'>
			 					<?php if(sizeof($alumnos)==0){
			 						$alumnos=array('');
			 					}?>
			 					@if(in_array($alumno->alumno_idalumno,$alumnos))
			 					{{Form::checkbox("alumno[$alumno->alumno_idalumno]", $alumno->alumno_idalumno,['checked'=>'checked'])}} {{$alumno->nombres . " " .$alumno->apellidos}}
			 				</div>
			 				<div class='col-sm-3'>
			 					{!!Form::select("tipofamiliar[$alumno->alumno_idalumno]",$tipofamiliar,$tipoacudiente[$alumno->alumno_idalumno]->tipofamiliar_idtipofamiliar,['class'=>'form-control'])!!}
			 				</div>
			 				<div class='col-sm-3'>
			 					@if($tipoacudiente[$alumno->alumno_idalumno]->acudiente)
			 						{{Form::checkbox("acudiente[$alumno->alumno_idalumno]", $alumno->alumno_idalumno,['checked'=>'checked'])}} Acudiente
			 					@else
			 					{{Form::checkbox("acudiente[$alumno->alumno_idalumno]", $alumno->alumno_idalumno)}} Acudiente
			 					
			 					@endif
			 				</div>	
			 					@else
			 					{{Form::checkbox("alumno[$alumno->alumno_idalumno]", $alumno->alumno_idalumno)}} {{$alumno->nombres . " " .$alumno->apellidos}}
			 					</div>
			 				<div class='col-sm-3'>
			 					{!!Form::select("tipofamiliar[$alumno->alumno_idalumno]",$tipofamiliar,null,['class'=>'form-control'])!!}
			 				</div>
			 				<div class='col-sm-3'>
			 					{{Form::checkbox("acudiente[$alumno->alumno_idalumno]", $alumno->alumno_idalumno)}} Acudiente
			 				</div>
			 					@endif
			 				
			 			</div>
			      		
			      	@endforeach
			      </div>
			    </div>
			  </div>
	    @endforeach
	</div>
	@endif
</div>
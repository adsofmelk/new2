
<div class='row'>
	<div class='col-sm-6'>
	<div class="panel panel-default">
	  <div class="panel-heading">Información Personal</div>
	  <div class="panel-body">
		  <div class='form-group col-sm-4'>
		  <img src="/images/alumnos/default.png" class="img-thumbnail" alt="Cinque Terre" style='width:100%;' >
		  </div>
	  	<div class='form-group col-sm-8'>
	        {!!Form::label("fotografia","Foto:")!!}
	        {!!Form::file("fotografia",$persona->fotografia,['class'=>'form-control','placeholder'=>'Fotografía'])!!}
	    </div>
	  		
	  		<div class='form-group col-sm-12'>
		        {!!Form::label("nombres","Nombres:")!!}
		        {!!Form::text("nombres",$persona->nombres,['class'=>'form-control','placeholder'=>'Ingrese los nombres del alumno'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		        {!!Form::label("apellidos","Apellidos:")!!}
		        {!!Form::text("apellidos",$persona->apellidos,['class'=>'form-control','placeholder'=>'Ingrese los apellidos del alumno'])!!}
		    </div>
		    <div class='form-group col-sm-6'>
		        {!!Form::label("genero","Genero:")!!}
		        {!!Form::select("idgenero",$generos,$persona->genero_idgenero,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-6'>
		        {!!Form::label("fechanacimiento","Fecha de Nacimiento:")!!}
		        {!!Form::date("fechanacimiento",$persona->fechanacimiento,['class'=>'form-control'])!!}
		    </div>
		    
		    <div class='form-group col-sm-12'>
		        {!!Form::label("lugarnacimiento","Ciudad de Nacimiento:")!!}
		        {!!Form::select("idciudadnacimiento",$ciudades,$persona->ciudad_nacimineto_idciudad,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		    	<hr>
		    </div>
		    <div class='form-group col-sm-6'>
		        {!!Form::label("tipodocumento","Tipo de documento:")!!}
		        {!!Form::select("idtipodocumento",$tiposdocumento,$persona->tipodocumento_idtipodocumento,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-6'>
		        {!!Form::label("numerodocumento","Numero de Documento:")!!}
		       	{!!Form::text("numerodocumento",$persona->numerodocumento,['class'=>'form-control','placeholder'=>'Documento de identidad'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
	    	
	        {!!Form::label("lugarexpedicion","Lugar de Expedición:")!!}
	        {!!Form::select("idciudaddocumento",$ciudades,$persona->ciudad_documento_idciudad,['class'=>'form-control'])!!}
	    </div>
	  </div>
	</div>
	</div>
	
	<div class='col-sm-6'>
		
		<div class="panel panel-default">
		  <div class="panel-heading">Información Académica</div>
		  <div class="panel-body">
				<div class='form-group col-sm-12'>
		    	
		        {!!Form::label("curso","Curso:")!!}
		        @if($alumno_curso->curso_idcurso!=null)
		        	{{$alumno_curso->nombre}}
		       	@else
		       		{!!Form::select("idcurso",$cursos,null,['class'=>'form-control'])!!}
		       	@endif
		    </div>
			</div>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-heading">Datos de Contácto</div>
		  <div class="panel-body">
		  	
		    <div class='form-group col-sm-12'>
		    	
		        {!!Form::label("ciudad","Lugar de residencia:")!!}
		        {!!Form::select("idciudadresidencia",$ciudades,$persona->ciudad_residencia_idciudad,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		        {!!Form::label("direccion","Dirección:")!!}
		        {!!Form::text("direccion",$persona->direccion,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
		    </div>
		    <div class='form-group col-sm-6'>
		        {!!Form::label("telefono","Teléfono:")!!}
		        {!!Form::text("telefono",$persona->telefono,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
		    </div>
		    
		    <div class='form-group col-sm-6'>
		        {!!Form::label("celular","Celular:")!!}
		        {!!Form::text("celular",$persona->celular,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		        {!!Form::label("email","Email:")!!}
		        {!!Form::email("email",$persona->email,['class'=>'form-control','placeholder'=>'Correo electrónico'])!!}
		    </div>
		  </div>
		</div>
		
		<div class="panel panel-default">
		  <div class="panel-heading">Datos de Salúd</div>
		  <div class="panel-body">
				<div class='form-group col-sm-12'>
		    	
		        {!!Form::label("eps","EPS:")!!}
		        {!!Form::select("ideps",$eps,$persona->eps_ideps,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-6'>
		    	
		        {!!Form::label("gruposanguineo","Grupo Sanguíneo:")!!}
		        {!!Form::select("idgruposanguineo",$gruposanguineo,$persona->gruposanguineo_idgruposanguineo,['class'=>'form-control'])!!}
		    </div>
		    
		    <div class='form-group col-sm-6'>
		    	
		        {!!Form::label("rh","Factor RH:")!!}
		        {!!Form::select("idrh",$rh,$persona->rh_idrh,['class'=>'form-control'])!!}
		    </div>
			</div>
		</div>
		<div class="panel panel-default">
		  <div class="panel-heading">Observaciones</div>
		  <div class="panel-body">
				<div class='form-group col-sm-12'>
		    	
			        {!!Form::textarea("observaciones",$persona->observaciones,['class'=>'form-control'])!!}
			    </div>
			</div>
		</div>
	</div>
</div> 

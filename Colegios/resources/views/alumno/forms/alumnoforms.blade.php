<div class='row'>
	<div class='panel panel-head'><h3>Información Personal</h3></div>
	<div class='col-sm-6'>
			
		<div class='penel-body'>
	    
		    <div class='form-group col-sm-12'>
		        {!!Form::label("nombres","Nombres:")!!}
		        {!!Form::text("nombres",null,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		        {!!Form::label("apellidos","Apellidos:")!!}
		        {!!Form::text("apellidos",null,['class'=>'form-control','placeholder'=>'Ingrese los apellidos del usuario'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		        {!!Form::label("fechanacimiento","Fecha de Nacimiento:")!!}
		        {!!Form::date("fechanacimiento",null,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		        {!!Form::label("lugarnacimiento","Ciudad de Nacimiento:")!!}
		        {!!Form::select("ciudad_nacimiento_idciudad",[1,2],null,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
		        {!!Form::label("genero","Genero:")!!}
		        {!!Form::select("genero_idgenero",[1,2],null,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-6'>
		        {!!Form::label("tipodocumento","Tipo de documento:")!!}
		        {!!Form::select("tipodocumento_idtipodocumento",[1,2],null,['class'=>'form-control'])!!}
		    </div>
		    <div class='form-group col-sm-6'>
		        {!!Form::label("numerodocumento","Numero de Documento:")!!}
		       	{!!Form::text("numerodocumento",null,['class'=>'form-control','placeholder'=>'Documento de identidad'])!!}
		    </div>
		    <div class='form-group col-sm-12'>
	    	
	        {!!Form::label("lugarexpedicion","Lugar de Expedición:")!!}
	        {!!Form::select("ciudad_documento_idciudad",[1,2],null,['class'=>'form-control'])!!}
	    </div>
		</div>
	</div>
	<div class='col-sm-6'>
		<div class='form-group col-sm-12'>
	        {!!Form::label("fotografia","Foto:")!!}
	        {!!Form::file("fotografia",null,['class'=>'form-control','placeholder'=>'Fotografía'])!!}
	    </div>
	    <div class='form-group col-sm-12'>
	    	<h4>Datos de Contácto</h4>
	    </div>
	    <div class='form-group col-sm-12'>
	        {!!Form::label("direccion","Dirección:")!!}
	        {!!Form::text("direccon",null,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
	    </div>
	    <div class='form-group col-sm-6'>
	    	
	        {!!Form::label("ciudad","Lugar de residencia:")!!}
	        {!!Form::select("idrh",[1,2],null,['class'=>'form-control'])!!}
	    </div>
	    <div class='form-group col-sm-6'>
	        {!!Form::label("telefono","Teléfono:")!!}
	        {!!Form::text("telefono",null,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
	    </div>
	    
	    <div class='form-group col-sm-6'>
	        {!!Form::label("celular","Celular:")!!}
	        {!!Form::text("celular",null,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
	    </div>
	    <div class='form-group col-sm-12'>
	        {!!Form::label("email","Email:")!!}
	        {!!Form::email("email",null,['class'=>'form-control','placeholder'=>'Correo electrónico'])!!}
	    </div>
	    <div class='form-group col-sm-12'>
	    	<h4>Datos de Salúd</h4>
	    </div>
	    <div class='form-group col-sm-6'>
	    	
	        {!!Form::label("gruposanguineo","Grupo Sanguíneo:")!!}
	        {!!Form::select("gruposanguineo_idgruosanguineo",[1,2],null,['class'=>'form-control'])!!}
	    </div>
	    <div class='form-group col-sm-6'>
	    	
	        {!!Form::label("rh","Factor RH:")!!}
	        {!!Form::select("idrh",[1,2],null,['class'=>'form-control'])!!}
	    </div>
	    <div class='form-group col-sm-12'>
	    	
	        {!!Form::label("eps","EPS:")!!}
	        {!!Form::select("eps_ideps",[1,2],null,['class'=>'form-control'])!!}
	    </div>
	</div>
</div>
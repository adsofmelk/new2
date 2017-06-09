<div class="row">
  <div class="col-sm-6">
  		<h3>Cambio de contraseña de usuario</h3>
  		<p>&nbsp;</p>
  		
	    <div class='form-group'>
	        {!!Form::label("password","Nuevo Password:")!!}
	        {!!Form::password("password",['class'=>'form-control','placeholder'=>'Ingrese su nuevo password'])!!}
	    </div>
	    
	    <div class='form-group'>
	        {!!Form::label("password2","Confirme el nuevo Password:")!!}
	        {!!Form::password("password2",['class'=>'form-control','placeholder'=>'Ingrese nuevamente el nuevo password'])!!}
	    </div>
	    
  </div> 
</div>
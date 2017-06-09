@extends('admin.template')

@section('content')

<div class="row">
  <div class="col-sm-6">
  		<h3>Datos de usuario</h3>
  		<p>&nbsp;</p>
  		
	    <div class='form-group'>
	        <p>
	        	Nombre: {{$usuario->nombres . " " . $usuario->apellidos}}
	        </p>
	        <p>
	        	Tipo de usuario: <?php
					            		$echo ='';
					            		foreach(\App\Helpers::getTipousuarioUsuario(Auth::user()->idusuario) as $tipo){
					            			$echo.= $tipo->nombretipo .  ' | ';
					            		}
					            		echo (rtrim($echo,' | '));
					            	?>
	        </p>
	    </div>
	    
	    
  </div> 
</div>

@stop



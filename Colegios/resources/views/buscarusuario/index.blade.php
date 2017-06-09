@extends('admin.template')

@section('content')

@include('usuario.menu.menu')

<h3>Buscador de Usuarios</h3>
  		<br>
  		
    
		{{Form::text('cadena',null,["class"=>"",'id'=>'cadena','size'=>60])}}
		{!!Form::button("Buscar",["class"=>"btn btn-primary",'id'=>'buscar'])!!}
		
		
		{!!Html::script('app/js/ModBuscarUsuario.js')!!}
<div class="row">
  <div class="col-sm-12" id='resultados'>
  		   
  		
  </div> 
</div>

@stop



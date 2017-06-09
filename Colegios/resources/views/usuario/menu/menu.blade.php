 <div class="row" style='padding-top:40px;padding-bottom:20px;'>
    <div class="col-sm-6">
	  <div class="btn-group" '>
		  {!!link_to_route('usuario.create',$title= "+ Nuevo Usuario", $parameters = null, $attributes = ["class"=>'btn btn-primary'])!!}
		  {!!link_to_route('usuario.index',$title= "Listado", $parameters = null, $attributes = ["class"=>'btn btn-primary'])!!}
		  {!!link_to_route('buscarusuario.index',$title= "Buscar Acudiente", $parameters = null, $attributes = ["class"=>'btn btn-primary'])!!}
		</div>
	</div>
</div>

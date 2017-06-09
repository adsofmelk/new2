@if(sizeof($usuarios)>0)
	<table class='table table-striped'>
	<thead>
		<tr>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Alumnos</th>
			<th>idusuario</th>
			<th>idpersona</th>
		</tr>
	</thead>
	<tbody>
	@foreach($usuarios as $usuario)
		<tr>
		<td>
		{{$usuario->nombres}}
		</td>
		<td>
		{{$usuario->apellidos}}
		</td>
		<td>
			@if(sizeof($usuario['alumnos'])>0)
				@foreach($usuario['alumnos'] as $alumno)
				
				({{$alumno->nombrecurso}}){{$alumno->nombres . " " . $alumno->apellidos}}<br>
				
				@endforeach
			@endif
		</td>
		<td>
		<a href='/usuario/{{$usuario->usuario_idusuario}}/edit' target='_blank'>EDITAR ({{$usuario->usuario_idusuario}})</a>
		
		</td>
		<td>
		{{$usuario->idpersona}}
		</td>
		</tr>
	@endforeach
	</tbody>
	</table>
@else
	no Hay resultados en su busqueda 
@endif


<h3>Profesores Registrados</h3>
<div class="panel panel-default"><!-- RESUMEN -->
  <div class="panel-body">
      @if(sizeof($profesores)>0)
  		<table class='table table-striped'>
                    <thead>
                    <th>Nombre</th>
                    <th>Cursos</th>
                    </thead>
                    <tbody>
                        
                        @foreach($profesores as $profesor)
                        <tr>
                            <td >{{$profesor->nombres. " ". $profesor->apellidos}}</td>
                            <td>
                            @foreach($profesor['cursos'] as $curso)
                            	<strong>{{$curso->nombrecurso}}: </strong>
                            	<?php 
                            		$print='';
                            		foreach($curso['materias'] as $materia){
                            			$print.="<a href='#myModal' data-toggle='modal' 
														data-idprofesor_curso ='".$materia->idprofesor_curso."'
														data-accion='verDetalleEvaluacionesCursoMateria2'
														data-tituloventana=' <strong>Profesor: </strong>".$profesor->nombres. " ". $profesor->apellidos." - <strong>Materia: </strong>".$materia->nombremateria."'
													>".$materia->nombremateria." (".$materia['numeroevaluaciones'].") </a>, ";
                            		}
                            		echo rtrim($print,", ");
                            	?>
                            	<br>
                            @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
  		</table>
      @endif
  </div>
</div>


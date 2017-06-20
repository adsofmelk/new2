

<h3>Profesores Registrados</h3>

      @if(sizeof($profesores)>0)
      <?php 
      	$i=0;
      ?>
      <div class="panel-group" id="accordion">
      		@foreach($profesores as $profesor)
      		<div class="panel panel-default">
				    <div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}">
					        {{$profesor->nombres. " ". $profesor->apellidos}}</a>
					      </h4>
				    </div>
				    <div id="collapse{{$i}}" class="panel-collapse collapse">
				      <div class="panel-body">
				      	
				      	@foreach($profesor['cursos'] as $curso)
                            	<div class='col-sm-6'>
                            		<div class="panel panel-default">
									  <div class="panel-heading">{{$curso->nombrecurso}}</div>
									  <div class="panel-body row">
									 
									 
									  <?php 
									  foreach($curso['materias'] as $materia){
									  	echo "<div class='col-sm-8'>";
									  		echo "<a href='#myModal' data-toggle='modal'
														data-idprofesor_curso ='".$materia->idprofesor_curso."'
														data-accion='verDetalleEvaluacionesCursoMateria2'
														data-tituloventana=' <strong>Profesor: </strong>".$profesor->nombres. " ". $profesor->apellidos." - <strong>Materia: </strong>".$materia->nombremateria."'
													class=''>".$materia->nombremateria." (".$materia['numeroevaluaciones'].") </a>";
									  	echo "</div>";
									  	echo "<div class='col-sm-4'>";
									  		echo link_to_route('planillanotas.show',$title= "Planilla", $parameters = $materia->idprofesor_curso, $attributes = ["class"=>'btn btn-sm btn-primary','target'=>'_blank']);
									  	echo "</div>";
									  	echo "<div class='col-sm-12'><hr></div>";
									  }
									  
									  ?>
									  
									  
										</div>
									</div>	  
								</div>
                            @endforeach
				      
				      </div>
				    </div>
			  </div>
			  <?php 
			  	$i++;
			  ?>
			  @endforeach
      </div>

      @endif




	<h3>Notas del Periodo por Materia</h3>
	<div class="panel-group" id="accordion">
		<?php 
			$i=0;
		?>
		@foreach($alumno['materias'] as $materia)
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#evaluacion{{$alumno->alumno_idalumno}}-{{$materia->curso_idcurso.$materia->materia_idmateria.$i}}">
	        {{$materia->nombremateria}}
	        <span class="badge" style='float:right;'>{{sizeof($materia['notas'])}}</span>
	        </a>
	      </h4>
	    </div>
	    <div id="evaluacion{{$alumno->alumno_idalumno}}-{{$materia->curso_idcurso.$materia->materia_idmateria.$i}}" class="panel-collapse collapse">
	      <div class="panel-body row">
	      @foreach($materia['notas'] as $nota)
	      	<div class='col-sm-4'><strong>Fecha: </strong>{{$nota->fechaevaluacion}}<br>
	      						<strong>Nota: </strong>{{number_format($nota->nota,2)}}<br>
	      						<strong>Tipo: </strong>{{$nota->nombretipoevaluacion}}<br>
	      						@if(sizeof($nota->observaciones)>0)
	      						<strong>Observaciones: </strong><br>{{$nota->observaciones}}
	      						@endif
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

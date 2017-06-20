
	<h3>Informe por Materia</h3>
	<div class="panel-group" id="accordion">
		<?php 
			$i=0;
		?>
		@foreach($alumno['materias'] as $materia)
		
	  <div class="panel panel-default">
	    <div class="panel-heading">
	      <h4 class="panel-title">
	        <a data-toggle="collapse" data-parent="#accordion" href="#evaluacion{{$alumno->alumno_idalumno}}-{{$materia->curso_idcurso.$materia->materia_idmateria.$i}}">
	        <strong>{{$materia->nombremateria}}</strong>
	        </a>
	        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        # de notas: <span class="badge">{{sizeof($materia['notas'])}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        # de Fallas: <span class="badge" style=''>{!!($materia['acumuladofallas']['cantidad']==null)?0:$materia['acumuladofallas']['cantidad']!!}</span>
	          
	        
	      </h4>
	    </div>
	    <div id="evaluacion{{$alumno->alumno_idalumno}}-{{$materia->curso_idcurso.$materia->materia_idmateria.$i}}" class="panel-collapse collapse">
	      <div class="panel-body row">
	      
	      <div class='col-sm-6'><h4>Notas:</h4>
	      @foreach($materia['notas'] as $nota)
	      	<div class='col-sm-12' style='border:1px solid #dda;padding:5px 5px 5px 10px;'><strong>Fecha: </strong>{{$nota->fechaevaluacion}}<br>
	      						<strong>Nota: </strong>{{number_format($nota->nota,2)}}<br>
	      						<strong>Tipo: </strong>{{$nota->nombretipoevaluacion}}<br>
	      						@if(sizeof($nota->observaciones)>0)
	      						<strong>Observaciones: </strong><br>{{$nota->observaciones}}
	      						@endif
	      	</div>
	      @endforeach
	      </div>
	      <div class='col-sm-6'><h4>Fallas: {!!($materia['acumuladofallas']['cantidad']==null)?0:$materia['acumuladofallas']['cantidad']!!}</h4>
	      
	      @foreach($materia['fallas'] as $falla)
	      	<div class='col-sm-12' style='border:1px solid #dda;padding:5px 5px 5px 10px;'><strong>Fecha: </strong>{{$falla->fecha}}<br>
	      						<strong>Numero de horas: </strong>{{$falla->numerohoras}}<br>
	      						@if(sizeof($falla->observaciones)>0)
	      						<strong>Observaciones: </strong><br>{{$falla->observaciones}}
	      						@endif
	      	</div>
	      @endforeach
	        </div>    
	      </div>
	    </div>
	  </div>
	  <?php 
	  	$i++;
	  ?>
	  @endforeach
	  
	</div>

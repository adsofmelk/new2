<div class='row'>
	<div class="col-sm-12">
  		{!!link_to_route('evaluacioncurso.edit',$title= "Modificar", $parameters = $evaluacion->idevaluacion, $attributes = ["class"=>'btn btn-warning'])!!}
   </div>
  
  
</div>
<p> &nbsp;</p>
<div class='row panel panel-default'>
<div class="panel-body">
  		
  <div class="col-sm-2">
  		<h5><strong>Curso:</strong> {{$evaluacion->nombrecurso}}</h5>    
  </div> 
  <div class="col-sm-3">
  		<h5><strong>Materia:</strong> {{$evaluacion->nombremateria}}</h5>    
  </div>
  <div class="col-sm-3">
  		<h5><strong>Periodo: </strong> {{$evaluacion->nombreperiodo}}</h5>    
  </div>  
  <div class="col-sm-4">
  		<h5><strong>Profesor: </strong> {{$profesor->nombres . ' ' . $profesor->apellidos}}</h5>    
  </div>
</div>
<div class="panel-body">  
  <div class="col-sm-4">
  		<h5><strong>Estandar:</strong> {{$evaluacion->nombretipoestandar}}</h5>    
  </div>
  
  <div class="col-sm-4">
  		<h5><strong>Tipo de Evaluación:</strong> {{$evaluacion->nombretipoevaluacion}}</h5>    
  </div>  
  <div class="col-sm-4">
  		<h5><strong>Fecha:</strong> {{$evaluacion->fechaevaluacion}}</h5>    
  </div> 
 </div>
  
  <div class="col-sm-12">
	  <div class="panel panel-default">
	  		<div class="panel-heading">Observaciones: </div>
			<div class="panel-body">
				{{$evaluacion->detalle}}
			</div>
	</div >
  		    
  </div> 
  
</div>
<div class='row'>      
	<div class="col-sm-12">
		<div class='table-responsive'>
		   <table class='table table-striped'>
		        <thead>
		           <tr>
		              <th> # </th>
		              <th>Nombre</th>
		              <th>Apellido</th>
		              <th>Nota</th>
		              <th>Observaciones</th>
		            </tr>
		        </thead>
		        <tbody>
		        <?php 
					$return = '';
	                    
                    foreach ($alumnos as $row){
                        $return.="<tr>";
                        
                        $return.="<td > ".$row->codigolista." </td>";
                        $return.="<td >".$row->nombres."</td>";
                        $return.="<td >".$row->apellidos."</td>";
                        $return.="<td >".$row->nota."</td>";
                        $return.="<td >".$row->observaciones."</td>";
                        $return.="</tr>";
                        
                    
                    }
                    echo $return;
                    
                    ///ALUMNOS NUEVOS
                    
                    if(sizeof($alumnosnuevos)>0){
                    	
                    	$return = "<tr>
								<th colspan='5' style='text-align:center;'>
									<h3>Alumnos Sin Nota</h3>
								</th>
							</tr>";
                    	
                    	
                    	foreach ($alumnosnuevos as $row){
                    		$return.="<tr>";
                    		
                    		$return.="<td style='width:25px;'>".$row->codigolista." </td>";
                    		$return.="<td style='width:150px;'>".$row->nombres."</td>";
                    		$return.="<td style='width:150px;'>".$row->apellidos."</td>";
                    		$return.="<td style=''></td>";
                    		$return.="<td style=''></td>";
                    		$return.="</tr>";
                    		
                    	}
                    	echo $return;
                    }
                    
                    ?>
           </tbody>
           </table>
           </div>
	</div>
</div>
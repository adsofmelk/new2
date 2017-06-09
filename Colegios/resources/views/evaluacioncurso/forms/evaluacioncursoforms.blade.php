@if(isset($evaluacion))
<?php 
	$detalle= $evaluacion->detalle;
	$fechaevaluacion =$evaluacion->fechaevaluacion;
?>
	
@else
<?php 
	$detalle= '';
	$fechaevaluacion =\Carbon\Carbon::now();
?>
@endif

<div class="row">
  <div class="col-sm-6">
  		<div class='form-group'>
	   
	        {!!Form::label("tipoestandar_idtipoestandar","Estandar:")!!}
	        {!!Form::select("tipoestandar_idtipoestandar",$tipoestandar,null,['class'=>'form-control'])!!}
	    </div>
	    
	     <div class='form-group'>
	   
	        {!!Form::label("tipoevaluacion_idtipoevaluacion","Tipo de evaluación:")!!}
	        {!!Form::select("tipoevaluacion_idtipoevaluacion",$tipoevaluacion,null,['class'=>'form-control'])!!}
	    </div>
	    
	     <div class='form-group'>
	   		
	   			
	        {!!Form::label("fechaevaluacion","Fecha:")!!}
	        {!!Form::date("fechaevaluacion",$fechaevaluacion ,['class'=>'form-control'])!!}
	    </div>
	    
	   
	    
	    {!!Form::hidden("curso_idcurso",$profesorcursomateria->curso_idcurso)!!}
	    {!!Form::hidden("materia_idmateria",$profesorcursomateria->materia_idmateria)!!}
	    {!!Form::hidden("profesor_idprofesor",$profesorcursomateria->profesor_idprofesor)!!}
	    {!!Form::hidden("idprofesor_curso",$profesor_curso->idprofesor_curso)!!}
	    
	    
	    
	    
  </div> 
  	
    <div class="col-sm-6">
	     
	    <div class='form-group'>
	   
	        {!!Form::label("detalle","Detalle:")!!}
	        {!!Form::textarea("detalle",$detalle,['class'=>'form-control'])!!}
	    </div> 
	    
	</div>
	<div class="col-sm-12">
		<div class='table-responsive'>
		   <table class='table-striped'>
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
	                $i=0;    
                    foreach ($alumnos as $row){
                        $return.="<tr>";
                        
                        $return.="<td style='width:25px;'> <input type='hidden' name='datos[".$i."][0]' value='".$row->alumno_idalumno."' />".$row->codigolista." </td>";
                        $return.="<td style='width:150px;'>".$row->nombres."</td>";
                        $return.="<td style='width:150px;'>".$row->apellidos."</td>";
                        $return.="<td style='width:50px;'><input class='nota'  type='text'  name='datos[".$i."][1]' value='".$row->nota."' size='3' style='text-align:center'/></td>";
                        $return.="<td style='width:200px;padding: 0 0 0 10px;'><input type='text'  name='datos[".$i."][2]' value='".$row->observaciones."' size='30' />";
                        if(isset($evaluacion)){
                        	$return.="<input type='hidden' name=datos[".$i."][3] value='".$row->idevaluaciondetalle."'>";
                        }
                        $return.="</td>";
                        $return.="</tr>";
                        
                        $i++;
                    }
                    echo $return;
                    
                    ///ALUMNOS NUEVOS
                    
                    if(sizeof($alumnosnuevos)>0){
                    	
                    	$return = "<tr>
								<th colspan='5' style='text-align:center;'>
									<h3>Alumnos Sin Nota</h3>
								</th>
							</tr>";
                    	
                    	$i=0;
                    	foreach ($alumnosnuevos as $row){
                    		$return.="<tr>";
                    		
                    		$return.="<td style='width:25px;'> <input type='hidden' name='datosnuevos[".$i."][0]' value='".$row->alumno_idalumno."' />".$row->codigolista." </td>";
                    		$return.="<td style='width:150px;'>".$row->nombres."</td>";
                    		$return.="<td style='width:150px;'>".$row->apellidos."</td>";
                    		$return.="<td style='width:50px;'><input class='nota'  type='text'  name='datosnuevos[".$i."][1]' value='' size='3' style='text-align:center'/></td>";
                    		$return.="<td style='width:200px;padding: 0 0 0 10px;'><input type='text'  name='datosnuevos[".$i."][2]' value='' size='30' />";
                    		$return.="</td>";
                    		$return.="</tr>";
                    		$i++;
                    	}
                    	echo $return;
                    }
                    
                    ?>
           </tbody>
           </table>
           </div>
	</div>
</div>
<p>&nbsp;</p>
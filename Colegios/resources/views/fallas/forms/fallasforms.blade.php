<?php 
	$horas =array();
	for($i=1;$i<=8;$i++){
		$horas[$i]=$i;
	}
?>

<div class="row">
  <div class="col-sm-6">
  		<div class='form-group col-sm-6'>
	   
	        {!!Form::label("fecha","Fecha:")!!}
	        {!!Form::date('fecha',$falla->fecha,['class'=>'form-control'])!!}
	    </div>
	    <div class='form-group col-sm-12'>
	    </div>
	     <div class='form-group col-sm-6'>
	   	
	        {!!Form::label("numerohoras","Numero de Horas:")!!}
	        {!!Form::select("numerohoras",$horas,$falla->numerohoras,['class'=>'form-control'])!!}
	    </div>
	    
	     
	    
	   
	    
	    {!!Form::hidden("alumno_idalumno",$falla->alumno_idalumno)!!}
	    {!!Form::hidden("anioescolar_idanioescolar",$falla->anioescolar_idanioescolar)!!}
	    {!!Form::hidden("periodo_idperiodo",$falla->periodo_idperiodo)!!}
	    {!!Form::hidden("curso_idcurso",$falla->curso_idcurso)!!}
	    {!!Form::hidden("materia_idmateria",$falla->materia_idmateria)!!}
	    {!!Form::hidden("estado",$falla->estado)!!}
	    {!!Form::hidden("idprofesor_curso",$falla->profesor_curso_idprofesor_curso)!!}
	    {!!Form::hidden("profesor_curso_idprofesor_curso",$falla->profesor_curso_idprofesor_curso)!!}
	    
	    
	    
	    
	    
  </div> 
  <div class='form-group col-sm-6'>
	   		
	   			
	        {!!Form::label("observaciones","Observaciones:")!!}
	        {!!Form::textarea("observaciones",$falla->observaciones ,['class'=>'form-control'])!!}
 </div>
 

</div>

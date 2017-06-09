<div class="row">
  <div class="col-sm-6">
  		<div class="col-sm-12">
		    <div class='form-group'>
		    	<p>&nbsp;</p>
		        {!!Form::label("tipomensaje","Tipo de mensaje:")!!}
		        <ul class="list-group list-inline">
		        	
		        	@foreach($tiposmensaje as $tipomensaje)
				  		<li class="list-group-item list-group-item-{{$tipomensaje->class}}"><?php echo Form::radio('tipomensaje_idtipomensaje', $tipomensaje->idtipomensaje,($tipomensaje->idtipomensaje==1)?1:0); ?> {{$tipomensaje->nombre}}</li>
				  	@endforeach
				</ul>
		    </div>
	    </div>
	    
	    <div class="col-sm-12">
		    <div class='form-group'>
		        {!!Form::label("tipocanal","Canales de Comunicación:")!!}
		        <ul class="list-group list-inline">
		        @foreach($canalesmensaje as $canalmensaje)
				  <li class="list-group-item list-group-item-default">{{Form::checkbox('canal['.$canalmensaje->idcanalmensaje.']', $canalmensaje->idcanalmensaje,1)}} {{$canalmensaje->nombre}}</li>
				@endforeach
				</ul>
		    </div>
	    </div>
	    
	    <div class="col-sm-6">
		    <div class='form-group'>
		        {!!Form::label("fechaenvio","Fecha para el envío:")!!}
		        <br>
		        {!!Form::date('fechaenvio',date('Y-m-d'))!!}
		    </div>
	    </div>
	    <div class="col-sm-6">
		    <div class='form-group'>
		        {!!Form::label("fechavencimiento","Publicar en Tablero hasta:")!!}
		        <br>
		        {!!Form::date('fechavencimiento',null)!!}
		    </div>
	    </div>
  		<div class="col-sm-12">
  		<br>
	  		<div class='form-group'>
		        {!!Form::label("asunto","Asunto:")!!}
		        {!!Form::text("asunto",null,['class'=>'form-control','placeholder'=>'Titulo del mensaje'])!!}
		    </div>
	    </div>
	    <div class="col-sm-12">
		    <div class='form-group'>
		        {!!Form::label("mensaje","Mensaje:")!!}
		        {!!Form::textarea("mensaje",null,['class'=>'form-control','placeholder'=>'Máximo 160 Caracteres','rows'=>'6','id'=>'mensaje'])!!}
		        <div id='charNum'class="alert">
				  
				</div>
		    </div>
	    </div>
	</div>    
    <div class="col-sm-6">

	    <div class="col-sm-12">
	    	<h4>Enviar a:</h4>
	    	 <ul class="list-group">
	    	 <li class="list-group-item">{!!Form::checkbox('profesores', 'true')!!}&nbsp;{!!Form::label("profesores","Profesores")!!}</li>
			 <li class="list-group-item">{!!Form::checkbox('acudientes', 'true',0,['id'=>'acudientes'])!!}&nbsp;<a href="#cursos" data-toggle="collapse" >{!!Form::label("acudientes","Padres y Acudientes")!!}</a>
			    

				<div id="cursos" class="collapse">
						
							<table class='table table-striped' style='margin: 0 2px 0 10px;'>
								<?php 
									$i=0;
									foreach ($cursos as $curso){
										if($i==0){
											echo "<tr>";
										}
										echo "<td>".Form::checkbox('curso['.$curso->idcurso.']', 'true',0,['class'=>'checkCurso']) ." ". Form::label($curso->nombre,$curso->nombre)."</td>";
										$i++;
										if($i==3){
											echo "</tr>";
											$i=0;
										}
										
									}
									while($i<3){
										echo "<td></td>";
										$i++;
									}
									echo "</tr>";
								?>
								
							</table>
								
									
								
							
					
					
				</div>
			  </li>
			  
			  
			</ul>
	    	
		    <div class='form-group'>
		        {!!Form::label("numeros","Otros números telefónicos: (separados por espacio)")!!}
		        {!!Form::textarea("numeros",null,['class'=>'form-control','placeholder'=>'numeros telefonicos','rows'=>'5'])!!}
		    </div>
		    
		     <div class='form-group'>
		        {!!Form::label("numeros","Otros correos electrónicos: (separados por espacio)")!!}
		        {!!Form::textarea("correos",null,['class'=>'form-control','placeholder'=>'Otros Correos Electrónicos','rows'=>'5'])!!}
		    </div>	
	    </div>
  	</div> 
</div>

{!!Html::script('app/js/ModMensaje.js')!!}   
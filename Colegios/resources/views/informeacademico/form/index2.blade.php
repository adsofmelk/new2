@extends('admin.template')

@section('content')
<p>&nbsp;</p>
<h2>Informes Academicos Año {{\App\Helpers::getParametros()['anio']}}</h2>

	@if(sizeof($periodos)>0)
		<div class="row" style='padding-top:40px;padding-bottom:20px;'>
			  
			  
		<?php $i=0;?>
		@foreach($periodos as $periodo)
			
			<div class="col-sm-6">
				<div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}">
				        {{$periodo->nombre}}
				        @if($periodo['estadoperiodo']=='activo')
				        	<div style="float:right;"><span class="badge badge-default badge-pill"></span>Periodo Actual</div></h4>
				        @endif
				        </a>
				      
				    </div>
				    <div id="collapse{{$i}}" class="panel-collapse collapse">
				      <div class="panel-body">
				      	@if($periodo['estadoperiodo']=='activo')
				      		<table class='table'>
					      			<thead>
					      				<tr>
					      					<th>Curso</th>
					      					<th>Entregados</th>
					      					<th>Faltantes</th>
					      					
					      				</tr>
					      			</thead>
					      			<tbody>
					      	@foreach ($periodo['cursos'] as $curso)
					      				<tr>
					      				<td><h3>{{$curso->nombre}}</h3>
					      					<p><a href="{!!\App\Helpers::getParametros()['generadorPdf']!!}?c={{$curso->idcurso}}" class="btn btn-primary" target="_blank">Vista Preliminar</a></p>
					      				</td>
					      				<td>
					      					@foreach($curso['entregados'] as $entregado)
					      						<span style='background-color:#ccffcc; padding: 3px;' >{{$entregado->nombre}}</span>
					      					@endforeach
					      				</td>
					      				
					      				<td>
					      					@foreach($curso['faltantes'] as $faltante)
					      						<span style='background-color:#ffeeff; padding: 3px;'>{{$faltante->nombre}}</span>
					      					@endforeach
					      				</td>
					      				
					      				</tr>
					      			
					      	@endforeach
					      		</tbody>
				      		</table>
				      	@else
				      		@if($periodo['estadoperiodo']=='cerrado')
				      			<table class="table">
									    <thead>
									        <th>Curso</th>
									        
									        <th>Acción</th>
									    </thead>
									    <tbody>
				      			@foreach($periodo['cursos'] as $curso)
				      				
									        
									        <tr>
									            <td><h3>{{$curso->nombre}}</h3></td>
									            <td>
									                <a href="{!!\App\Helpers::getParametros()['generadorPdf']!!}?c={{$curso->idcurso}}" class="btn btn-primary" target="_blank">Boletines</a> 
									            </td>
									            
									        </tr>
									        
									
									    
				      			@endforeach
				      				</tbody>
								</table>
				      		@endif
				      	@endif            	
				      </div>
				    </div>
			  </div>
		  </div>
		  
		  <?php $i++;?>
		@endforeach
		
		</div>
	@endif

@stop
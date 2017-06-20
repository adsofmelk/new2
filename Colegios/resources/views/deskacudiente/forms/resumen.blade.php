<h3>Resumen</h3>
<div class="panel panel-default"><!-- RESUMEN -->
  <div class="panel-body">
  		<table class='table table-striped'>
  			<tr>
  				<td>Total Evaluaciones</td>
  				<td>{{$alumno['totalevaluaciones']}}</td>
  			</tr>
  			<tr>
  				<td>Aprobadas</td>
  				<td>{{$alumno['evaluacionesaprovadas']}}</td>
  			</tr>
  			<tr>
  				<td>Perdidas</td>
  				<td>{{$alumno['evaluacionesperdidas']}}</td>
  			</tr>
  			<tr>
  				<td>Total Fallas</td>
  				<td>{{$alumno['acumuladofallas']['cantidad']}}</td>
  			</tr>
  		</table>
  		
  		<!--  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Ver Información Detallada</button>  -->
  </div>
</div>
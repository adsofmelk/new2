@extends('admin.template')

@section('content')




<h3>Modulo Estudiantes</h3>

<div class='btn-group'>
	{!!link_to_route('alumno.create',$title= "+ Matricular", $parameters = '', $attributes = ["class"=>'btn btn-success'])!!}
	
</div>

<p>&nbsp;</p>
<div class="row" id="accordion">
<?php $i=1;?>
@foreach($cursos as $row)

  <div class="panel panel-default col-sm-6">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}">{{$row->nombre}}
        </a>
        
      </h4>
      
    </div>
    <div id="collapse{{$i}}" class="panel-collapse collapse">
      <div class="panel-body">
      	<table class='table table-striped'>
      		
      		@foreach($row['alumnos'] as $alumno)
      		<tr>
      			<td>{{ $alumno->apellidos . '  ' .$alumno->nombres }}</td>
      			<td>
      				{!!link_to_route('alumno.show',$title= "Ver +", $parameters = $alumno->alumno_idalumno, $attributes = ["class"=>'btn btn-sm btn-primary'])!!}
      			</td>
      		</tr>
      		@endforeach
      	
      	</table>
     	
      </div>
    </div>
  </div>
<?php $i++;?>  
@endforeach
</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Información del Estudiante</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>

<!-- END Modal -->

@stop
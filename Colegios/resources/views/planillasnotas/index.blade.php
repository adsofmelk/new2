@extends('admin.template')

@section('content')
<p>&nbsp;</p>

<h3>Planillas de Notas</h3>

<div class="row" id="accordion">
<?php $i=1;?>
@foreach($cursos as $row)

  <div class="panel panel-default col-sm-6">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}">{{$row->nombrecurso}}
        </a>
        <div style='float:right;'>{!!link_to_action('PlanillaNotasController@planillaPuestosCurso',$title= "Ver Promedios", $parameters = $row->curso_idcurso, $attributes = ["class"=>'','target'=>'_blank'])!!}</div>
      </h4>
      
    </div>
    <div id="collapse{{$i}}" class="panel-collapse collapse">
      <div class="panel-body">
      
      @foreach($row['materias'] as $materia)
      	<ul class="list-group">

		      <li class="">{!!link_to_route('planillanotas.show',$title= "$materia->nombremateria", $parameters = $materia->idprofesor_curso, $attributes = ["class"=>'','target'=>'_blank'])!!}</li>
		</ul>
      @endforeach
      </div>
    </div>
  </div>
<?php $i++;?>  
@endforeach
</div>

@stop
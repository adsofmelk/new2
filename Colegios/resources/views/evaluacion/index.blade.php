@extends('admin.template')

@section('content')

<p>&nbsp;</p>

<h3>Modulo de Evaluaciónes</h3>
<p>Seleccióne el curso a evaluar</p>

<div class="row" id="accordion">
<?php $i=1;?>
@foreach($cursos as $row)

  <div class="panel panel-default col-sm-6">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}">
        {{$row->nombrecurso}}
        <div style="float:right;"><span class="badge badge-default badge-pill">{{sizeof($row['materias'])}}</span></div></h4>
        </a>
      
    </div>
    <div id="collapse{{$i}}" class="panel-collapse collapse">
      <div class="panel-body">
      @foreach($row['materias'] as $materia)
            	{!!link_to_route('evaluacioncurso.show',$title= "$materia->nombremateria", $parameters = $materia->idprofesor_curso, $attributes = ["class"=>'btn btn-secondary btn-sm'])!!}
      @endforeach
      </div>
    </div>
  </div>
<?php $i++;?>  
@endforeach
</div>


@stop
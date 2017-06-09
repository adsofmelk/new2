@extends('admin.template')

@section('content')
<p> &nbsp;</p>
@if($datosprofesor)
<h3>Profesor: {{$datosprofesor->nombres ." ". $datosprofesor->apellidos }}</h3>
@endif
<h2>Cursos disponibles</h2>

<table class="table">
    <thead>
        <th>Curso</th>
        <th>Materia</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </thead>
    <tbody>
        @foreach($cursos as $row)
        <tr>
            <td>{{$row->nombrecurso}}</td>
            <td>{{$row->nombremateria}}</td>
            <td></td>
            
            <td>
            	<?php if(\App\Helpers::getInformeAcademicoPeriodo()[0]->estado=='activo'){?>
		                @if($row->numeroinformes>0)
		                    {!!link_to_route('notasfinalesperiodo.show',$title= "Ver Reporte", $parameters = $row->idprofesor_curso, $attributes = ["class"=>'btn btn-success'])!!}
		                    
		                    {!!link_to_route('notasfinalesperiodocurso.edit',$title= "Modificar Notas", $parameters = $row->idprofesor_curso, $attributes = ["class"=>'btn btn-warning'])!!}
		                @else
		                    {!!link_to_route('notasfinalesperiodo.edit',$title= "Registrar Notas Finales Periodo", $parameters = $row->idprofesor_curso, $attributes = ["class"=>'btn btn-primary  '])!!}
		                @endif
	           <?php }else { ?>
	           				{!!link_to_route('notasfinalesperiodo.show',$title= "Ver Reporte", $parameters = $row->idprofesor_curso, $attributes = ["class"=>'btn btn-success'])!!}
	           				{!!link_to_route('planillanotas.show',$title= "Planilla de Notas", $parameters = $row->idprofesor_curso, $attributes = ["class"=>'btn btn-primary','target'=>'_blank'])!!}
	           <?php }?>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@stop
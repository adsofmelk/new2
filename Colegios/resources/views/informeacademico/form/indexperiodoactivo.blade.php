@extends('admin.template')

@section('content')

<h2>Periodo Activo</h2>
<p><strong>Periodo: </strong>{{$informeacademico[0]->nombre}} </p>
<p><strong>Fecha limite: </strong>{{$informeacademico[0]->fechalimite}}</p>
<p><strong>Estado: </strong> {{$informeacademico[0]->estado}}</p>
<p>@if($informeacademico[0]->estado == 'activo')
	{!!link_to_route('informeacademicoparametros.edit',"Modificar parametros del cierre de periodo", $informeacademico[0]->idinformeacademico,["class"=>'btn btn-primary'])!!}
    {!!link_to_route('informeacademico.show',"Cerrar Periodo y Generar Boletines", $informeacademico[0]->idinformeacademico,["class"=>'btn btn-danger'])!!}
   @endif 
</p>

<p> </p>
<hr>
<p> </p>
@if(!empty($cursos))
<div style='width:100%; text-align:center;'>
<h3>Informe por cursos</h3>
</div>
<table class="table">
    <thead>
        <th>Curso</th>
        <th>Informes Entregados</th>
        <th>Informes Faltantes</th>
        <th>Acción</th>
    </thead>
    <tbody>
        @foreach($cursos as $curso)
        <tr>
            <td>{{$curso->nombre}}</td>
            
            <td>
            @if(!empty($curso->entregados))
                
                @foreach($curso->entregados as $materia)
                <span style='background-color:#ccffcc; padding: 3px;'>{!!$materia->nombre!!}</span>
                &nbsp;
                @endforeach
                
            @endif
            </td>
            <td>@if(!empty($curso->faltantes))
                
                @foreach($curso->faltantes as $materia)
                   <span style='background-color:#ffeeff; padding: 3px;'>{!!$materia->nombre!!}</span>
                &nbsp;
                @endforeach
                
            @endif</td>
            <td>
                <a href="{!!\App\Helpers::getParametros()['generadorPdf']!!}?c={{$curso->idcurso}}" class="btn btn-primary" target="_blank">Vista Preliminar</a> 
            </td>
            
        </tr>
        @endforeach

    </tbody>
</table>
@endif

@stop
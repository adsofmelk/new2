@extends('admin.template')

@section('content')

<h2>Periodo Cerrado</h2>
<p><strong>Periodo: </strong>{{$informeacademico[0]->nombre}} </p>
<p><strong>Fecha limite: </strong>{{$informeacademico[0]->fechalimite}}</p>
<p><strong>Estado: </strong> {{$informeacademico[0]->estado}}</p>


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
        
        <th>Acción</th>
    </thead>
    <tbody>
        @foreach($cursos as $curso)
        <tr>
            <td>{{$curso->nombre}}</td>
            <td>
                <a href="{!!\App\Helpers::getParametros()['generadorPdf']!!}?c={{$curso->idcurso}}" class="btn btn-primary" target="_blank">Boletines</a> 
            </td>
            
        </tr>
        @endforeach

    </tbody>
</table>
@endif

@stop
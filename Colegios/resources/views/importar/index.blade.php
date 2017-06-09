@extends('admin.template')

@section('content')
<table class="table">
    <thead>
        <th>Curso</th>
        <th>Materia</th>
        <th>Estado</th>
        <th>Acción</th>
    </thead>
    <tbody>
        @foreach($archivoimportado as $row)
        <tr>
            <td>{{$row->curso}}</td>
            <td>{{$row->materia}}</td>
            <td>{{$row->estado}}</td>
            <td>{!!link_to_route('importarnotas.edit',$title= "Procesar", $parameters = $row->idarchivoimportado, $attributes = ["class"=>'btn btn-primary  '])!!}</td>
        </tr>
        @endforeach
    </tbody>
</table>


@stop
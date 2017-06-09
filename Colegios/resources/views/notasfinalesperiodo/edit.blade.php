@extends('admin.template')

@section('content')
<h2>Modificar notas finales para el curso</h2>

{!!Form::open(['route'=>['notasfinalesperiodocurso.update',$profesor_curso->idprofesor_curso],'method'=>'PUT'])!!}
    
    @include('notasfinalesperiodo.forms.editnotasfinalesperiodoforms')
    <p>&nbsp;</p>
    
    {!!Form::submit("Actualizar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

{!!Html::script('app/js/ModNotasFinalesPeriodo.js')!!}      

@stop



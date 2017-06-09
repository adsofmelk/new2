@extends('admin.template')

@section('content')

<h2>Confirmar cierre de periodo</h2>

<p>Desea realmente cerrar el periodo y generar los boletines academicos?</p>

<div style="width:400px;margin-left: auto;margin-right: auto;">
    {!!link_to_route('informeacademico.index',$title= "No Cerrar Periodo", null, $attributes = ["class"=>'btn btn-primary  '])!!}
    {!!link_to_route('informeacademico.edit',$title= "Cerrar Periodo y Generar Boletines", $parameters = $id, $attributes = ["class"=>'btn btn-danger  '])!!}
</div>
    
@stop



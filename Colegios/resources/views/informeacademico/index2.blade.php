@extends('admin.template')

@section('content')

@if(sizeof($periodos)>0)

    @include('informeacademico.form.index2')
    
@else
    El periodo se encuentra cerrado
@endif
@stop
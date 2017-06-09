@extends('admin.template')

@section('content')

@if(sizeof($informeacademico)>0)

    @include('informeacademico.form.indexperiodoactivo')
    
@else
    El periodo se encuentra cerrado
@endif
@stop
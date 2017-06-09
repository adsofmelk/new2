@extends('admin.template')

@section('content')
{!!Form::open(['route'=>'notasfinalesperiodo.store','method'=>'POST'])!!}
    
    @include('notasfinalesperiodo.forms.notasfinalesperiodoforms')
    
    {!!Form::submit("Guardar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

{!!Html::script('app/js/ModNotasFinalesPeriodo.js')!!}    

@stop



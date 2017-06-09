@extends('admin.template')

@section('content')
{!!Form::open(['route'=>'importarnotas.store','method'=>'POST','files'=>true])!!}
    
    @include('importar.forms.importarforms')
    
    {!!Form::submit("Guardar",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

{!!Html::script('app/js/ModImportar.js')!!}

@stop



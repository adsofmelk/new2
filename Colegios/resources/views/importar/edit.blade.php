@extends('admin.template')

@section('content')
{!!Form::model($archivoimportado,['route'=>['importarnotas.update',$archivoimportado->idarchivoimportado],'method'=>'PUT'])!!}
   
    @include('importar.forms.procesarnotasforms')
    <p>&nbsp;</p>
     {!!Form::submit("Finalizar Proceso",["class"=>"btn btn-primary"])!!}
{!!Form::close()!!}

    
@stop



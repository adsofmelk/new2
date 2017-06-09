@extends('admin.template')

@section('content')

<h3>Envio de mensajes</h3>
{!!link_to_route('mensaje.create',$title= "+ Nuevo Mensaje", null, $attributes = ["class"=>'btn btn-success'])!!}

	@if(sizeof($mensaje)>0)
		<table class='table table-striped'>
		<thead>
			<tr>
				<th>Envío</th>
				<th>Tipo</th>
				<th>Asunto</th>
				<th>Canales</th>
                                <th>Destinatarios</th>
				<th>Estado</th>
				<th>Opciones</th>
			</tr>
		</thead>
		@foreach($mensaje as $row)
			<tr>
				<td>{{$row->fechaenvio}}</td>
                                <td><span class="text-{{$row->class}}">{{$row->nombretipomensaje}}</span></td>
				<td>{{$row->asunto}}</td>
                                <td>
                                   @foreach($row['canales'] as $canal)
                                   {{$canal->nombre}}<br>
                                   @endforeach
                                    
                                </td>
                                <td>
                                    <?php
                                        $print ='';
                                        if($row->profesores){
                                            $print.= "<strong>Profesores</strong>, ";
                                        }
                                        if($row->acudientes){
                                            $print.= "<strong>Acudientes (</strong>";
                                            $row->acudientesdetalle = json_decode($row->acudientesdetalle,false);
                                            foreach($row->acudientesdetalle as $curso){
                                                $print.= $cursos[($curso)-1]->nombre.", ";
                                            }
                                            $print = rtrim($print,', ');
                                            $print.= ")";
                                        }
                                        if(sizeof($row->numerosadicionales)>0){
                                            $print.= "<strong>Numeros Adicionales (</strong>";
                                            $numeros = explode(' ',$row->numerosadicionales);
                                            foreach($numeros as $numero){
                                                $print.= $numero.", ";
                                            }
                                            $print = rtrim($print,', ');
                                            $print.= ")";
                                        }
                                        if(sizeof($row->emailsadicionales)>0){
                                            $print.= "<strong>Emails Adicionales (</strong>";
                                            $emails = explode(' ',$row->emailsadicionales);
                                            foreach($emails as $email){
                                                $print.= $email.", ";
                                            }
                                            $print = rtrim($print,', ');
                                            $print.= ")";
                                        }
                                        $print = rtrim($print,', ');
                                        echo $print;
                                    ?>
                                </td>
				<td>{{$row->estado}}</td>
				<td></td>
			</tr>
		@endforeach
		</table>
	@else
		
	@endif
	
@stop
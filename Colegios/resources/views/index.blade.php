@extends('layouts.principal')
	@section('content')
                    <div class="header">
			<div class="top-header">
				<div class="logo">
					<a href="index.html"><img src="images/logo.jpg"  alt="Colegio Parroquial Integrado Santa Cruz" style='width:120px;'/></a>
					<h3 style="margin:20px;">COLEGIO PARROQUIAL INTEGRADO SANTA CRUZ</h3>
				</div>
				<div class="search">
                                    <p>Soporte Técnico: <br>Ing. Jose Ruben Ortiz Medina</p>
                                    <p>Email: ingjbenortm@gmail.com</p>
                                    <p>Cel: 313 885 0377</p>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="content">
                            @include('alerts.errors')
                            <div style='margin-left: auto;margin-right: auto;width:400px; '>
				<h2 style='text-align:center;'>{!!config('app.name')!!}</h2>
                                <p>&nbsp;</p>
                                {!!Form::open(['route'=>'log.store','method'=>'POST'])!!}
                                <div class="form-group">
                                        {!!Form::label('correo','Correo: ')!!}
                                        {!!Form::text('email',null,['class'=>'form-control','placeholder'=>'Ingresa tu Correo'])!!}
                                </div>
                                <div class="form-group">
                                        {!!Form::label('password','Password: ')!!}
                                        {!!Form::password('password',['class'=>'form-control','placeholder'=>'Ingresa tu Contraseña'])!!}
                                </div>
                                {!!Form::submit('Iniciar',['class'=>'btn btn-primary'])!!}
                                {!!Form::close()!!}
                            </div>
				
			</div>
		</div>
		
			
		</div>
	@endsection	
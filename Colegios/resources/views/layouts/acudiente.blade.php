<!DOCTYPE html>
<html lang="{{ config('app.locale', 'es')}}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="0">
    <title>{{ config('app.name', 'SAE Soft - Sistema de Admnistración Escolar') }}</title>
    
    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/metisMenu.min.css')!!}
    {!!Html::style('css/sb-admin-2.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('css/custom.css')!!}
    {!!Html::script("js/jquery-3.1.0.min.js")!!}
    
</head>

<body>
	@if(isset(\App\Helpers::getParametros()['estadosistema']))
		@if(\App\Helpers::getParametros()['estadosistema']=='inactivo' && !(\App\Helpers::isRoot()))
		<div id="wrapperadmin">
			<div id="mensajeadmin">
				<h1>En proceso de actualización</h1>
				<h3>La plataforma estará temporalmente deshabilitada, mientras concluye esta labor.</h3>
				
				<p> &nbsp;</p>
				<h4>Requiere ayuda ? </h4> <p>Por favor comuníquese con nuestro <strong>soporte técnico:</strong> </p>
				
				<p><big>Ing. Jose Ruben Ortiz Medina <br><strong>Email: </strong>ingjbenortm@gmail.com <br><strong>Cel:</strong> 313 885 0377</big></p>
				<p>{!!link_to_action('LogController@logOut',$title= " Cerrar", null , ['class'=>'btn btn-danger'])!!}</p>
			</div>
		</div>
		@endif
	@endif
    <div id="wrapper">

        
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/admin">{{ config('app.name', 'SAE Soft - Sistema de Admnistración Escolar') }}</a>
                
            </div>
           

            <ul class="nav navbar-top-links navbar-right">
                <?php $parametros = \App\Helpers::getParametros();
                $informeacademico = \App\Helpers::getInformeAcademicoPeriodo($parametros['idperiodo'])?>
                
                
                <li><strong>Año:</strong> {{$parametros['anio']}}</li>
                <li><strong>&nbsp;&nbsp;&nbsp;&nbsp;Periodo:</strong> {{$parametros['periodo']}}</li>
                <li><strong>&nbsp;&nbsp;&nbsp;&nbsp;Limite para Cierre:</strong> {{$informeacademico[0]->fechalimite}}</li>
                <li><strong>&nbsp;&nbsp;&nbsp;&nbsp;Estado del Periodo:</strong> {{$informeacademico[0]->estado}}</li>
                 <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {!!Auth::user()->nombres!!} {!!Auth::user()->apellidos!!}
                        <?php
                        $idusuario = Auth::user()->idusuario;
                        ?>
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-users fa-fw"></i> Grupo: 
									<?php
					            		$echo ='';
					            		foreach(\App\Helpers::getTipousuarioUsuario(Auth::user()->idusuario) as $tipo){
					            			$echo.= $tipo->nombretipo .  ' | ';
					            		}
					            		echo (rtrim($echo,' | '));
					            	?>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>{!!link_to_route('cuentausuario.edit',$title= " Ajustes", $idusuario , $attributes = ["class"=>'fa fa-gear fa-fw'])!!}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
     </nav>

         <div id="page-wrapper" style='margin:0 !important;'>
           <div class=''>
            
           @if(Session::has('error'))
           
           <div class='alert alert-danger alert-dismissible' role='alert'> 
                <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                {{Session::get('error')}}
                
            </div>
            @endif
            
            @if(count($errors)>0)
           
           <div class='alert alert-danger alert-dismissible' role='alert'> 
                <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                <ul>
                    @foreach($errors->all() as $err)
                    <li>{!!$err!!}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            @if(Session::has('message'))
            <div class='alert alert-success alert-dismissible' role='alert'> 
                <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                {{Session::get('message')}}
                
            </div>
            @endif
            
            </div>
           <p>&nbsp;</p>
            
            
            @yield('content')
            <div style='background: #fff; width:100%;height:30px;margin-top: 60px;'></div>
            
            
        </div>
        
        
        <div style='background: #eee; width:100%;height:20px;margin-top: 60px;'></div>
    </div>

    
    {!!Html::script("js/bootstrap.min.js")!!}
    {!!Html::script("js/metisMenu.min.js")!!}
    {!!Html::script("js/sb-admin-2.js")!!}
    

</body>

</html>

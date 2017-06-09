<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Session;

class VerificarPermisosTipousuarioModulos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$temp = str_replace('/', '.', ltrim($request->getPathInfo(),'/'));
    	$patharray =  explode('.',$temp);
    	$accion='';
    	$modulo = '';
    	$acciones = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];
    	
    	if(isset($patharray[0])){
    		$modulo = $patharray[0];
    	}
    	if(isset($patharray[1])){
    		$accion = $this->tipoAccion($patharray[1]);
    		if($accion=="show" && isset($patharray[2])){
    			$accion = $this->tipoAccion($patharray[2]);
    		}
    		
    	}
    	
    	if(!in_array($accion, $acciones)){
    		$accion = "index";
    	}
    	
		if($this->verificarPermisos($modulo, $accion)){
			switch($accion){
				case 'create':
				case 'edit':{
					
					$_SESSION['hash-formulario']=md5(date('Y-m-d h'));
					break;
				}
				case 'index':
				case 'show':
				case 'destroy':{
					
					
					break;
				}
				default:{
					if(isset($_SESSION['hash-formulario'])){
						unset($_SESSION['hash-formulario']);
						
					}else{
						
						return Redirect::to('/admin');
					}
				}
			}
			
			
			
			return $next($request);
		}else{
			Session::flash('error',"No tiene permisos para ejecutar [$modulo : $accion]" );
			return Redirect::to('/admin');
		}
    	
        
    }
    
    private function verificarPermisos($modulo,$accion){
    	$permisos = \App\ViewPermisoModuloUsuarioModel::where([
    			'path'=>$modulo, 
    			$accion =>true,
    			'idusuario'=>Auth::user()->idusuario
    	])->get();
    	return (sizeof($permisos)>0);
    	
    }
    
    private function tipoAccion($accion){
    	
    	switch ($accion){
    		case 'index':
    		case 'create':
    		case 'store':
    		case 'edit':
    		case 'update':
    		case 'destroy':{
    			return $accion;
    			break;
    		}
    		
    	}
    	
    	if(is_numeric($accion)){
    		return "show";
    	}
    	
    	return false;
    }
}

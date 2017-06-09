<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
class HasherController extends Controller
{
	public function __construct(){
		
	}
	
    public function generarHash(){
    	$tablas = [
    			['ProfesorCursoModel','idprofesor_curso'],
    			['CursoModel','idcurso'],
    			['EvaluacionModel','idevaluacion'],
    			['UsuarioModel','idusuario'],
    			['AlumnoCursoModel','idalumno_curso'],
    	];
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		foreach($tablas as $tabla){
    			 eval('$rows = \\App\\'.($tabla[0])."::where(['hash'=>null])->get();");
    			if(sizeof($rows)>0){
    				foreach($rows as $row){
    					eval ('$id = $row->'.$tabla[1].';');
    					eval('$item = \\App\\'.$tabla[0].'::find("$id");');
    					$item->hash = bcrypt($id);
    					$item->save();
    				}
    			}
    			
    			
    		}
    		
    		
    		
    		DB::commit();
    		Session::flash("message","Hash generado");
    		
    		return "Tablas Afectadas";
    		
    	} catch (Exception $ex) {
    		Session::flash("error","Error generando hash");
    		DB::rollBack();
    		return "Error";
    	}
    	
	}
	
	public function reasignarFamiliar(){
		try {
			DB::BeginTransaction();
			$familiares = \App\FamiliarModel::all();
			foreach ($familiares as $familiar){
				$familiaralumnos = \App\FamiliarAlumnoModel::where([
						'familiar_idfamiliar'=>$familiar->idfamiliar
				])->get();
				foreach($familiaralumnos as $alumno){
					$tempo  = \App\FamiliarAlumnoModel::find($alumno->idfamiliar_alumno);
					$tempo->tipofamiliar_idtipofamiliar= $familiar->tipofamiliar_idtipofamiliar;
					$tempo->save();
				}
			}
			DB::commit();
			return "Ok";
		}catch (\Exception $ex){
			DB::rollBack();
			return "Error";
		}
	}
	
	
	public function poblarUsuarioPersona(){
		try {
			DB::BeginTransaction();
			
			$acudientes = \App\ViewAcudienteUsuarioPersonaModel::all();
			foreach ($acudientes as $acudiente){
				$numero_usuario_persona = \App\UsuarioPersonaModel::where([
						'usuario_idusuario'=>$acudiente->usuario_idusuario
				])->count();
				if($numero_usuario_persona==0){
					\App\UsuarioPersonaModel::create([
							'usuario_idusuario'=>$acudiente->usuario_idusuario,
							'persona_idpersona'=>$acudiente->idpersona
					]);
				}
			}
			
			$profesores = \App\ViewProfesorInformacionPersonalModel::all();
			foreach ($profesores as $profesor){
				$numero_usuario_persona = \App\UsuarioPersonaModel::where([
						'usuario_idusuario'=>$profesor->usuario_idusuario
				])->count();
				if($numero_usuario_persona==0){
					\App\UsuarioPersonaModel::create([
							'usuario_idusuario'=>$profesor->usuario_idusuario,
							'persona_idpersona'=>$profesor->idpersona
					]);
				}
			}
			
			DB::commit();
			return "Ok";
		}catch (\Exception $ex){
			DB::rollBack();
			return "Error";
		}
	}
	
}

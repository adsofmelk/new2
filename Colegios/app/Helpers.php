<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Funciones auxiliares
 *
 * @author adso
 */

use Auth;
use DB;


/**
 * @author adso
 *
 */
class Helpers {
    
    private static $parametros = null;
    
    
    public static function utf($cadena =""){
    	
    	return iconv('UTF-8', 'ISO-8859-1//IGNORE',$cadena);
    }

    public static function getParametros() {
        if(self::$parametros==null){
            $temp = \App\ParametrosModel::all();
            
            
            foreach($temp as $row){
                self::$parametros[$row['key']] = $row['value'];  
            }
            
            
            $temp =  \App\AnioescolarModel::find(self::$parametros['idanioescolar']);
            self::$parametros['anio']= $temp->anio;

            $temp =  \App\PeriodoModel::find(self::$parametros['idperiodo']);
            self::$parametros['periodo']= $temp->nombre;

            $temp =  \App\ViewUsuarioTipousuarioModel::select(DB::raw('DISTINCT idtipousuario, nombre'))
                    ->where(['idusuario'=> Auth::user()->idusuario])->get();
            self::$parametros['tipousuario']= $temp;
            self::$parametros['periodos'] = json_decode(self::$parametros['periodos'],true);
            
            
        }
        
        return self::$parametros;
    }
    
    public static function getPeriodo(){
        
        return \App\PeriodoModel::find(Helpers::getParametros()['idperiodo']);
        
    }
    
    public static function getMenuLateral(){
        $temp = Helpers::getParametros();
        $grupos =  \App\ViewModuloUsuarioModel::select(DB::raw('DISTINCT idgrupomodulo, nombregrupomodulo, iconogrupo'))
                		->where(['usuario_idusuario'=> Auth::user()->idusuario])
                		->orderBy('nombregrupomodulo','ASC')
        				->get();
        foreach($grupos as $key => $val){
            $grupos[$key]['modulos'] = \App\ViewModuloUsuarioModel::select(DB::raw('DISTINCT nombremodulo, path, iconomodulo'))
            		->where(['idgrupomodulo'=>$val->idgrupomodulo,'usuario_idusuario'=> Auth::user()->idusuario])
            		->get();
        }
        
        return view('layouts.forms.menulateral',['datos'=> $grupos]);
    }
    
    public static function getTipousuarioUsuario($idusuario = NULL){
    	
    	if($idusuario == NULL){
    		$idusuario = Helpers::getParametros()['idusuario'];
    	}
    	$grupos= \App\UsuarioTipousuarioModel::select(DB::raw('distinct usuario_tipousuario.idusuario_tipousuario, usuario_tipousuario.usuario_idusuario, usuario_tipousuario.tipousuario_idtipousuario, tu.nombre as nombretipo'))
    				->join('tipousuario as tu','tu.idtipousuario','usuario_tipousuario.tipousuario_idtipousuario')
    				->where(['usuario_tipousuario.usuario_idusuario'=>$idusuario])
    				->get();
    	
    	return $grupos;
    }
    
    public static function getIdProfesorCurso($idprofesor,$idcurso,$idmateria){
    	$profesorcurso = \App\ProfesorCursoModel::where([
    		'profesor_idprofesor'=>$idprofesor,
    		'curso_idcurso'=>$idcurso,
    		'materia_idmateria'=>$idmateria,
    	])->get();
    	if(sizeof($profesorcurso)>0){
    		return $profesorcurso[0];
    	}
    	return false;
    }
    
    public static function isTipoUsuario($tipos){
    	
    	foreach($tipos as $tipo){
    	
	    	foreach (Helpers::getParametros()['tipousuario'] as $row){
	    		if($tipo == $row->idtipousuario){
	    			return true;
	    		}
	    	}
    	}
    	return false;
    	
    }
    
    public static function isRoot(){
    	return self::isTipoUsuario([1]);
    }
    public static function isAdmin(){
    	return self::isTipoUsuario([1,2]);
    }
    public static function isProfesor(){
    	return self::isTipoUsuario([3]);
    }
    public static function isAcudiente(){
    	return self::isTipoUsuario([4]);
    }
    
    public static function comprobarPermisosIdprofesorCurso($idprofesor_curso){
    	
    	if(self::isAdmin()) return true;
    	
    	$res = \App\ProfesorCursoModel::where(['idprofesor_curso'=>$idprofesor_curso,'profesor_idprofesor'=>self::getIdProfesor()])->count();
    	
    	return ($res>0)?true:false;
    }
    
    public static function comprobarPermisosIdprofesorIdCurso($profesor_idprofesor, $curso_idcurso){
    	
    	if(self::isAdmin()) return true;
    	
    	$res = \App\ProfesorCursoModel::where(['profesor_idprofesor'=>self::getIdProfesor(),'curso_idcurso'=>$curso_idcurso])->count();
    	
    	return ($res>0)?true:false;
    }
    
    public static function getInformeAcademicoPeriodo($idperiodo = NULL){
    	if($idperiodo == NULL){
    		$idperiodo = Helpers::getParametros()['idperiodo'];
    	}
    	return \App\InformeAcademicoModel::where('periodo_idperiodo',$idperiodo)->get();
    }
    
    public static function getIdProfesor(){
    	$profesor_usuario = \App\ProfesorUsuarioModel::where(['usuario_idusuario'=>Auth::user()->idusuario])->get();
    	if(sizeof($profesor_usuario)>0){
    		return $profesor_usuario[0]->profesor_idprofesor;
    	}
    	return false;
    }
    
    public static function cursoToGrado($idcurso){
    	$curso = \App\CursoModel::find($idcurso);
    	return $curso->grado_idgrado;
    }

}

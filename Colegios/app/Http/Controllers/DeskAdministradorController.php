<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Charts;
use DB;

class DeskAdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$profesores = \App\ViewProfesorInformacionPersonalModel::
    		where([
                    'estado'=>true
    		])->orderby('apellidos','ASC')
    		->get();
        foreach($profesores as  $key=>$val){
        	$profesores[$key]['cursos']=\App\ViewProfesorCurso2Model::where([
        			'profesor_idprofesor'=>$val->idprofesor
        	])->orderby('curso_idcurso','ASC')->get();
        	
        	if(sizeof($profesores[$key]['cursos'])>0){
        		foreach ($profesores[$key]['cursos'] as $ckey=>$cval){
        			
        			$profesores[$key]['cursos'][$ckey]['materias'] = \App\ViewProfesorCursoMateriaModel::where([
        					'profesor_idprofesor'=>$val->idprofesor,
        					'curso_idcurso'=>$cval->curso_idcurso
        			])->orderby('nombremateria','ASC')->get();
        			foreach ($profesores[$key]['cursos'][$ckey]['materias'] as $llavemateria=>$valormateria){
        				$profesores[$key]['cursos'][$ckey]['materias'][$llavemateria]['numeroevaluaciones'] = \App\EvaluacionModel::where([
        						'profesor_idprofesor'=>$val->idprofesor,
        						'curso_idcurso'=>$cval->curso_idcurso,
        						'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
        						'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
        						'materia_idmateria'=>$valormateria->materia_idmateria,
        				])->count();
        			}
        		}
        	}
        }
        
        ///MENSAJES
        $temp = \App\MensajeUsuarioModel::select(DB::raw('distinct mensaje_idmensaje'))
        ->where([//'usuario_idusuario'=>Auth::user()->idusuario,
        		'estado'=>'activo'])
        		->get();
        		
        $mensajes = array();
        if(sizeof($temp)>0){
       		foreach($temp as $mensaje){
      				$mensajes[]= \App\ViewMensajeTipomensajeModel::find($mensaje->mensaje_idmensaje);
        				
      			}
   		}
        		
        		
        return view('deskadministrador.index',['profesores'=>$profesores,'mensajes'=>$mensajes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

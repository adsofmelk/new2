<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class DeskAcudienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alumnos = \App\ViewAcudienteAlumnoModel::
        		where(['usuario_idusuario'=>Auth::user()->idusuario,
        				'estadocurso'=>'activo'
        		])
        		->get();
        
        foreach ($alumnos as $key=>$val){
        	
        	//DIRECCION DE CURSO
        	$alumnos[$key]['directorcurso'] = \App\ViewDirectorCursoModel::where(['curso_idcurso'=>$val->curso_idcurso])->limit(1)->get();
        	
        	//NUMERO TOTAL DE EVALUACIONES
        	$alumnos[$key]['totalevaluaciones'] = \App\EvaluacionDetalleModel::
        		where(['alumno_idalumno'=>$val->alumno_idalumno,
        				'estado'=>'activo',
        		])->count();
        		
        	//EVALUACIONES APROBADAS
        	$alumnos[$key]['evaluacionesaprovadas'] = \App\EvaluacionDetalleModel::
        		where(['alumno_idalumno'=>$val->alumno_idalumno,
        				'estado'=>'activo',
        		])
        		->where('nota','>=',\App\Helpers::getParametros()['notaaprovatoria'])
        		->count();
        		
        		//EVALUACIONES PERDIDAS
        		$alumnos[$key]['evaluacionesperdidas'] = \App\EvaluacionDetalleModel::
        		where(['alumno_idalumno'=>$val->alumno_idalumno,
        				'estado'=>'activo',
        		])
        		->where('nota','<',\App\Helpers::getParametros()['notaaprovatoria'])
        		->count();
        		
        		
        		//PROXIMAS EVALUACIONES
        		$alumnos[$key]['proximasevaluaciones'] = \App\ViewEvaluacionEstandarTipoCurMatModel::where([
        				'estado'=>'activo',
        				'curso_idcurso'=>$val->curso_idcurso,
        				'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
        				'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
        		])
        		->where('fechaevaluacion','>',date('Y-m-d'))
        		->get();
        		
        		
        		//ACUMULADO TOTAL DE FALLAS
        		$alumnos[$key]['acumuladofallas'] = \App\ViewAcumuladoFallasModel::select(DB::raw('sum(cantidad) as cantidad'))->where([
        				'alumno_idalumno'=>$val->alumno_idalumno,
        				'curso_idcurso'=>$val->curso_idcurso,
        				'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
        				'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
        		])->first();
        		
        		
        		///LISTADO DE MATERIAS
        		$alumnos[$key]['materias'] = \App\ViewProfesorCursoMateriaModel::where([
        				'curso_idcurso'=>$val->curso_idcurso,
        		])->orderBy('nombremateria','ASC')->get();
        		
        		foreach($alumnos[$key]['materias'] as $llave=>$valor){
        			$alumnos[$key]['materias'][$llave]['notas'] = \App\ViewEvaluacionDetalleModel::where([
        					'estado'=>'activo',
        					'alumno_idalumno'=>$val->alumno_idalumno,
        					'materia_idmateria'=>$valor->materia_idmateria,
        					'curso_idcurso'=>$val->curso_idcurso,
        					'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
        					'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
        					
        			])->get();
        			
        			$alumnos[$key]['materias'][$llave]['acumuladofallas'] = \App\ViewAcumuladoFallasModel::where([
        					'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
        					'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
        					'curso_idcurso'=>$val->curso_idcurso,
        					'materia_idmateria'=>$valor->materia_idmateria,
        					'alumno_idalumno'=>$val->alumno_idalumno,
        			])->first();
        			
        			$alumnos[$key]['materias'][$llave]['fallas'] = \App\FallasModel::where([
        					'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
        					'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
        					'curso_idcurso'=>$val->curso_idcurso,
        					'materia_idmateria'=>$valor->materia_idmateria,
        					'alumno_idalumno'=>$val->alumno_idalumno,
        					'estado'=>'activo',
        			])->get();
        		}
                        
        }
        
        ///MENSAJES
        $temp = \App\MensajeUsuarioModel::
                where(['usuario_idusuario'=>Auth::user()->idusuario,
                        'estado'=>'activo'])
                ->get();
        
        $mensajes = array();
        if(sizeof($temp)>0){
            foreach($temp as $mensaje){
                $mensajes[]= \App\ViewMensajeTipomensajeModel::find($mensaje->mensaje_idmensaje);

            }
            
        }
        
    	return view('deskacudiente.index',['alumnos'=>$alumnos,'mensajes'=>$mensajes]);
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

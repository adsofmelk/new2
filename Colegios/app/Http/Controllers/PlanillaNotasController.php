<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  \App\Helpers;
use DB;
class PlanillaNotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$idprodesor = \App\Helpers::getIdProfesor();
    	if($idprodesor!=false){
    		$cursos = \App\ViewProfesorCursoMateriaModel::select(DB::raw('distinct curso_idcurso,nombrecurso'))
    				->where(['profesor_idprofesor'=>$idprodesor,
    						'estadomateria'=>true,
    						'estadocurso'=>true
    				])->orderBy('curso_idcurso','ASC')
    				->get();
    				
    				foreach($cursos as $key => $val){
    					$cursos[$key]['materias'] = \App\ViewProfesorCursoMateriaModel::where(['curso_idcurso'=>$val['curso_idcurso'],
    							'estadomateria'=>true,
    							'profesor_idprofesor'=>$idprodesor,
    							'estadocurso'=>true])
    							->orderby('nombremateria')
    							->get();
    							
    				}
    				
    				
    	}else if(\App\Helpers::isAdmin()){
    		$cursos = \App\ViewProfesorCursoModel::select(DB::raw('distinct curso_idcurso,nombre as nombrecurso'))
    		->where([
    				'estado'=>true
    		])->orderBy('curso_idcurso','ASC')
    		->get();
    		
    		foreach($cursos as $key => $val){
    			$cursos[$key]['materias'] = \App\ViewProfesorCursoMateriaModel::where(['curso_idcurso'=>$val['curso_idcurso'],
    					'estadomateria'=>true,
    					'estadocurso'=>true])
    					->orderby('nombremateria')
    					->get();
    					
    		}
    		
    	}else{
    		Session::flash('error','No tiene asignados cursos');
    		return Redirect::to('/admin');
    	}
    	/*
    	foreach($cursos as $key => $val){
    		$cursos[$key]['materias'] = \App\ViewProfesorCursoMateriaModel::where(['curso_idcurso'=>$val['curso_idcurso'],
																    				'estadomateria'=>true,
																    				'estadocurso'=>true])
																    				->orderby('nombremateria')
																    				->get();
    																	
    	}*/
    	
        return view('planillasnotas.index',['cursos'=>$cursos]);
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
    	$profesor_curso = \App\ProfesorCursoModel::find($id);
    	
    	$datos['alumnos'] = \App\ViewAlumnosCursoModel::where(['curso_idcurso'=>$profesor_curso->curso_idcurso])
    				->get();

    	$datos['cabecera'] = \App\ViewProfesorCursoMateriaPersonaModel::where(['profesor_idprofesor'=>$profesor_curso->profesor_idprofesor,
    																			'curso_idcurso'=>$profesor_curso->curso_idcurso,
    																			'materia_idmateria'=>$profesor_curso->materia_idmateria
    															])->get();
    	$periodos = \App\PeriodoModel::where(['anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar']])->get();
    	
    	$tipoestandar = \App\TipoEstandarModel::where([
    			'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    			'estado'=>true,
    			'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    			'grado_idgrado'=>\App\Helpers::cursoToGrado($profesor_curso->curso_idcurso)
    	])->get();
    	
    	
		foreach($datos['alumnos'] as $key=>$val){
			$tempnotas = array();
			for($i = 0; $i<sizeof($periodos); $i++){
				$datos['alumnos'][$key]['notas'.($i+1).'p'] = \App\InformeAlumnoDetalleModel::where([
									'alumno_idalumno'=>$val->alumno_idalumno,
									'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
									'periodo_idperiodo'=>$periodos[$i]->idperiodo,
									'curso_idcurso'=>$profesor_curso->curso_idcurso,
									'materia_idmateria'=>$profesor_curso->materia_idmateria
						
				])->get();
				
				if(isset($datos['alumnos'][$key]['notas'.($i+1).'p'][0])){
					$tempnotas[] = $datos['alumnos'][$key]['notas'.($i+1).'p'][0]->nota;
				}
			}
			
			$datos['estandares']=array();
			
			foreach($tipoestandar as $tipokey=>$tipoval){
				$datos['alumnos'][$key][$tipoval->nombre]= DB::select('call getPromedioEstandar(?,?,?,?,?,?)',[
																					$datos['alumnos'][$key]['alumno_idalumno'],
																					$tipoval->idtipoestandar,
																					$profesor_curso->curso_idcurso,
																					\App\Helpers::getParametros()['idperiodo'],
																					\App\Helpers::getParametros()['idanioescolar'],
																					$profesor_curso->materia_idmateria
								]);
			}
			
			
			
			$datos['alumnos'][$key]['notasacar'] = (sizeof($tempnotas)>0)?number_format(\App\Helpers::getParametros()['notaaprovatoria'] + (\App\Helpers::getParametros()['notaaprovatoria']*sizeof($tempnotas))-(array_sum($tempnotas)),2):'';
			$datos['alumnos'][$key]['nf']=(sizeof($tempnotas)>0)?number_format((array_sum($tempnotas)/sizeof($tempnotas)),2):'';
			unset($tempnotas);
		}
    	
		
    	$planillanotas = new \App\Http\Controllers\PdfPlanillaNotasController($datos);
    	
    	
    	
    	return $planillanotas->planillaNotas($datos);
    	
    }
    
    
    /**
     * Muestra una planilla con promedios y puestos en el curso
     *
     * @param  int  $id id del curso
     * @return \Illuminate\Http\Response
     */
    public function planillaPuestosCurso($id){
    	//$profesor_curso = \App\ProfesorCursoModel::find($id);
    	
    	$datos['alumnos'] = \App\ViewInformeAlumnoDatosAlumnoModel::where(['curso_idcurso'=>$id])
    	->orderBy('promedio','DESC')
    	->get();
    	if(sizeof($datos['alumnos'])>0){
    		$curso = \App\CursoModel::find($id);
    		
    		
    		$datos['cabecera'] = ['promediocurso'=>$datos['alumnos'][0]->promediocurso,'nombrecurso'=>$curso->nombre];
    		
    		
    		$planillanotas = new \App\Http\Controllers\PdfPlanillaPuestoCursoController($datos);
    		
    		return $planillanotas->getPlanillaPuestoCurso($datos);
    	}
    	return "No data";
    	
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

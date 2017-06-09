<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \App\Helpers;

use Session;
use Redirect;

class EvaluacionCursoController extends Controller
{
	
	
	public function verDetalleEvaluacion($id){
		
		$parametros = \App\Helpers::getParametros();
		$evaluacion = \App\ViewEvaluacionEstandarTipoCurMatModel::find($id);
		if(sizeof($evaluacion)>0){
			
			if(!\App\Helpers::comprobarPermisosIdprofesorIdCurso($evaluacion->profesor_idprofesor,$evaluacion->curso_idcurso)){
				Session::flash('error','No posee permisos para acceder a la información solicitada');
				return Redirect::to('/admin');
			}
			
			$profesor = \App\ViewProfesorCursoMateriaPersonaModel::
			where(['profesor_idprofesor'=>$evaluacion->profesor_idprofesor,
					'curso_idcurso'=>$evaluacion->curso_idcurso,
					'materia_idmateria'=>$evaluacion->materia_idmateria
			])->get();
			
			$alumnos = \App\ViewEvaluacionDetalleAlumnoPersonaModel::where(['evaluacion_idevaluacion'=>$id])->get();
			
			$alumnosnuevos = \App\ViewAlumnosCursoModel::where([
					'estado'=>'activo',
					'curso_idcurso'=>$evaluacion->curso_idcurso,
			])
			->whereNotIn('alumno_idalumno',
					\App\EvaluacionDetalleModel::select(DB::raw('distinct alumno_idalumno'))->where(['evaluacion_idevaluacion'=>$evaluacion->idevaluacion])->get()
					)
					->get();
			
			return view('evaluacioncurso.view',['evaluacion'=>$evaluacion,
					'alumnos'=>$alumnos,'profesor'=>$profesor[0],
					'alumnosnuevos'=>$alumnosnuevos,
					'profesor_curso'=>\App\Helpers::getIdProfesorCurso($evaluacion->profesor_idprofesor,$evaluacion->curso_idcurso,$evaluacion->materia_idmateria),
			]);
		}
		
		
	}
	
	public function nuevaEvaluacion($id)
	{
		if(!\App\Helpers::comprobarPermisosIdprofesorCurso($id)){
			Session::flash('error','No posee permisos para acceder a la información solicitada');
			return Redirect::to('/admin');
		}
		
		$parametros = \App\Helpers::getParametros();
		$profesor_curso = \App\ProfesorCursoModel::find($id);
		
		$tipoevaluacion = \App\TipoEvaluacionModel::orderBy('nombre','ASC')
						->pluck('nombre','idtipoevaluacion');
		
		$curso = \App\CursoModel::find($profesor_curso->curso_idcurso);
		
		$profesorcursomateria = \App\ViewProfesorCursoMateriaPersonaModel::where(['profesor_idprofesor'=>$profesor_curso->profesor_idprofesor,
				'curso_idcurso'=>$profesor_curso->curso_idcurso,
				'materia_idmateria'=>$profesor_curso->materia_idmateria,
		])->get();
		
		$tipoestandar = \App\TipoEstandarModel::select(DB::raw("distinct concat(nombre, ' [ ',porcentaje, ' ]' ) as nombre, idtipoestandar"))
						->where(['anioescolar_idanioescolar'=>$parametros['idanioescolar'],
								'periodo_idperiodo'=>$parametros['idperiodo'],
								'grado_idgrado'=>$curso->grado_idgrado,
								'estado'=>true
						])
						->orderBy('nombre','ASC')
						->pluck('nombre','idtipoestandar');
						
		$alumnos = \App\ViewAlumnosCursoModel::where([
												'curso_idcurso'=>$curso->idcurso,
												'estadoalumno'=>'activo',
												
											])->get();
		
		Return view('evaluacioncurso.create',['tipoestandar'=>$tipoestandar,
												'tipoevaluacion'=>$tipoevaluacion,
												'parametros'=>$parametros,
												'profesor_curso'=>$profesor_curso,
												'curso'=>$curso,
												'alumnos'=>$alumnos,
												'profesorcursomateria'=>$profesorcursomateria[0],
												'alumnosnuevos'=>null
		]);
												
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	
        return view('evaluacioncurso.show');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
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
    	if(!\App\Helpers::comprobarPermisosIdprofesorIdCurso($request['profesor_idprofesor'],$request['curso_idcurso'])){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	$parametros = Helpers::getParametros();
    	
    	$evaluacion = ['fechaevaluacion'=>($request['fechaevaluacion']!='')?$request['fechaevaluacion']:date('Y-m-d'),
    					'porcentaje'=>0,
    					'detalle'=>$request['detalle'],
    					'estado'=>'activo',
    					'tipoestandar_idtipoestandar'=>$request['tipoestandar_idtipoestandar'],
    					'curso_idcurso'=>$request['curso_idcurso'],
    					'periodo_idperiodo'=>$parametros['idperiodo'],
    					'anioescolar_idanioescolar'=>$parametros['idanioescolar'],
    					'tipoevaluacion_idtipoevaluacion'=>$request['tipoevaluacion_idtipoevaluacion'],
    					'materia_idmateria'=>$request['materia_idmateria'],
    					'profesor_idprofesor'=>$request['profesor_idprofesor']
    	];
    	
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		$evaluacion = \App\EvaluacionModel::create($evaluacion);
    		
    		foreach ($request['datos'] as $row){
    			
    			$notasalumno['alumno_idalumno']= $row[0];
    			$notasalumno['evaluacion_idevaluacion']= $evaluacion->idevaluacion;
    			$notasalumno['estado']='activo';
    			
    			if($row[1]!=''){
    				$notasalumno['nota']=abs(floatval(preg_replace("/[^0-9.]/", "", str_replace(',', '.',$row[1]))));
    				$notasalumno['nota'] = (($notasalumno['nota']>$parametros['notamaxima']) || ($notasalumno['nota']<$parametros['notaminima']))?0:$notasalumno['nota'];
    				$notasalumno['observaciones'] = $row[2];
    				
    				\App\EvaluacionDetalleModel::create($notasalumno);
    			}
    			
    		}
    		
    		DB::commit();
    		Session::flash("message","Notas Guardadas");
    		
    		
    	} catch (Exception $ex) {
    		Session::flash("error","Error Almacenando Notas");
    		
    	}
    	return Redirect('/evaluacioncurso/verdetalle/'.$evaluacion->idevaluacion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verNotasAcumuladasCursoMateria($id)
    {
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($id)){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	return view('evaluacioncurso.notasacumuladascursomateria',$this->helperNotasAcumuladasCursoMatria($id));
    }
    
    public function verNotasAcumuladasCursoMateriaModal($id)
    {
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($id)){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	
    	return view('evaluacioncurso.forms.detallenotasacumuladas',$this->helperNotasAcumuladasCursoMatria($id));
    }
    
    
    public function helperNotasAcumuladasCursoMatria($id){
    	$profesor_curso = \App\ProfesorCursoModel::find($id);
    	
    	
    	$profesorcursomateria = \App\ViewProfesorCursoMateriaPersonaModel::where(['profesor_idprofesor'=>$profesor_curso->profesor_idprofesor,
    			'curso_idcurso'=>$profesor_curso->curso_idcurso,
    			'materia_idmateria'=>$profesor_curso->materia_idmateria,
    	])->get();
    	
    	$where = ['curso_idcurso'=>$profesor_curso->curso_idcurso,
    			'materia_idmateria'=>$profesor_curso->materia_idmateria,
    			'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    			'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    			'deleted_at'=>null];
    	
    	if(!Helpers::isAdmin()){
    		$where['profesor_idprofesor']=\App\Helpers::getIdProfesor();
    	}
    	
    	$evaluaciones = \App\ViewEvaluacionEstandarTipoCurMatModel::where($where)->orderBy('idevaluacion','ASC')->get();
    	
    	$tipoestandar = \App\TipoEstandarModel::where(
    			['periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    					'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    					'grado_idgrado'=>$profesorcursomateria[0]->grado_idgrado
    			])->get();
    			
    	$alumnos = \App\ViewAlumnosCursoModel::where(['curso_idcurso'=>$profesor_curso->curso_idcurso,
    					'estadoalumno'=>'activo'])
    					->orderBy('ordenlista','ASC')->get();
    					
    	foreach ($alumnos as $key=>$val){
    		$alumnos[$key]['evaluaciones'] = \App\ViewEvaluaciondetalleAlumnoModel::where(['curso_idcurso'=>$profesor_curso->curso_idcurso,
    								'materia_idmateria'=>$profesor_curso->materia_idmateria,
    								'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    								'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    								'alumno_idalumno'=>$val->alumno_idalumno,
    						])->orderBy('evaluacion_idevaluacion','ASC')->get();
    						
    						
    	}
    	
    	return ['profesor_curso'=>$profesor_curso,'evaluaciones'=>$evaluaciones,
    			'alumnos'=>$alumnos,'tipoestandar'=>$tipoestandar,
    			'profesorcursomateria'=>$profesorcursomateria[0]];
    }
    
    
    public function progresoEvaluacionEstandares($id){
    	
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($id)){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	
    	$profesor_curso = \App\ViewProfesorCursoMateriaModel::where(['idprofesor_curso'=>$id])->first();
    	
    	
    	if(sizeof($profesor_curso)>0){
    		
    		$estandares = \App\TipoEstandarModel::where([
    				'grado_idgrado'=>$profesor_curso->grado_idgrado,
    				'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    				'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    		])->get();
    		if(sizeof($estandares)>0){
    			foreach($estandares as $key=>$val){
    				$estandares[$key]['evaluado'] = \App\EvaluacionModel::where([
    						'tipoestandar_idtipoestandar'=>$val->idtipoestandar,
    						'curso_idcurso'=>$profesor_curso->curso_idcurso,
    						'materia_idmateria'=>$profesor_curso->materia_idmateria,
    						'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    						'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    				])->count();
    				
    			}
    		}
    		
    	}
    	
    	return view('evaluacioncurso.forms.progresoevaluacionestandares',['profesor_curso'=>$profesor_curso,'estandares'=>$estandares]);
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($id)){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	$profesor_curso = \App\ProfesorCursoModel::find($id);
    	
    	
    	$profesorcursomateria = \App\ViewProfesorCursoMateriaPersonaModel::where(['profesor_idprofesor'=>$profesor_curso->profesor_idprofesor,
    								'curso_idcurso'=>$profesor_curso->curso_idcurso,
    								'materia_idmateria'=>$profesor_curso->materia_idmateria,
    						])->get();
    	
    	$where = ['curso_idcurso'=>$profesor_curso->curso_idcurso,
    			'materia_idmateria'=>$profesor_curso->materia_idmateria,
    			'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    			'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    			'deleted_at'=>null];
    	
    	if(!Helpers::isAdmin()){
    		$where['profesor_idprofesor']=\App\Helpers::getIdProfesor();
    	}
    	
    	$evaluaciones = \App\ViewEvaluacionEstandarTipoCurMatModel::where($where)->get();
    	
    	
    	
    	return view('evaluacioncurso.show',['profesor_curso'=>$profesor_curso,'evaluaciones'=>$evaluaciones,
    								'profesorcursomateria'=>$profesorcursomateria[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {	
    	$parametros = \App\Helpers::getParametros();
    	$evaluacion = \App\EvaluacionModel::find($id);
    	
    	if(!\App\Helpers::comprobarPermisosIdprofesorIdCurso($evaluacion->profesor_idprofesor,$evaluacion->curso_idcurso)){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	$profesor_curso = \App\ProfesorCursoModel::where(['profesor_idprofesor'=>$evaluacion->profesor_idprofesor,
    													'materia_idmateria'=>$evaluacion->materia_idmateria,
    													'curso_idcurso'=>$evaluacion->curso_idcurso
    	])->get();
    	$profesor_curso = $profesor_curso[0];
    	
    	$curso = \App\CursoModel::where(['idcurso'=>$evaluacion->curso_idcurso])->get();
    	
    	$tipoevaluacion = \App\TipoEvaluacionModel::orderBy('nombre','ASC')
    	->pluck('nombre','idtipoevaluacion');
    	$profesorcursomateria = \App\ViewProfesorCursoMateriaPersonaModel::where(['profesor_idprofesor'=>$evaluacion->profesor_idprofesor,
    			'curso_idcurso'=>$evaluacion->curso_idcurso,
    			'materia_idmateria'=>$evaluacion->materia_idmateria,
    	])->limit(1)->get();
    	
    	$tipoestandar = \App\TipoEstandarModel::select(DB::raw("distinct concat(nombre, ' [ ',porcentaje, ' ]' ) as nombre, idtipoestandar"))
    	->where(['anioescolar_idanioescolar'=>$parametros['idanioescolar'],
    			'periodo_idperiodo'=>$parametros['idperiodo'],
    			'grado_idgrado'=>$curso[0]->grado_idgrado,
    			'estado'=>true
    	])
    	->orderBy('nombre','ASC')
    	->pluck('nombre','idtipoestandar');
    	
    	$alumnos = \App\ViewEvaluacionDetalleAlumnoPersonaModel::where(['evaluacion_idevaluacion'=>$evaluacion->idevaluacion])->get();
    	
    	
    	
    	$alumnosnuevos = \App\ViewAlumnosCursoModel::where([
    			'estado'=>'activo',
    			'curso_idcurso'=>$evaluacion->curso_idcurso,
    		])
    		->whereNotIn('alumno_idalumno',
    				\App\EvaluacionDetalleModel::select(DB::raw('distinct alumno_idalumno'))->where(['evaluacion_idevaluacion'=>$evaluacion->idevaluacion])->get()
			)
    		->get();
    	

        
    	return view('evaluacioncurso.edit',['evaluacion'=>$evaluacion,'profesorcursomateria'=>$profesorcursomateria[0],
    				'tipoestandar'=>$tipoestandar, 'tipoevaluacion'=>$tipoevaluacion,
    				'alumnos'=>$alumnos,'profesor_curso'=>$profesor_curso,
    				'alumnosnuevos'=>$alumnosnuevos,
    	]);
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
    	
    	
    	
    	try{
    		
    		DB::beginTransaction();
    		
    		$parametros = Helpers::getParametros();
    		$evaluacion = \App\EvaluacionModel::find($id);
    		
    		if(!\App\Helpers::comprobarPermisosIdprofesorIdCurso($evaluacion->profesor_idprofesor,$evaluacion->curso_idcurso)){
    			Session::flash('error','No posee permisos para acceder a la información solicitada');
    			return Redirect::to('/admin');
    		}
    		
    		$evaluacion->fechaevaluacion= $request['fechaevaluacion'];
    		$evaluacion->detalle= $request['detalle'];
    		$evaluacion->tipoestandar_idtipoestandar=$request['tipoestandar_idtipoestandar'];
    		$evaluacion->tipoevaluacion_idtipoevaluacion = $request['tipoevaluacion_idtipoevaluacion'];
    		
    		
    		$evaluacion->save();
    		
    		if(isset($request['datos'])){
    			foreach ($request['datos'] as $row){
    				$evaluaciondetalle = \App\EvaluacionDetalleModel::find($row[3]);
    				if(sizeof($evaluaciondetalle)>0){
    					$evaluaciondetalle->nota = abs(floatval(preg_replace("/[^0-9.]/", "", str_replace(',', '.',$row[1]))));
    					$evaluaciondetalle->nota= (($evaluaciondetalle->nota>$parametros['notamaxima']) || ($evaluaciondetalle->nota<$parametros['notaminima']))?0:$evaluaciondetalle->nota;
    					$evaluaciondetalle->observaciones = $row[2];
    					
    					$evaluaciondetalle->save();
    				}
    				
    			}
    		}
    		
    		
    		
    		//ALUMNOS NUEVOS
    		if(isset($request['datosnuevos'] )){
    			
    		
	    		foreach ($request['datosnuevos'] as $row){
	    			$notasalumno['alumno_idalumno']= $row[0];
	    			$notasalumno['evaluacion_idevaluacion']= $evaluacion->idevaluacion;
	    			$notasalumno['estado']='activo';
	    			
	    			if($row[1]!=''){
	    				$notasalumno['nota']=abs(floatval(preg_replace("/[^0-9.]/", "", str_replace(',', '.',$row[1]))));
	    				$notasalumno['nota'] = (($notasalumno['nota']>$parametros['notamaxima']) || ($notasalumno['nota']<$parametros['notaminima']))?0:$notasalumno['nota'];
	    				$notasalumno['observaciones'] = $row[2];
	    				
	    				\App\EvaluacionDetalleModel::create($notasalumno);
	    			}
	    			
	    			
	    		}
    		}
    		DB::commit();
    		Session::flash("message","Notas Guardadas");
    		
    		
    	} catch (Exception $ex) {
    		Session::flash("error","Error Almacenando Notas");
    		
    	}
    	return Redirect('/evaluacioncurso/verdetalle/'.$evaluacion->idevaluacion);
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

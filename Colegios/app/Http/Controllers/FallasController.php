<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \App\Helpers;
use Session;
class FallasController extends Controller
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
    		
    	} else if(\App\Helpers::isAdmin()){
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
    	
    	
    	
    	return view('fallas.index',['cursos'=>$cursos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFalla($idalumno,$idprofesor_curso)
    {
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($idprofesor_curso)){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	
    	$profesor_curso = \App\ProfesorCursoModel::find($idprofesor_curso);
    	
    	
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
    	
    	
    	$alumno = \App\ViewAlumnoInformacionPersonalModel::where(['idalumno'=>$idalumno])->limit(1)->get();
    	
    		
    	return view("fallas.create",['falla'=>new Falla($idalumno,$idprofesor_curso,$profesor_curso->curso_idcurso,$profesor_curso->materia_idmateria),'alumno'=>$alumno[0], 'profesor_curso'=> $profesor_curso, 'profesorcursomateria'=>$profesorcursomateria[0]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($request['profesor_curso_idprofesor_curso'])){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	try{
    		
    		DB::beginTransaction();
    		$fallas = \App\FallasModel::where([
    				'fecha'=>date('Y-m-d'),
    				'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    				'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    				'curso_idcurso'=>$request['curso_idcurso'],
    				'materia_idmateria'=>$request['materia_idmateria'],
    				'alumno_idalumno'=>$request['alumno_idalumno'],
    				'profesor_curso_idprofesor_curso'=>$request['profesor_curso_idprofesor_curso']
    		])->get();
    		if(sizeof($fallas)>0){
    			$fallas = \App\FallasModel::find($fallas[0]->idfallas);
    			$fallas->numerohoras++;
    			$fallas->save();
    		}else{
    			\App\FallasModel::create($request->all());
    		}
    		
    		
    		DB::commit();
    		Session::flash("message","Falla Registrada!");
    		return Redirect("/fallas/".$request['profesor_curso_idprofesor_curso']);
    		
    	} catch (Exception $ex) {
    		Session::flash("error","Error Registrando falla");
    		DB::rollBack();
    		return Redirect('/fallas');
    	}
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
    	
    			
    	$alumnos = \App\ViewAlumnosCursoModel::where(['curso_idcurso'=>$profesor_curso->curso_idcurso,
    					'estadoalumno'=>'activo'])
    					->orderBy('ordenlista','ASC')->get();
    					
    	foreach ($alumnos as $key=>$val){
    			$alumnos[$key]['fallas'] = \App\ViewAcumuladoFallasModel::where(['curso_idcurso'=>$profesor_curso->curso_idcurso,
    						'materia_idmateria'=>$profesor_curso->materia_idmateria,
    						'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    						'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    						'alumno_idalumno'=>$val->alumno_idalumno,
    						])->get();
    						
    						$alumnos[$key]['fallashoy'] = \App\FallasModel::select(DB::raw('sum(numerohoras) as fallashoy'))
    								->where(['curso_idcurso'=>$profesor_curso->curso_idcurso,
    								'materia_idmateria'=>$profesor_curso->materia_idmateria,
    								'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo'],
    								'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    								'alumno_idalumno'=>$val->alumno_idalumno,
    								'fecha'=>(date('Y-m-d'))
    						])->get();
    						
    	}
    					
    	return view('fallas.show',['profesor_curso'=>$profesor_curso,
    							'alumnos'=>$alumnos,
    							'profesorcursomateria'=>$profesorcursomateria[0]]);
    }
    
    public function verDetalle($idalumno,$idprofesor_curso){
    	
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($idprofesor_curso)){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	
    	$profesor_curso = \App\ProfesorCursoModel::find($idprofesor_curso);
    	
    	
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
    	
    	
    	$alumno = \App\ViewAlumnoInformacionPersonalModel::where(['idalumno'=>$idalumno])->limit(1)->get();
    	
    	$fallas = \App\FallasModel::where([
    			'alumno_idalumno'=>$idalumno,
    			'profesor_curso_idprofesor_curso'=>$idprofesor_curso,
    			'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
    			'periodo_idperiodo'=>\App\Helpers::getParametros()['idperiodo']
    	])->get();
    	
    	
    	
    	return view("fallas.detalle",['fallas'=>$fallas, 'alumno'=>$alumno[0], 'profesor_curso'=> $profesor_curso, 'profesorcursomateria'=>$profesorcursomateria[0]]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $falla = \App\FallasModel::find($id);
        $alumno = \App\ViewAlumnoInformacionPersonalModel::
        	where(['idalumno'=>$falla->alumno_idalumno])
        	->get();
        
        $profesorcursomateria = \App\ViewProfesorCursoMateriaPersonaModel::
        		where([
        				'idprofesor_curso'=>$falla->profesor_curso_idprofesor_curso
        		])
        		->get();
        return view('fallas.edit',['falla'=>$falla,
        							'alumno'=>$alumno[0],
        							'profesorcursomateria'=>$profesorcursomateria[0],
        							'profesor_curso'=>\App\ProfesorCursoModel::find($falla->profesor_curso_idprofesor_curso),
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
    	if(!\App\Helpers::comprobarPermisosIdprofesorCurso($request['idprofesor_curso'])){
    		Session::flash('error','No posee permisos para acceder a la información solicitada');
    		return Redirect::to('/admin');
    	}
    	
    	try{
    		
    		DB::beginTransaction();
    	
    		$falla =\App\FallasModel::find($id);
    		$falla->fecha = $request['fecha'];
    		$falla->numerohoras = $request['numerohoras'];
    		$falla->observaciones =$request['observaciones'];
    		$falla->save();
    		
    		DB::commit();
    		Session::flash("message","Falla Actualizada!");
    		return Redirect("/detallefallas/".$request['idalumno']."/".$request['idprofesor_curso']);
    		
    	} catch (Exception $ex) {
    		Session::flash("error","Error Registrando falla");
    		DB::rollBack();
    		return Redirect('/fallas');
    	}
    	
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


class Falla{
	public $alumno_idalumno;
	public $profesor_curso_idprofesor_curso;
	public $fecha;
	public $numerohoras;
	public $anioescolar_idanioescolar;
	public $periodo_idperiodo;
	public $curso_idcurso;
	public $materia_idmateria;
	public $estado;
	public $observaciones;
	
	
	function __construct($alumno_idalumno,$profesor_curso_idprofesor_curso,$curso_idcurso,$materia_idmateria){
		$this->alumno_idalumno=$alumno_idalumno;
		$this->profesor_curso_idprofesor_curso = $profesor_curso_idprofesor_curso;
		$this->fecha = date('Y-m-d');
		$this->numerohoras = 1;
		$this->anioescolar_idanioescolar = \App\Helpers::getParametros()['idanioescolar'];
		$this->periodo_idperiodo = \App\Helpers::getParametros()['idperiodo'];
		$this->curso_idcurso = $curso_idcurso;
		$this->materia_idmateria = $materia_idmateria;
		$this->estado='activo';
		$this->observaciones='';
	}
}
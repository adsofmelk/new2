<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Redirect;
use Illuminate\Contracts\View\View;
use App\Helpers;

class InformeAcademicoController extends Controller
{
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$cursos = \App\CursoModel::where('estado','=',true)->get();
    	
    	$periodos = \App\PeriodoModel::where(['anioescolar_idanioescolar'=>Helpers::getParametros()['idanioescolar']])
    									->get();
    	
    	foreach($periodos as $key=>$value){
    		if($value->idperiodo == Helpers::getParametros()['idperiodo']){
    			$periodos[$key]['estadoperiodo']='activo';
    			foreach($cursos as $llave=>$curso){
    				$cursos[$llave]['entregados'] = \App\ViewMateriasInformesEntregadosModel::where([
    						'view_materiasinformesentregados.curso_idcurso'=>$curso->idcurso,
    						'view_materiasinformesentregados.anioescolar_idanioescolar'=>Helpers::getParametros()['idanioescolar'],
    						'view_materiasinformesentregados.periodo_idperiodo'=>Helpers::getParametros()['idperiodo'],
    				])
    				->get();
    				$cursos[$llave]['faltantes'] = \App\ViewMateriasInformesFaltantesModel::where('view_materiasinformesfaltantes.curso_idcurso','=',$curso->idcurso)->get();
    			}
    			
    			$periodos[$key]['cursos']=$cursos;
    			
    		}else{
    			
    			$temp = \App\InformeAcademicoModel::where(['estado'=>'cerrado',
	    					'informeacademico.anioescolar_idanioescolar'=>Helpers::getParametros()['idanioescolar'],
	    					'informeacademico.periodo_idperiodo'=>$value->idperiodo,
	    					'deleted_at'=>null,
	    			])
	    			->get();
	    		if(sizeof($temp)>0){
	    			$periodos[$key]['estadoperiodo']='cerrado';
	    			$periodos[$key]['cursos']= $cursos;
	    		}else{
	    			unset($periodos[$key]);
	    		}
    		}
    	}
    	
    	return view("informeacademico.index2",['periodos'=>$periodos]);
    	
    	
    	/*
        $informeacaemico = \App\InformeAcademicoModel::join('periodo','idperiodo','=','informeacademico.periodo_idperiodo')
                            ->select(DB::raw('periodo.nombre,periodo.idperiodo,informeacademico.*'))
                            ->where('estado','=','activo')
                        ->limit(1)->get();
        if(sizeof($informeacaemico)==0){
        	
        	$informeacaemico = \App\InformeAcademicoModel::join('periodo','idperiodo','=','informeacademico.periodo_idperiodo')
        	->select(DB::raw('periodo.nombre,periodo.idperiodo,informeacademico.*'))
        	->where('estado','!=','activo')
        	->limit(1)->get();
        	
        	return view("informeacademico.indexperiodocerrado",["informeacademico"=>$informeacaemico,'cursos'=>$cursos]);
        }else{
        	foreach($cursos as $key=>$curso){
        		$cursos[$key]['entregados'] = \App\ViewMateriasInformesEntregadosModel::where('view_materiasinformesentregados.curso_idcurso','=',$curso->idcurso)->get();
        		$cursos[$key]['faltantes'] = \App\ViewMateriasInformesFaltantesModel::where('view_materiasinformesfaltantes.curso_idcurso','=',$curso->idcurso)->get();
        	}
        	
        	return view("informeacademico.index",["informeacademico"=>$informeacaemico,
        			'cursos'=>$cursos]);
        	
        }
                        
        */
        
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
        return view('informeacademico.show',['id'=>$id]);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            
            DB::beginTransaction();
            
            //0. consultar datos de periodo a cerrar
            $informeacademico = \App\InformeAcademicoModel::find($id);
            if($informeacademico->estado!='activo'){
                DB::rollBack();
                Session::flash("message-error","No puede realizarse el cierre del periodo. El periodo no esta activo!");
                return Redirect('/informeacademico');
            }
            
            
            $informesprevios = \App\InformeAlumnoModel::where(
						[	"anioescolar_idanioescolar"=>$informeacademico->anioescolar_idanioescolar,
							"periodo_idperiodo"=>$informeacademico->periodo_idperiodo
							]
						)->get();
            		
			foreach($informesprevios as $informe){
				$inf = \App\InformeAlumnoModel::find($informe->idinforme_alumno);
				$inf->estado="borrado";
				$inf->delete();
			}
            
            
            //1. consultar cursos a procesar y prodedio de cada curso
            
            $promediosCurso = \App\ViewPromedioCursoModel::
                    where("anioescolar_idanioescolar","=",$informeacademico->anioescolar_idanioescolar)
                    ->where("periodo_idperiodo","=",$informeacademico->periodo_idperiodo)
                    ->orderBy('promedio','DESC')
                     ->get();
            $puestocurso=1;
            foreach($promediosCurso as $curso){
                
                $promediosAlumnos = \App\ViewPromedioAlumnoModel::
                        where("anioescolar_idanioescolar","=",$informeacademico->anioescolar_idanioescolar)
                        ->where("periodo_idperiodo","=",$informeacademico->periodo_idperiodo)
                        ->where("curso_idcurso","=",$curso['curso_idcurso'])
                        ->orderBy("promedio","DESC")
                        ->get();
                
                        
                        
                $puestoalumno = 1;
                foreach($promediosAlumnos as $alumno){
                    
            //2. Guardar cada entrada de alumno por curso con sus respetivos promedios
            
            //2.1 Asegurarse que no hay registro previos (en caso que el perioso haya sido reabierto)
             
                	
		             
		            \App\InformeAlumnoModel::create(
                            ["anioescolar_idanioescolar"=>$informeacademico->anioescolar_idanioescolar,
                             "periodo_idperiodo"=>$informeacademico->periodo_idperiodo,
                             "curso_idcurso"=>$curso['curso_idcurso'],
                             "alumno_idalumno"=>$alumno["alumno_idalumno"],
                             "profesor_idprofesor"=>1,
                             "informeacademico_idinformeacademico"=>$id,
                             'promedio'=>$alumno['promedio'],
                            'promediocurso'=>$curso['promedio'],
                            'puestocurso'=>$puestoalumno,
                            'puestogrado'=>$puestocurso,
                            'estado'=>"activo",
                        ]);
                    $puestoalumno++;
                }//fin foreach alumno
                $puestocurso++;
                
            }//fin foreach curso
            
            
            //2.5 Actualizar con puesto en el colegio
            
            $rangos = [[1,2,3],[4,5,6,7,8],[9,10,11,12,13,14]];
            foreach ($rangos as $rango){
            
            	$promediosAlumnos = \App\ViewPromedioAlumnoModel::
            	where("anioescolar_idanioescolar","=",$informeacademico->anioescolar_idanioescolar)
            	->where("periodo_idperiodo","=",$informeacademico->periodo_idperiodo)
            	->whereIn('curso_idcurso',$rango)
            	->orderBy("promedio","DESC")
            	->get();
            	
            	$puestoalumno = 1;
            	foreach($promediosAlumnos as $alumno){
            		$temp = \App\InformeAlumnoModel::where(["anioescolar_idanioescolar"=>$informeacademico->anioescolar_idanioescolar,
            				"periodo_idperiodo"=>$informeacademico->periodo_idperiodo,
            				"alumno_idalumno"=>$alumno["alumno_idalumno"],
            				"profesor_idprofesor"=>1,
            				"informeacademico_idinformeacademico"=>$id])->get();
            		$temp = \App\InformeAlumnoModel::find($temp[0]->idinforme_alumno);
            		$temp->puestocolegio = $puestoalumno;
            		$temp->save();
            		$puestoalumno++;
            	}
            }
            
            
            //3. Actualizar estado del informe academico
            
            
            $informeacademico->update(['estado'=>'cerrado']);
            
            //4. actualizar estado de informe_alumno_detalle
            
            DB::table('informe_alumno_detalle')
                    ->where("anioescolar_idanioescolar","=",$informeacademico->anioescolar_idanioescolar)
                    ->where("periodo_idperiodo","=",$informeacademico->periodo_idperiodo)
                    ->where('estado',"=",true)
                    ->update(['estado'=>false]);
            
            
            DB::commit();
            Session::flash("message","Cierre del periodo exitoso!");
            return Redirect('/informeacademico');
        
        } catch (Exception $ex) {
            Session::flash("error","Error cerrando el periodo");
            return Redirect('/informeacademico');
        }
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}

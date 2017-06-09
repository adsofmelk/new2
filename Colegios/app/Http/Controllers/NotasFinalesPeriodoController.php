<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Session;
use App\Helpers;
class NotasFinalesPeriodoController extends Controller
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
        //
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
        $parametros = Helpers::getParametros();
        
        $notasalumno = array(
            'materia_idmateria'=>$request['idmateria'],
            'curso_idcurso'=>$request['idcurso'],
            'periodo_idperiodo'=>$parametros['idperiodo'],
            'anioescolar_idanioescolar'=>$parametros['idanioescolar'],
            'estado'=>true,
                
        );
        try{
            
            DB::beginTransaction();
            
            
            foreach ($request['datos'] as $row){
                $alumno = DB::table('alumno_curso')->select("alumno_curso.alumno_idalumno")
                                                ->where("alumno_curso.codigolista","=",$row[0])
                                                ->where("curso_idcurso","=",$request['idcurso'])->get();

                $notasalumno['alumno_idalumno']= $alumno[0]->alumno_idalumno;
                
                $notasalumno['nota']=abs(floatval(preg_replace("/[^0-9.]/", "", str_replace(',', '.',$row[1]))));
                //$notasalumno['nota'] = (($notasalumno['nota']>$parametros['notamaxima']) || ($notasalumno['nota']<$parametros['notaminima']))?$parametros['notaminima']:$notasalumno['nota'];
                
                    
                $fallas = abs(intval(preg_replace("/[^0-9]/", "",$row[2])));
                $notasalumno['fallas']=($fallas==0)?null:$fallas;
                
                \App\InformeAlumnoDetalleModel::create($notasalumno);
                
                
            }
            
            DB::commit();
            Session::flash("message","Notas Guardadas");
            
        
        } catch (Exception $ex) {
            Session::flash("error","Error Almacenando Notas");
            
        }
        return Redirect('/curso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parametros = Helpers::getParametros();
        $profesor_curso = \App\ProfesorCursoModel::find($id);
        
        $notasalumnos = DB::table('view_informealumnodetalle as vi')
                ->select(DB::raw('vi.idinforme_alumno_detalle,vi.codigolista,vi.nombres, vi.apellidos,  vi.nota, vi.fallas, vi.estadoalumno'))
                ->join('profesor_curso as pc','pc.curso_idcurso','=','vi.curso_idcurso')
                ->where([
                        'pc.idprofesor_curso'=>$id,
                        'vi.periodo_idperiodo'=> $parametros['idperiodo'],
                        'vi.anioescolar_idanioescolar'=> $parametros['idanioescolar']])
                ->whereColumn('pc.materia_idmateria','vi.materia_idmateria')
                ->get();
                
        if(sizeof($notasalumnos)>0){
            Return view('notasfinalesperiodo.show',['notasalumnos'=>$notasalumnos,'profesor_curso'=>$profesor_curso]);
        }else{
            Session::flash('message-error','No se pudo recuperar información del curso seleccionado');   
            Return view('curso.index');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parametros = Helpers::getParametros();
        
        $profesor_curso = \App\ProfesorCursoModel::find($id);
        
        $notasalumnos = DB::table('view_informealumnodetalle as vi')
                ->select(DB::raw('vi.idinforme_alumno_detalle,vi.codigolista,vi.nombres, vi.apellidos,  vi.nota, vi.fallas, vi.estadoalumno'))
                ->join('profesor_curso as pc','pc.curso_idcurso','=','vi.curso_idcurso')
                ->where([
                        'pc.idprofesor_curso'=>$id,
                        'vi.periodo_idperiodo'=> $parametros['idperiodo'],
                        'vi.anioescolar_idanioescolar'=> $parametros['idanioescolar']])
                ->whereColumn('pc.materia_idmateria','vi.materia_idmateria')
                ->get();
                
                
        if(sizeof($notasalumnos)>0){
            Return view('notasfinalesperiodo.update',['notasalumnos'=>$notasalumnos]);
        }else{
            
            $notasalumnos = \App\ViewAlumnosCursoModel::
                            select(DB::raw("codigolista,nombres, apellidos, '' as notas, '' as fallas, estadoalumno"))                    
                            ->join('profesor_curso as pc','pc.curso_idcurso','=','view_alumnoscurso.curso_idcurso')
                            ->where(['pc.idprofesor_curso'=>$id])->get();
            
            Return view('notasfinalesperiodo.create',[
                    'notasalumnos'=>$notasalumnos,
                    'materia_idmateria'=>$profesor_curso->materia_idmateria,
                    'curso_idcurso'=>$profesor_curso->curso_idcurso,
                    ]);
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

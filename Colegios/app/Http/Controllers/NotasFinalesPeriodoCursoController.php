<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Redirect;
use App\Helpers;
class NotasFinalesPeriodoCursoController extends Controller
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
        //MOSTRAR BOLETIN DEL CURSO
        return Redirect::away($this->parametros['generadorPdf']."?c=".$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profesor_curso = \App\ProfesorCursoModel::find($id);
        
        $parametros = Helpers::getParametros();
        
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
            Return view('notasfinalesperiodo.edit',['notasalumnos'=>$notasalumnos,'profesor_curso'=>$profesor_curso]);
        }else{
            Session::flash('message-error','No se pudo recuperar información del curso seleccionado');   
            Return view('curso.index');
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
        $parametros = Helpers::getParametros();
        
        try{
            
            DB::beginTransaction();
            
            
            foreach ($request['datos'] as $row){
                $notasalumno = \App\InformeAlumnoDetalleModel::find($row[0]);
                
                $notasalumno['nota']=abs(floatval(preg_replace("/[^0-9.]/", "", str_replace(',', '.',$row[1]))));
                //$notasalumno['nota'] = (($notasalumno['nota']>$parametros['notamaxima']) || ($notasalumno['nota']<$parametros['notaminima']))?$parametros['notaminima']:$notasalumno['nota'];
                    
                $fallas = abs(intval(preg_replace("/[^0-9]/", "",$row[2])));
                $notasalumno['fallas']=($fallas==0)?null:$fallas;
                
                $notasalumno->save();
                
            }
            
            DB::commit();
            Session::flash("message","Notas Actualizadas");
            
        
        } catch (Exception $ex) {
            Session::flash("error","Error Actualizando Notas");
            
        }
        return Redirect('/notasfinalesperiodo/'.$id);
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

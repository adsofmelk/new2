<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Session;


class CursoController extends Controller
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
    	$parametros = \App\Helpers::getParametros();
        $datosprofesor = DB::table('profesor as pro')
                            ->join('persona as pe','pe.idpersona','=','pro.persona_idpersona')
                            ->join('profesor_usuario as pu','pu.profesor_idprofesor','pro.idprofesor')
                            ->where(['pu.usuario_idusuario'=>Auth::user()->idusuario])->get();
        if((sizeof($datosprofesor)==0)){
        	if(\App\Helpers::isTipoUsuario([1,2])){
        		$cursos = DB::table('view_profesorcursoinformes as pc')
	        		->select(DB::raw('distinct pc.*, c.nombre as nombrecurso, m.nombre as nombremateria, pc.numeroinformes'))
	        		->join('curso as c','c.idcurso','=','pc.curso_idcurso')
	        		->join('materia as m','m.idmateria','=','pc.materia_idmateria')
	        		->get();
	        		$datosprofesor = false;
        	}else{
        		Session::flash('message-error','No posee cursos asignados');
        		return Redirect('/admin');
        	}
        	
        }else{
        	$cursos = DB::table('view_profesorcursoinformes as pc')
	        	->select(DB::raw('distinct pc.*, c.nombre as nombrecurso, m.nombre as nombremateria, pc.numeroinformes'))
	        	->join('curso as c','c.idcurso','=','pc.curso_idcurso')
	        	->join('materia as m','m.idmateria','=','pc.materia_idmateria')
	        	->where('pc.profesor_idprofesor','=',$datosprofesor[0]->profesor_idprofesor)->get();
        	
        }
        
        
        return view("curso.index",['cursos'=>$cursos,'datosprofesor'=> (($datosprofesor)?$datosprofesor[0]:false)]);
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

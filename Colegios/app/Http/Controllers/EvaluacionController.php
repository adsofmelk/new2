<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EvaluacionController extends Controller
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
    	
    	
    	
    	return view('evaluacion.index',['cursos'=>$cursos]);
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

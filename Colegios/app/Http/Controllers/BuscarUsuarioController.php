<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BuscarUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('buscarusuario.index');
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
    	
    	
     	
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$usuarios = \App\ViewAcudienteUsuarioPersonaModel::select(DB::raw("distinct nombres,apellidos,familiar_idfamiliar,usuario_idusuario,idpersona"))
    		->where('apellidos','like',"%$id%")
    		->orwhere('nombres','like',"%$id%")
    		->orderby('apellidos','ASC')->get();
    	foreach($usuarios as $key=>$val){
    		$usuarios[$key]['alumnos']=\App\ViewAcudienteAlumnoModel::where(['idfamiliar'=>$val->familiar_idfamiliar])->get();
    	}
    	return view('buscarusuario.view',['usuarios'=>$usuarios]);
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

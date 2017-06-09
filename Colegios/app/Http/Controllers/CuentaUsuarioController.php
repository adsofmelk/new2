<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;
use DB;

class CuentaUsuarioController extends Controller
{
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
    	$usuario = \App\UsuarioModel::find(Auth::user()->idusuario);
    	return view('cuentausuario.show',['usuario'=>$usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	return view('cuentausuario.edit',['usuario'=>\App\UsuarioModel::find(Auth::user()->idusuario)]);
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
        		$usuario = \App\UsuarioModel::find($id);
        		$usuario->fill($request->all());
        		$usuario->save();
        	
        	DB::commit();
        	Session::flash('message','Pasword actualizado correctamente');
        	
        }catch (Exception $e){
        	Session::flash('message-error','Problemas cambiando su pasword');
        	DB::rollBack();
        }
        
        return Redirect::to('cuentausuario/'.$id);
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

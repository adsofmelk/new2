<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
//use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;
use Auth;


class LogController extends Controller
{
	public function __construct(){
		
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
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'],'estado'=>'activo'])) {
            $usuario = \App\UsuarioModel::find(Auth::user()->idusuario);
            $usuario->intentos=0;
            $usuario->save();
            if((\App\Helpers::isAcudiente())&&(!\App\Helpers::isAdmin())){
            	return Redirect::to('acudiente');
            }
            return Redirect::to('admin');
        }else{
            $usuario = \App\UsuarioModel::where(['email'=>$request['email'],'estado'=>'activo'])->get();
            if(sizeof($usuario)>0){
                $usuario = \App\UsuarioModel::find($usuario[0]['idusuario']);
                $usuario->intentos++;
                if($usuario->intentos > 2){
                    $usuario->estado='bloqueado';
                    Session::flash('message-error','Usuario bloqueado por exceder intentos. Contácte al administrador del sistema.');
                }else{
                    Session::flash('message-error','Datos de ingreso no validos');
                }
                $usuario->save();
            }else{
                Session::flash('message-error','Datos de ingreso no validos');
            }
        }
        
        
        return Redirect::to("/");
        
        
    }
    
    public function logOut(){
        Auth::logout();
        return Redirect::to("/");
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

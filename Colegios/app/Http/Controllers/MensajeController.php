<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
class MensajeController extends Controller
{
	
		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mensaje = \App\ViewMensajeTipomensajeModel::where([
            'deleted_at'=> null,
            
            ])->orderby('idmensaje','DESC')->get();
        foreach ($mensaje as $key=>$val){
            $mensaje[$key]['canales'] = \App\ViewMensajeCanalmensajeModel::where(['mensaje_idmensaje'=>$val->idmensaje])->get();
        }
        $cursos = \App\CursoModel::where([
            'anioescolar_idanioescolar'=> \App\Helpers::getParametros()['idanioescolar'],
            'estado'=>true,
                ])->get();
        return view('mensaje.index',['mensaje'=>$mensaje,'cursos'=>$cursos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$tiposmensaje = \App\TipoMensajeModel::all();
    	$canalesmensaje = \App\CanalMensajeModel::where(['estado'=>true])->get();
    	$cursos = \App\CursoModel::where(['anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar']])->get();
    	return view('mensaje.create',[
    			'tiposmensaje'=>$tiposmensaje,
    			'canalesmensaje'=>$canalesmensaje,
    			'cursos'=>$cursos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	
    	try{
    		
    		DB::beginTransaction();
    		
    			
                $profesores = (isset($request['profesores']))?true:false;
                $acudientes = (isset($request['acudientes']))?true:false;
                if($acudientes){
                        if(isset($request['curso'])){
                                $acudientesdetalle = array();
                                foreach ($request['curso'] as $key=>$val){
                                        $acudientesdetalle[]=$key;
                                }
                        }
                        $acudientesdetalle=json_encode($acudientesdetalle);
                }else{
                        $acudientesdetalle=null;
                }

                //1. Crear el mensaje
                $mensaje = \App\MensajeModel::create([
                                'asunto'=>$request['asunto'],
                                'mensaje'=>$request['mensaje'],
                                'fechaenvio'=>$request['fechaenvio'],
                                'fechavencimiento'=>$request['fechavencimiento'],
                                'profesores'=>$profesores,
                                'acudientes'=>$acudientes,
                                'acudientesdetalle'=>$acudientesdetalle,
                                'numerosadicionales'=>$request['numeros'],
                                'emailsadicionales'=>$request['correos'],
                                'estado'=>'activo',
                                'usuario_idusuario'=>Auth::user()->idusuario,
                                'tipomensaje_idtipomensaje'=>$request['tipomensaje_idtipomensaje'],

                ]);

                //2.Agregar el canal de mensaje
                foreach($request['canal'] as $canal=>$valor){
                    \App\MensajeCanalmensajeModel::create([
                                    'mensaje_idmensaje'=>$mensaje->idmensaje,
                                    'canalmensaje_idcanalmensaje'=>$canal,
                                    'estado'=>'activo'
                    ]);
                }
    		
    		DB::commit();
    		
    		Session::flash('message','Mensaje Guardado. Sera procesado el los próximos minutos');
                
                $this->procesarMensajesTablero();
                
                $this->procesarMensajesSms();
    		
    		
    	} catch (Exception $ex) {
    		Session::flash('error','El mensaje no pudo ser almacenado.');
    		DB::rollBack();
                
    	}
        return Redirect::to('mensaje');
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
    
    public function procesarMensajesTablero(){
        
        try{
    		
    		DB::beginTransaction();
    		
                $mensajecanalmensaje = \App\MensajeCanalmensajeModel::where([
                'estado'=>'activo',
                 'canalmensaje_idcanalmensaje'=>2,
                ])->get();
                
                foreach($mensajecanalmensaje as $row){
                    $mensaje = \App\MensajeModel::find($row->mensaje_idmensaje);
                    
                    if($mensaje->profesores){
                        $profesores = \App\ViewTipousuarioUsuarioModel::where([
                            'tipousuario_idtipousuario'=>3,
                            'estado'=>'activo'
                        ])->get();
                        foreach($profesores as $profesor){
                            \App\MensajeUsuarioModel::Create([
                                'estado'=>'activo',
                                'usuario_idusuario'=>$profesor->usuario_idusuario,
                                'mensaje_idmensaje'=>$row->mensaje_idmensaje
                            ]);
                        }
                    }
                    
                    if($mensaje->acudientes){
                        $cursos = json_decode($mensaje->acudientesdetalle,false);
                        if(sizeof($cursos)>0){
                            foreach ($cursos as $curso){
                            
                                $acudientes = \App\ViewAcudienteAlumnoUsuarioModel::where(
                                        ['curso_idcurso'=>$curso,'estadoalumnocurso'=>'activo'])->get();
                                foreach($acudientes as $acudiente){
                                        $nuevomensaje = ['estado'=>'activo',
                                        'usuario_idusuario'=>$acudiente->usuario_idusuario,
                                        'mensaje_idmensaje'=>$row->mensaje_idmensaje];
                                        if(! \App\MensajeUsuarioModel::where($nuevomensaje)->exists()){
                                            \App\MensajeUsuarioModel::Create($nuevomensaje);
                                        }

                                }

                            }
                        }
                        
                    }
                    $row= \App\MensajeCanalmensajeModel::find($row->idmensaje_canalmensaje);
                    $row->estado='procesado';
                    $row->save();
                }
    		
    		DB::commit();
    		
    		return true;
    		
    		
    	} catch (Exception $ex) {
    		
    		DB::rollBack();
                return false;
    	}
    }
    
    public function procesarMensajesSms(){
        
        try{
    		
    		DB::beginTransaction();
    		
                $mensajecanalmensaje = \App\MensajeCanalmensajeModel::where([
                'estado'=>'activo',
                 'canalmensaje_idcanalmensaje'=>1,
                ])->get();
                
                foreach($mensajecanalmensaje as $row){
                    $mensaje = \App\MensajeModel::find($row->mensaje_idmensaje);
                    
                    if($mensaje->profesores){
                        $profesores = \App\ViewProfesorInformacionPersonalModel::where([
                            'estado'=>true
                        ])->get();
                        
                        foreach($profesores as $profesor){
                            if(sizeof($profesor->celular)>0){
                                \App\MensajeSmsModel::Create([
                                    'fechaenvio'=>$mensaje->fechaenvio,
                                    'telefono'=>$profesor->celular,
                                    'estado'=>'activo',
                                    'mensaje_idmensaje'=>$row->mensaje_idmensaje
                                ]);
                            }
                            
                        }
                        
                    }
                    
                    if($mensaje->acudientes){
                        $cursos = json_decode($mensaje->acudientesdetalle,false);
                        if(sizeof($cursos)>0){
                            foreach ($cursos as $curso){
                            
                                $acudientes = \App\ViewAcudienteAlumnoPersonaModel::where(
                                        ['curso_idcurso'=>$curso,'estadoalumnocurso'=>'activo'])->get();
                                foreach($acudientes as $acudiente){
                                    
                                        $nuevomensaje = [
                                            'fechaenvio'=>$mensaje->fechaenvio,
                                            'telefono'=>$acudiente->celular,
                                            'estado'=>'activo',
                                            'mensaje_idmensaje'=>$row->mensaje_idmensaje
                                            
                                            ];
                                        
                                        if(! \App\MensajeSmsModel::where($nuevomensaje)->exists()){
                                            \App\MensajeSmsModel::Create($nuevomensaje);
                                        }

                                }

                            }
                        }
                        
                    }
                    
                    if(sizeof($mensaje->numerosadicionales)>0){
                        $numeros = explode(' ',$mensaje->numerosadicionales);
                        foreach($numeros as $num){
                            if(sizeof($num)>0){
                                $nuevomensaje = [
                                    'fechaenvio'=>$mensaje->fechaenvio,
                                    'telefono'=>$num,
                                    'estado'=>'activo',
                                    'mensaje_idmensaje'=>$row->mensaje_idmensaje

                                    ];

                                if(! \App\MensajeSmsModel::where($nuevomensaje)->exists()){
                                    \App\MensajeSmsModel::Create($nuevomensaje);
                                }
                            }
                        }
                    }
                    $row= \App\MensajeCanalmensajeModel::find($row->idmensaje_canalmensaje);
                    $row->estado='procesado';
                    $row->save();
                }
    		
    		DB::commit();
    		
    		return true;
    		
    		
    	} catch (Exception $ex) {
    		
    		DB::rollBack();
                return false;
    	}
    }
}

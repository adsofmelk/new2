<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use App\TipodocumentoModel;


class UsuarioController extends Controller
{
    

		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	/*$usuario = \App\UsuarioModel::where(['deleted_at'=>null])
    					->orderBy('apellidos')
    					->paginate(30);
    	*/
    	if(\App\Helpers::isRoot()){
    		$tipousuarios = \App\TipousuarioModel::all();
    	}else{
    		$tipousuarios = \App\TipousuarioModel::where(['idtipousuario'=>3])
    		->orwhere(['idtipousuario'=>4])->orderby('idtipousuario','DESC')->get();
    	}
    	
    	foreach ($tipousuarios as $key=>$val){
    		if($val->idtipousuario==4){
    		
    				$tipousuarios[$key]['cursos']=\App\CursoModel::orderby('idcurso','asc')->get();
    				foreach($tipousuarios[$key]['cursos'] as $keycurso=>$valuecurso){
    					$tipousuarios[$key]['cursos'][$keycurso]['alumnos']=\App\ViewAlumnosCursoModel::
    						where([
    								'curso_idcurso'=>$valuecurso->idcurso,
    								'estado'=>'activo'
    						])
    						->orderby('alumno_idalumno','ASC')->get();
    						foreach($tipousuarios[$key]['cursos'][$keycurso]['alumnos'] as $keyalumno=>$valalumno){
    							$tipousuarios[$key]['cursos'][$keycurso]['alumnos'][$keyalumno]['acudientes']=\App\ViewAcudienteAlumnoPersonaModel::
    								join('familiar_usuario','familiar_usuario.familiar_idfamiliar','=','view_acudientealumnopersona.familiar_idfamiliar')
    								->join('usuario','usuario.idusuario','=','familiar_usuario.usuario_idusuario')
    								->where(['alumno_idalumno'=>$valalumno->alumno_idalumno,
    										'usuario.deleted_at'=>null,
    										'usuario.estado'=>'activo',
    								])->get();
    						}
    				}
    				
    			}else{
    				
    				$tipousuarios[$key]['usuarios']= \App\ViewUsuarioTipousuarioModel::where(['idtipousuario'=>$val->idtipousuario])->get();
    				
    			
    		}
    	}
        
        return view("usuario.index",["tipousuarios"=>$tipousuarios]);
    }

    
    public function getUsuariosPorTipousuario($id){
    	
    	
    	return view('usuario.usuariosportipousuario',['usuarios'=>$usuarios]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $tipousuario = \App\TipousuarioModel::pluck('nombre','idtipousuario');
       $genero = \App\GeneroModel::pluck('nombre','idgenero');
       $tipodocumento  = \App\TipodocumentoModel::pluck('nombre','idtipodocumento');
       $cursos = \App\CursoModel::where([
       		'estado'=>true,
       		'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
       		
       ])->get();
       foreach ($cursos as $key=>$val){
       	$cursos[$key]['alumnos']=\App\ViewAlumnosCursoModel::
	       	where([
	       			'curso_idcurso'=>$val->idcurso,
	       			'estado'=>'activo'
	       	])->orderby('alumno_idalumno','ASC')->get();
       }
       
       $tipofamiliar = \App\TipofamiliarModel::pluck('nombre','idtipofamiliar');
       
       $estado = ['activo'=>'Activo','inactivo'=>'Inactivo'];
       
       
       return view('usuario.create',['tipousuario'=>$tipousuario,'genero'=>$genero,
       				'tipodocumento'=>$tipodocumento,
       				'cursos'=>$cursos,
       				'tipofamiliar'=>$tipofamiliar,
       				'estado'=>$estado,
       				'selected'=>null,
		       		'persona'=>null,
		       		'alumnos'=>null,
		       		'tipoacudiente'=>null
       		]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\UsuarioCreateRequest $request)
    {
        
        try{
            
            DB::beginTransaction();
            
            
            $usuario = \App\UsuarioModel::create([
                        'nombres'=>$request['nombres'],
                        'apellidos'=>$request['apellidos'],
                        'email'=>$request['email'],
                        'password'=>$request['password'],
            			'estado'=>$request['estado'],
                        'hash'=>bcrypt($request['email']),
                        'intentos'=>0
            ]);
            
            $acudiente = false;
            $profesor = false;
            
            foreach($request['idtipousuario'] as $grupo){
            	$temp = ['tipousuario_idtipousuario'=>$grupo,'usuario_idusuario'=>$usuario->idusuario];
            	\App\UsuarioTipousuarioModel::create($temp);
            	
            	if($grupo == 3){
            		$profesor = true;
            	}
            	if($grupo == 4){
            		$acudiente = true;
            	}
            	
            }
            
            $persona = \App\PersonaModel::create([
            		'nombres'=>$request['nombres'],
            		'apellidos'=>$request['apellidos'],
            		'numerodocumento'=>$request['numerodocumento'],
            		'telefono'=>$request['telefono'],
            		'celular'=>$request['celular'],
            		'email'=>$request['email'],
            		'genero_idgenero'=>$request['idgenero'],
            		'tipodocumento_idtipodocumento'=>$request['tipodocumento'],
            		'ciudad_documento_idciudad'=>1,
            		'gruposanguineo_idgruposanguineo'=>1,
            		'rh_idhr'=>1,
            		'eps_ideps'=>1
            ]);
            
            $usuario_persona = \App\UsuarioPersonaModel::create([
            		'usuario_idusuario'=>$usuario->idusuario,
            		'persona_idpersona'=>$persona->idpersona,
            ]);
            
            
            if($acudiente){
            	$familiar = \App\FamiliarModel::create([
            			'persona_idpersona'=>$persona->idpersona]);
            	
            	\App\FamiliarUsuarioModel::create([
            			'familiar_idfamiliar'=>$familiar->idfamiliar,
            			'usuario_idusuario'=>$usuario->idusuario,
            	]);
            	
            	if(sizeof($request['alumno'])>0){
            		foreach($request['alumno'] as $key=>$val){
            			\App\FamiliarAlumnoModel::create([
            					'acudiente'=>(isset($request['acudiente'][$key])?true:false),
            					'familiar_idfamiliar'=>$familiar->idfamiliar,
            					'alumno_idalumno'=>$val,
            					'tipofamiliar_idtipofamiliar'=>$request['tipofamiliar'][$key],
            			]);
            		}
            		
            	}
            	
            	
            }
            
            DB::commit();
            Session::flash("message","Usuario Creado!");
            return Redirect('/usuario');
        
        } catch (Exception $ex) {
            Session::flash("error","Error Creando Usuario");
            DB::rollBack();
            return Redirect('/usuario');
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
        $usuario = \App\UsuarioModel::find($id);
        
        if(sizeof($usuario)==0){
        	return Redirect::to('usuario');
        }
        
        
        $tipousuario = \App\TipousuarioModel::pluck('nombre','idtipousuario');
        $genero = \App\GeneroModel::pluck('nombre','idgenero');
        $tipodocumento  = \App\TipodocumentoModel::pluck('nombre','idtipodocumento');
        $cursos = \App\CursoModel::where([
        		'estado'=>true,
        		'anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar'],
        		
        ])->get();
        foreach ($cursos as $key=>$val){
        	$cursos[$key]['alumnos']=\App\ViewAlumnosCursoModel::
        	where([
        			'curso_idcurso'=>$val->idcurso,
        			'estado'=>'activo'
        	])->orderby('alumno_idalumno','ASC')->get();
        }
        
        $tipofamiliar = \App\TipofamiliarModel::pluck('nombre','idtipofamiliar');
        
        
        
        $alumnos=array();
        $tipoacudiente=null;
        $temp = \App\Helpers::getTipousuarioUsuario($usuario->idusuario);
        if(sizeof($temp)>0){
        	foreach($temp as $tipo){
        		$selected[]=$tipo->tipousuario_idtipousuario;
        		
        		if($tipo->tipousuario_idtipousuario==4){
        			$alumnos = \App\ViewAcudienteAlumnoUsuarioModel::where([
        					'estadoalumnocurso'=>'activo',
        					'usuario_idusuario'=>$usuario->idusuario
        			])->get();
        			if(sizeof($alumnos)>0){
        				$tempalumnos = array();
        				$tipoacudiente = array();
        				foreach($alumnos as $alumno){
        					$tempalumnos[]=$alumno->alumno_idalumno;
        					$tipoacudiente[$alumno->alumno_idalumno] =\App\ViewAcudienteAlumnoModel::where([
        							'alumno_idalumno'=>$alumno->alumno_idalumno,
        							'usuario_idusuario'=>$alumno->usuario_idusuario,
        					])->first();
        				}
        				$alumnos = $tempalumnos;
        			}
        			
        		}

        	}
        }else{
        	$selected = null;
        }
        
        
        
        $usuario_persona = \App\UsuarioPersonaModel::where([
        			'usuario_idusuario'=>$usuario->idusuario
        		])->first();
        if(sizeof($usuario_persona)>0){
        	$persona = \App\PersonaModel::find($usuario_persona->persona_idpersona);
        }else{
        	$persona = null;
        }
        
        
        $estado = ['activo'=>'Activo','inactivo'=>'Inactivo'];
        
        return view('usuario.edit',["usuario"=>$usuario,'tipousuario'=>$tipousuario,'genero'=>$genero,
        		'tipodocumento'=>$tipodocumento,
        		'cursos'=>$cursos,
        		'tipofamiliar'=>$tipofamiliar,
        		'estado'=>$estado,
        		'selected'=>$selected,
        		'persona'=>$persona,
        		'alumnos'=>$alumnos,
        		'tipoacudiente'=>$tipoacudiente
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\UsuarioUpdateRequest $request, $id)
    {
        try{
            
            DB::beginTransaction();
            
            //DATOS DEL USUARIO
            $usuario = \App\UsuarioModel::find($id);
            if(sizeof($usuario)==0){
            	return Redirect::to('usuario');
            }
            
            $usuario->fill([
            		'nombres'=>$request['nombres'],
            		'apellidos'=>$request['apellidos'],
            		'email'=>$request['email'],
            		'password'=>$request['password'],
            		'estado'=>$request['estado'],
            		'hash'=>bcrypt($request['email']),
            		'intentos'=>0
            ]);
            $usuario->save();
            
            $persona=null;
            $usuario_persona = \App\UsuarioPersonaModel::where(['usuario_idusuario'=>$usuario->idusuario])->first();
            if(sizeof($usuario_persona)>0){
            	$persona = \App\PersonaModel::find($usuario_persona->persona_idpersona);
            	
            	$persona->fill([
            			'nombres'=>$request['nombres'],
            			'apellidos'=>$request['apellidos'],
            			'numerodocumento'=>$request['numerodocumento'],
            			'telefono'=>$request['telefono'],
            			'celular'=>$request['celular'],
            			'email'=>$request['email'],
            			'genero_idgenero'=>$request['genero_idgenero'],
            			'tipodocumento_idtipodocumento'=>$request['tipodocumento'],
            			
            	]);
            	$persona->save();
            }else{
            	$persona = \App\PersonaModel::create([
            			'nombres'=>$request['nombres'],
            			'apellidos'=>$request['apellidos'],
            			'numerodocumento'=>$request['numerodocumento'],
            			'telefono'=>$request['telefono'],
            			'celular'=>$request['celular'],
            			'email'=>$request['email'],
            			'genero_idgenero'=>$request['genero_idgenero'],
            			'tipodocumento_idtipodocumento'=>$request['tipodocumento'],
            			'ciudad_documento_idciudad'=>1,
            			'gruposanguineo_idgruposanguineo'=>1,
            			'rh_idhr'=>1,
            			'eps_ideps'=>1
            	]);
            	$usuario_persona = \App\UsuarioPersonaModel::create([
            			'usuario_idusuario'=>$usuario->idusuario,
            			'persona_idpersona'=>$persona->idpersona,
            	]);
            }
            
            
            //GRUPOS DEL USUARIO
            
            $grupos= \App\UsuarioTipousuarioModel::select(DB::raw('distinct idusuario_tipousuario'))
            ->where(['usuario_idusuario'=>($usuario->idusuario)])->get();
            foreach($grupos as $grupo){
            	$temp = \App\UsuarioTipousuarioModel::find($grupo->idusuario_tipousuario);
            	if(!\App\Helpers::isRoot()&&($temp->tipousuario_idtipousuario==1||$temp->tipousuario_idtipousuario==2)){
            		
            	}else{
            		$temp->delete();
            	}
            	
            	
            }
            
            $profesor =false;
            $acudiente = false;
            foreach($request['idtipousuario'] as $grupo){
            	
            	if(!\App\Helpers::isRoot()&&(($grupo==1)||($grupo==2))){
            		
            	}else{
            		
            	
	            	//CREA lOS GRUPOS DEL USUARIO
	            	
	            	$temp = ['tipousuario_idtipousuario'=>$grupo,'usuario_idusuario'=>$usuario->idusuario];
	            	\App\UsuarioTipousuarioModel::create($temp);
	            	
	            	
	            	
	            	if($grupo==4){ //acudientes
	            		$acudiente = \App\ViewAcudienteUsuarioPersonaModel::where([
	            				'usuario_idusuario'=>$usuario->idusuario
	            		])->first();
	            		if(sizeof($acudiente)>0){
	            			
	            			$familiar = \App\FamiliarModel::find($acudiente->familiar_idfamiliar);
	            		}else{
	            			
	            			$familiar = \App\FamiliarModel::create([
	            					'persona_idpersona'=>$persona->idpersona]);
	            			
	            			\App\FamiliarUsuarioModel::create([
	            					'familiar_idfamiliar'=>$familiar->idfamiliar,
	            					'usuario_idusuario'=>$usuario->idusuario,
	            			]);
	            			
	            			
	            			
	            		}
	            		
	            		$familiaralumnos= \App\FamiliarAlumnoModel::where(['familiar_idfamiliar'=>($familiar->idfamiliar)])->get();
	            		foreach($familiaralumnos as $familiaralumno){
	            			$temp = \App\FamiliarAlumnoModel::find($familiaralumno->idfamiliar_alumno);
	            			$temp->delete();
	            			
	            		}
	            		
	            		if(sizeof($request['alumno'])>0){
	            			foreach($request['alumno'] as $key=>$val){
	            				\App\FamiliarAlumnoModel::create([
	            						'acudiente'=>(isset($request['acudiente'][$key])?true:false),
	            						'familiar_idfamiliar'=>$familiar->idfamiliar,
	            						'alumno_idalumno'=>$val,
	            						'tipofamiliar_idtipofamiliar'=>$request['tipofamiliar'][$key],
	            				]);
	            			}
	            			
	            		}
	            		
	            		
	            	}elseif($grupo==3){//profesores
	            		
	            	}
            	
            	}
            	
            }
            
            //FIN GRUPOS DEL USUARIO
            
            
            
            DB::commit();
            Session::flash('message','Usuario editado!');
            return Redirect::to('/usuario');
        } catch (Exception $ex) {
            DB::rollBack();
            Session::flash('error','Error editado Usuario!: '.$ex->getMessage());
            return Redirect::to('/usuario');
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
        //\App\UsuarioModel::destroy($id);
        try{
            DB::beginTransaction();
            $usuario_pesona = \App\UsuarioPersonaModel::where(['usuario_idusuario'=>$id])->first();
            if($usuario_pesona!=null){
            	$usuario_pesona->delete();
            }
            
            
            $familiar_usuario = \App\FamiliarUsuarioModel::where(['usuario_idusuario'=>$id])->first();
            if($familiar_usuario!=null){
            	$familiar_usuario->delete();
            }
            
            $profesor_usuario = \App\ProfesorUsuarioModel::where(['usuario_idusuario'=>$id])->first();
            if($profesor_usuario!=null){
            	$profesor_usuario->delete();
            }
            
            $usuario = \App\UsuarioModel::find($id);
            $usuario->delete();
            DB::commit();
            Session::flash('message','Usuario eliminado!');
            return Redirect::to('/usuario');
        } catch (Exception $ex) {
            DB::rollBack();
            Session::flash('error','Error eliminando Usuario!: '.$ex->getMessage());
            return Redirect::to('/usuario');
        }
        
    }
    
    
    
}

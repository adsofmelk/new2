<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\PersonaModel;
use App\AlumnoCursoModel;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$cursos = \App\CursoModel::all();
    	foreach ($cursos as $key=>$val){
    		$cursos[$key]['alumnos'] = \App\ViewAlumnosCursoModel::where([
    						'curso_idcurso'=>$val->idcurso,
    						'estadoalumno'=>'activo',
    						'estado'=>'activo',
    						])->orderBy('codigolista',"ASC")
    						->get();
    	}
        return view('alumno.index',['cursos'=>$cursos]);
    }
    
    public function listadoAlumnosCurso($id){
    	
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$ciudades = \App\CiudadModel::where(['departamento_iddepartamento'=>'1'])->pluck('nombre','idciudad');
    	$lugarexpedicion = \App\CiudadModel::pluck('nombre', 'idciudad');
    	$generos = \App\GeneroModel::pluck('nombre','idgenero');
    	$tiposdocumento = \App\TipodocumentoModel::pluck('nombre','idtipodocumento');
    	$eps = \App\EpsModel::pluck('nombre','ideps');
    	$gruposanguineos = \App\GruposanguineoModel::pluck('grupo','idgruposanguineo');
    	$rh = \App\RhModel::pluck('factorrh','idrh');
    	
    	$cursos = \App\CursoModel::where(['anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar']])->pluck('nombre','idcurso');
        return view('alumno.create',[
        		'persona'=>new PersonaModel(),
        		'alumno_curso'=>new AlumnoCursoModel(),
        		'ciudades'=>$ciudades,
        		'generos'=>$generos,
        		'tiposdocumento'=>$tiposdocumento,
        		'eps'=>$eps,
        		'rh'=>$rh,
        		'gruposanguineo'=>$gruposanguineos,
        		'cursos'=>$cursos,
        ]);
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
    		
    		if($request->file('fotografia') !=null){
    			echo "foto";die;
    			$request['fotografia'] = Carbon::now()->second . $request['fotografia']->getName();
    			
    			\Storage::disk('public')->put(Carbon::now()->second . $request['fotografia']->getName(),\File::get($request['fotografia']));
    			$request->file('fotografia')->store('images/alumnos');
    		}
    		
    		$persona = \App\PersonaModel::create([
    				'nombres'=>$request['nombres'],
    				'apellidos'=>$request['apellidos'],
    				'fechanacimiento'=>$request['fechanacimiento'],
    				'genero_idgenero'=>$request['idgenero'],
    				'numerodocumento'=>$request['numerodocumento'],
    				'tipodocumento_idtipodocumento'=>$request['idtipodocumento'],
    				'telefono'=>$request['telefono'],
    				'celular'=>$request['celular'],
    				'email'=>$request['email'],
    				'direccion'=>$request['direccion'],
    				'ciudad_nacimiento_idciudad'=>$request['idciudadnacimiento'],
    				'ciudad_documento_idciudad'=>$request['idciudaddocumento'],
    				'ciudad_residencia_idciudad'=>$request['idciudadresidencia'],
    				'gruposanguineo_idgruposanguineo'=>$request['idgruposanguineo'],
    				'rh_idhr'=>$request['idrh'],
    				'eps_ideps'=>$request['ideps'],
    				'observaciones'=>$request['observaciones'],
    		]);
    		
    		
    		$alumno = \App\AlumnoModel::create(['estado'=>'activo',
    											'persona_idpersona'=>$persona->idpersona
    						]);
    		
    		$codigo = \App\AlumnoCursoModel::select(DB::raw('max(codigolista) as codigolista, max(ordenlista) as ordenlista'))
    													->where(['curso_idcurso'=>$request['idcurso']])->first();
    		
    		$alumno_curso = \App\AlumnoCursoModel::create([
    					'codigolista'=>($codigo->codigolista+1),
    					'ordenlista'=>($codigo->ordenlista+1),
    					'estado'=>'activo',
    					'alumno_idalumno'=>$alumno->idalumno,
    					'curso_idcurso'=>$request['idcurso'],
    				
    				]);
    		
    		DB::commit();
    		Session::flash("message","Alumno Creado!");
    		return Redirect('/alumno/'.$alumno->idalumno);
    		
    	} catch (Exception $ex) {
    		Session::flash("error","Error Creando Alumno");
    		DB::rollBack();
    		return Redirect('/alumno');
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
        $alumno = \App\ViewAlumnoInformacionPersonalModel::
        		select(DB::raw ('view_alumnoinformacionpersonal.* ,tipodocumento.nombre as nombretipodocumento, 
								genero.nombre as nombregenero, 
								cn.nombre as nombreciudadnacimiento,
								cd.nombre as nombreciudaddocumento,
								cr.nombre as nombreciudadresidencia,
								gs.grupo as nombregruposanguineo,
								rh.factorrh,
								eps.nombre as nombreeps
								 '))
								
        		->join('tipodocumento','tipodocumento_idtipodocumento','=','idtipodocumento')
        		->join('genero','idgenero','=','genero_idgenero')
        		->join('ciudad as cn','cn.idciudad','=','ciudad_nacimiento_idciudad')
        		->join('ciudad as cd','cd.idciudad','=','ciudad_documento_idciudad')
        		->join('ciudad as cr','cr.idciudad','=','ciudad_residencia_idciudad')
        		->join('gruposanguineo as gs','idgruposanguineo','=','gruposanguineo_idgruposanguineo')
        		->join('rh','idrh','=','rh_idrh')
        		->join('eps','ideps','=','eps_ideps')
        		->where ([
        		'idalumno'=>$id
        ])->first();
        if(sizeof($alumno)>0){    	
        	
        	$curso = \App\AlumnoCursoModel::select(DB::raw('distinct alumno_curso.*, curso.nombre as nombrecurso, persona.nombres, persona.apellidos'))
        			->join('curso','idcurso','=','curso.idcurso')
        			->join('profesor_curso as pc','pc.curso_idcurso','=','curso.idcurso')
        			->join('profesor as p','idprofesor','=','pc.profesor_idprofesor')
        			->join('persona','idpersona','=','p.persona_idpersona')
        			->where(['alumno_idalumno'=>$id,'alumno_curso.estado'=>'activo','pc.director'=>true])->first();
        	
        	$acudientes = \App\ViewAcudienteAlumnoPersonaModel::select(DB::raw('nombres,apellidos,telefono,celular, au.usuario_idusuario'))
        	->join('view_acudientealumnousuario as au','au.familiar_idfamiliar','=','view_acudientealumnopersona.familiar_idfamiliar')
        				->where([
        				'view_acudientealumnopersona.alumno_idalumno'=>$id,
        				
        			])->get();
        	
        	return view('alumno.show',['alumno'=>$alumno,'curso'=>$curso,'acudientes'=>$acudientes]);
        	
        }else{
        	session('error','Alumno no disponible');
        	return Redirect::to('/alumno');
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
    	$alumno = \App\AlumnoModel::find($id);
    	if(sizeof($alumno)==0){
    		return redirect('/alumno');
    	}
    	$persona = \App\ViewAlumnoInformacionPersonalModel::where(['idalumno'=>$id])->first();
    	$ciudades = \App\CiudadModel::where(['departamento_iddepartamento'=>'1'])->pluck('nombre','idciudad');
    	$lugarexpedicion = \App\CiudadModel::pluck('nombre', 'idciudad');
    	$generos = \App\GeneroModel::pluck('nombre','idgenero');
    	$tiposdocumento = \App\TipodocumentoModel::pluck('nombre','idtipodocumento');
    	$eps = \App\EpsModel::pluck('nombre','ideps');
    	$gruposanguineos = \App\GruposanguineoModel::pluck('grupo','idgruposanguineo');
    	$rh = \App\RhModel::pluck('factorrh','idrh');
    	
    	$cursos = \App\CursoModel::where(['anioescolar_idanioescolar'=>\App\Helpers::getParametros()['idanioescolar']])->pluck('nombre','idcurso');
    	
    	$alumno_curso = \App\AlumnoCursoModel::join('curso','idcurso','=','curso_idcurso')->where([
    			'alumno_idalumno'=>$id,
    			'alumno_curso.estado'=>'activo',
    			])->first();
    	return view('alumno.edit',[
    			'alumno'=>$alumno,
    			'persona'=>$persona,
    			'alumno_curso'=>$alumno_curso,
    			'ciudades'=>$ciudades,
    			'generos'=>$generos,
    			'tiposdocumento'=>$tiposdocumento,
    			'eps'=>$eps,
    			'rh'=>$rh,
    			'gruposanguineo'=>$gruposanguineos,
    			'cursos'=>$cursos,
    	]);
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
    		
    		$alumno = \App\AlumnoModel::find($id);
    		
    		
    		if($request->file('fotografia') !=null){
    			echo "foto";die;
    			$request['fotografia'] = Carbon::now()->second . $request['fotografia']->getName();
    			
    			\Storage::disk('public')->put(Carbon::now()->second . $request['fotografia']->getName(),\File::get($request['fotografia']));
    			$request->file('fotografia')->store('images/alumnos');
    		}
    		
    		$persona = \App\PersonaModel::find($alumno->persona_idpersona);
    		$persona->fill([
    				'nombres'=>$request['nombres'],
    				'apellidos'=>$request['apellidos'],
    				'fechanacimiento'=>$request['fechanacimiento'],
    				'genero_idgenero'=>$request['idgenero'],
    				'numerodocumento'=>$request['numerodocumento'],
    				'tipodocumento_idtipodocumento'=>$request['idtipodocumento'],
    				'telefono'=>$request['telefono'],
    				'celular'=>$request['celular'],
    				'email'=>$request['email'],
    				'direccion'=>$request['direccion'],
    				'ciudad_nacimiento_idciudad'=>$request['idciudadnacimiento'],
    				'ciudad_documento_idciudad'=>$request['idciudaddocumento'],
    				'ciudad_residencia_idciudad'=>$request['idciudadresidencia'],
    				'gruposanguineo_idgruposanguineo'=>$request['idgruposanguineo'],
    				'rh_idhr'=>$request['idrh'],
    				'eps_ideps'=>$request['ideps'],
    				'observaciones'=>$request['observaciones'],
    		]);
    		$persona->save();
    		
    		
    		DB::commit();
    		Session::flash("message","Alumno Modificado!");
    		return Redirect('/alumno/'.$alumno->idalumno);
    		
    	} catch (Exception $ex) {
    		Session::flash("error","Error Modificando Alumno");
    		DB::rollBack();
    		return Redirect('/alumno'.$alumno->idalumno);
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
        //
    }
}

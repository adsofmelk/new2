<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use DB;
use Session;
use Redirect;
use Auth;
class ImportarNotasController extends Controller
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
        $archivoimportado = DB::table('archivoimportado')->select(DB::raw("materia.nombre as materia, curso.nombre as curso, archivoimportado.*"))
                                    ->join ("curso","curso.idcurso","=","archivoimportado.curso_idcurso")
                                    ->join ("materia","materia.idmateria","=","archivoimportado.materia_idmateria")
                                    ->join('periodo','periodo.idperiodo',"=","archivoimportado.periodo_idperiodo")
                                    ->join('anioescolar','anioescolar.idanioescolar','=',"archivoimportado.anioescolar_idanioescolar")
                                    ->where("archivoimportado.estado","=","pendiente")
                                    ->where("archivoimportado.usuario_idusuario","=",Auth::user()->idusuario)
                                    ->get();
        return view('importar.index',['archivoimportado'=>$archivoimportado]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //$profesorcurso = \App\ProfesorCursoModel::query()->where("idprofesor","1");
       $curso = DB::table('curso')->join("profesor_curso","profesor_curso.curso_idcurso", "=", "curso.idcurso")
                                    ->join("profesor_usuario","profesor_usuario.profesor_idprofesor","=","profesor_curso.profesor_idprofesor")
                                    ->select("curso.*")
                                    ->where('profesor_usuario.usuario_idusuario','=',Auth::user()->idusuario)
                                    ->orderBy('curso.idcurso', 'asc')
                                    ->pluck('nombre','idcurso');
       if(sizeof($curso)==0){
           $curso = \App\CursoModel::pluck("nombre","idcurso");
           /*
           $profesor = DB::table('persona')
                                            ->join("profesor","profesor.persona_idpersona","=","persona.idpersona")
                                            ->select(DB::raw ("CONCAT(persona.apellidos, ' ', persona.nombres) as nombreprof, profesor.idprofesor"))
                                            ->where("profesor.estado","=",true)
                                            ->orderBy('nombreprof', 'asc')->pluck("nombreprof","idprofesor");
            * 
            * 
            */
       }
       /*
       $materia = DB::table('materia')->join('grado',"grado.idgrado","=","materia.grado_idgrado")
                                        ->select(DB::raw("CONCAT('Grado ' , grado.nombre, ' -> ', materia.nombre) as nombre, materia.idmateria"))
                                        ->pluck("nombre","idmateria");*/
       return view('importar.create',compact('curso'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $temp =  \App\ParametrosModel::where('key','idperiodo')->get();
        foreach($temp as $param){
            $request['periodo_idperiodo'] = $param['value'];
        }
        
        $temp =  \App\ParametrosModel::where('key','idanioescolar')->get();
        foreach($temp as $param){
            $request['anioescolar_idanioescolar'] = $param['value'];
        }
         
        
        $request['usuario_idusuario']= $request->session()->get('idusuario');
        $request['estado']='pendiente';
        $request['nombre']=$request['path']->getClientOriginalName();
        
        $archivoimportado = \App\ArchivoImportadoModel::create($request->all());
        
        $request['path']= $archivoimportado->idarchivoimportado."-".$request['path']->getClientOriginalName();
        $name =$archivoimportado->idarchivoimportado."-".$request['path']->getClientOriginalName();
        
        Storage::disk('local')->put($name,File::get($request['path']));
        
        
        File::move(storage_path()."/app/".$name,storage_path()."/app/archivoimportado/". $name);
        $archivoimportado->setAttribute('path',storage_path()."/app/archivoimportado/". $name );
        $archivoimportado->save();
        Session::flash("message","Archivo subido. Debe procedes a procesarlo para que las notas queden registradas.");
        return Redirect::to("/importarnotas");
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
        $archivoimportado = \App\ArchivoImportadoModel::find($id);
        
        $alumnoscurso = DB::table('view_alumnoscurso')->select(DB::raw ("CONCAT(apellidos, ' ', nombres) as nombre, codigolista, estadoalumno"))
                                                        ->where('curso_idcurso',"=",$archivoimportado['curso_idcurso'])->get();
        
        $datos = self::generarTabla(self::leerDatos($archivoimportado['path']));
        
        return view('importar.edit', ["datos"=>$datos,"archivoimportado"=>$archivoimportado,"alumnoscurso"=>$alumnoscurso]);
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
        
        $notasalumno = array(
            'materia_idmateria'=>$request['materia_idmateria'],
            'curso_idcurso'=>$request['curso_idcurso'],
            'periodo_idperiodo'=>$request['periodo_idperiodo'],
            'anioescolar_idanioescolar'=>$request['anioescolar_idanioescolar'],
            'estado'=>true,
                
        );
        try{
            
            DB::beginTransaction();
            /*$persona = \App\PersonaModel::create([
                        'nombres'=>$request['nombres'],
                        'apellidos'=>$request['apellidos'],
                        'email'=>$request['email'],
            ]);*/
            
            
            foreach ($request['datos'] as $row){
                $alumno = DB::table('alumno_curso')->select("alumno_curso.alumno_idalumno")
                                                ->where("alumno_curso.codigolista","=",$row[0])
                                                ->where("curso_idcurso","=",$request['curso_idcurso'])->get();

                $notasalumno['alumno_idalumno']= $alumno[0]->alumno_idalumno;
                
                $notasalumno['nota']=abs(floatval(preg_replace("/[^0-9.]/", "", str_replace(',', '.',$row[1]))));
                $notasalumno['nota'] = ($notasalumno['nota']>$this->parametros['notamaxima'])?$this->parametros['notaminima']:$notasalumno['nota'];
                    
                $fallas = abs(intval(preg_replace("/[^0-9]/", "",$row[2])));
                $notasalumno['fallas']=($fallas==0)?null:$fallas;
                
                \App\InformeAlumnoDetalleModel::create($notasalumno);
                
                
            }
            
            $archivoimportado= \App\ArchivoImportadoModel::find($id);
            $archivoimportado['estado']='procesado';
            $archivoimportado->save();
            
            DB::commit();
            Session::flash("message","Importación Completada");
            return Redirect('/importarnotas');
        
        } catch (Exception $ex) {
            Session::flash("error","Error Importando Notas");
            return Redirect('/importarnotas');
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
    
    private static function leerDatos($filename){
        try{
            $fp = fopen($filename,'r') or die("no puede accederse el archivo!!");
            $datos = array();
            fgetcsv($fp); // descartar la primera linea
            $i=0;
            while($csv_line = fgetcsv($fp)) {
                foreach($csv_line as $cel){
                    $datos[$i][] = (str_replace(',', '.', $cel));
                }
                $i++;
            }

            fclose($fp) or die("No puede cerrarse el archivo!!");
            return $datos;

        } catch (Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    
    private static function generarTabla($datos,$editable=false){
        $return = "<div class='table-responsive'>"
                . "<table class='table-striped' width='400'>"
                . "<thead>"
                . "<tr>"
                . "<th>#</th>"
                . "<th>Nombre</th>"
                . "<th>Apellido</th>"
                . "<th>Nota</th>"
                . "<th>Fallas</th>"
                . "</tr>"
                . "</thead>"
                . "<tbody>";
        $i=0;    
        foreach ($datos as $row){
            $return.="<tr>";
            $j=0;
            foreach($row as $cell){
                switch($j){
                    case 0:{
                        $return.="<td><input type='hidden' name='datos[".$i."][".$j."]' value='".$cell."' />".$cell."</td>";
                        break;
                    }
                    case 1:
                    case 2:{
                        $return.="<td>".$cell."</td>";
                        break;
                    }
                    default :{
                        $return.="<td><input type='text' name='datos[".($i)."][".($j-2)."]' value='".$cell."' size='3' style='text-align:center'/></td>";
                    }
                }
                if((($j == 3)||($j == 4))&&$editable){

                }else{

                }
                $j++;
            }
            $return.="</tr>";
            $i++;
        }
        $return.="</tbody></table>"
                . "</div>";

        return $return;
    } 
}

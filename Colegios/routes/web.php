<?php

use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('log','LogController');

Route::get('logout','LogController@logOut');
Route::get('auth/login', 'LogController@logOut');
Route::get('login', ['as' => 'login', 'uses' => 'LogController@logOut']);
Route::get('index.html', ['as' => 'login', 'uses' => 'LogController@logOut']);

//TEST CONTROLLER
//Route::get('planilla.pdf','PdfTemplateLanscapeA4Controller@generarDocumento');

//OBTENER LISTADOS PARA AJAX
Route::get('listarmateriasxcurso/{idcurso}','MateriaController@getMateriasCurso'); //LISTA DE MATERIAS DE UN GRADO




Route::get('admin', function () {
	if((\App\Helpers::isAcudiente())&&(!\App\Helpers::isAdmin())){
		return Redirect::to('acudiente');
	}
	
	if(\App\Helpers::isAdmin()){
		return Redirect::to('administrador');
	}
	
    return view('admin/index');
})->middleware('auth')->middleware('prevent-back-history');

Route::get('/', function () {
    return view('index');
});


//Usuarios
Route::get('usuarioportipousuario/{$id}','UsuarioController@getUsuariosPorTipousuario');
Route::resource('buscarusuario','BuscarUsuarioController');
Route::resource('usuario','UsuarioController');


//ENRUTADO RESTFULL
Route::resource('importarnotas','ImportarNotasController');
Route::resource('informealumno','InformeAlumnoController');
Route::resource('informeacademico','InformeAcademicoController');
Route::resource('informeacademicoparametros','InformeAcademicoParametrosController');
Route::resource('periodo','PeriodoController');
Route::resource('notasfinalesperiodo','NotasFinalesPeriodoController');
Route::resource('notasfinalesperiodocurso','NotasFinalesPeriodoCursoController');
Route::resource('curso','CursoController');
Route::resource('cuentausuario','CuentaUsuarioController');


//EVALUACIONES

Route::resource('evaluacion','EvaluacionController');

Route::get('evaluacioncurso/nueva/{id}','EvaluacionCursoController@nuevaEvaluacion');
Route::get('evaluacioncurso/verdetalle/{id}','EvaluacionCursoController@verDetalleEvaluacion');
Route::get('evaluacioncurso/notasacumuladascursomateria/{id}','EvaluacionCursoController@verNotasAcumuladasCursoMateria');
Route::get('evaluacioncurso/notasacumuladascursomateriamodal/{id}','EvaluacionCursoController@verNotasAcumuladasCursoMateriaModal');
Route::get('evaluacioncurso/progresoevaluacionestandares/{id}','EvaluacionCursoController@progresoEvaluacionEstandares');


Route::resource('evaluacioncurso','EvaluacionCursoController');



///ALUMNOS
Route::get('listadoalumnoscurso/{id}','AlumnoController@listadoAlumnosCurso');
Route::resource('alumno','AlumnoController');

//PLANILLAS DE NOTAS
Route::get('planillapuestocurso/{id}','PlanillaNotasController@planillaPuestosCurso');
Route::resource('planillanotas','PlanillaNotasController');

//FALLAS
Route::get('detallefallas/{idalumno}/{idprofesor_curso}','FallasController@verDetalle');
Route::get('crearfalla/{idalumno}/{idprofesor_curso}','FallasController@createFalla');
Route::resource('fallas','FallasController');


//DESK ADMINISTRADORES
Route::resource('administrador','DeskAdministradorController');


//DESK ACUDIENTES
Route::resource('acudiente','DeskAcudienteController');

//HASHER

Route::get('hasher','HasherController@generarHash');
Route::get('reasignarfamiliar','HasherController@reasignarFamiliar');
Route::get('poblarusuariopersona','HasherController@poblarUsuarioPersona');



//MENSAJES

Route::get('procesarmensajestablero','MensajeController@procesarMensajesTablero');
Route::resource('mensaje','MensajeController');

//MENSAJES => SMS
/*Route::get('enviarsms','CronMensajeSmsController@enviarSms');
Route::get('procesarColaSMS','SmsController@procesarColaSMS');
*/
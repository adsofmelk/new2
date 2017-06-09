@if(isset($profesor_curso->idprofesor_curso))
<div class='btn-group panel'>
	{!!link_to_action('EvaluacionCursoController@nuevaEvaluacion',$title= " + Nueva Evaluación", $profesor_curso->idprofesor_curso, $attributes = ["class"=>'btn btn-success'])!!}
	{!!link_to_action('EvaluacionCursoController@verNotasAcumuladasCursoMateria',"Ver Notas Acumuladas", $profesor_curso->idprofesor_curso, $attributes = ["class"=>'btn btn-primary'])!!}
	{!!link_to_action('EvaluacionCursoController@show',"Ver Resumen", $profesor_curso->idprofesor_curso, $attributes = ["class"=>'btn btn-primary'])!!}
	{!!link_to_action('FallasController@show',"Control de Asistencia", $profesor_curso->idprofesor_curso, $attributes = ["class"=>'btn btn-danger'])!!}
	{!!link_to_route('planillanotas.show',"Planilla de Acumulados", $profesor_curso->idprofesor_curso, $attributes = ["class"=>'btn btn-primary','target'=>'_blank'])!!}
</div>
@else
	No esta definido profesor_curso->idprofesor_curso
@endif
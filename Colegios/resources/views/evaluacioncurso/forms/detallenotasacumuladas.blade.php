	@if(sizeof($evaluaciones)>0)

		<table class='table table-striped'>
		<thead>
			<tr>
				<th >Alumno</th>
				@foreach($evaluaciones as $evaluacion)
				<th>
					{{$evaluacion->nombretipoestandar}}<br>
					{{$evaluacion->nombretipoevaluacion}}<br>
					{{$evaluacion->fechaevaluacion}}<br>
					{!!link_to_action('EvaluacionCursoController@verDetalleEvaluacion',$title= "Ver +", $parameters = $evaluacion->idevaluacion, $attributes = ["class"=>'btn btn-link'])!!}
				</th>
				@endforeach


			</tr>
		</thead>

		@foreach($alumnos as $alumno)
		<tr>
			<td><strong>{{'[ '. $alumno->codigolista .' ] '.$alumno->nombres . " " . $alumno->apellidos}}</strong></td>
			<?php
				$i=0;
				$acumulado =0;
				$acumuladostipoestandar = array();
			?>
			@foreach($alumno['evaluaciones'] as $evaluacion)


			

			<td>{{number_format($evaluacion->nota,2)}}</td>

			<?php
				$i++;
				$acumulado+=$evaluacion->nota;
			?>


			<?php

				if(isset($acumuladostipoestandar[$evaluacion->idtipoestandar])){
					$acumuladostipoestandar[$evaluacion->idtipoestandar]['acumulado'][]=$evaluacion->nota;
				}else{
					$acumuladostipoestandar[$evaluacion->idtipoestandar]['acumulado'][]=$evaluacion->nota;
					$acumuladostipoestandar[$evaluacion->idtipoestandar]['porcentaje']=$evaluacion->porcentaje;
					$acumuladostipoestandar[$evaluacion->idtipoestandar]['nombretipoestandar']=$evaluacion->nombretipoestandar;
				}
			?>

			@endforeach
			</tr>
			
			<tr>
			<td colspan='<?php echo (sizeof($evaluaciones)+1)?>' class='row'>

				<?php
				$totalizado = 0;
				$porcentajetotalizado = 0;
				foreach($acumuladostipoestandar as $acumuladotipoestandar){
					echo "<div class='col-sm-2'>";
					$suma=0;
					foreach($acumuladotipoestandar['acumulado'] as $item){
						$suma+=$item;
					}
					if(sizeof($acumuladotipoestandar['acumulado'])>0){
						$valor = $suma / sizeof($acumuladotipoestandar['acumulado']);
						echo "<strong>Acumulado ";
						echo $acumuladotipoestandar['nombretipoestandar'];
						echo "</strong>";
						echo "(".($acumuladotipoestandar['porcentaje'] * 100)."%)";
						echo "[".number_format($valor,2)."]&nbsp;&nbsp;&nbsp;&nbsp;" ;
						echo "<strong>".number_format(($valor * $acumuladotipoestandar['porcentaje']),2)."</strong>";
						$totalizado+=($valor * $acumuladotipoestandar['porcentaje']);
						$porcentajetotalizado+= $acumuladotipoestandar['porcentaje'];

					}
					echo "</div>";
				}
				?>

				<div class='col-sm-2' style='text-align:center;'>
					<?php
				
						echo "<strong>Total Acumulado: ".number_format($totalizado,2)."</strong>";

					?>
				</div>
				
				<div class='col-sm-2' style='text-align:center;'>
					<?php
				
						echo "Porcentaje Evaluado: ".($porcentajetotalizado*100)."%";

					?>
				</div>
			</td>
		</tr>

		@endforeach

		</table>
	@endif
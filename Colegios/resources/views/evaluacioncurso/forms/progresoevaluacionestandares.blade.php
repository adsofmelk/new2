<div class='row'>
<?php $i=0;?>
@foreach($estandares as $estandar)
	<div class='col-sm-2'>
	<h5><strong>{{$estandar->nombre}}</strong></h5>
	# Eval: {{$estandar['evaluado']}}
	</div>
	<?php if($estandar['evaluado']>0){
		$i++;
	}
	?>
@endforeach
</div>
<div class='row'>
	<div class='col-sm-6 text-centered' >
		<h4>Total Estandares Evaluados: </h4>
		<h4>{{$i}}</h4>
	</div>
	<div class='col-sm-6 text-centered'>
		<h4>Porcentaje de Estandares Evaluados: </h4>
		<h4>{{number_format(($i/sizeof($estandares))*100,2)}} %</h4>
	</div>
</div>

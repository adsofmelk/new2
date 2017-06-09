		
  	<h3>Anuncios</h3>
  	
  		<ul class="list-group">
                  @foreach($mensajes as $mensaje)
		  <li class="list-group-item list-group-item-{{$mensaje->class}}">
		  <h4>{{$mensaje->asunto}}</h4>
		  {{$mensaje->mensaje}}
		  </li>
                  
                  @endforeach
		</ul>
  
	

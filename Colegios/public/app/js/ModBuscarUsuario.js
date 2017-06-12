$('document').ready(function(){
	
	$('#buscar').click(function(){
		$.ajax({
	    	type: 'GET',
	    	url: 'buscarusuario/'+$('#cadena').val(),
	    	dataType: 'html',
	    	success: function(html, textStatus) {
	    		$('#resultados').html(html);
	    	},
	    	error: function(xhr, textStatus, errorThrown) {
	    		$('#resultados').html('Ocurrio un error: ' + ( errorThrown ? errorThrown : xhr.status ));
	    	}
	    });
		
	});
	
	
	
});
   

$(function() {
    $('#myModal').on("show.bs.modal", function (e) {
             	//e.relatedTarget.dataset.nombremateria
    	$('#titulo-modal').html(e.relatedTarget.dataset.tituloventana);
    	switch(e.relatedTarget.dataset.accion){
    	
	    	case 'verDetalleEvaluacionesCursoMateria':{
	    		var ruta = "evaluacioncurso/notasacumuladascursomateriamodal/"+e.relatedTarget.dataset.idprofesor_curso;
	    		$( "#contenido-modal" ).load( ruta );
	    		break;
	    	}
	    	
	    	case 'verDetalleEvaluacionesCursoMateria2':{
	    		var ruta = "evaluacioncurso/progresoevaluacionestandares/"+e.relatedTarget.dataset.idprofesor_curso;
	    		$( "#contenido-modal" ).load( ruta );
	    		break;
	    	}
    	
    	}
    	
    });
});


$("form").submit(function(e){
	$('#btn-save').prop('disabled', true);
	var $form = $(this);
    if ($form.data('submitted') === true) {
      e.preventDefault();
    } else {
      $form.data('submitted', true);
    }
});
$("#acudientes").change(function() {
    if(this.checked) {
    	$('.checkCurso').prop('checked', true);
    	$('#cursos').addClass('in');
    	
    }else{
    	$('.checkCurso').prop('checked', false);
    	$('#cursos').removeClass('in');
    }
});

$('#mensaje').keyup(function () {
	  var max = 160;
	  var len = $(this).val().length;
	  if (len > max) {
	    $('#charNum').text(len + " Caracteres. Exede el tamaño máximo de "+max+" caracteres");
	    $('#charNum').removeClass('alert-success');
	    $('#charNum').addClass('alert-danger');
	  } else {
	    var char = max - len;
	    $('#charNum').text(char + ' Caracteres restantes');
	    $('#charNum').removeClass('alert-danger');
	    $('#charNum').addClass('alert-success');
	  }
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

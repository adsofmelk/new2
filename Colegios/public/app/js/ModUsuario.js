$('document').ready(function(){
	$('#password').val('');
	$('#password2').val('');
});

$("form").submit(function(e){
	if($('#password').val()!=$('#password2').val()){
		alert('Los paswords no coinciden.');
		e.preventDefault();
		return 1;
	}
	$('#btn-save').prop('disabled', true);
	var $form = $(this);
    if ($form.data('submitted') === true) {
      e.preventDefault();
    } else {
      $form.data('submitted', true);
    }
});

$('#idtipousuario').click(function(e){
	if($('#idtipousuario').val()==4){
		$('#cursos').fadeIn();
	}
});
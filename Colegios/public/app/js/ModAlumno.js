
$("form").submit(function(e){
	$('#btn-save').prop('disabled', true);
	var $form = $(this);
    if ($form.data('submitted') === true) {
      e.preventDefault();
    } else {
      $form.data('submitted', true);
    }
});

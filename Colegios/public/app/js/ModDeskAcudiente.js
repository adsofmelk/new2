$(function() {
    $('#myModal').on("show.bs.modal", function (e) {
         //$("#favoritesModalLabel").html($(e.relatedTarget).data('title'));
         //$("#fav-title").html($(e.relatedTarget).data('title'));
    	$('#contenido-modal').load('http://google.com');
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
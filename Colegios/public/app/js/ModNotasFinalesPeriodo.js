$('.nota').change(event=>{
    /*
	$.get('/listarmateriasxcurso/'+event.target.value, function(response, state){
       $('#idmateria').empty(); 
       response.forEach(element =>{
           $('#idmateria').append('<option value="'+element.idmateria+'">'+element.nombrecurso+' -> '+element.nombre+'</option>');
           console.log(element.idmateria);
       });
    });*/
	if (event.keyCode === 10 || event.keyCode === 13){
		event.preventDefault();
		alert("enter");
	} 

	event.target.value = event.target.value.replace(/[\,]/g,'.');
	event.target.value = event.target.value.replace(/[^\d\.\-]/g,'');
	if(event.target.value > 5 || event.target.value < 2){
		alert('La nota tener un valor mínimo de 2 y un máximo de 5');
		$('#formulario').preventDefault();
		event.target.focus();
		
	}
	
});
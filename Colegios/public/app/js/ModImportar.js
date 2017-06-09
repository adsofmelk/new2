$('#idcurso').change(event=>{
    $.get('/listarmateriasxcurso/'+event.target.value, function(response, state){
       $('#idmateria').empty(); 
       response.forEach(element =>{
           $('#idmateria').append('<option value="'+element.idmateria+'">'+element.nombrecurso+' -> '+element.nombre+'</option>');
           console.log(element.idmateria);
       });
    });
});
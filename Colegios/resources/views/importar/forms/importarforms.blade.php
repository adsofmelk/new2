    <div class='form-group'>
        
        {!!Form::label("curso_idcurso","Curso:")!!}
        {!!Form::select("curso_idcurso",$curso,null,['id'=>'idcurso','class'=>'form-control','placeholder'=>' -- Seleccione el Curso --'])!!}
        {!!Form::label("materia_idmateria","Materia:")!!}
        {!!Form::select("materia_idmateria",['placeholder'=>' ----'],null,['id'=>'idmateria','class'=>'form-control'])!!}
        {!!Form::label("archivo","Archivo:")!!}
        {!!Form::file("path")!!}
    </div>


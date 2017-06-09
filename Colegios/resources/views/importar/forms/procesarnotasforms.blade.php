<div class="row">
     
  
    <div class="col-sm-6">
        
        {!!Form::hidden("curso_idcurso",$archivoimportado['curso_idcurso'])!!}
        {!!Form::hidden("materia_idmateria",$archivoimportado['materia_idmateria'])!!}
        {!!Form::hidden("periodo_idperiodo",$archivoimportado['periodo_idperiodo'])!!}
        {!!Form::hidden("anioescolar_idanioescolar",$archivoimportado['anioescolar_idanioescolar'])!!}
        <h2>Notas para procesar</h2>
        {!!$datos!!}
    </div>
    <div class="col-sm-4">
        <h2>Lista del curso</h2>
        <div class='table-responsive'>
                <table class='table-striped' width='100%'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Alumno</th>
                            <th>Estado</th>
                           
                        </tr>
                    </thead>
                    <tbody>
        <?php
        
            foreach ($alumnoscurso as $row){
                echo "<tr><td>".$row->codigolista."</td><td> ".$row->nombre."</td>"
                        . "<td style='color:".(($row->estadoalumno=='activo')?"green":"red") .";'>".$row->estadoalumno."</td></tr>";
            }
        ?>
                    </tbody>
                </table>
        </div>
                    
    </div>
    <div class="col-sm-2">&nbsp;
    </div>
</div>

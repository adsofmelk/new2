<div class='table-responsive'>
   <table class='table-striped' width='400'>
        <thead>
           <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Nota</th>
              <th>Fallas</th>
              <th>Novedades</th>
            </tr>
        </thead>
        <tbody>

            <?php

                $return = '';
                $i=0;
                
                    foreach ($notasalumnos as $row){
                    	$readonly = (($row->estadoalumno!='activo')?'READONLY':'');
                        $return.="<tr>";
                        $return.="<td><input type='hidden' name='datos[".$i."][0]' value='".$row->idinforme_alumno_detalle."' />".$row->codigolista."</td>";
                        $return.="<td>".$row->nombres."</td>";
                        $return.="<td>".$row->apellidos."</td>";
                        $return.="<td><input type='text' class='nota' ".$readonly." name='datos[".$i."][1]' value='".$row->nota."' size='3' style='text-align:center'/></td>";
                        $return.="<td><input type='text' ".$readonly." name='datos[".$i."][2]' value='".$row->fallas."' size='3' style='text-align:center'/></td>";
                        $return.="<td>".(($row->estadoalumno!='activo')?$row->estadoalumno:'')."</td>";
                        $return.="</tr>";
                        $i++;
                    }
                    echo $return;
            ?>
            
        </tbody>
   </table>
</div>

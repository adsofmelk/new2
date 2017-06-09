@include('notasfinalesperiodo.menu.menu')
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
                        $return.="<tr>";
                        $return.="<td>".$row->codigolista."</td>";
                        $return.="<td>".$row->nombres."</td>";
                        $return.="<td>".$row->apellidos."</td>";
                        $return.="<td>".$row->nota."</td>";
                        $return.="<td>".$row->fallas."</td>";
                        $return.="<td>".(($row->estadoalumno!='activo')?$row->estadoalumno:'')."</td>";
                        $return.="</tr>";
                        $i++;
                    }
                    echo $return;
            ?>
            
        </tbody>
   </table>
</div>
{!!link_to_route('notasfinalesperiodocurso.edit',$title= "Modificar Notas", $parameters = $profesor_curso->idprofesor_curso, $attributes = ["class"=>'btn btn-warning'])!!}

<?php
echo 'actividades <br>';
$id=1;
echo $id;
$resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

foreach ($resultados as $fila) { ?>
     <div class="actividades">
       <h4><?=$fila->getDescripcion()?></h4>
     </div>

<?php } ?>

<?php
echo 'actividades <br>';
$resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

foreach ($resultados as $fila) { ?>
     <div class="actividades">
       <h4><?=$fila->getDescripcion()?></h4>
     </div>

<?php } ?>
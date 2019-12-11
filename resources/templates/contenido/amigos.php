<?php

$id=1;
$resultados = AmigoManager::obtenerAmigos($id);

foreach ($resultados as $fila) { ?>
     <div class="amigos">
       <h4><?=$fila->getNombre()?></h4>
     </div>

<?php } ?>

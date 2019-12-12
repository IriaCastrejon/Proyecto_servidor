<?php

$id=1;

$resultados = AnuncioManager::obtenerAnuncioPorIdCliente($id);

foreach ($resultados as $fila) { ?>
     <div class="anuncios">
       <h4><?=$fila->getFechaAlta()?></h4>
       <h4><?=$fila->getUrl()?></h4>
     </div>

<?php } ?>

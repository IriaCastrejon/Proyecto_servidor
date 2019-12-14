<?php

session_start();
  echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
$id=$_SESSION['id'];

$resultados = AnuncioManager::obtenerAnuncioPorIdCliente($id);

foreach ($resultados as $fila) { ?>
     <div class="anuncios">
       <h4><?=$fila->getFechaAlta()?></h4>
       <h4><?=$fila->getUrl()?></h4>
     </div>

<?php } ?>

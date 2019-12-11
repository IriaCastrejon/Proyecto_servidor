<?php

session_start();
  echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
$id=$_SESSION['id'];

$resultados = AmigoManager::obtenerAmigos($id);

foreach ($resultados as $fila) { ?>
     <div class="amigos">
       <h4><?=$fila->getNombre()?></h4>
     </div>

<?php } ?>

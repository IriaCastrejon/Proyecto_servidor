<?php

session_start();
  echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
$id=$_SESSION['id'];

$resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

foreach ($resultados as $fila) { ?>
     <div class="actividades">
       <h4><?=$fila->getDescripcion()?></h4>
     </div>

<?php } ?>

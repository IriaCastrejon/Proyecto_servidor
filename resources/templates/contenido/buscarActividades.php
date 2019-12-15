<?php

session_start();

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];

$resultados = ActividadManager::obtenerActividadNoParticipa($id);



foreach ($resultados as $fila) { ?>
     <div class="actividades">
       <h4>
         <a href="detalleActividad.php?participa=false&idActividad=<?=$fila->getId()?>"><?=$fila->getNombre()?></a>

       </h4>
     </div>

<?php } ?>

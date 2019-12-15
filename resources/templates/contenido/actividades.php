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

?>

<a href="nuevaActividad.php">Crear nueva Actividad</a>
<a href="buscarActividades.php">Buscar Actividad</a>

<?php

$resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

foreach ($resultados as $fila) { ?>
     <div class="actividades">
       <h4>
         <a href="detalleActividad.php?participa=true&idActividad=<?=$fila->getId()?>"><?=$fila->getNombre()?></a>

       </h4>
     </div>




<?php } ?>

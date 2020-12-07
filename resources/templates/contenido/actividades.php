<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];
$idActividad = $_GET['idActividad'];
$participa = $_GET['participa'];

?>
<p class="btnsActividad">
  <a href="nuevaActividad.php" class="botonActividad">Crear nueva Actividad</a>
  <a href="buscarActividades.php" class="botonActividad">Buscar Actividad</a>
</p>


<?php

$resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

if (isset($_POST['participar'])) {

  $db= DWESBaseDatos::obtenerInstancia();
  ParticipaManager::insert($id,$idActividad);
  header('Location: actividades.php');
  die();

}


if (isset($_POST['desapuntarse'])) {

  $db= DWESBaseDatos::obtenerInstancia();
  ParticipaManager::delete($id,$idActividad);
  header('Location: actividades.php');
  die();

}
?>

<div class="contenedor_actividades">
    <h1> Mis actividades </h1>
  <div class="c_actividad">
      <?php
      foreach ($resultados as $fila) {
        $participantes = ActividadManager::numeroParticipantes($fila->getId());
        ?>
            <div class="actividad">
                <h4><?=$fila->getNombre()?></h4><br><br>
                <p>
                <span>Día: </span>  <?=substr($fila->getFecha(),0,10)?><br><br>
                <span>Lugar: </span>  <?=$fila->getLugar()?><br><br>
                <span>Descripción: </span><?=$fila->getDescripcion()?><br><br>
                </p>
                <form class="" action="actividades.php?participa=true&idActividad=<?=$fila->getId()?>" method="post">
                    <?php if($participa == 'false'){ ?>
                        <input type="submit" name="participar" value="Participar" class="boton">
                    <?php }else{ ?>
                        <input type="submit" name="desapuntarse" value="No Participar" class="boton">
                    <?php } ?>
                </form>
            </div>
      <?php } ?>
  </div>
</div>

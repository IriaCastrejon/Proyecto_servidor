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

$resultados = ActividadManager::obtenerActividadNoParticipa($id);
?>
<div class="contenedor_actividades">
    <h1> Actividades disponibles </h1>
    <div class="c_actividad">
        <?php
          foreach ($resultados as $fila) { ?>
          <div class="actividad">
            <h4><?=$fila->getNombre()?></h4><br><br>
            <p>
            <span>Día: </span>  <?=substr($fila->getFecha(),0,10)?><br><br>
            <span>Lugar: </span>  <?=$fila->getLugar()?><br><br>
            <span>Descripción: </span><?=$fila->getDescripcion()?><br><br>
            </p>
          <form class="" action="actividades.php?participa=false&idActividad=<?=$fila->getId()?>" method="post">
            <input type="submit" name="participar" value="Participar" class="boton">
          </form>

          </h5>
          </div>

      <?php } ?>
    </div>

</div>

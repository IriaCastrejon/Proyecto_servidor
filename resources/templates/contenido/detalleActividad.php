<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$idUsuario = $_SESSION['id'];
$idActividad = $_GET['idActividad'];
$participa = $_GET['participa'];

$actividad = ActividadManager::getById($idActividad);
$participantes = ActividadManager::numeroParticipantes($idActividad);

if (isset($_POST['participar'])) {

  $db= DWESBaseDatos::obtenerInstancia();
  ParticipaManager::insert($idUsuario,$idActividad);
  header('Location: buscarActividades.php');
  die();

}


if (isset($_POST['desapuntarse'])) {

  $db= DWESBaseDatos::obtenerInstancia();
  ParticipaManager::delete($idUsuario,$idActividad);
  header('Location: actividades.php');
  die();

}


?>

<div class="tabla">

<table>
  <thead>
    <tr>
      <th>NOMBRE</th>
      <th>DESCRIPCION</th>
      <th>PARTICIPANTES</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td><?=$actividad->getNombre()?></td>
      <td><?=$actividad->getDescripcion()?></td>
      <td><?=$participantes?></td>
    </tr>
  </tbody>
</table>




    <form class="" action="detalleActividad.php?idActividad=<?=$idActividad?>" method="post">
      <?php if($participa == 'false'){ ?>
              <input type="submit" name="participar" value="Participar">
    <?php }else{ ?>
              <input type="submit" name="desapuntarse" value="No Participar">

    <?php } ?>
    </form>





</div>

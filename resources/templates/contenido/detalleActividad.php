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

$idActividad = $_GET['idActividad'];
$actividad = ActividadManager::getById($idActividad);
$participantes = ActividadManager::numeroParticipantes($idActividad);


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
</div>

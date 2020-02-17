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
$idActividad = $_GET['idActividad'];
$participa = $_GET['participa'];

?>

<a href="nuevaActividad.php" class="botonActividad">Crear nueva Actividad</a>
<a href="buscarActividades.php" class="botonActividad">Buscar Actividad</a>

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
<?php
foreach ($resultados as $fila) {
  $participantes = ActividadManager::numeroParticipantes($fila->getId());
  ?>
     <div class="actividades">


         <h5> Actividad <br>

              <span><?=$fila->getNombre()?></span>

        </h5>
         <h5> Fecha<br> <span><?=substr($fila->getFecha(),0,10)?> </span></h5>
         <h5> Descripción <br> <span><?=$fila->getDescripcion()?> </span></h5>
         <h5> Participantes <br> <span><?=$participantes?> </span></h5>
         <h5>
           <form class="" action="actividades.php?participa=true&idActividad=<?=$fila->getId()?>" method="post">
             <?php if($participa == 'false'){ ?>
                     <input type="submit" name="participar" value="Participar" class="boton">
             <?php }else{ ?>
                     <input type="submit" name="desapuntarse" value="No Participar" class="boton">

             <?php } ?>
           </form>

         </h5>

     </div>

<?php } ?>
</div>

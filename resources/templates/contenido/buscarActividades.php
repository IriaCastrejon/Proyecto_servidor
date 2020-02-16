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
      <h5> Actividad <br>
        <span><?=$fila->getNombre()?></span>
      </h5>
       <h5> Fecha<br> <span><?=$fila->getFecha()?> </span></h5>
       <h5> Descripción <br> <span><?=$fila->getDescripcion()?> </span></h5>

       <h5>
         <form class="" action="actividades.php?participa=false&idActividad=<?=$fila->getId()?>" method="post">
               <input type="submit" name="participar" value="Participar">
         </form>

       </h5>
     </div>

<?php } ?>

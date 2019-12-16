<?php

session_start();
  echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

$id=$_SESSION['id'];

$resultados = AnuncioManager::obtenerAnuncioPorIdCliente($id);

function dias_pasados($fecha_inicial,$fecha_final){
  $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
  $dias = abs($dias); $dias = floor($dias);
  return $dias;
}

//echo dias_pasados($fecha_baja,$fecha_alta);
$precioDia = 25;

?>


<div class="contenedor_anuncios">
  <h1> Mis anuncios </h1>
  <?php foreach ($resultados as $fila) { ?>
       <div class="anuncios">
         <h5> Fecha alta <br><?=substr($fila->getFechaAlta(),0,10) ?></h5>
         <h5> Fecha baja <br><?=$fila->getFechaBaja()?></h5>
         <h5> Precio <br><?php echo dias_pasados($fila->getFechaBaja(),$fila->getFechaAlta()) * $precioDia . ' €'?></h5>
         <h5><?=$fila->getFoto()?></h5>
         <img src="../imgs/InicioFondo1.png" alt="">
       </div>

  <?php } ?>
</div>

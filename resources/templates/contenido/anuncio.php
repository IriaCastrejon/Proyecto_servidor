<?php


  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'mascota'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];
define("PRECIO_DIA", 25);

$resultados = AnuncioManager::obtenerAnuncioPorIdCliente($id);

function dias_pasados($fecha_inicial,$fecha_final){
  $dias = (strtotime($fecha_inicial)-strtotime($fecha_final))/86400;
  $dias = abs($dias); $dias = floor($dias);
  return $dias;
}

//echo dias_pasados($fecha_baja,$fecha_alta);
$precioDia = PRECIO_DIA;

?>


<div class="contenedor_anuncios">
  <h1> Mis anuncios </h1>
  <?php foreach ($resultados as $fila) { ?>
       <div class="anuncios">
         <h5> Fecha alta <br> <span><?=substr($fila->getFechaAlta(),0,10) ?></span></h5>
         <h5> Fecha baja <br> <span><?=$fila->getFechaBaja()?> </span></h5>
         <h5> Precio <br> <span><?php echo dias_pasados($fila->getFechaBaja(),$fila->getFechaAlta()) * $precioDia . ' €'?> </span></h5>
         <img class="anuncio_img" src="<?=$fila->getFoto()?>" alt="">
       </div>

  <?php } ?>
</div>

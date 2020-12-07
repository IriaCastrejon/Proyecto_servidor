<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id_seguir = '';
$kms=1;
$id = $_SESSION['id'];

// dejar de seguir
if(isset($_GET['unfollow'])) {
  $id_dejar = (int)$_GET['idDejar'];
  AmigoManager::delete($id,$id_dejar);
  header("Location: cercaDeMi.php");
  die();
}
//seguir
if(isset($_GET['seguir'])) {
  $id_seguir = (int)$_GET['idSeguir'];
  AmigoManager::insert($id,$id_seguir);
  header("Location: cercaDeMi.php");
  die();
}

if (isset($_GET["kilometros"])) {
  $kms=$_GET["kilometros"];
}

$obj_cordenadas = CoordenadasManager::getCordenadasByUsuarioID($id)[0];
$lat=$obj_cordenadas->getLatitud();
$long=$obj_cordenadas->getLongitud();

$resultados= CoordenadasManager::getCercanos($lat, $long,$id);

function formateaDistancia($distancia){
  $txt = '';
  $arrayKms = explode(".",$distancia);
  // si hay decimales y son mas de 3
    if (isset($arrayKms[1])) {
      // Me quedo con los 3 primeros
      $arrayKms[1] = substr($arrayKms[1],0,3);
    }
  if ($distancia < 1) {
    $tex = $arrayKms[1] .' metros';
  }else{
    $tex = implode(",",$arrayKms).' Kms';
  }
  return $tex;
}

 ?>

 <?php if (count($resultados) <= 0 ){ ?>
   <div class="notificaciones">
     <h1>No hay Amigos a <?=$kms?>Km</h1>
     <h2>Intente nuevamente</h2>
   </div>

 <?php }else{ ?>
   <div class="contenedor_amigos">
     <h1> Mascotas a <?=$kms?> Kms  </h1>
   <?php foreach ($resultados as $fila) { ?>
     <?php
      $mascota = MascotaManager::getById($fila['usuario_id'])[0];
      $txt =formateaDistancia($fila['distanciaKilometros']);

     ?>
       <?php if ($mascota!= null &&  $fila['distanciaKilometros'] <= $kms && $mascota->getId() != $id): ?>
         <div class="amigos">
           <div class="amigosCabecera">
             <p><?=$mascota->getNombre()?></p>

              <?php if (AmigoManager::compruebaAmistad($id,$mascota->getId())) { ?>
                 <a href="cercaDeMi.php?kilometros=<?=$kms?>&unfollow=true&idDejar=<?=$mascota->getId()?>">
                   <button >No seguir</button>
                 </a>
              <?php }else{ ?>
                <a href="cercaDeMi.php?kilometros=<?=$kms?>&seguir=true&idSeguir=<?=$mascota->getId()?>">
                 <button >Seguir</button>
               </a>
               <?php } ?>
           </div>

           <div class="amigosImagen">
              <img class="amigos_img" src="<?=$mascota->getFoto()?>" alt="">
           </div>

              <p class="p_kms">
                <span>A <?=$txt?>  cerca de ti</span>
              </p>
         </div>
       <?php endif; ?>
    <?php } ?>
    </div>
 <?php } ?>

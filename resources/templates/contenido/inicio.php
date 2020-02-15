<?php
session_start();
  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
$id = $_SESSION['id'];

$resActividades = ActividadManager::getAll();
$resAnuncio = AnuncioManager::getAll();
$resPublicaciones = PublicacionesManager::getAllPublicaciones($id);

?>


<div class="contendor_inicio">
  <br><br>
  <div class="c_publicaciones">

    <?php foreach ($resPublicaciones as $fila):
        $resultados = MascotaManager::getById($fila->getId_usuario());
        $num_megustas = MegustaManager::contadorMegustas($fila->getId());
        $verificar = MegustaManager::verificarMeGusta($id, $fila->getId());

    ?>
      <div class="cuerpoPerfil">
        <div class="publicacionInfo">
          <img class="small-img" src="<?=$resultados[0]->getFoto() ?>" alt="">
          <a href="eliminarPublicacion.php?idPub=<?=$fila->getId()?>">
            Eliminar

          </a>
          <h2><?=$resultados[0]->getNombre() ?></h2><br>
          <h4> <?=$fila->getFecha() ?></h4>
        </div>
        <div class="publicacionInfo2">
          <img src="<?=$fila->getImagen() ?>" alt="publicacion">
          <p><?=$fila->getTexto() ?></p>
          <span><?=$num_megustas ?></span>
          <a href="perfil.php">
            <?php
                if($verificar){
                  echo " No me gusta";
                  MegustaManager::delete($id, $fila->getId());
                }else{
                  echo " Me gusta";
                  MegustaManager::insert($id, $fila->getId());
                }
            ?>
          </a>
          <a href="#">Comentar</a>
          <a href="#">Compartir</a>
          <a href="#">Comentarios</a>
        </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="c_actividad">
    <?php
    $resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

    foreach ($resultados as $fila) { ?>
         <div class="actividadInicio">
           <h4><?=$fila->getNombre()?></h4><br>
           <p>
             <?=$fila->getFecha()?><br>
             <?=$fila->getLugar()?><br>
             <?=$fila->getDescripcion()?><br><br>
           </p>
         </div>
    <?php } ?>

  </div>
  <div class="c_anuncios">
    <p>Publicidad</p>
    <div class="anuncioInicio">
      <?php
      $resultadoAnuncio = AnuncioManager::getAll();
      foreach ($resultadoAnuncio as $fila) { ?>
         <?php //$fila->getUrl()?>
         <img class="anuncio_img" src="<?=$fila->getFoto()?>" alt="">
      <?php } ?>
      <pre>
      <?php //print_r($resultadoAnuncio);?>
      </pre>

      <!-- <img src="../imgs/InicioFondo1.png" alt="">
      <img src="../imgs/InicioFondo1.png" alt="">
      <img src="../imgs/InicioFondo1.png" alt=""> -->
    </div>

  </div>
</div>

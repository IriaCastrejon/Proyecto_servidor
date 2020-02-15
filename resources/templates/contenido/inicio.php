<?php
session_start();
  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
$id = $_SESSION['id'];

$resAnuncio = AnuncioManager::getAll();
$resPublicaciones = PublicacionesManager::getAll();
$resActividades = ActividadManager::getAll();
$publicaciones=PublicacionesManager::getByIdDeMascota($id);
$resultados = MascotaManager::getById($id);
//generar random para que aparezcan solo 2 anuncios

// foreach $resultadosSiguiendo as $otra
//   $otra->getId
//   $pubki= PublicacionesManager::GETBYID()
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
foreach ($resultadosSiguiendo as $filaAmigo) {
  $idAmigo = $filaAmigo->getId();
  $publicacionById = PublicacionesManager::getById($idAmigo);
  ?>
  <pre>
  <?php //print_r($publicacionById);?>
  </pre>
  <?php
  //$idAmigo = $filaAmigo->getById();
  //$publicacionById = PublicacionesManager::getById($idAmigo);

}
?>



<div class="contendor_inicio">
  <h1> Inicio de Mascota con id: <?= $id ?> </h1>

  <div class="c_publicaciones">
    <!-- <img src="../imgs/publicacion.png" alt="">
    <img src="../imgs/publicacion.png" alt=""> -->

    <?php foreach ($publicaciones as $fila):
        $num_megustas= MegustaManager::contadorMegustas($fila->getId());
    ?>
      <div class="cuerpoPerfil">
        <div class="publicacionInfo">
          <img class="small-img" src="<?=$resultados[0]->getFoto() ?>" alt="">
          <h2><?=$resultados[0]->getNombre() ?></h2><br>
          <h4> <?=$fila->getFecha() ?></h4>
        </div>
        <div class="publicacionInfo2">
          <img src="<?=$fila->getImagen() ?>" alt="publicacion">
          <p><?=$fila->getTexto() ?></p>
          <a href="#"><span><?=$num_megustas ?></span><?=($num_megustas) ? " No me gusta" : " Me gusta" ?></a><a href="perfil.php?">Comentar</a><a href="#">Compartir</a><a href="#">Comentarios</a>
        </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="c_actividad">
    <?php
    $resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

    foreach ($resultados as $fila) { ?>
         <div class="actividades">
           <h4>
             <?=$fila->getId()?>
             <?=$fila->getNombre()?>
           </h4>
         </div>
    <?php } ?>

    <!-- <p>Actividad</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
      sed do eiusmod tempor incididunt ut labore.
    </p>
    <div class="actividadInicio">
      <img src="../imgs/InicioFondo1.png" alt="">
    </div> -->
  </div>
  <div class="c_anuncios">
    <p>Publicidad</p>
    <div class="anuncioInicio">
      <?php
      $resultadoAnuncio = AnuncioManager::getAll();
      foreach ($resultadoAnuncio as $fila) { ?>
         <?=$fila->getUrl()?>
         <img class="anuncio_img" src="<?=$fila->getFoto()?>" alt="">
      <?php } ?>
      <pre>
      <?php print_r($resultadoAnuncio);?>
      </pre>

      <!-- <img src="../imgs/InicioFondo1.png" alt="">
      <img src="../imgs/InicioFondo1.png" alt="">
      <img src="../imgs/InicioFondo1.png" alt=""> -->
    </div>

  </div>
</div>

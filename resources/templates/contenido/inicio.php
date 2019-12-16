<?php
session_start();
  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
$id=$_SESSION['id'];


$resultados = AnuncioManager::getAll();

//generar random para que aparezcan solo 2 anuncios
?>
<div class="contendor_inicio">
  <h1> Inicio de Mascota con id: <?= $id ?> </h1>

  <div class="c_publicaciones">
    <img src="../imgs/publicacion.png" alt="">
    <img src="../imgs/publicacion.png" alt="">
  </div>
  <div class="c_actividad">
    <p>Actividad</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
      sed do eiusmod tempor incididunt ut labore.
    </p>
    <div class="actividadInicio">
      <img src="../imgs/InicioFondo1.png" alt="">
    </div>
  </div>
  <div class="c_anuncios">
    <p>Publicidad</p>
    <div class="anuncioInicio">
      <?php foreach ($resultados as $fila) { ?>
         <?php $fila->getFoto()?>
      <?php } ?>
      <img src="../imgs/InicioFondo1.png" alt="">
      <img src="../imgs/InicioFondo1.png" alt="">
      <img src="../imgs/InicioFondo1.png" alt="">
    </div>

  </div>
</div>

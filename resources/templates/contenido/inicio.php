<?php
session_start();
  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}


$id = $_SESSION['id'];
$errores = [];
$comentario='';


if(isset($_GET['meGusta'])) {
  $idPublicacion = $_GET['idPublicacion'];
  MegustaManager::insert($id,$idPublicacion);

}

if(isset($_GET['noMegusta'])) {
  $idPublicacion = $_GET['idPublicacion'];
  MegustaManager::delete($id,$idPublicacion);

}

if (isset($_POST['enviarComentario'])) {
    $idPublicacion = $_GET['idPublicacion'];

    if (isset($_POST['comentar']) && $_POST['comentar'] != ''){
      $comentario = clean_input($_POST['comentar']);
    }else{
      $errores['comentar']= true;
    }

    if(count($errores)==0){
        $db= DWESBaseDatos::obtenerInstancia();
        ComentarioManager::insertComentariosPublicacion($id,$idPublicacion,$comentario);
    }


}

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
          
          <h2><?=$resultados[0]->getNombre() ?></h2><br>
          <h4> <?=$fila->getFecha() ?></h4>
        </div>
        <div class="publicacionInfo2">
          <img src="<?=$fila->getImagen() ?>" alt="publicacion">
          <p><?=$fila->getTexto() ?></p>
          <span><?=$num_megustas ?></span>
          <a href="perfil.php">
            <?php if ($verificar) { ?>
               <a href="inicio.php?noMegusta=true&idPublicacion=<?=$fila->getId()?>">
                   No me gusta
               </a>
            <?php }else{ ?>
              <a href="inicio.php?meGusta=true&idPublicacion=<?=$fila->getId()?>">
                   Me gusta
             </a>
             <?php } ?>
          </a>


          <a href="javascript:mostrarOcultar(<?=$fila->getId()?>);">Comentarios</a>

            <div class="oculto" id="comentarios<?=$fila->getId()?>">
              <div class="comentar">
                <form class="" action="inicio.php?idPublicacion=<?=$fila->getId()?>" method="post">
                  <textarea name="comentar" rows="8" cols="80" placeholder="Aqui tu comentario"></textarea>
                  <input type="submit" name="enviarComentario" value="Enviar">
                </form>
              </div>

              <div class="comentarios">
                <?php
                   foreach ( $fila->getComentarios() as $filaComentario): ?>
                   <div class="">
                     <img class="small-img" src="<?=($filaComentario->getUsuario())->getFoto()?>" alt="">
                     <?=($filaComentario->getUsuario())->getNombre()?>
                     <?=$filaComentario->getTexto()?>
                   </div>
                <?php endforeach; ?>
              </div>
            </div>
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
  <script>
  function mostrarOcultar(id){
    elemento = document.getElementById('comentarios' + id);
    elemento.classList.toggle("oculto");
  }
  </script>
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

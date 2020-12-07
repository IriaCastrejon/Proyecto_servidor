<?php

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
    <div class="c_actividad">
      <p class="p">Actividades</p>
      <?php
      $resultados = ActividadManager::obtenerActividadPorIdParticipante($id);

      foreach ($resultados as $fila) { ?>
           <div class="actividad">
             <h4><?=$fila->getNombre()?></h4><br>
             <p>
               <span>Día: </span>  <?=substr($fila->getFecha(),0,10)?><br>
              <span>Lugar: </span>  <?=$fila->getLugar()?><br>
               <span>Descripción: </span><?=$fila->getDescripcion()?><br><br>
             </p>
           </div>
      <?php } ?>

    </div><!--fin c_actividades-->
    <div class="c_publicaciones">
        <?php if (count($resPublicaciones)!==0){ ?>

            <?php foreach ($resPublicaciones as $fila):
                $resultados = MascotaManager::getById($fila->getId_usuario());
                $num_megustas = MegustaManager::contadorMegustas($fila->getId());
                $verificar = MegustaManager::verificarMeGusta($id, $fila->getId());

            ?>
              <div class="contenedorPublicaciones">
                  <div class="publicacion">
                    <div class="publicacionCabecera">
                      <div >
                          <img class="small-img" src="<?=$resultados[0]->getFoto() ?>" alt="">
                          <a href="perfil.php?idUsuario=<?=$fila->getId_usuario()?>">
                            <span><?=$resultados[0]->getNombre() ?></span>
                          </a>
                          <p> <?=substr($fila->getFecha(),0,10) ?></p>
                          <a></a>
                      </div>
                    </div><!--publicacionCabecera-->

                      <div class="publicacionCuerpo">
                        <p><?=$fila->getTexto() ?></p>
                        <img src="<?=$fila->getImagen() ?>" alt="publicacion">
                      </div><!--publicacionCuerpo-->
                        <div class="publicacionFooter">
                            <span>Likes <?=$num_megustas ?></span>
                            <a href="perfil.php">
                              <?php if ($verificar) { ?>
                                 <a href="inicio.php?idUsuario=<?=$id?>&noMegusta=true&idPublicacion=<?=$fila->getId()?>">
                                     No me gusta
                                 </a>
                              <?php }else{ ?>
                                <a href="inicio.php?idUsuario=<?=$id?>&meGusta=true&idPublicacion=<?=$fila->getId()?>">
                                     Me gusta
                               </a>
                               <?php } ?>
                            </a>

                          <a href="javascript:mostrarOcultar(<?=$fila->getId()?>);">Comentarios</a>
                        </div><!--publicacionFooter-->
                        <div class="oculto" id="comentarios<?=$fila->getId()?>">
                          <div class="comentar">
                            <form class="" action="inicio.php?idUsuario=<?=$id?>&idPublicacion=<?=$fila->getId()?>" method="post">
                              <textarea name="comentar" rows="8" cols="80" placeholder="Aqui tu comentario"></textarea>
                              <input type="submit" name="enviarComentario" value="Enviar">
                            </form>
                          </div>

                          <div class="comentarios">
                            <?php
                               foreach ( $fila->getComentarios() as $filaComentario): ?>
                               <div class="comentarioUnaLinea">
                                 <img class="small-img" src="<?=($filaComentario->getUsuario())->getFoto()?>" alt="">
                                <span><?=($filaComentario->getUsuario())->getNombre()?></span>
                                 <p><?=$filaComentario->getTexto()?></p>
                               </div>
                            <?php endforeach; ?>
                          </div>
                        </div>
                  </div>

                </div>

            <?php endforeach; ?>

        <?php }else{ ?>
          <div class="notificaciones">
            <h1>No tienes publicaciones. </h1>
            <h2><i>Puedes añadir una nueva publicación en tu perfil</i></h2>
            <h1>Añade nuevos amigos</h1>
            <h2><i>Encuentra a tus amigos usando nuestro buscador.</i></h2>
          </div>
        <?php } ?>
    </div><!--fin contenedor publicaciones-->


    <div class="c_anuncios">
        <p class="p">Publicidad</p>
        <?php
        $resultadoAnuncio = AnuncioManager::getAll();
        foreach ($resultadoAnuncio as $fila) { ?>
           <p class="publicidad">
              <span>Dirección: </span><?=$fila->getUrl()?>
              <img class="anuncio_img" src="<?=$fila->getFoto()?>" alt="">
           </p>

        <?php } ?>
    </div><!--fin c_anuncios-->
  <script>
    function mostrarOcultar(id){
      elemento = document.getElementById('comentarios' + id);
      elemento.classList.toggle("oculto");
    }
  </script>
</div>

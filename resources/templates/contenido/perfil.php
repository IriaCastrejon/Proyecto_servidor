<?php

  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];
$id_sesion=$id;
$errores = [];
$comentario='';
$idInicio = $_GET['idUsuario'];
$idV = $_SESSION['id'];


if($idInicio!==$id){
  $id=$idInicio;
}

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

$ruta='';
$resultados = MascotaManager::getById($id);
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
$resultadosSiguiendo = count($resultadosSiguiendo);
$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);
$resultadosSeguidores = count($resultadosSeguidores);

$publicaciones=PublicacionesManager::getByIdDeMascota($id);



?>
<div class="contenedorPerfilMascota">
  <div class="cabeceraPerfil">
    <div class="fotosYseguidores">
        <img  src="<?=$resultados[0]->getFoto()?>" alt="">
        <?php
            if($idInicio == $idV){ ?>
              <h3><a href="amigos.php">Siguiendo</a> <br> <span><?=$resultadosSiguiendo ?></span> </h3>
              <h3><a href="seguidores.php">Seguidores</a><br> <span><?=$resultadosSeguidores ?></span> </h3>
        <?php    }else{ ?>
            <h3><a href="#">Siguiendo</a> <br> <span><?=$resultadosSiguiendo ?></span> </h3>
            <h3><a href="#">Seguidores</a><br> <span><?=$resultadosSeguidores ?></span> </h3>
        <?php  }
         ?>
    </div><!--seguidres y foto-->

    <div class="datosMascota">
      <div class="info">
        <P><?=$resultados[0]->getNombre()?></P>
        <P><?=$resultados[0]->getDescripcion()?></P>
        <P><?=$resultados[0]->getNombre_dueno()?></P>
      </div>

      <div class="botonesPerfil"><!--datos-->
        <?php if($idInicio==$idV){ ?>

            <a href="editarPerfil.php">
              <input class="enviar" type="submit" name="editar" value="Editar">
            </a><br>

            <a href="publicacion.php">
              <input class="enviar" type="submit" name="crearPublicacion" value="Nueva Publicacion">
            </a>

            <a href="actividades.php">
              <input class="enviar" type="submit" name="actiidad" value="Actividades">
            </a>
        <?php } ?>
      </div>

    </div><!--botones-->

  </div><!--cabeceraPerfil-->




    <?php foreach ($publicaciones as $fila):
        $num_megustas = MegustaManager::contadorMegustas($fila->getId());
        $verificar = MegustaManager::verificarMeGusta($id, $fila->getId());
    ?>
      <div class="contenedorPublicaciones">
        <div class="publicacion">

          <div class="publicacionCabecera">
            <div>
              <img class="small-img" src="<?=$resultados[0]->getFoto() ?>" alt="">
              <span><?=$resultados[0]->getNombre() ?></span>
              <p> <?=substr($fila->getFecha(),0,10) ?></span>
            </div>
            <?php if ($id_sesion != $id){ ?>
              <a></a>
            <?php }else{ ?>
              <a href="eliminarPublicacion.php?idPub=<?=$fila->getId()?>&idUsuario=<?=$id?>">
                <img class="icon-img" src="imgs/borrar.png" alt="">
              </a>
            <?php } ?>

          </div><!--publicacionCabecera-->

          <div class="publicacionCuerpo">
            <p><?=$fila->getTexto() ?></p>
            <img  src="<?=$fila->getImagen() ?>" alt="publicacion">
          </div><!--publicacionCuerpo-->

          <div class="publicacionFooter">
            <span>Likes <?=$num_megustas ?></span>

              <?php if ($verificar) { ?>
                 <a href="perfil.php?idUsuario=<?=$id?>&noMegusta=true&idPublicacion=<?=$fila->getId()?>">
                     No me gusta
                 </a>
              <?php }else{ ?>
                <a href="perfil.php?idUsuario=<?=$id?>&meGusta=true&idPublicacion=<?=$fila->getId()?>">
                     Me gusta
               </a>
               <?php } ?>
          

              <a href="javascript:mostrarOcultar(<?=$fila->getId()?>);">Comentarios</a>
          </div>
          <div class="oculto" id="comentarios<?=$fila->getId()?>">
            <div class="comentar">
              <form class="" action="perfil.php?idUsuario=<?=$id?>&idPublicacion=<?=$fila->getId()?>" method="post">
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
        </div><!--publicacion-->

    </div>
    <?php endforeach; ?>



  <script>
    function mostrarOcultar(id){
      elemento = document.getElementById('comentarios' + id);
      elemento.classList.toggle("oculto");
    }
  </script>

</div>
<br><br>

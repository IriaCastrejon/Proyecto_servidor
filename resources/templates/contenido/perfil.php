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

$ruta='';
$resultados = MascotaManager::getById($id);
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
$resultadosSiguiendo = count($resultadosSiguiendo);
$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);
$resultadosSeguidores = count($resultadosSeguidores);

$publicaciones=PublicacionesManager::getByIdDeMascota($id);



echo "<pre>";
print_r($_POST);
echo "</pre>";
?>
<div class="contenedorPerfilMascota">
  <div class="cabeceraPerfil">

      <img  src="<?=$resultados[0]->getFoto()?>" alt="">
      <div class="datosMascota">
        <h2><?=$resultados[0]->getNombre()?></h2><br>
        <h4><?=$resultados[0]->getDescripcion()?></h4><br>
        <h4><?=$resultados[0]->getNombre_dueno()?></h4><br>
        <a href="editarPerfil.php">
          <input class="enviar" type="submit" name="editar" value="Editar perfil">
        </a><br>

        <a href="publicacion.php">
          <input class="enviar" type="submit" name="crearPublicacion" value="Nueva Publicacion">
        </a>

        <a href="actividades.php">
          <input class="enviar" type="submit" name="actiidad" value="Actividades">
        </a>
      </div>

      <div class="datosAmigos">
        <h3><a href="amigos.php">Siguiendo</a> <br> <span><?=$resultadosSiguiendo ?></span> </h3>
        <h3><a href="seguidores.php">Seguidores</a><br> <span><?=$resultadosSeguidores ?></span> </h3>
      </div>

  </div>




    <?php foreach ($publicaciones as $fila):
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


          <?php if ($verificar) { ?>
             <a href="perfil2.php?noMegusta=true&idPublicacion=<?=$fila->getId()?>">
                 No me gusta
             </a>
          <?php }else{ ?>
            <a href="perfil2.php?meGusta=true&idPublicacion=<?=$fila->getId()?>">
                 Me gusta
           </a>
           <?php } ?>


          <a href="javascript:mostrarOcultar(<?=$fila->getId()?>);">Comentarios</a>

            <div class="oculto" id="comentarios<?=$fila->getId()?>">
              <div class="comentar">
                <form class="" action="perfil2.php?idPublicacion=<?=$fila->getId()?>" method="post">
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



<script>

function mostrarOcultar(id){

  elemento = document.getElementById('comentarios' + id);
  elemento.classList.toggle("oculto");

}



</script>

</div>
<br><br>

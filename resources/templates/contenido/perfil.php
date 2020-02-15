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

$ruta='';
$resultados = MascotaManager::getById($id);
$id_publicacion = PublicacionesManager::getById($id);
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
$resultadosSiguiendo = count($resultadosSiguiendo);
$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);
$resultadosSeguidores = count($resultadosSeguidores);

$publicaciones=PublicacionesManager::getByIdDeMascota($id);


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
<br><br>

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
//print_r($resultados);
$publicaciones= PublicacionesManager::getById($id);
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
$resultadosSiguiendo=count($resultadosSiguiendo);
$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);
$resultadosSeguidores=count($resultadosSeguidores);

$publicaciones=PublicacionesManager::getByIdDeMascota($id);


?>
<div class="contenedorPerfilMascota">
  <div class="cabeceraPerfil">

      <img  src="<?=$resultados[0]->getFoto()?>" alt="">
      <div class="datosMascota">
        <h2><?=$resultados[0]->getNombre()?></h2><br>
        <h4><?=$resultados[0]->getDescripcion()?></h4><br>
        <h4><?=$resultados[0]->getNombre_dueno()?></h4>
        <form class="" action="editarPerfil.php" method="post">
          <input class="enviar" type="submit" name="editar" value="Editar perfil">
        </form><br>
        <form class="miPerfil_publicacionNueva" action="publicacion.php" method="post">
          <input class="enviar" type="submit" name="crearPublicacion" value="Nueva Publicacion">
        </form>
        <form class="miPerfil_actividades" action="actividades.php" method="post">
          <input class="enviar" type="submit" name="actiidad" value="Actividades">
        </form>
      </div>
      <div class="datosAmigos">
        <h3><a href="amigos.php">Siguiendo</a> <br> <span><?=$resultadosSeguidores ?></span> </h3>
        <h3><a href="seguidores.php">Seguidores</a><br> <span><?=$resultadosSiguiendo ?></span> </h3>
      </div>

  </div>




    <?php foreach ($publicaciones as $fila):
        $verifica= MegustaManager::verificarMegustas($id,$fila->getId());
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
          <a href="#"><span><?= $num_megustas ?></span><?php ($verifica) ? 'No me gusta' : 'me gusta' ?></a><a href="perfil.php?">Comentar</a><a href="#">Compartir</a><a href="#">Comentarios</a>
        </div>
    </div>
    <?php endforeach; ?>



</div>
<br><br>

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
print_r($resultados);
$publicaciones= PublicacionesManager::getById($id);
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
$resultadosSiguiendo=count($resultadosSiguiendo);
$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);
$resultadosSeguidores=count($resultadosSeguidores);

$publicaciones=PublicacionesManager::getByIdDeMascota($id);
echo '<pre>';
  print_r($publicaciones);
echo '</pre>';
?>
<h1>

perfil de Mascota con id: <?= $id ?>

</h1>

<div class="cabeceraPerfil">
    <img class="small-img" src="<?=$resultados[0]->getFoto()?>" alt="">
    <div class="datosMascota">
      <h3><?=$resultados[0]->getNombre()?></h3><br>
      <p><?=$resultados[0]->getDescripcion()?></p>
      <p><?=$resultados[0]->getNombre_dueno()?></p>
      <form class="" action="editarPerfil.php" method="post">
        <input type="submit" name="editar" value="Editar perfil">
      </form><br>
      <form class="miPerfil_publicacionNueva" action="publicacion.php" method="post">
        <input type="submit" name="crearPublicacion" value="Nueva Publicacion">
      </form>


    </div>
    <div class="datosAmigos">
      <h3>Seguidores <span><?=$resultadosSeguidores ?></span> </3>
      <h3>Siguiendo <span><?=$resultadosSiguiendo ?></span> </3>
    </div>
</div><br><br>
<div class="cuerpoPerfil">

  <?php foreach ($publicaciones as $fila): ?>

    <div class="publicacion">
      <img class="small-img" src="<?=$resultados[0]->getFoto() ?>" alt="">
      <span><?=$resultados[0]->getNombre() ?></span>
      <span> <?=$fila->getFecha() ?></span>
      <img src="<?=$fila->getImagen() ?>" alt="publicacion">
    </div>
  <?php endforeach; ?>

</div>

<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'mascota'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];

$ruta='';
$resultados = EmpresaManager::getAllById($id);

?>

<div class="contenedorPerfilCliente">

      <img  src="<?=$resultados[0]->getFoto()?>" alt="">
      <h2><?=$resultados[0]->getNombre()?></h2><br>
      <h4><?=$resultados[0]->getLocalidad()?></h4><br>
      <h4><?=$resultados[0]->getCP()?></h4><br>
      <h4><?=$resultados[0]->getTelefono()?></h4><br>

      <a href="editarPerfil.php">
        <input class="enviar" type="submit" name="editar" value="Editar perfil">
      </a>


</div>

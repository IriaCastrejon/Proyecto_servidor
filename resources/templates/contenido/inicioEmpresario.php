<?php
session_start();
  //echo $_SESSION['id'].' Las id  es <br>';
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

<div class="contenedorPerfilMascota">
  <div class="cabeceraPerfil">
    <div class="">
      <img  src="<?=$resultados[0]->getFoto()?>" alt="">
      <div class="datosMascota">
        <h2><?=$resultados[0]->getNombre()?></h2><br>
        <h4><?=$resultados[0]->getLocalidad()?></h4><br>
        <h4><?=$resultados[0]->getCP()?></h4><br>
        <h4><?=$resultados[0]->getTelefono()?></h4><br>
    </div>  
      <a href="editarPerfil.php">
        <input class="enviar" type="submit" name="editar" value="Editar perfil">
      </a><br>

      </div>
  </div>
</div>

<?php

session_start();

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];
$id_dejar = $_GET['idDejar'];

if(isset($_POST['unfollow'])) {
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::delete($id,$id_dejar);
  header('Location: amigos.php');
  die();

}

$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);

?>
<div class="contenedor_amigos">
<h1> Seguidores </h1>
   <?php foreach ($resultadosSeguidores as $fila) { ?>
      <div class="amigos">
         <h3><?=$fila->getNombre()?></h3>
        <img class="amigos_img" src="<?=$fila->getFoto()?>" alt="">
      </div>
    <?php } ?>

</div>

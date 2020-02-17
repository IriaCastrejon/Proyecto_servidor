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

$buscar='';
$id=$_SESSION['id'];
$id_dejar = '';
$id_seguir = '';

if(isset($_GET['unfollow'])) {
  $id_dejar = (int)$_GET['idDejar'];
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::delete($id,$id_dejar);
  header('Location: amigos.php');
  die();
}

if(isset($_GET['seguir'])) {
  $id_seguir = (int)$_GET['idSeguir'];
  AmigoManager::insert($id,$id_seguir);
  header("Location: amigos.php");
  die();
}

?>

<?php
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
?>



<div class="contenedor_amigos">
  <h1> Mis amigos </h1>
  <?php foreach ($resultadosSiguiendo as $fila) { ?>
       <div class="amigos">
         <h3><?=$fila->getNombre()?></h3>

         <a href="amigos.php?unfollow=true&idDejar=<?=$fila->getId()?>">
           <button class="boton">Dejar de Seguir</button>
         </a>

         <img class="amigos_img" src="<?=$fila->getFoto()?>" alt="">
       </div>

  <?php } ?>
</div>

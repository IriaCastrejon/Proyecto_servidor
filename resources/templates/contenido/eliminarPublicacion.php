<?php

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id_pub = $_GET['idPub'];
$id=$_SESSION['id'];

PublicacionesManager::delete($id_pub);
header("Location: perfil.php?idUsuario=$id");
die();

?>

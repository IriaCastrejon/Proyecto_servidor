<?php

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id_pub = $_GET['idPub'];

PublicacionesManager::delete($id_pub);
header('Location: perfil.php');
die();

?>

<?php
$id_pub = $_GET['idPub'];

PublicacionesManager::delete($id_pub);
//header('Location: perfil.php');
//die();

?>

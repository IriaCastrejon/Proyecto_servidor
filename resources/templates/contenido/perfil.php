<?php
session_start();
  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
$id=$_SESSION['id'];

$ruta='';


?>
<h1>

perfil de Mascota con id: <?= $id ?>

</h1>
<img src="<?=$ruta ?>" alt="">

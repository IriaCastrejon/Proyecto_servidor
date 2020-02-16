<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'mascota'){
  header('Location: accesoRestringido.php');
  die();
}

 ?>

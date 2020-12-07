<?php


TokenManager::delete($_SESSION['id'],$_SESSION['tipo_cliente']);
session_destroy();

setCookie("recuerdame","",time()-1);
header("Location: login.php ");
die();


 ?>

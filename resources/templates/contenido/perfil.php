<?php
session_start();
  //echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];

$ruta='';
$resultados = MascotaManager::getAllById($id);

?>
<h1>

perfil de Mascota con id: <?= $id ?>

</h1>

<?php foreach ($resultados as $fila) { ?>

<img class="small-img" src="<?=$fila->getFoto()?>" alt="">
<?php } ?>

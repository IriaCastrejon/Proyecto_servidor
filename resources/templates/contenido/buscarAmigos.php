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
$id_seguir = $_GET['seguir'];

if(isset($_POST['seguir'])) {
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::insert($id,$id_seguir);
  header('Location: amigos.php');
  die();

}





$resultados = AmigoManager::obtenerNoAmigos($id);



foreach ($resultados as $fila) { ?>

  <div class="amigos">
    <h4>
      <?=$fila->getNombre()?>
      <form class="" action="buscarAmigos.php?seguir=<?=$fila->getId()?>" method="post">
        <input type="submit" name="seguir" value="Seguir">
      </form>

    </h4>
  </div>

<?php } ?>

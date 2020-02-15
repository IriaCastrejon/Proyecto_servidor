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
$id_seguir = $_GET['id'];
if(isset($_GET['seguir'])) {
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
      <a href="buscarAmigos.php?seguir=true&id=<?=$fila->getId()?>">
        <button> Seguir<button>
      </a>

    </h4>
  </div>

<?php } ?>

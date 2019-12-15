<?php

session_start();
  echo $_SESSION['id'].' Las id  es <br>';
if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id=$_SESSION['id'];

$resultados = AmigoManager::obtenerAmigos($id);

foreach ($resultados as $fila) { ?>
     <div class="amigos">
       <figure>
         <img src="<?=$fila->getFoto()?>" alt="">
         <figcaption><?=$fila->getNombre()?></figcaption>
       </figure>
     </div>

<?php } ?>

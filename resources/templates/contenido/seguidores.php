<?php


if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}



$id=$_SESSION['id'];

if(isset($_GET['seguir'])) {
  $id_seguir = (int)$_GET['idSeguir'];
  AmigoManager::insert($id,$id_seguir);
  header("Location: seguidores.php");
  die();
}
if(isset($_GET['unfollow'])) {
  $id_dejar = (int)$_GET['idDejar'];
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::delete($id,$id_dejar);
  header("Location: seguidores.php");
  die();
}

$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);

?>
<div class="contenedor_amigos">
<h1> Seguidores </h1>
   <?php foreach ($resultadosSeguidores as $fila) { ?>
     <div class="amigos">
       <div class="amigosCabecera">
         <p><?=$fila->getNombre()?></p>

          <?php if (AmigoManager::compruebaAmistad($id,$fila->getId())) { ?>
             <a href="seguidores.php?unfollow=true&idDejar=<?=$fila->getId()?>">
               <button class="boton">No seguir</button>
             </a>
          <?php }else{ ?>
            <a href="seguidores.php?seguir=true&idSeguir=<?=$fila->getId()?>">
             <button class="boton">Seguir</button>
           </a>
           <?php } ?>
       </div>
       <div class="amigosImagen">
          <img class="amigos_img" src="<?=$fila->getFoto()?>" alt="">
       </div>
     </div>
    <?php } ?>

</div>

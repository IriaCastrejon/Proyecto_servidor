<?php

$id=$_SESSION['id'];
$id_seguir = '';
session_start();

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}
if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

//obteer los resultados del get

if(isset($_GET['unfollow'])) {
  $id_dejar = (int)$_GET['idDejar'];
  $buscar=$_GET['busca'];
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::delete($id,$id_dejar);
  header("Location: buscarAmigos.php?busca=$buscar");
  die();
}

if(isset($_GET['seguir'])) {
  $id_seguir = (int)$_GET['idSeguir'];
  $buscar=$_GET['busca'];
  AmigoManager::insert($id,$id_seguir);
  header("Location: buscarAmigos.php?busca=$buscar");
  die();
}

if (isset($_GET['busca']) && $_GET['busca'] != "") {
  $buscar=$_GET['busca'];
  $resultados=MascotaManager::buscar($buscar);
}
?>
<?php if (count($resultados)<=0){ ?>
  <h1>No hay resultados para su busqueda</h1>
  <h2>Intente nuevamente</h2>
<?php }else{ ?>
  <?php foreach ($resultados as $fila) { ?>
    <div class="amigosParaSeguir">
      <img class="small-img" src="<?=$fila->getFoto()?>" alt=""><?=$fila->getNombre()?>
        <?php if (AmigoManager::compruebaAmistad($id,$fila->getId())) { ?>
           <a href="buscarAmigos.php?busca=<?=$buscar?>&unfollow=true&idDejar=<?=$fila->getId()?>">
             <button>Dejar de seguir</button>
           </a>
        <?php }else{ ?>
          <a href="buscarAmigos.php?busca=<?=$buscar?>&seguir=true&idSeguir=<?=$fila->getId()?>">
           <button>Seguir</button>
         </a>
         <?php } ?>
      </a> <!--Este a SOBRAAAAAAAAAAAAAAA!!!-->
    </div>
   <?php } ?>
<?php } ?>

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

$buscar='';
$id=$_SESSION['id'];
$id_dejar = '';
$id_seguir = '';

if(isset($_GET['unfollow'])) {
  $id_dejar = (int)$_GET['idDejar'];
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::delete($id,$id_dejar);
  header('Location: amigos.php');
  die();
}
echo '<pre>';
print_r($_GET);
echo '</pre>';
if(isset($_GET['seguir'])) {
  $id_seguir = (int)$_GET['idSeguir'];
  $buscar=$_GET['busca'];
  AmigoManager::insert($id,$id_seguir);
  header("Location: amigos.php?busca=$buscar");
  die();
}
if (isset($_GET['busca']) && $_GET['busca'] != "") {
  $buscar=$_GET['busca'];
  $salidaBuscador=MascotaManager::buscar($buscar);

}

?>
<div>
  <form class="" action="amigos.php" method="get" >
    <input type="text" name="busca" value="<?= $buscar?>" placeholder="Busca">
    <input type="submit" name="enviar" value="Buscar">
  </form>
</div>

<?php
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
?>
<?php if (!isset($_GET['busca'])): ?>
<div class="amigos">
  <caption>Mis amigos</caption>
  <table>
    <tbody>
      <?php foreach ($resultadosSiguiendo as $fila) {
        ?>
        <tr>
          <td>
            <img class="small-img" src="<?=$fila->getFoto()?>" alt=""><?=$fila->getNombre()?>
            <a href="amigos.php?unfollow=true&idDejar=<?=$fila->getId()?>">
              <button >Dejar de Seguir</button>
            </a>
          </td>
        </tr>
       <?php } ?>
    </tbody>
  </table>
</div>
<?php endif; ?>

<div class="resultadosBuscador">
  <caption>Resultados de la busqueda</caption>
   <table>
     <tbody>
       <?php foreach ($salidaBuscador as $fila) { ?>
         <tr>
           <td>
             <img class="small-img" src="<?=$fila->getFoto()?>" alt=""><?=$fila->getNombre()?>
               <?php if (AmigoManager::compruebaAmistad($id,$fila->getId())) { ?>
                  <a href="amigos.php?unfollow=true&idDejar=<?=$fila->getId()?>">
                    <button>Dejar de seguir</button>
                  </a>
               <?php }else{ ?>
                 <a href="amigos.php?busca=<?=$buscar?>&seguir=true&idSeguir=<?=$fila->getId()?>">
                  <button>Seguir</button>
                </a>
                <?php } ?>
             </a>
           </td>
         </tr>
        <?php } ?>
     </tbody>
   </table>
</div>

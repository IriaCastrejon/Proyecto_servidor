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
$id_dejar = $_GET['idDejar'];
$id_seguir = $_GET['idSeguir'];
if(isset($_POST['unfollow'])) {
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::delete($id,$id_dejar);
  header('Location: amigos.php');
  die();
}

if(isset($_GET['seguir'])) {
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::insert($id,$id_seguir);
  //header('Location: amigos.php');
  //die();
}
var_dump($_GET);
if (isset($_GET['busca']) && $_GET['busca'] != "") {
  echo 'dentro del det en perfil <br>';
  echo $_GET['busca'];

  $salidaBuscador=MascotaManager::buscar($_GET['busca']);
  echo '<br>';
 // var_dump($salidaBuscador);
}

?>
<div>
  <form class="" action="amigos.php" method="get" >
    <input type="text" name="busca" value="<?= $buscar?>" placeholder="Buscar amigo">
    <input type="submit" name="enviar" value="Buscar">
  </form>
</div>

<?php
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
?>

<div class="amigos">
   <table>
     <tbody>
       <?php foreach ($resultadosSiguiendo as $fila) {

         ?>
         <tr>
           <td>
             <img class="small-img" src="<?=$fila->getFoto()?>" alt=""><?=$fila->getNombre()?>
             <form class="" action="amigos.php?idDejar=<?=$fila->getId()?>" method="post">
               <input type="submit" name="unfollow" value="Dejar de seguir">
             </form>
           </td>
         </tr>
        <?php } ?>
     </tbody>

   </table>
</div>
<div class="resultadosBuscador">
  <br><br><br>  <br><br><br>
   <table>
     <tbody>
       <?php foreach ($salidaBuscador as $fila) { ?>
         <tr>
           <td>
             <img class="small-img" src="<?=$fila->getFoto()?>" alt=""><?=$fila->getNombre()?>
             <a href="amigos.php?seguir=true&idSeguir=<?=$fila->getId()?>">
              <button> Seguir</button>
             </a>
           </td>
         </tr>
        <?php } ?>
     </tbody>

   </table>
</div>

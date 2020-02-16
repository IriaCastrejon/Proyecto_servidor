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
$id_dejar = $_GET['idDejar'];

if(isset($_POST['unfollow'])) {
  $db= DWESBaseDatos::obtenerInstancia();
  AmigoManager::delete($id,$id_dejar);
  header('Location: amigos.php');
  die();

}

$resultadosSeguidores = AmigoManager::obtenerSeguidores($id);

?>
<div class="amigos">


   <table>

     <tbody>
       <?php foreach ($resultadosSeguidores as $fila) { ?>
         <tr>
           <td><img class="small-img" src="<?=$fila->getFoto()?>" alt=""><?=$fila->getNombre()?></td>
         </tr>
        <?php } ?>
     </tbody>

   </table>
</div>

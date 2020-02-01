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

?>


<a href="buscarAmigos.php">Buscar Amigos</a>

<?php

$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);


?>
<div class="amigos">


   <table>
     <!--
     <thead>
       <tr>
         <th>SIGUIENDO</th>

       </tr>
     </thead>
   -->
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

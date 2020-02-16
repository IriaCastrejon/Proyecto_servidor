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

if(isset($_GET['seguir'])) {
  $id_seguir = (int)$_GET['idSeguir'];
  AmigoManager::insert($id,$id_seguir);
  header("Location: amigos.php");
  die();
}

?>

<?php
$resultadosSiguiendo = AmigoManager::obtenerAmigos($id);
?>

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

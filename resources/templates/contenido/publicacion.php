<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$id = $_SESSION['id'];
$errores=[];
$imagen_nombre='';
$contenido='';

if ($_POST['enviar']== 'Publicar') {

  if (isset($_POST['contenido']) && $_POST['contenido'] != '') {
    $contenido=clean_input($_POST['contenido']);
  }else {
  $errores['contenido']='Debe rellenar este campo';
  }

  if(count($_FILES)>0) {
      if($_FILES['imagen']['size'] < $config['MB_2']){
          if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/jpg"){
              // Gestionamos la información del fichero
              $fichero_tmp = $_FILES["imagen"]["tmp_name"];
              $imagen_nombre = basename($_FILES["imagen"]["name"]);
              $ruta_destino = $config['img_path']."/";

          } else {
              $errores[] = "Fichero no soportado";
          }
      } else {
          $errores[] = "Fichero gigante";
      }
  } else {
      $errores[] = "Sin imagen";
  }

if (count($errores)==0) {

  PublicacionesManager::insert($_SESSION['id'], $imagen_nombre,$contenido);
  $db = DWESBaseDatos::obtenerInstancia();
  $ultimoId= $db->getLastId();

  if (move_uploaded_file($fichero_tmp, $ROOT.$ruta_destino.$imagen_nombre)) {

  } else {
      $errores[] = "Error moviendo fichero";

      $borrado = PublicacionesManager::delete($ultimoId);

      if(!$borrado) {

      }
  }
  header("Location: perfil.php?idUsuario=$id");
  die();
}

}

 ?>
 <div class="nuevaPublicacion">

   <form  action="publicacion.php" method="post" enctype="multipart/form-data">
    <h2>Comparte lo que piensas</h2>
     <input type="textarea" name="contenido" value="<?= $contenido ?>"> <br>
      <h3>Agrega una imagen</h3><input type="file" name="imagen" accept="image/png, image/jpeg"><br>
     <?php foreach ($errores as $key => $value): ?>
       <span class="error"><?=$value ?></span>
     <?php endforeach; ?>
     <br><br><input class="enviar" type="submit" name="enviar" value="Publicar"><br><br>
   </form>
 </div>

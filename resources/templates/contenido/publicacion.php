<?php

if( !isset($_SESSION['id']) ){
    header('Location: login.php');
    die();
}

if($_SESSION['tipo_cliente'] == 'empresa'){
  header('Location: accesoRestringido.php');
  die();
}

$errores=[];
$imagen_nombre='';
$contenido='';
print_r($_POST);

if ($_POST['enviar']== 'Publicar') {

  if (isset($_POST['contenido']) && $_POST['contenido'] != '') {
    $contenido=clean_input($_POST['contenido']);
  }else {
  $errores['contenido']='Debe rellenar este campo';
  }

  /*if(count($_FILES)>0) {
      if($_FILES['imagen']['size'] < $config['MB_2']){
          if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg"){
              // Gestionamos la información del fichero
              $fichero_tmp = $_FILES["imagen"]["tmp_name"];
              $imagen_nombre = basename($_FILES["imagen"]["name"]);
              $ruta_destino = $config['img_path']. "/" . $_SESSION['id']. "/";

              if (!file_exists($ruta_destino)) {
                 mkdir('resources/images/'.$_SESSION['id']);
              }

              echo "Depuración<br>";
              echo "$fichero_tmp <br>$imagen_nombre <br>$ruta_destino <br>";*/

              /*
              Si existe lo machacamos. Tener en cuenta
              if (file_exists($ruta_destino)) {
                  // Procesar error
              }
              */

        /*  } else {
              $errores[] = "Fichero no soportado";
          }
      } else {
          $errores[] = "Fichero gigante";
      }
  } else {
      $errores[] = "Sin imagen";
  }*/
  if(count($_FILES)>0) {
      if($_FILES['imagen']['size'] < $config['MB_2']){
          if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg"){
              // Gestionamos la información del fichero
              $fichero_tmp = $_FILES["imagen"]["tmp_name"];
              $imagen_nombre = basename($_FILES["imagen"]["name"]);
              $ruta_destino = $config['img_path']."/";


              echo "Depuración<br>";
              echo "$fichero_tmp <br>$imagen_nombre <br>$ruta_destino <br>";

              /*
              Si existe lo machacamos. Tener en cuenta
              if (file_exists($ruta_destino)) {
                  // Procesar error
              }
              */

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
    echo 'moviendo fichero <br>';
  } else {
      $errores[] = "Error moviendo fichero";

      $borrado = PublicacionesManager::delete($ultimoId);

      if(!$borrado) {
          // Ha ocurrido un error extraño
          // Debemos reportarlo y que un admin
          // Deje la información correcta
          // Hay un tema sin imagen
          // También podríamos usar transacciones de base de datos
      }
  }
}



}

 ?>
 <form class="" action="publicacion.php" method="post" enctype="multipart/form-data">
   <label for=""> Texto </label> <input type="textarea" name="contenido" value="<?= $contenido ?>"> <br>
   <label for="">Subir foto</label><input type="file" name="imagen" accept="image/png, image/jpeg"><br><br>
   <?php foreach ($errores as $key => $value): ?>
     <span class="error"><?=$value ?></span>
   <?php endforeach; ?>
   <br><input type="submit" name="enviar" value="Publicar">
 </form>

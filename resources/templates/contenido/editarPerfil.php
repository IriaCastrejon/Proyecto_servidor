<?php

print_r($_POST);
$imagen='';
$errores=[];

if ($_POST['enviar']=="Realizar cambios") {
  if(count($_FILES)>0) {
    if($_FILES['imagen']['size'] < $config['MB_2']){

        if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg"){
            // Gestionamos la información del fichero
            $fichero_tmp = $_FILES["imagen"]["tmp_name"];
            $imagen_nombre = basename($_FILES["imagen"]["name"]);
            $ruta_destino = $config['img_path']."/";
            echo "Depuración<br>";
            echo "$fichero_tmp <br>$imagen_nombre <br>$ruta_destino <br>";

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

    MascotaManager::update($_SESSION['id'], $imagen_nombre);
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


}//enviar

 ?>

 <div class="cambiar_foto">
   <form class="" action="editarPerfil.php" method="post" enctype="multipart/form-data">
     <label for="">Cambiar foto de perfil</label><input type="file" name="imagen" value="Cambiar"><br>
     <input type="submit" name="enviar" value="Realizar cambios">
   </form>
 </div>

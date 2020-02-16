<?php

$imagen='';
$errores=[];
$id = $_SESSION['id'];

if ($_POST['enviar']=="Cambiar") {
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
    if($_SESSION['tipo_cliente'] == 'mascota'){
      MascotaManager::update($_SESSION['id'], $imagen_nombre);
      $db = DWESBaseDatos::obtenerInstancia();
      $ultimoId= $db->getLastId();

      if (move_uploaded_file($fichero_tmp, $ROOT.$ruta_destino.$imagen_nombre)) {

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
      header("Location: perfil.php?idUsuario=$id");
      die();
    }else{
      EmpresaManager::update($_SESSION['id'], $imagen_nombre);
      $db = DWESBaseDatos::obtenerInstancia();
      $ultimoId= $db->getLastId();



      header('Location: inicioEmpresario.php');
      die();
    }

  }


}//enviar

 ?>

 <div class="cambiar_foto">
   <h2>Modificar foto de perfil </h2>
   <form class="" action="editarPerfil.php" method="post" enctype="multipart/form-data">
     <h3>Subir nueva foto</h3><input type="file" name="imagen" value=""><br><br>
     <input class="enviar" type="submit" name="enviar" value="Cambiar"><br><br>
   </form>
 </div>

<?php

  session_start();
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';



  if( !isset($_SESSION['id']) ){
      header('Location: login.php');
      die();
  }

define ("MB_2", 2097152); // Esto se puede y debe sacar al config

  $id = $_SESSION['id'];
  $cliente = $_SESSION['tipo_cliente'];
  $duracion = '';
  $fecha_alta = '';
  $foto = '';
  // $fecha_baja = fecha_alta + duracion;
  //$fecha_baja = strtotime($fecha_alta."+ ". $duracion." days");
  $url= '';
  $mascota=false;
  $empresa=false;

  $errores=[];

  // if (isset($_POST['tipo_cliente'])) {
  //   $_SESSION['tipo_cliente']=$_POST['cliente'];
  // }

  //Controlar que sea una empresa
  // if (isset($_SESSION['tipo_cliente'])) {
  //   if ($_SESSION['tipo_cliente'] == 'mascota') {
  //     $mascota=true;
  //   }else{
  //     $empresa=true;
  //   }
  // }
/*
if($cliente == 'empresa'){

}
*/
// validacion del formulario
  if (isset($_POST['comprar'])) {

    // duracion
    if (isset($_POST['duracion']) && $_POST['duracion'] != '') {
      $duracion=clean_input($_POST['duracion']);
    }else{
      $errores['duracion']= 'introduce una duración';
    }

    //Funcion para validar la fecha que sea mayor a la actual
    function validarFecha($fecha){
    	// $valores = explode('/', $fecha);
    	// if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
    	// 	return true;
      // }else{
      //   return false;
      // }
      $hoy = getdate();
      //print_r($hoy);
      $fechaHoy = $hoy['mday'].'/'.$hoy['mon'].'/'.$hoy['year'];
      echo '<br>' . $fechaHoy;

      if ($fecha > $fechaHoy) {
        return true;
      }else{
        return false;
      }
    }
    // validarFecha($fecha);

    // fecha_alta
    if (isset($_POST['fecha_alta']) && $_POST['fecha_alta'] != '') {
      if (validarFecha($fecha_alta)) {
        $fecha_alta=clean_input($_POST['fecha_alta']);
        //$fecha_baja = $fecha_alta + durarion;
      }else{
        $errores['fecha_alta'] = 'Introduce una fecha mayor a la actual';
      }
    }else{
      $errores['fecha_alta'] = 'Introduce una fecha de alta';
    }

    //foto

    if(count($_FILES)>0) {
        if($_FILES['imagen']['size'] < MB_2){
            if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg"){
                // Gestionamos la información del fichero
                $fichero_tmp = $_FILES["imagen"]["tmp_name"];
                $nombre_real = basename($_FILES["imagen"]["name"]);
                $ruta_destino = $config['img_path']."/".$nombre_real;

                echo "Depuración<br>";
                echo "$fichero_tmp <br>$nombre_real <br>$ruta_destino <br>";

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

    //url
    if (isset($_POST['url']) && $_POST['url'] != '') {
      $url = clean_input($_POST['url']);
    }
    //errores
    if(count($errores)==0){
      $id = AnuncioManager::insert($id,$nombre_real,$fecha_alta, $fecha_baja, $url);

      if($id){
          if (move_uploaded_file($fichero_tmp, $ROOT.$ruta_destino)) {
            header('Location: anuncioOk.php');
            die();
          } else {
              $errores[] = "Error moviendo fichero";
              // Ojo!!!
              $borrado = TemaManager::delete($id);

              if(!$borrado) {
                  // Ha ocurrido un error extraño
                  // Debemos reportarlo y que un admin
                  // Deje la información correcta
                  // Hay un tema sin imagen
                  // También podríamos usar transacciones de base de datos
              }
          }
      } else {
          $errores[] = "Error en la insercción";
      }



      // $_SESSION['id']= $db->getLastId();
      // echo $_SESSION['id']. ' ultimo id insertado';
      //header("location: anuncio.php");

    }// no hay errores

  }
  //echo $_SESSION['tipo_cliente'];
 ?>

 <div class="form_anuncio">

  <?php if (isset($_SESSION['id'])): ?>
 <form class="registro" action="anuncioNuevo.php" method="post">
   <!-- Duracion-->
   <?php if (isset($errores['duracion'])): ?>
     <span class="error">Debe introducir una duración</span> <br>
   <?php endif; ?>
   <label for=""> Duración </label><input type="text" name="duracion" value=" <?= $duracion ?>"><br><br>

   <!-- EMAIL-->
   <?php if (isset($errores['fecha_alta'])): ?>
     <span class="error"> Debe introducir una fecha de alta </span> <br>
   <?php endif; ?>
   <label for=""> Fecha de alta </label><input type="date" name="fecha_alta" value="<?= $fecha_alta ?>"><br><br>

   <label for="">Foto</label><input type="file" name="imagen"accept="image/png, image/jpeg"><br>

   <label for="">Url</label><input type="text" name="url" value="<?= $url ?>"><br><br>

   <br><br> <input type="submit" name="comprar" value="Comprar">

  </form>
  <?php endif; ?>

 </div>

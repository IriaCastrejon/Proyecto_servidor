<?php

  session_start();
  
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';




  if( !isset($_SESSION['id']) ){
      header('Location: login.php');
      die();
  }

  if($_SESSION['tipo_cliente'] == 'mascota'){
    header('Location: accesoRestringido.php');
    die();
  }

  $id = $_SESSION['id'];
  $duracion = '';
  $fecha_alta = '';
  $foto = '';
  $fecha_baja = '';
  $url= '';
  $mascota=false;
  $empresa=false;

  $errores=[];

  define("ERROR_FECHA_MAYOR", 0);
  define("ERROR_FECHA_NO", 1);




// validacion del formulario
  if (isset($_POST['comprar'])) {

    // duracion
    if (isset($_POST['duracion']) && $_POST['duracion'] != '') {
      $duracion=clean_input($_POST['duracion']);
    }else{
      $errores['duracion']= true;
    }



    // fecha_alta
    if (isset($_POST['fecha_alta']) && $_POST['fecha_alta'] != '') {
      if (validarFecha($_POST['fecha_alta'])) {
        $fecha_alta=clean_input($_POST['fecha_alta']);
        $fecha_baja = strtotime($fecha_alta. "+ $duracion days");

        $fecha_baja = date('Y-m-d',$fecha_baja);

      }else{
        $errores['fecha_alta'] = ERROR_FECHA_MAYOR;
      }
    }else{
      $errores['fecha_alta'] = ERROR_FECHA_NO;
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
    }else{
      $errores['url']= true;
    }
    //errores
    if(count($errores)==0){
      $db= DWESBaseDatos::obtenerInstancia();
      AnuncioManager::insert($id,$nombre_real,$fecha_alta, $fecha_baja, $url);

      header('Location: anuncio.php');
      die();

          if (move_uploaded_file($fichero_tmp, $ROOT.$ruta_destino)) {
            header('Location: anuncio.php');
            exit;
          } else {
              $errores[] = "Error moviendo fichero";
              // Ojo!!!
              $borrado = AnuncioManager::delete($id);

              if(!$borrado) {
                  // Ha ocurrido un error extraño
                  // Debemos reportarlo y que un admin
                  // Deje la información correcta
                  // Hay un tema sin imagen
                  // También podríamos usar transacciones de base de datos
              }
          }

      }



      // $_SESSION['id']= $db->getLastId();
      // echo $_SESSION['id']. ' ultimo id insertado';
      //header("location: anuncio.php");

    }// no hay errores


  //echo $_SESSION['tipo_cliente'];
 ?>

 <div class="form_anuncio">

  <?php if (isset($_SESSION['id'])): ?>
 <form class="registro" action="anuncioNuevo.php" method="post"  enctype="multipart/form-data" >
   <!-- Duracion-->
   <?php if (isset($errores['duracion'])): ?>
     <span class="error">Debe introducir una duración</span> <br>
   <?php endif; ?>
   <label for=""> Duración </label><input type="text" name="duracion" value="<?=$duracion?>"><br><br>

   <!-- FECHA ALTA-->
   <?php if (isset($errores['fecha_alta'])){
           if ($errores['fecha_alta'] == ERROR_FECHA_MAYOR ){ ?>
             <span class="error"> Introduce una fecha mayor a la actual </span> <br>
           <?php }else if($errores['fecha_alta'] == ERROR_FECHA_NO){ ?>
             <span class="error"> Introduce una fecha</span> <br>
    <?php }
         } ?>

   <label for=""> Fecha de alta </label><input type="date" name="fecha_alta" value="<?=$fecha_alta?>"><br><br>

   <label for="">Foto</label><input type="file" name="imagen" accept="image/png, image/jpeg"><br>

   <?php if (isset($errores['url'])): ?>
     <span class="error"> Debe introducir una url </span> <br>
   <?php endif; ?>
   <label for="">Url</label><input type="text" name="url" value="<?=$url?>"><br><br>

   <br><br> <input type="submit" name="comprar" value="Comprar">

  </form>
  <?php endif;


  echo '<pre>';
  print_r($errores);
  print_r($_FILES);
  echo '</pre>';

  ?>

 </div>

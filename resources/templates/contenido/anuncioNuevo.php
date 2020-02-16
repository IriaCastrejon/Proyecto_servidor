<?php

  session_start();


  if( !isset($_SESSION['id']) && $_SESSION['tipo_cliente']!='Empresa'){
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
  $empresa=false;

  $precio= 0;


  $errores=[];

  define("PRECIO_DIA", 25);
  define("ERROR_FECHA_MAYOR", 0);
  define("ERROR_FECHA_NO", 1);

  $precioDia = PRECIO_DIA;
  $precio = $precioDia * $_POST['duracion'];

  //Calculo
  if (isset($_POST['calcular'])) {
    // duracion
    if (isset($_POST['duracion']) && $_POST['duracion'] > 0) {
      $duracion=clean_input($_POST['duracion']);
    }else{
      $errores['duracion']= true;
    }

    //url
    if (isset($_POST['url']) && $_POST['url'] != '') {
      $url = clean_input($_POST['url']);
    }else{
      $errores['url']= true;
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
  }


// validacion del formulario
  if (isset($_POST['comprar'])) {
    // duracion
    if (isset($_POST['duracion']) && $_POST['duracion'] > 0) {
      $duracion=clean_input($_POST['duracion']);
    }else{
      $errores['duracion']= true;
    }

    //url
    if (isset($_POST['url']) && $_POST['url'] != '') {
      $url = clean_input($_POST['url']);
    }else{
      $errores['url']= true;
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
        if($_FILES['imagen']['size'] < $config['MB_2']){
            if($_FILES['imagen']['type'] == "image/png" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/jpg" ){
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
                $errores['foto'] = "Fichero no soportado";
            }
        } else {
            $errores['foto'] = "Fichero gigante";
        }
    } else {
        $errores['foto'] = "Sin imagen";
    }
    // else{
    //   $errores['foto'] = 'Introduce una foto';
    // }

    //errores
    if(count($errores) == 0){
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

      //header("location: anuncio.php");

    }

 ?>

 <div class="form_anuncio">

  <?php if (isset($_SESSION['id'])): ?>
 <form class="registro" action="anuncioNuevo.php" method="post"  enctype="multipart/form-data" >
   <!-- Duracion-->
   <?php if (isset($errores['duracion'])): ?>
     <span class="error">Debe introducir una duración</span> <br>
   <?php endif; ?>
   <label for=""> Duración </label><input type="number" name="duracion" value="<?=$duracion?>" min="1" placeholder='Número de días'><br><br>


   <!-- URL-->
   <?php if (isset($errores['url'])): ?>
     <span class="error">Debe introducir la URL de su empresa</span> <br>
   <?php endif; ?>
  <label for=""> Url </label><input type="url" name="url" value="<?= $url ?>" placeholder='http://www.ejemplo.com'><br><br>


   <!-- FECHA ALTA-->
   <?php if (isset($errores['fecha_alta'])){
           if ($errores['fecha_alta'] == ERROR_FECHA_MAYOR ){ ?>
             <span class="error"> Introduce una fecha mayor a la actual </span> <br>
           <?php }else if($errores['fecha_alta'] == ERROR_FECHA_NO){ ?>
             <span class="error"> Introduce una fecha</span> <br>
    <?php  } ?>
  <?php } ?>
   <label for=""> Fecha de alta </label><input type="date" name="fecha_alta" value="<?=$fecha_alta?>"><br><br>

   <?php if (isset($errores['foto'])): ?>
        <span class="error"><?= $errores['foto']?> </span> <br><br>
   <?php endif; ?>
   <label for=""> Foto </label><input type="file" name="imagen" accept="image/png, image/jpeg"><br>
   <br><br>

    <h4> Total a pagar:
      <?php if (isset($_POST['calcular']) && count($errores) === 0): ?>
        <span ><?php echo $precio . ' €';?></span> <br>
     <?php else: ?>
       <span ><?= $precio = 0 ?></span> <br>
      <?php endif; ?>
      </h4>
    <br><br>



    <div class="botones">

      <input type="submit" name="calcular" value="Calcular">
      <input type="submit" name="comprar" value="Comprar">

      <!-- <button type="submit" name="calcular" class="login-button">Calcular</button>
      <button type="submit" name="comprar" class="login-button">Comprar</button> -->
    </div>

  </form>
  <?php endif; ?>

 </div>

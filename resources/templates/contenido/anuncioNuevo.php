<?php

  session_start();
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';

  if( !isset($_SESSION['id']) && $_SESSION['tipo_cliente']!='Empresa'){
      header('Location: login.php');
      die();
  }
  $id = $_SESSION['id'];
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
    if (isset($_POST['foto']) && $_POST['foto'] != '') {
      $foto = clean_input($_POST['foto']);
    }

    //url
    if (isset($_POST['url']) && $_POST['url'] != '') {
      $url = clean_input($_POST['url']);
    }
    //errores
    if(count($errores)==0){
      $db = DWESBaseDatos::obtenerInstancia();
      AnuncioManager::insert($id,$foto,$fecha_alta, $fecha_baja, $url);


      // $_SESSION['id']= $db->getLastId();
      // echo $_SESSION['id']. ' ultimo id insertado';
      //header("location: anuncio.php");

    }// no hay errores

  }
  //echo $_SESSION['tipo_cliente'];
 ?>

 <div class="form_anuncio">

  <?php if (isset($_SESSION['id'])): ?>
 <form class="registro" action="anuncioOk.php" method="post">
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

   <label for="">Foto</label><input type="file" name="foto" value="<?= $foto ?>"><br>

   <label for="">Url</label><input type="text" name="url" value="<?= $url ?>"><br><br>

   <br><br> <input type="submit" name="comprar" value="Comprar">

  </form>
  <?php endif; ?>

 </div>
